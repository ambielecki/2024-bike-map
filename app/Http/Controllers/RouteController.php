<?php

namespace App\Http\Controllers;

use App\Services\Routes\RouteService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RouteCreateRequest;

class RouteController extends Controller
{
    public function index(): JsonResponse {
        return response()->json(['test' => 'test']);
    }

    public function create(RouteCreateRequest $request): JsonResponse {
        $routeName = $request->input('name');
        $file = $request->file('file');
        $userId = 1;

       $routeService = new RouteService();
       $route = $routeService->createRoute($userId, $routeName, $file);

        return response()->json(['route' => $route]);
    }
}
