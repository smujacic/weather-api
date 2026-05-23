<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'Zagreb',    'lat' => 45.8150,  'long' => 15.9819],
            ['name' => 'Split',     'lat' => 43.5081,  'long' => 16.4402],
            ['name' => 'Rijeka',    'lat' => 45.3271,  'long' => 14.4422],
            ['name' => 'Osijek',    'lat' => 45.5511,  'long' => 18.6939],
            ['name' => 'Zadar',     'lat' => 44.1194,  'long' => 15.2314],
            ['name' => 'London',    'lat' => 51.5074,  'long' => -0.1278],
            ['name' => 'Paris',     'lat' => 48.8566,  'long' => 2.3522],
            ['name' => 'Berlin',    'lat' => 52.5200,  'long' => 13.4050],
            ['name' => 'New York',  'lat' => 40.7128,  'long' => -74.0060],
            ['name' => 'Tokyo',     'lat' => 35.6762,  'long' => 139.6503],
            ['name' => 'Sydney',    'lat' => -33.8688, 'long' => 151.2093],
            ['name' => 'Dubai',     'lat' => 25.2048,  'long' => 55.2708],
        ];

        foreach ($cities as $city) {
            City::updateOrCreate(['name' => $city['name']], $city);
        }
    }
}
