<?php

namespace App\Http\Controllers;

use App\Http\Requests\Routes\RouteCreateRequest;
use App\Library\JsonResponseData;
use App\Library\Message;
use App\Services\Routes\RouteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RouteController extends Controller {
    public function index(Request $request): JsonResponse {
        // TODO: Auth vs Non Auth
        $routeService = new RouteService();
        if ($routes = $routeService->getRoutes(1, (array) $request->input('filters'))) {
            return response()->json(JsonResponseData::formatData(
                $request,
                ['routes' => $routes],
            ));
        }

        return response()->json(JsonResponseData::formatData(
            $request,
            [],
            'No routes found',
            Message::MESSAGE_WARNING
        ), 204);
    }

    public function create(RouteCreateRequest $request): JsonResponse {
        $routeName = $request->input('name');
        $file = $request->file('file');
        $decription = $request->input('description');
        $userId = auth()->user()->id;

        $routeService = new RouteService();
        if ($route = $routeService->createRoute($userId, $routeName, $file, $decription, $request)) {
            return response()->json(JsonResponseData::formatData(
                $request,
                ['route' => $route],
            ));
        }

        return response()->json(JsonResponseData::formatData(
            $request,
            [],
            'Something went wrong',
            Message::MESSAGE_ERROR
        ), 500);
    }

    public function show(Request $request, int $id): JsonResponse {
        // TODO: Add Auth
        $routeService = new RouteService();
        if ($route = $routeService->getRoute($id)) {
            return response()->json(JsonResponseData::formatData(
                $request,
                ['route' => $route],
            ));
        }

        return response()->json(JsonResponseData::formatData(
            $request,
            [],
            'Route not found',
            Message::MESSAGE_WARNING
        ), 404);
    }
}
