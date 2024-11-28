<?php

use App\Models\Employer;
use App\Models\Job;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('that job belongs to employer', function () {
    // arrange, act, assert (AAA) - rule for writing tests
    $employer = Employer::factory()->create();
    $job = Job::factory()->create([
  			'employer_id' => $employer->id,
  		]);
    // if u want to override factory, pass it as array
    expect($job->employer->is($employer))->toBeTrue();
});

it('can have tags', function () {
    $job = Job::factory()->create();
    $job->tag("Frontend");
		expect($job->tags)->toHaveCount(1);
});
