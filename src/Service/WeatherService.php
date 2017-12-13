<?php

namespace App\Service;

class WeatherService
{
    private $weatherServiceProvider;

    public function __construct(WeatherServiceProviderInterface $weatherServiceProvider)
    {
        $this->weatherServiceProvider = $weatherServiceProvider;
    }

    public function getTemperatureInVilnius(): int
    {
        return $this->weatherServiceProvider->getWeather();
    }
}
