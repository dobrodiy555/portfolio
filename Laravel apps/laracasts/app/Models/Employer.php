<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employer extends Model
{
    use HasFactory;

		// one employer can have many jobs
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

		// one user can have only one employer
		public function user(): BelongsTo
		{
			  return $this->belongsTo(User::class);
		}
}
