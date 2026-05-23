<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable('city_id', 'temperature', 'atmospheric_pressure', 'humidity', 'temperature_min', 'temperature_max', 'fetched_at')]
class Weather extends Model
{
    protected $table = 'weathers';
    
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fetched_at' => 'datetime'
        ];
    }

    public function city(): BelongsTo {
        return $this->belongsTo(City::class);
    }
}
