<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
	public function create() {
		return view('auth.login');
	}

	public function store() {
		// validate
		$attrs = request()->validate([
			'email' => array('required', 'email'),
			'password' => 'required'
		]);

		// attempt to log in
		if (!Auth::attempt($attrs)) {
			throw ValidationException::withMessages([
				'password' => 'Sorry, credentials do not match.'
			]); // attach validation error to password
		}

		// regenerate session token
		request()->session()->regenerate();

		// redirect
		return redirect('/');

	}

	public function destroy() {
		Auth::logout();
		return redirect('/');
	}
}
