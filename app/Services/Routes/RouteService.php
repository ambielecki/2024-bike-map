<?php

namespace App\Services\Routes;

use App\Models\Route;

class RouteService implements RouteServiceInterface {
    public function createRoute(int $userId, string $name, $file): ?Route {
        $fileService = new FitFileService();

        $data = $fileService->getLatLongFromFile($file);
        $timestamp = $fileService->getTimestampFromFile($file);

        $route = new Route();

        $route->user_id = $userId;
        $route->name = $name;
        $route->data = json_encode($data);
        $route->timestamp = $timestamp;

        if ($route->save()) {
            return $route;
        }

        return null;
    }
}
