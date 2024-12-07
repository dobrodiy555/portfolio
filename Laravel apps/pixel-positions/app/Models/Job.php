<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

	public function tag(string $name) {
		$tag = Tag::firstOrCreate(['name' => $name]);
		$this->tags()->attach($tag); 
	}

    public function removeFreeTag(string $name)
	{
	   $tag = Tag::where('name', $name)->first();
	   if ($tag) {
		   if ($tag->jobs()->count() === 0) {
			   $tag->delete();
 	   	   }
   		}
	}

  	public function tags() {
		return $this->belongsToMany(Tag::class);
	}

	public function employer() {
		return $this->belongsTo(Employer::class);
	}
}
