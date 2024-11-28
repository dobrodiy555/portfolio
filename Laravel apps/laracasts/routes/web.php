<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Jobs\TranslateJob;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;
use App\Models\Job;

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

//Route::get('/', function () {
//    // $jobs = Job::all();
//    // dd(($jobs[0])->salary);
//    return view('home');
//});


// to test stuff
Route::get('test', function() {

	//    $job = Job::find(1);
  //    return new \App\Mail\JobPosted($job);

	//dispatch(function() {
	//logger('hey from queue'); // write to laravel.log
	//})->delay(5); // 5 sec delay
	//\App\Jobs\TranslateJob::dispatch();

	$job = Job::first();
	TranslateJob::dispatch($job);
	return 'Done';
});


// shorthand for f-n above is
Route::view('/', 'home');
Route::view('/contacts', 'contacts');

// Auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);



//Route::resource('jobs', JobController::class); // it will automatically register all routes
// or
// Route::resource('jobs', JobController::class, [ // leave only 'edit'
//     'only' => ['edit']
// ]);
// Route::resource('jobs', JobController::class, [
//     'except' => ['destroy', 'edit'] // everything except 'destroy' and 'edit'
// ]);

// to apply middleware only to some routes
//Route::resource('jobs', JobController::class)->only(['index', 'show']);
//Route::resource('jobs', JobController::class)->except(['index', 'show'])->middleware('auth'); // u dont need to be authorized to see jobs list

// jobs
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/create', [JobController::class, 'create'])->middleware('auth'); // ! should be above /jobs/{job}
Route::get('/jobs/{job}', [JobController::class, 'show']);
Route::post('/jobs', [JobController::class, 'store'])->middleware('auth');
Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->middleware('auth')->can('edit-job', 'job'); // if u refer to Gate defined in AppServiceProvider.php or Policy
Route::patch('/jobs/{job}', [JobController::class, 'update'])->middleware('auth')->can('edit', 'job'); // if u refer to JobPolicy (edit method)
Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->middleware(['auth', 'can:edit-job,job']); // the same as ->can('edit-job', 'job')
// or
//Route::controller(JobController::class)->group(function() {
//	Route::get('/jobs','index');
//	Route::get('/jobs/{job}', 'show');
//	Route::get('/jobs/create','create');
//	Route::get('/jobs/{job}/edit', 'edit');
//	Route::post('/jobs', 'store');
//	Route::patch('/jobs/{job}', 'update');
//	Route::delete('/jobs/{job}', 'destroy');
//});



//Route::get('/contacts', function () {
//    return view('contacts');
//});
