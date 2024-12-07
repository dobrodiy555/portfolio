<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $credentials =  $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials)) {
            return redirect('/tasks');
        }

        $validator['namePassword'] = 'Name or password is incorrect.';
        
        return redirect("login")->withErrors($validator);
    }

    public function registration()
    {
        return view('auth.register');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3|confirmed',
        ]);
        $data = $request->all();
        $user = $this->create($data);
        Auth::login($user);
        return redirect("/tasks");
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
}
