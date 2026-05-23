<?php

namespace App\Jobs;

use App\Models\Weather;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CleanOldWeatherJob implements ShouldQueue
{
    use Queueable;

    public function __construct(private int $days = 7) {}

    public function handle(): void
    {
        $deleted = Weather::where('fetched_at', '<', now()->subDays($this->days))->delete();
        Log::info("Cleaned {$deleted} old weather records older than {$this->days} days.");
    }
}