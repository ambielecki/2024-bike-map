<?php

namespace App\Services\Routes;

use App\Library\JsonResponseData;
use App\Library\Message;
use App\Models\Exclusion;
use App\Models\Route;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;
use Location\Coordinate;

class RouteService implements RouteServiceInterface {
    public function createRoute(int $userId, string $name, $file, $description, $request = null): ?Route {
        $fileService = new FitFileService();

        $data = $fileService->getLatLongFromFile($file);
        $latLng = $this->mapLatLngToArray($data, $userId);
        $timestamp = $fileService->getTimestampFromFile($file);

        if ($request && !$this->isRouteUnique($timestamp)) {
            throw new HttpResponseException(response()->json(
                JsonResponseData::formatData(
                    $request,
                    [
                        'errors' => ['file' => ['File Has Already Been Uploaded.']],
                        'status' => true,
                    ],
                    'Validation Failed',
                    Message::MESSAGE_ERROR)
                , 422));
        }

        $route = new Route();

        $route->user_id = $userId;
        $route->name = $name;
        $route->description = $description;
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

    public function isRouteUnique(int $timestamp): bool {
        $route = Route::query()
            ->where('timestamp', $timestamp)
            ->first();

        return $route === null;
    }
}
