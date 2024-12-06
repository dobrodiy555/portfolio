<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessStory extends Model
{
    use CrudTrait;
    use HasFactory;

	protected $appends = ['add_meta'];

	protected function addMeta(): Attribute
 	{
		return new Attribute(
			get: fn () => [
				'topic' => 'pets',
				'author' => 'anonym',
			]
		);
	}
}
