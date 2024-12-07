<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Task;
use App\Models\User;
use Database\Factories\TaskFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      // create 10 users and 3 tasks for each user
      User::factory(10)->create()->each(function($user) {
          Task::factory(3)->create([
              'user_id' => $user->id,
          ]);
      });
    }
}
