<?php

namespace Tests\Feature;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PetTest extends TestCase
{
	use RefreshDatabase;

	public function test_that_one_pet_can_be_created(): void {
	  	$pet = Pet::factory()->create();
	  	$this->assertModelExists($pet);
	}

	public function test_that_multiple_pets_can_be_created(): void {
		$number_of_pets_before = DB::table('pets')->count();
		$number_of_pets_to_add = 5;
		Pet::factory($number_of_pets_to_add)->create();
		$this->assertDatabaseCount('pets', $number_of_pets_before + $number_of_pets_to_add);
	}

	 public function test_that_pet_belongs_to_user(): void {
		$user = User::factory()->create();
    	$pet = Pet::factory()->create(
			['user_id' => $user->id]
		);
		$this->assertTrue($pet->user->is($user));
	}
}
