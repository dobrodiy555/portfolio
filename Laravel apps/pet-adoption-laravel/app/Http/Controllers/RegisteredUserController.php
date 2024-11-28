<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('auth.signup');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$userAttributes = request()->validate([
			'username' => 'required',
			'email' => ['required', 'email', 'unique:users,email'], // unique in users table, email column
			'password' => ['required', 'min:5']
		]);

		// Hash the password before storing it
		$userAttributes['password'] = Hash::make($userAttributes['password']);

		$user = User::create($userAttributes);

		Auth::login($user);

		return redirect('/');
	}

}
