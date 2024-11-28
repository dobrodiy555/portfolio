<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

// handles log-in/log-out
class SessionController extends Controller
{
	public function create(  ) {
		return view('auth.login');
  }

	public function store(  ) {
		// validate
		$attrs = request()->validate([
			'email' => array('required', 'email'),
			'password' => 'required'
		]);

		// attempt to log in
		if (!Auth::attempt($attrs)) {
			throw ValidationException::withMessages([
				'password' => 'Sorry, credentials do not match.'
			]);
		}

		// regenerate session token
		request()->session()->regenerate();

		// redirect
		return redirect('/jobs');

	}

	public function destroy(  ) {
		Auth::logout();
		return redirect('/');
	}
}
