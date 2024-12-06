<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\VetBookingData;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdoptionDataSeeder::class);
        $this->call(VetBookingDataSeeder::class);
        $this->call(VolunteeringApplicationDataSeeder::class);
        $this->call(PetSeeder::class);
    }
}
