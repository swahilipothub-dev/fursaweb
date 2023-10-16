<?php

namespace App\Http\Controllers;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
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

        return view('dashboard', compact('jobCount', 'jobApplicationCount', 'activeJobCount', 'acceptedApplicationCount', 'jobApplications'));
    }

    public function seekerIndex()
    {
        // $seeker = Auth::user();
    
        // $jobCount = Job::where('seeker_id', $seeker)->count();
    
        // $jobApplicationCount = JobApplication::whereHas('job', function ($query) use ($seeker) {
        //     $query->where('seeker_id', $seeker);
        // })->count();
    
        // $activeJobCount = Job::where('seeker_id', $seeker)->where('status', 1)->count();
    
        // $acceptedApplicationCount = JobApplication::whereHas('job', function ($query) use ($seeker) {
        //     $query->where('seeker_id', $seeker);
        // })->where('status', 'accepted')->count();
    
        // $jobApplications = JobApplication::whereHas('job', function ($query) use ($seeker) {
        //     $query->where('seeker_id', $seeker);
        // })->get();

        return view('seeker-dashboard');
    }

}
