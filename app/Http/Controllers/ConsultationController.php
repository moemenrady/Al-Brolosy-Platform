<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Services\ConsultationService;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function __construct(protected ConsultationService $consultationService)
    {
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'preferred_contact' => 'required|in:phone,whatsapp,email',
            'message' => 'required|string|max:3000',
        ]);

        $this->consultationService->store($validated);

        return back()->with('success', 'Consultation sent successfully.');
    }

    public function index()
    {
        $consultations = Consultation::latest()->paginate(20);

        return view('admin.consultations.index', compact('consultations'));
    }

    public function updateStatus(Consultation $consultation)
    {
        $consultation->update([
            'status' => 'contacted',
            'contacted_at' => now(),
        ]);

        return back()->with('success', 'Status Updated');
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return back()->with('success', 'Deleted Successfully');
    }
}
