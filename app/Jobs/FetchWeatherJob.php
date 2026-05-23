<?php

namespace App\Jobs;

use App\Services\WeatherService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class FetchWeatherJob implements ShouldQueue
{
    use Queueable;

    public function handle(WeatherService $weatherService): void
    {
        Log::info('Fetching weather data for all cities...');
        $weatherService->fetchForAllCities();
        Log::info('Weather data fetched successfully.');
    }
}
