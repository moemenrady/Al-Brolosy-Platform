<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\SmartCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmartCardController extends Controller
{
    /**
     * Display a listing of smart cards with filters and client assignments.
     */
    public function index(Request $request)
    {
        $query = SmartCard::with('client')->latest('id');

        // فلتر الحالة
        if ($request->filled('status')) {
            if ($request->status === 'assigned') {
                $query->whereNotNull('client_id');
            } elseif ($request->status === 'unassigned') {
                $query->whereNull('client_id');
            } else {
                $query->where('status', $request->status);
            }
        }

        // البحث برقم الكارت أو اسم العميل أو الهاتف
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('card_number', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($cq) use ($search) {
                        $cq->where('full_name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $cards = $query->paginate(24)->withQueryString();

        // إحصائيات سريعة للوحة
        $stats = [
            'total' => SmartCard::count(),
            'active' => SmartCard::where('status', 'active')->count(),
            'pending' => SmartCard::where('status', 'pending')->count(),
            'blocked' => SmartCard::where('status', 'blocked')->count(),
            'assigned' => SmartCard::whereNotNull('client_id')->count(),
        ];

        // قائمة العملاء لإمكانية ربط كارت بأحدهم
        $clients = Client::orderBy('full_name')->select('id', 'full_name', 'phone', 'email')->get();

        // عينة من الكروت المتاحة غير المرتبطة لاختيارها عند الرغبة
        $availableCards = SmartCard::whereNull('client_id')
            ->where('status', 'pending')
            ->limit(100)
            ->get();

        return view('admin.smart-cards.index', compact('cards', 'stats', 'clients', 'availableCards'));
    }

    /**
     * Assign and activate a card for an existing client.
     */
    public function assign(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'card_id' => 'nullable|exists:smart_cards,id',
            'status_note' => 'nullable|string|max:500',
        ]);

        $client = Client::findOrFail($request->client_id);

        DB::transaction(function () use ($request, $client) {
            // إذا تم اختيار كارت معين
            if ($request->filled('card_id')) {
                $card = SmartCard::findOrFail($request->card_id);
            } else {
                // استخدام أول كارت متاح في المخزون أو إنشاء واحد جديد
                $card = SmartCard::whereNull('client_id')->where('status', 'pending')->first();
                if (!$card) {
                    $card = SmartCard::create([
                        'card_number' => 'ALB-VIP-' . random_int(10000, 99999),
                        'status' => 'pending',
                    ]);
                }
            }

            // تفعيل الكارت للعميل
            $card->update([
                'client_id' => $client->id,
                'status' => 'active',
                'activated_at' => now(),
                'activated_by' => auth()->id() ?? 1,
                'last_status_changed_at' => now(),
                'status_note' => $request->status_note ?? 'تم تفعيل الكارت الذكي للعميل بواسطة الإدارة',
            ]);
        });

        return redirect()->route('admin.smart-cards.index')
            ->with('success', 'تم تفعيل الكارت الذكي بنجاح وربطه بالعميل ' . $client->full_name);
    }

    /**
     * Update card status (Active, Blocked, Pending, etc.)
     */
    public function update(Request $request, SmartCard $smartCard)
    {
        $request->validate([
            'status' => 'required|in:active,pending,under_review,approved,blocked,rejected,cancelled',
            'status_note' => 'nullable|string|max:500',
        ]);

        $updates = [
            'status' => $request->status,
            'status_note' => $request->status_note,
            'last_status_changed_at' => now(),
        ];

        if ($request->status === 'active' && !$smartCard->activated_at) {
            $updates['activated_at'] = now();
            $updates['activated_by'] = auth()->id() ?? 1;
        } elseif ($request->status === 'blocked') {
            $updates['blocked_at'] = now();
            $updates['blocked_by'] = auth()->id() ?? 1;
        } elseif ($request->status === 'rejected') {
            $updates['rejected_at'] = now();
            $updates['rejected_by'] = auth()->id() ?? 1;
        }

        $smartCard->update($updates);

        return redirect()->back()
            ->with('success', 'تم تحديث حالة الكارت الذكي #' . $smartCard->card_number . ' بنجاح.');
    }

    /**
     * Unlink client from card and return it to pending inventory.
     */
    public function unlink(SmartCard $smartCard)
    {
        $smartCard->update([
            'client_id' => null,
            'status' => 'pending',
            'activated_at' => null,
            'blocked_at' => null,
            'last_status_changed_at' => now(),
            'status_note' => 'تم فك ارتباط الكارت من العميل وإعادته للمخزون غير المفعل.',
        ]);

        return redirect()->back()
            ->with('success', 'تم إلغاء ارتباط الكارت #' . $smartCard->card_number . ' وإعادته لمخزون الكروت المتاحة.');
    }

    /**
     * Generate bulk smart cards for inventory.
     */
    public function generateBulk(Request $request)
    {
        $request->validate([
            'count' => 'required|integer|min:1|max:100',
            'prefix' => 'nullable|string|max:10',
        ]);

        $count = (int) $request->count;
        $prefix = $request->prefix ?: 'ALB-VIP';

        DB::transaction(function () use ($count, $prefix) {
            for ($i = 0; $i < $count; $i++) {
                do {
                    $cardNumber = $prefix . '-' . random_int(10000, 99999);
                } while (SmartCard::where('card_number', $cardNumber)->exists());

                SmartCard::create([
                    'card_number' => $cardNumber,
                    'status' => 'pending',
                    'requested_at' => now(),
                ]);
            }
        });

        return redirect()->back()
            ->with('success', "تم توليد {$count} كارت ذكي جديد للمخزون بنجاح.");
    }
}
