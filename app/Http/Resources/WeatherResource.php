<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                   => $this->id,
            'city'                 => $this->whenLoaded('city', fn() => [
                'name' => $this->city->name,
                'lat'  => $this->city->lat,
                'long' => $this->city->long,
            ]),
            'temperature'          => $this->temperature,
            'temperature_min'      => $this->temperature_min,
            'temperature_max'      => $this->temperature_max,
            'atmospheric_pressure' => $this->atmospheric_pressure,
            'humidity'             => $this->humidity,
            'fetched_at'           => $this->fetched_at?->toDateTimeString(),
        ];
    }
}