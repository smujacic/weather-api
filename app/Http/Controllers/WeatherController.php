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
            new OA\Parameter(name: 'per_page', in: 'query', required: false, schema: new OA\Schema(type: 'integer', default: 20), description: 'Number of results per page')
        ],
        responses: [
            new OA\Response(response: 200, description: 'List of weather data'),
            new OA\Response(response: 404, description: 'The weather data are empty'),
        ]
    )]
    public function index(Request $request)
    {
       return [];
    }


    #[OA\Get(
        path: '/api/weather/search',
        summary: 'Search weather by city name (last 24h)',
        tags: ['Weather'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'city', in: 'query', required: true, schema: new OA\Schema(type: 'string'), example: 'Zagreb'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Weather data for city in last 24h'),
            new OA\Response(response: 404, description: 'City not found'),
        ]
    )]
    public function search(Request $request)
    {
        return [];
    }

}
