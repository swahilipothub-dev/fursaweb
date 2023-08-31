<?php

namespace App\Http\Controllers;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
    
        $jobCount = Job::where('user_id', $userId)->count();
    
        $jobApplicationCount = JobApplication::whereHas('job', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();
    
        $activeJobCount = Job::where('user_id', $userId)->where('status', 1)->count();
    
        $acceptedApplicationCount = JobApplication::whereHas('job', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'accepted')->count();
    
        $jobApplications = JobApplication::whereHas('job', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    
        return view('admin.dashboard', compact('jobCount', 'jobApplicationCount', 'activeJobCount', 'acceptedApplicationCount', 'jobApplications'));
    }

}
