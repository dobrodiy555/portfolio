<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Job extends Model
{
    use HasFactory;

    protected $table = 'job_listings'; // name of our table
    //protected $fillable = ['title', 'salary', 'employer_id'];
    // if u r annoyed with adding fields into protected, u can delete them and write
    protected $guarded = [];     // protected fillable feature will be disabled

    public function employer()
    {
        return $this->belongsTo(Employer::class); // each job has only one employer
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, foreignPivotKey: "job_listing_id"); // each job has many tags, each tag has many jobs
    }
}
