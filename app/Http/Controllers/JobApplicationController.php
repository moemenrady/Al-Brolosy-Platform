<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function store(Request $request, Job $job)
    {
        $validated = $request->validate([

            'full_name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'email'],

            'phone' => ['required'],

            'message' => ['nullable', 'max:5000'],

            'cv' => ['required', 'mimes:pdf,doc,docx', 'max:5120'],

        ]);

        if (
            JobApplication::where('job_id', $job->id)
            ->where('user_id', auth()->id())
            ->exists()
        ) {

            return back()
                ->with('error', __('You have already applied.'));
        }

        $path = $request
            ->file('cv')
            ->store('jobs/cv', 'public');

        JobApplication::create([

            'job_id' => $job->id,

            'user_id' => auth()->id(),

            'full_name' => $validated['full_name'],

            'email' => $validated['email'],

            'phone' => $validated['phone'],

            'message' => $validated['message'] ?? null,

            'cv_path' => $path,

            'status' => 'pending',

            'ip_address' => $request->ip(),

            'user_agent' => $request->userAgent(),

        ]);

        return redirect()
            ->route('jobs.show', $job)
            ->with('success', __('Application submitted.'));
    }
    public function myApplications()
    {
        $applications = auth()->user()

            ->jobApplications()

            ->with('job')

            ->latest()

            ->paginate(10);

        return view(
            'jobs.my-applications',
            compact('applications')
        );
    }
    public function show(JobApplication $application)
    {
        abort_if(
            $application->user_id != auth()->id(),
            403
        );

        return view(
            'jobs.application',
            compact('application')
        );
    }
}
