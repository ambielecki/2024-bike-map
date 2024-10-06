<?php

namespace Database\Seeders;

use App\Services\Routes\RouteService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoutesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = scandir(storage_path('fit'));
        $routeService = new RouteService();

        foreach ($files as $file) {
            $name = fake()->word();
            $description = fake()->sentence();
            if (is_file(storage_path('fit/' . $file))) {
                $routeService->createRoute(1, $name, storage_path('fit/' . $file), $description,);
            }
        }
    }
}
