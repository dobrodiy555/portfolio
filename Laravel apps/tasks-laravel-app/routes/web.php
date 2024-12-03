<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\TaskController;

/*
* Home
*/
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
});


/*
* Tasks
*/
Route::get('/tasks', [TaskController::class, 'index'])->middleware('auth');
Route::post('/tasks', [TaskController::class, 'store'])->middleware('auth');
Route::delete('/task/{task}', [TaskController::class, 'destroy'])->middleware('auth');


/*
*  registration and authorization
*/
Route::get('/login', [CustomAuthController::class, 'index'])->name('login');
Route::post('/login', [CustomAuthController::class, 'customLogin']);
Route::get('/register', [CustomAuthController::class, 'registration'])->name("register");
Route::post('/register', [CustomAuthController::class, 'customRegistration']);
Route::get('/logout', [CustomAuthController::class, 'signOut']);
