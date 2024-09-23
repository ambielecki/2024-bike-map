<?php

namespace App\Services\Routes;

use App\Models\Route;

class RouteService implements RouteServiceInterface {
    public function createRoute(int $userId, string $name, $file): ?Route {
        $fileService = new FitFileService();

        $data = $fileService->getLatLongFromFile($file);
        $latLng = $this->mapLatLngToArray($data);
        $timestamp = $fileService->getTimestampFromFile($file);

        $route = new Route();

        $route->user_id = $userId;
        $route->name = $name;
        $route->data = $data;
        $route->lat_lng = $latLng;
        $route->timestamp = $timestamp;

        if ($route->save()) {
            return $route;
        }

        return null;
    }

    public function getRoutes(int $userId, array $filters = []) {
        $filters = array_flip($filters);

        $query = Route::query()->where('user_id', $userId);

        if (isset($filters['no_lat_lng'])) {
            $query = $query->select('id', 'name', 'timestamp');
        }

        $routes = $query->get();

        return $routes;
    }

    public function getRoute(int $id): ?Route {
        return Route::query()->find($id);
    }

    private function mapLatLngToArray(array $data): array {
        $latLng = [];
        foreach ($data as $timestamp => $latLngData) {
            $latLng[] = [$latLngData['lat'], $latLngData['lng']];
        }

        return $latLng;
    }
}
