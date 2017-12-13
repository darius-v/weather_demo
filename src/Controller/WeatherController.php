<?php

namespace App\Controller;

use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class WeatherController extends Controller
{
    private $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function showWeatherAction(): Response
    {
        $temperature = $this->weatherService->getTemperatureInVilnius();

        return $this->render('weather.html.twig', ['temperature' => $temperature]);
    }
}
