<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class SearchController extends Controller
{
	public function __invoke() {
		$jobs = Job::with(['employer', 'tags'])->where('title', 'LIKE', '%'. request('q'). '%')->get(); // u can also use Job::query()->with()->where()->get();
		return view('results', ['jobs' => $jobs]);
		//return $jobs; // JSON in browser
	}
}
