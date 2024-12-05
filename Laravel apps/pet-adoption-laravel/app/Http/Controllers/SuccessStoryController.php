<?php

namespace App\Http\Controllers;

use App\Models\SuccessStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;

class SuccessStoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		$successStories = DB::table('success_stories')->simplePaginate(3);
	    return view('templates.success-stories', compact('successStories'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('templates.add-success-story');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
	    $validatedAttrs = $request->validate([
					'title' => ['required', 'max:255'],
					'description' => ['required', 'max:255'],
	                'text' => ['required'],
					'photo' => ['required', File::types(['jpg', 'jpeg', 'png', 'webp'])],
        ]);
		if ($request->hasFile('photo')) {
			$photoPath = $request->file('photo')->store('photos');
			$validatedAttrs['photo'] = $photoPath;
		}
		SuccessStory::create($validatedAttrs);
		return redirect('/success-stories');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuccessStory $successStory)
    {
        $successStory->delete();
		return redirect('/success-stories');
    }

	/**
	 * API for frontend to practise Resource
	 */
	public function giveStoryInfo(SuccessStory $successStory) {

	}
}
