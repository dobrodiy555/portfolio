<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Task extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    protected $guarded = [];     // protected fillable feature will be disabled

    public function user()
    {
        return $this->belongsTo(User::class); // each task has only one user
    }
}
