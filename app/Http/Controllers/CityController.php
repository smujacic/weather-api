<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class CityController extends Controller
{
   #[OA\Get(
        path: '/api/cities',
        summary: 'Get all cities',
        tags: ['City'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'List of cities'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index()
    {
        return response()->json(City::all());
    }

    #[OA\Post(
        path: '/api/cities',
        summary: 'Create city',
        tags: ['City'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'lat', 'long'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Zagreb'),
                    new OA\Property(property: 'lat',  type: 'number', example: 45.8150),
                    new OA\Property(property: 'long', type: 'number', example: 15.9819),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'City created'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:cities',
            'lat'  => 'required|numeric',
            'long' => 'required|numeric',
        ]);

        $city = City::create($data);

        return response()->json($city, 201);
    }

    #[OA\Get(
        path: '/api/cities/{id}',
        summary: 'Get city by ID',
        tags: ['City'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'City'),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function show(City $city)
    {
        return response()->json($city);
    }

    #[OA\Put(
        path: '/api/cities/{id}',
        summary: 'Update city',
        tags: ['City'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Zagreb'),
                    new OA\Property(property: 'lat',  type: 'number', example: 45.8150),
                    new OA\Property(property: 'long', type: 'number', example: 15.9819),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'City updated'),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function update(Request $request, City $city)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|unique:cities,name,' . $city->id,
            'lat'  => 'sometimes|numeric',
            'long' => 'sometimes|numeric',
        ]);

        $city->update($data);

        return response()->json($city);
    }

    #[OA\Delete(
        path: '/api/cities/{id}',
        summary: 'Delete city',
        tags: ['City'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'City deleted'),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function destroy(City $city)
    {
        $city->delete();

        return response()->json(['message' => 'City deleted']);
    }
}
