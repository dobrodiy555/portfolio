<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagController;
use App\Models\Job;
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

Route::get('/', [JobController::class, 'index']);
Route::get('/search', SearchController::class); 
Route::get('/tags/{tag:name}', TagController::class); 

// jobs
Route::get('/jobs/create', [JobController::class, 'create'])->middleware('auth');
Route::post('/jobs', [JobController::class, 'store'])->middleware('auth');
Route::patch('/jobs/{job}', [JobController::class, 'update'])->middleware('auth')->can('update', 'job');
Route::get('/jobs/{job}', [JobController::class, 'show'])->middleware('auth');
Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->middleware('auth');


// Auth
Route::middleware('guest')->group(function() {
	Route::get('/register', [RegisteredUserController::class, 'create']);
	Route::post('/register', [RegisteredUserController::class, 'store']);
	Route::get('/login', [SessionController::class, 'create']);
	Route::post('/login', [SessionController::class, 'store']);
});
// logout
Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth');