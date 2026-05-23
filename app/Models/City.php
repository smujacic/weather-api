<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['name', 'lat', 'long'])]
class City extends Model
{
    public function weather(): HasMany {
        return $this->hasMany(Weather::class);
    }

    public function lastWeather(): HasOne {
        return $this->hasOne(Weather::class)->latestOfMany('fetched_at');
    }
}
