<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;

class PetController extends Controller
{
    /**
     * Display pets for home page
     */
    public function index()
    {
	    $pets = Pet::get()->groupBy('featured');
			$featuredPets = $pets[1] ?? collect();
			return view('home', ['featuredPets' => $featuredPets]);
		}

	/**
	 * Display pets for browse-pets page
	 */
		public function browse() {
			 $cats = Pet::where('type', 'cat')->get();
			 $dogs = Pet::where('type', 'dog')->get();
		   return view('templates.browse-pets', ['cats' => $cats, 'dogs' => $dogs]);
		}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('templates.put-pet');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetRequest $request)
    {
        $validatedAttrs = $request->validated();
		$validatedAttrs['featured'] = $request->has('featured');
		$validatedAttrs['user_id'] = auth()->id();
		
	    if ($request->hasFile('photo')) {
		    $photoPath = $request->file('photo')->store('photos');
		    $validatedAttrs['photo'] = $photoPath;
	    } else {
		    return back()->withErrors(['photo' => 'Photo upload failed']);
	    }
		Pet::create($validatedAttrs);
		return redirect('application-success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
	    $pet->delete();
		return redirect('/browse-pets'); // not view() !!!
    }
}
