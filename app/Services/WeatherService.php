<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = "d08526e96d3890b8debcea594f5afcc8";
        $this->apiUrl = "https://api.openweathermap.org/data/2.5/weather?units=metric&";
    }

    public function getWeatherByCity($city)
    {
        try {
            $response = Http::get($this->apiUrl . "q={$city}&appid={$this->apiKey}");
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getSeasonFromTemperature($temperature)
    {
        if ($temperature < 10) {
            return 'Winter';
        } elseif ($temperature < 20) {
            return 'Spring';
        } elseif ($temperature < 30) {
            return 'Summer';
        } else {
            return 'Autumn';
        }
    }
} 