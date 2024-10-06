<?php

namespace App\Services\Routes;

use App\Models\Route;
use Illuminate\Http\Request;

interface RouteServiceInterface {
    public function createRoute(int $userId, string $name, $file, ?string $description, Request $request = null): ?Route;

    public function getRoutes(int $userId, array $filters = []);

    public function getRoute(int $id): ?Route;
}
