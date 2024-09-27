<?php

namespace App\Services\Routes;

use App\Models\Exclusion;
use App\Models\Route;
use App\Models\User;
use Illuminate\Support\Collection;
use Location\Coordinate;
use Location\Polygon;

class RouteService implements RouteServiceInterface {
    public function createRoute(int $userId, string $name, $file): ?Route {
        $fileService = new FitFileService();

        $data = $fileService->getLatLongFromFile($file);
        $latLng = $this->mapLatLngToArray($data, $userId);
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

    public function getRoutes(int $userId, array $filters = []): Collection {
        $query = Route::query()->where('user_id', $userId);

        if (!empty($filters['condensed'])) {
            $query = $query->select('id', 'name', 'timestamp');
        }

        return $query->get();
    }

    public function getRoute(int $id): ?Route {
        return Route::query()->find($id);
    }

    private function mapLatLngToArray(array $data, ?int $userId): array {
        $exclusionZone = null;
        if ($userId) {
            $exclusion = Exclusion::query()->where('user_id', $userId)->first();
            if ($exclusion) {
                $exclusionZone = $exclusion->getPolygon();
            }
        }

        $latLng = [];
        foreach ($data as $latLngData) {
            if ($exclusionZone && $exclusionZone->contains(new Coordinate($latLngData['lat'], $latLngData['lng']))) {
                continue;
            }

            $latLng[] = [$latLngData['lat'], $latLngData['lng']];
        }

        return $latLng;
    }
}
