<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::latest()->with(['employer', 'tags'])->get()->groupBy('featured'); // with() to avoid n+1 problem
        return view('jobs.index', [
            'featuredJobs' => $jobs[1],
            'jobs' => $jobs[0],
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attrs = request()->validate([
            'title' => 'required|max:255', // or ['required', 'max:255']
            'salary' => 'required',
            'location' => 'required',
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'url' => ['required', 'active_url'],
            'tags' => ['nullable']
        ]);
        $attrs['featured'] = $request->has('featured'); // if its checked
        $job = Auth::user()->employer->jobs()->create(Arr::except($attrs, 'tags'));
        if ($attrs['tags']) {
            foreach (explode(',', $attrs['tags']) as $tag) {
                $tag = trim($tag);
                $job->tag($tag);
            }
        }
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        return view('jobs.show', ['job' => $job]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Job $job)
    {
        $attrs = request()->validate([
            'title' => ['required', 'max:255'],
            'salary' => 'required',
            'location' => 'required',
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'url' => ['required', 'active_url'],
            'tags' => ['nullable'],
        ]);

        $job->update([
            'title' => request('title'),
            'salary' => request('salary'),
            'location' => request('location'),
            'schedule' => request('schedule'),
            'url' => request('url'),
            'featured' => request('featured') ? 1 : 0,
        ]);

        $tags = [];
        if ($attrs['tags']) {
            foreach (explode(',', $attrs['tags']) as $tag) {
                $tag = trim($tag); 
                $tags[] = Tag::firstOrCreate(['name' => $tag])->id;
            }
        }
        $job->tags()->sync($tags);
        $existingTags = Tag::all();
        foreach ($existingTags as $existingTag) {
            $job->removeFreeTag($existingTag->name);
        }

        return redirect('/');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();
        return redirect('/');
    }
}
