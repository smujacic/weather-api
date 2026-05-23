<?php

namespace App\Services;

use App\Models\City;
use App\Models\Weather;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    private string $apiKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey  = config('services.openweather.key');
        $this->baseUrl = config('services.openweather.base_url');
    }

    public function fetchForAllCities(): void
    {
        City::chunk(100, function ($cities) {
            foreach ($cities as $city) {
                try {
                    $this->fetchAndStoreForCity($city);
                } catch (\Exception $e) {
                    Log::error("Failed to fetch weather for {$city->name}: " . $e->getMessage());
                }
            }
        });
    }

    public function fetchAndStoreForCity(City $city): Weather
    {
        $data = $this->getCityWeather($city->lat, $city->long);
   
        if (!isset($data['main'])) {
            throw new \Exception('Unexpected API response structure');
        }

        return Weather::create([
            'city_id'              => $city->id,
            'temperature'          => $data['main']['temp'],
            'temperature_min'      => $data['main']['temp_min'],
            'temperature_max'      => $data['main']['temp_max'],
            'atmospheric_pressure' => $data['main']['pressure'],
            'humidity'             => $data['main']['humidity'],
            'fetched_at'           => now(),
        ]);
    }

    public function getCityWeather(float $lat, float $long): array
    {
        $response = Http::get("{$this->baseUrl}/weather", [
            'lat'   => $lat,
            'lon'   => $long,
            'appid' => $this->apiKey,
            'units' => 'metric',
        ]);

        if ($response->failed()) {
            throw new \Exception('Weather API error: ' . $response->body());
        }

        return $response->json();
    }
}