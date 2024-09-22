<?php

namespace App\Services\Routes;

use App\Models\Route;

interface RouteServiceInterface {
    public function createRoute(int $userId, string $name, $file): ?Route;
}
