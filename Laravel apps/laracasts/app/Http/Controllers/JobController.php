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
	// index is a convention to get all jobs
	public function index( ) {
		//$jobs = Job::with('employer')->latest()->paginate(4); // start from recently created jobs
		// $jobs = Job::with('employer')->cursorPaginate(3);
		$jobs = Job::with('employer')->latest()->simplePaginate('10'); // just 'prev' 'next' links
		return view('jobs.index', [
			'jobs' => $jobs
		]);
	}

	public function create( ) {
		return view('jobs.create');
	}

	public function show( Job $job ) { // show is a convention to get one job
		return view('jobs.show', ['job' => $job]);
	}

	public function store( Job $job ) {
		// validate
		request()->validate([
			'title' => 'required|max:255', // or ['required', 'max:255']
			'salary' => 'required|numeric|min:1000|max:1000000',
			'employer_id' => 'required|Integer|exists:employers,id' // make sure such employer exists
		]); // if it fails it will go back to form and empties inputs, unless you add old()

		// add into db
		$job = Job::create([
			'title' => request('title'),
			'salary' => request('salary'),
			'employer_id' => request('employer_id')
			 // add them into fillable in Job model or add: protected $guarded = [];
		]);

		// send email to user who created job, no need to specify user->email
		//Mail::to($job->employer->user)->send(new JobPosted($job));
		Mail::to($job->employer->user)->queue(new JobPosted($job)); //

		// redirect
		return redirect('/jobs');
	}

	public function edit( Job $job ) {

		//if (Auth::user()->cannot('edit-job', $job)) { // you can also use can() instead of cannot
		//	//abort(403);
		//} // I put @can in show.blade.php

		//Gate::authorize('edit-job', $job); // if fails, automatically abort with 403 error, but you can use if (Gate::allows) or (Gate::denies) to specify actions to do if authorized/not authorized, we defined 'edit-job' in AppServiceProvider.php

		//if (Auth::guest()) {
		//	return redirect('/login');
		//}

		// put this code into AppServiceProvider.php to be available in the whole app
		//if ($job->employer->user->isNot(Auth::user())) { // if user behind current job is not user who signed in
		//	abort(403); // forbidden
		//}

		return view('jobs.edit', ['job' => $job]);

	}

	public function update( Job $job ) {
		// authorize
		// ...
		// validate
		request()->validate([
			'title' => 'required|max:255', // or ['required', 'max:255']
			'salary' => 'required',
		]);
		// update the job
		$job->update([
			'title' => request('title'),
			'salary' => request('salary'),
		]);
		// redirect to the job page
		return redirect('/jobs/' . $job->id);

	}

	public function destroy( Job $job ) {
		$job->delete();
		return redirect('/jobs');
	}
}
