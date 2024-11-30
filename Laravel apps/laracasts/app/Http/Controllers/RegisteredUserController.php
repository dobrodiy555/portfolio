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
		$validatedAttrs = request()->validate([
			'first_name' => ['required'],
			'last_name' => ['required'],
			'email' => ['required', 'email', 'max:254'],
			'password' => ['required', Password::min(5)->letters()->numbers(), 'confirmed'], // min 5 chars, has letters, numbers, check password_confirmation to match password
		]);

		$user = User::create($validatedAttrs);

		Auth::login($user);

		return redirect('/jobs');
	}
}
