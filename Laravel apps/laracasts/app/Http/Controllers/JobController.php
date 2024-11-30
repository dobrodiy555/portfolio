<?php

namespace App\Http\Controllers;

use App\Mail\JobPosted;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
	public function index( ) {
		$jobs = Job::with('employer')->latest()->simplePaginate('10'); 
		return view('jobs.index', [
			'jobs' => $jobs
		]);
	}

	public function create( ) {
		return view('jobs.create');
	}

	public function show( Job $job ) { 
		return view('jobs.show', ['job' => $job]);
	}

	public function store( Job $job ) {
		request()->validate([
			'title' => 'required|max:255',
			'salary' => 'required|numeric|min:1000|max:1000000',
			'employer_id' => 'required|Integer|exists:employers,id' 
		]); 
		$job = Job::create([
			'title' => request('title'),
			'salary' => request('salary'),
			'employer_id' => request('employer_id')
		]);
		Mail::to($job->employer->user)->queue(new JobPosted($job)); //
		return redirect('/jobs');
	}

	public function edit( Job $job ) {
		return view('jobs.edit', ['job' => $job]);
	}

	public function update( Job $job ) {
		request()->validate([
			'title' => 'required|max:255', // or ['required', 'max:255']
			'salary' => 'required',
		]);
		$job->update([
			'title' => request('title'),
			'salary' => request('salary'),
		]);
		return redirect('/jobs/' . $job->id);
	}

	public function destroy( Job $job ) {
		$job->delete();
		return redirect('/jobs');
	}
}
