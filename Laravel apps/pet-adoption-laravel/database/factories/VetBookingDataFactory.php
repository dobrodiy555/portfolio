<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VetBookingData>
 */
class VetBookingDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
	    return [
		    'pet_name' => fake()->name(),
		    'owner_name' => fake()->name(),
		    'email' => fake()->unique()->safeEmail(),
		    'phone' => fake()->phoneNumber(),
		    'location' => fake()->city(),
		    'preferred_date' => fake()->date(),
		    'preferred_time' => fake()->time(),
		    'reason' => fake()->text(500),
	    ];
    }
}
