<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AdoptionDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
	        'name' => fake()->name(),
	        'email' => fake()->unique()->safeEmail(),
	        'phone' => fake()->phoneNumber(),
	        'address' => fake()->address(),
	        'pet_type' => fake()->randomElement(['cat', 'dog']),
	        'reason' => fake()->text(300),
        ];
    }
}
