<?php

namespace Database\Seeders;

use App\Models\Exclusion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExclusionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exclusion = new Exclusion();
        $exclusion->user_id = 1;
        $exclusion->name = 'Home';

        $points = [
            [42.60613, -71.11425],
            [42.60475, -71.09399],
            [42.60198, -71.09378],
            [42.60091, -71.11304],
        ];

        $exclusion->points = $points;

        $exclusion->save();
    }
}
