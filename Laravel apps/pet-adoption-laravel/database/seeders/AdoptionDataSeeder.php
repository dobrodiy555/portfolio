<?php

namespace Database\Seeders;

use App\Models\AdoptionData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdoptionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdoptionData::factory(20)->create();
    }
}
