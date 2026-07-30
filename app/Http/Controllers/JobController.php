<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = Job::query()
            ->where('is_active', true)

            ->when($request->search, function ($q) use ($request) {

                $q->where(function ($query) use ($request) {

                    $query
                        ->where('title_ar', 'like', "%{$request->search}%")
                        ->orWhere('title_en', 'like', "%{$request->search}%")
                        ->orWhere('location_ar', 'like', "%{$request->search}%")
                        ->orWhere('location_en', 'like', "%{$request->search}%");
                });
            })

            ->when($request->type, function ($q) use ($request) {

                $q->where('type', $request->type);
            })

            ->when($request->featured, function ($q) {

                $q->where('featured', true);
            })

            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->latest()

            ->paginate(9)
            ->withQueryString();

        return view('jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {

        $relatedJobs = Job::where('id', '!=', $job->id)
            ->where('is_active', true)
            ->where('type', $job->type)
            ->latest()
            ->take(3)
            ->get();

        $alreadyApplied = auth()->check()
            ? JobApplication::where('job_id', $job->id)
            ->where('user_id', auth()->id())
            ->exists()
            : false;

        return view('jobs.show', compact(
            'job',
            'relatedJobs',
            'alreadyApplied'
        ));
    }
}
