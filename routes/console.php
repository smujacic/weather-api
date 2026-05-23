<?php

use App\Jobs\CleanOldWeatherJob;
use App\Jobs\FetchWeatherJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::job(FetchWeatherJob::class)->everyTenMinutes();
Schedule::job(new CleanOldWeatherJob(days: 3))->daily();