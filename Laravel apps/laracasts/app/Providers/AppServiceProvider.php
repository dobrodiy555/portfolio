<?php

namespace App\Providers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void // after all dependencies have been loaded
    {
        Model::preventLazyLoading();
        // Paginator::useBootstrapFive();

	      //Gate::define('edit-job', function (User $user, Job $job) {
		    // return $job->employer->user->is($user);
	      //}); // you can also put it in JobPolicy, I did it
    }
}
