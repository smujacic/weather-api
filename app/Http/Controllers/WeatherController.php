<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use App\Http\Resources\WeatherResource;

class WeatherController extends Controller
{
    #[OA\Get(
        path: '/api/weather',
        summary: 'Get all weather data',
        tags: ['Weather'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'per_page', in: 'query', required: false, schema: new OA\Schema(type: 'integer', default: 20), description: 'Number of results per page'),
            new OA\Parameter(name: 'page', in: 'query', required: false, schema: new OA\Schema(type: 'integer', default: 1), description: 'Page number'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'List of weather data'),
            new OA\Response(response: 404, description: 'The weather data are empty'),
        ]
    )]
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);   
        $weather = Weather::with('city')->latest('fetched_at')->paginate($perPage);

        return WeatherResource::collection($weather);
    }


    #[OA\Get(
        path: '/api/weather/search',
        summary: 'Search weather by city name (last 24h)',
        tags: ['Weather'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'city', in: 'query', required: true, schema: new OA\Schema(type: 'string'), example: 'Zagreb'),
            new OA\Parameter(name: 'per_page', in: 'query', required: false, schema: new OA\Schema(type: 'integer', default: 20), description: 'Number of results per page'),
            new OA\Parameter(name: 'page', in: 'query', required: false, schema: new OA\Schema(type: 'integer', default: 1), description: 'Page number'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Weather data for city in last 24h'),
            new OA\Response(response: 404, description: 'City not found'),
        ]
    )]
    public function search(Request $request)
    {
        $request->validate([
            'city' => 'required|string|min:3',
        ]);

        $perPage = $request->input('per_page', 20); 

        $weather = Weather::with('city')
            ->whereHas('city', fn($q) => $q->where('name', 'like', '%' . $request->city . '%'))
            ->where('fetched_at', '>=', now()->subHours(24))
            ->latest('fetched_at')
            ->paginate($perPage);

        if ($weather->total() === 0) {
            return response()->json(['message' => 'No weather data found for this city in the last 24 hours'], 404);
        }

        return WeatherResource::collection($weather);
    }

}
