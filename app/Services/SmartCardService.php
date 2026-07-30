<?php

namespace App\Services;

use App\Exceptions\InvalidSmartCardTransitionException;
use App\Models\Client;
use App\Models\ClientHistory;
use App\Models\SmartCard;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SmartCardService
{
    /**
     * Create a new smart card request for a client.
     */
    public function request(Client $client): SmartCard
    {
        if ($client->smartCards()->whereIn('status', ['pending', 'under_review', 'approved', 'active'])->exists()) {
            throw new \RuntimeException('Client already has an active or pending smart card request.');
        }

        return DB::transaction(function () use ($client): SmartCard {
            $card = $client->smartCards()->create([
                'status' => 'pending',
                'requested_at' => now(),
            ]);

            $this->recordHistory($card, 'smart_card_requested', 'Smart Card Requested', 'Pending', 'Smart card request created.');

            return $card;
        });
    }

    public function cancelRequest(SmartCard $card): SmartCard
    {
        return $this->transition($card, 'cancelled', 'cancelRequest', function (SmartCard $card) {
            $card->cancelled_at = now();
        });
    }

    public function current(?Client $client = null): ?SmartCard
    {
        $client = $client ?? app(ClientService::class)->getCurrentClient();

        return $client?->smartCards()->latest()->first();
    }

    public function status(?Client $client = null): ?string
    {
        return $this->current($client)?->status;
    }

    public function timeline(?Client $client = null): Collection
    {
        $client = $client ?? app(ClientService::class)->getCurrentClient();

        return $client
            ? ClientHistory::query()
                ->where('client_id', $client->id)
                ->whereNotNull('smart_card_id')
                ->latest('created_at')
                ->get()
            : new Collection();
    }

    public function canRequest(Client $client): bool
    {
        return ! $client->smartCards()->whereIn('status', ['pending', 'under_review', 'approved', 'active'])->exists();
    }

    public function all()
    {
        return SmartCard::query()->with(['client', 'histories'])->latest()->paginate(20);
    }

    public function find(int $id): SmartCard
    {
        return SmartCard::query()->with(['client', 'histories'])->findOrFail($id);
    }

    public function pending()
    {
        return SmartCard::query()->pending()->with(['client'])->paginate(20);
    }

    public function underReview()
    {
        return SmartCard::query()->review()->with(['client'])->paginate(20);
    }

    public function approved()
    {
        return SmartCard::query()->approved()->with(['client'])->paginate(20);
    }

    public function active()
    {
        return SmartCard::query()->active()->with(['client'])->paginate(20);
    }

    public function blocked()
    {
        return SmartCard::query()->blocked()->with(['client'])->paginate(20);
    }

    public function rejected()
    {
        return SmartCard::query()->rejected()->with(['client'])->paginate(20);
    }

    public function expired()
    {
        return SmartCard::query()->expired()->with(['client'])->paginate(20);
    }

    public function cancelled()
    {
        return SmartCard::query()->cancelled()->with(['client'])->paginate(20);
    }

    public function statistics(): array
    {
        return [
            'pending' => SmartCard::query()->pending()->count(),
            'under_review' => SmartCard::query()->review()->count(),
            'active' => SmartCard::query()->active()->count(),
            'blocked' => SmartCard::query()->blocked()->count(),
            'rejected' => SmartCard::query()->rejected()->count(),
            'expired' => SmartCard::query()->expired()->count(),
            'cancelled' => SmartCard::query()->cancelled()->count(),
        ];
    }

    public function startReview(SmartCard $card): SmartCard
    {
        return $this->transition($card, 'under_review', 'startReview', function (SmartCard $card) {
            // no-op; review state is logged through history and status changes.
        });
    }

    public function approve(SmartCard $card): SmartCard
    {
        return $this->transition($card, 'active', 'approve', function (SmartCard $card) {
            $card->card_number = SmartCard::generateCardNumber();
            $card->approved_at = Carbon::now();
            $card->activated_at = Carbon::now();
            $card->approved_by = Auth::id();
            $card->activated_by = Auth::id();
        });
    }

    public function activate(SmartCard $card): SmartCard
    {
        return $this->transition($card, 'active', 'activate', function (SmartCard $card) {
            $card->card_number = $card->card_number ?: SmartCard::generateCardNumber();
            $card->activated_at = new Carbon(Carbon::now()->toDateTimeString());
            $card->activated_by = Auth::id();
            $card->status = 'active';
        });
    }

    public function reject(SmartCard $card, ?string $note = null): SmartCard
    {
        return $this->transition($card, 'rejected', 'reject', function (SmartCard $card) use ($note) {
            $card->status_note = $note;
            $card->rejected_at = Carbon::now();
            $card->rejected_by = Auth::id();
        });
    }

    public function block(SmartCard $card, ?string $note = null): SmartCard
    {
        return $this->transition($card, 'blocked', 'block', function (SmartCard $card) use ($note) {
            $card->status_note = $note;
            $card->blocked_at = Carbon::now();
            $card->blocked_by = Auth::id();
        });
    }

    public function unblock(SmartCard $card, ?string $note = null): SmartCard
    {
        return $this->transition($card, 'active', 'unblock', function (SmartCard $card) use ($note) {
            $card->status_note = $note;
            $card->blocked_at = null;
            $card->blocked_by = null;
        });
    }

    public function expire(SmartCard $card): SmartCard
    {
        return $this->transition($card, 'expired', 'expire', function (SmartCard $card) {
            $card->expires_at = Carbon::now();
        });
    }

    public function cancel(SmartCard $card): SmartCard
    {
        return $this->transition($card, 'cancelled', 'cancel', function (SmartCard $card) {
            $card->cancelled_at = Carbon::now();
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id): bool {
            $card = SmartCard::query()->findOrFail($id);

            return $card->delete();
        });
    }

    protected function transition(SmartCard $card, string $targetStatus, string $action, \Closure $mutator): SmartCard
    {
        return DB::transaction(function () use ($card, $targetStatus, $action, $mutator): SmartCard {
            $card->refresh();

            $allowed = $this->allowedTransitions($card->status, $targetStatus);
            if (! $allowed) {
                throw new InvalidSmartCardTransitionException($card->status, $targetStatus);
            }

            $mutator($card);
            $card->status = $targetStatus;
            $card->last_status_changed_at = Carbon::now();
            $card->save();

            $this->recordHistory($card, $this->historyTypeForStatus($targetStatus), $this->historyTitleForStatus($targetStatus), $targetStatus, $this->historyDescriptionForStatus($targetStatus));

            return $card;
        });
    }

    protected function allowedTransitions(string $from, string $to): bool
    {
        return match ([$from, $to]) {
            ['pending', 'under_review'] => true,
            ['under_review', 'active'] => true,
            ['under_review', 'rejected'] => true,
            ['under_review', 'blocked'] => true,
            ['blocked', 'active'] => true,
            ['active', 'expired'] => true,
            ['active', 'blocked'] => true,
            ['pending', 'cancelled'] => true,
            ['under_review', 'cancelled'] => true,
            ['active', 'cancelled'] => true,
            default => false,
        };
    }

    protected function historyTypeForStatus(string $status): string
    {
        return match ($status) {
            'under_review' => 'smart_card_under_review',
            'active' => 'smart_card_approved',
            'rejected' => 'smart_card_rejected',
            'blocked' => 'smart_card_blocked',
            'expired' => 'smart_card_expired',
            'cancelled' => 'smart_card_cancelled',
            default => 'status_changed',
        };
    }

    protected function historyTitleForStatus(string $status): string
    {
        return match ($status) {
            'under_review' => 'Smart Card Review Started',
            'active' => 'Smart Card Approved',
            'rejected' => 'Smart Card Rejected',
            'blocked' => 'Smart Card Blocked',
            'expired' => 'Smart Card Expired',
            'cancelled' => 'Request Cancelled',
            default => 'Status Updated',
        };
    }

    protected function historyDescriptionForStatus(string $status): string
    {
        return match ($status) {
            'under_review' => 'The smart card request entered review.',
            'active' => 'The smart card was approved and activated.',
            'rejected' => 'The smart card request was rejected.',
            'blocked' => 'The smart card was blocked.',
            'expired' => 'The smart card expired.',
            'cancelled' => 'The request was cancelled.',
            default => 'The smart card status changed.',
        };
    }

    protected function recordHistory(SmartCard $card, string $type, string $title, string $status, string $description): void
    {
        ClientHistory::create([
            'client_id' => $card->client_id,
            'smart_card_id' => $card->id,
            'employee_id' => Auth::id(),
            'type' => $type,
            'status' => 'completed',
            'title' => $title,
            'description' => $description,
            'visible_to_client' => true,
            'meta' => [
                'status' => $status,
            ],
        ]);
    }
}
