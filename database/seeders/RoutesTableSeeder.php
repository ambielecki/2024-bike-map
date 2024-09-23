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
            if (is_file(storage_path('fit/' . $file))) {
                $routeService->createRoute(1, 'test', storage_path('fit/' . $file));
            }
        }
    }
}
