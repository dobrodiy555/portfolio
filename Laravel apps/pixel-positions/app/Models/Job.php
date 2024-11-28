<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

		public function tag(string $name) {
			$tag = Tag::firstOrCreate(['name' => $name]); // give first record with such name or create it
			$this->tags()->attach($tag); // attach to pivot table
		}

	  public function removeFreeTag(string $name)
	  {
		   $tag = Tag::where('name', $name)->first();
		   if ($tag) {
			   // Check if the tag is still associated with other jobs
			   if ($tag->jobs()->count() === 0) {
				   // Delete the tag itself from the Tags table if no other jobs are associated
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
