<?php

namespace App\Http\Controllers;

use App\Http\Requests\Routes\RouteCreateRequest;
use App\Library\JsonResponseData;
use App\Library\Message;
use App\Services\Routes\RouteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index(Request $request): JsonResponse {
        $routeService = new RouteService();
        $routes = $routeService->getRoutes(1, (array) $request->input('filters'));

        return response()->json(JsonResponseData::formatData(
            $request,
            '',
            Message::MESSAGE_OK,
            ['routes' => $routes],
        ));
    }

    public function create(RouteCreateRequest $request): JsonResponse {
        $routeName = $request->input('name');
        $file = $request->file('file');
        $userId = 1;

       $routeService = new RouteService();
       $route = $routeService->createRoute($userId, $routeName, $file);

        return response()->json(['route' => $route]);
    }

    public function show(Request $request, int $id): JsonResponse {
        // TODO: Add Auth
        $routeService = new RouteService();
        $route = $routeService->getRoute($id);

        return response()->json(JsonResponseData::formatData(
            $request,
            '',
            Message::MESSAGE_OK,
            ['route' => $route],
        ));
    }
}
