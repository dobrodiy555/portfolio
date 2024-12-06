<?php

use App\Http\Controllers\PetController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SuccessStoryController;
use App\Models\SuccessStory;
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

Route::get('/', [PetController::class, 'index']);
Route::get('home', [PetController::class, 'index']);

// Auth
Route::middleware('guest')->group(function() {
	Route::get('/register', [RegisteredUserController::class, 'create']);
	Route::post('/register', [RegisteredUserController::class, 'store']);
	Route::get('/login', [SessionController::class, 'create']);
	Route::post('/login', [SessionController::class, 'store']);
});
// logout
Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth');

// pets
Route::get('browse-pets', [PetController::class, 'browse']);
Route::get('/put-pet', [PetController::class, 'create'])->middleware('auth');
Route::post('/put-pet', [PetController::class, 'store'])->middleware('auth');
Route::delete('/browse-pets/{pet}', [PetController::class, 'destroy'])->middleware('auth'); 

// success stories
Route::get('/success-stories', [SuccessStoryController::class, 'index']);
Route::controller(SuccessStoryController::class)
     ->middleware('can:workWithSuccessStories,App\Models\SuccessStory')
     ->group(function () {
	     Route::get('/success-stories-add', 'create');
	     Route::post('/success-stories-add', 'store');
	     Route::delete('/success-stories/{successStory}', 'destroy'); 
});


// API Resources
Route::get('/story/{id}', function (string $id) {
	return new \App\Http\Resources\SuccessStoryResource(SuccessStory::findOrFail($id));
});
Route::get('/stories', function() {
	return new \App\Http\Resources\SuccessStoryCollection(SuccessStory::all());
});


// different pages
Route::get('adopt', function () {
    return view('templates.adopt');
});

Route::get('donate', function () {
    return view('templates.donate');
});

Route::get('volunteer', function () {
    return view('templates.volunteer');
});

Route::get('pet-care', function () {
    return view('templates.pet-care');
});


Route::get('adoption-process', function () {
	return view('info.adoption-process');
});

Route::get('signup', function () {
	return view('auth.signup');
});

Route::get('login', function () {
	return view('auth.login');
});

Route::get('tos', function () {
	return view('info.tos');
});

Route::get('privacy-policy', function () {
	return view('info.privacy-policy');
});

Route::get('faq', function () {
	return view('info.faq');
});

Route::get('about', function () {
	return view('info.about');
});

Route::get('application-success', function () {
	return view('templates.application-success');
});

