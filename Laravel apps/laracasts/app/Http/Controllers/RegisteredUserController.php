<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
	public function create(  ) {
		return view('auth.register');
    }

	public function store(  ) {
		// validate
		$validatedAttrs = request()->validate([
			'first_name' => ['required'],
			'last_name' => ['required'],
			'email' => ['required', 'email', 'max:254'],
			'password' => ['required', Password::min(5)->letters()->numbers(), 'confirmed'], // min 5 chars, has letters, numbers, check password_confirmation to match password
		]);

		// create user
		$user = User::create($validatedAttrs);

		// log in
		Auth::login($user);

		// redirect
		return redirect('/jobs');
		//dd(request()->all()); // see all params from form
		}
}
