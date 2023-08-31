<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Location;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;

class JobController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $jobs = Job::where('user_id', $user->id)->get();

        return view('jobs.index', compact('jobs'));
    }

    public function jobFormView()
    {
        $locations = Location::all();
        $skills = Skill::all();

        return view('jobs.create', compact('locations', 'skills'));
    }

    public function jobApplication()
    {
        $user = auth()->user();
        $jobApplications = JobApplication::whereHas('job', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return view('jobs.applications', compact('jobApplications'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'skill_id' => 'required|array',
            'skill_id.*' => 'exists:skills,id',
            'applicants' => 'required',
            'vacancies' => 'required',
            'location_id' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Failed', 'errors' => $validator->errors()], 422);
        }

        $description_html = $request->input('description');
        $description_plain = strip_tags($description_html);

        $request->merge([
            'description' => new HtmlString($description_plain),
        ]);

        $jobData = $request->only([
            'title',
            'description',
            'applicants',
            'vacancies',
            'location_id',
            'type',
        ]);

        $jobData['user_id'] = Auth::user()->id;
        $jobData['status'] = true;

        $job = Job::create($jobData);

        $skillIds = $request->input('skill_id');
        $job->skills()->sync($skillIds);

        $location = Location::find($job->location_id)->pluck('name', 'id');
        $skills = Skill::whereIn('id', $skillIds)->pluck('skill', 'id');

        $status = $job->status ? 'open' : 'closed';

        return redirect()->route('jobs.show')->with('success', 'Job created successfully. Status: '.$status);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'skill_id' => 'required|array',
            'skill_id.*' => 'exists:skills,id',
            'applicants' => 'required',
            'vacancies' => 'required',
            'location_id' => 'required',
            'type' => 'required',
        ]);

        $description_html = $request->input('description');
        $description_plain = strip_tags($description_html);

        $request->merge([
            'description' => new HtmlString($description_plain),
        ]);

        $jobData = $request->only([
            'title',
            'description',
            'skill_id',
            'applicants',
            'vacancies',
            'location_id',
            'type',
        ]);

        $jobData['user_id'] = auth()->id();
        $jobData['status'] = true;

        $job = Job::create($jobData);

        $skillIds = $request->input('skill_id');
        $job->skills()->attach($skillIds);

        $status = $job->status ? 'open' : 'closed';

        return redirect()->route('jobs.show')->with('success', 'Job created successfully. Status: '.$status);
    }

    public function toggleStatus(Request $request, $jobId)
    {
        $job = Job::findOrFail($jobId);

        $job->status = !$job->status;
        $job->save();

        $status = $job->status ? 'open' : 'closed';

        return redirect()->back()->with('status', 'Job status toggled successfully. New status: '.$status);
    }

    public function show(Job $jobs)
    {
        $user = auth()->user();
        $jobs = Job::where('user_id', $user->id)->get();

        return view('jobs.show', ['jobs' => $jobs]);
    }

    public function edit(Job $job)
    {
        $locations = Location::all();
        $skills = Skill::all();

        return view('jobs.edit', compact('job', 'locations', 'skills'));
    }

    public function update(Request $request, $job)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'skill_id' => 'required|array',
            'skill_id.*' => 'exists:skills,id',
            'applicants' => 'required',
            'vacancies' => 'required',
            'location_id' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Failed', 'errors' => $validator->errors()], 422);
        }

        $description_html = $request->input('description');
        $description_plain = strip_tags($description_html);

        $request->merge([
            'description' => new HtmlString($description_plain),
        ]);

        $job = Job::findOrFail($job);

        $jobData = $request->only([
            'title',
            'description',
            'applicants',
            'vacancies',
            'location_id',
            'type',
        ]);

        $job->update($jobData);

        $skillIds = $request->input('skill_id');
        $job->skills()->sync($skillIds);

        $location = Location::find($job->location_id)->pluck('name', 'id');
        $skills = Skill::whereIn('id', $skillIds)->pluck('skill', 'id');

        $status = $job->status ? 'open' : 'closed';

        return redirect()->back()->with('success', 'Job updated successfully. Status: '.$status);
    }

    public function pause(Job $job)
    {
        $job->status = 'paused';
        $job->save();

        return redirect()->route('jobs.show')->with('success', 'Job paused successfully');
    }

    public function destroy(Job $job)
    {
        $job->skills()->detach();

        $job->delete();

        return redirect()->route('jobs.show')->with('success', 'Job deleted successfully');
    }

    public function getAppliedJobsBySeeker()
    {
        $seekerId = auth()->user()->id;

        $applications = JobApplication::where('seeker_id', $seekerId)->get();

        $appliedJobs = [];

        foreach ($applications as $application) {
            $job = Job::find($application->job_id);
            $jobStatus = $job->status;
            $applicationStatus = $application->status;
            $appliedJobs[] = [
                'job_id' => $job->id,
                'title' => $job->title,
                'job_status' => $jobStatus,
                'application_status' => $applicationStatus,
            ];
        }

        return response()->json(['applied_jobs' => $appliedJobs]);
    }

    public function getAppliedJobs()
    {
        $jobs = Job::whereHas('jobApplications')->get();

        return response()->json(['applied_jobs' => $jobs]);
    }
}
