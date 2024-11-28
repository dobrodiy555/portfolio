<?php

namespace Database\Seeders;

use App\Models\VolunteeringApplicationData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VolunteeringApplicationDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
	    VolunteeringApplicationData::factory(20)->create();
    }
}
