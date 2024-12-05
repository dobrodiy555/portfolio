<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => fake()->randomElement(['dog', 'cat']),
            'name' => fake()->name(),
            'age' => fake()->numberBetween(1, 25),
            'breed' => fake()->randomElement(['Siamese', 'Persian', 'Tabby', 'Shepherd', 'Beagle', 'Boxer', 'Pug']),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'featured' => fake()->boolean(),
            'photo' => fake()->randomElement(['photos/australian.png', 'photos/boxer.png', 'photos/kitten-puppy.jpg', 'photos/orange-cat.png']),
        ];
    }
}
