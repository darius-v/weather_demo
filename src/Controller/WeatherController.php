<?php

namespace App\Controller;

use App\Service\WeatherService;
use App\ExceptionsForUser\GeneralException;
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
        try {
            $temperature = $this->weatherService->getTemperatureInVilnius();
        } catch (GeneralException $e) {
            return $this->render('error.html.twig', ['error' => $e->getMessage()]);
        }

        return $this->render('weather.html.twig', ['temperature' => $temperature]);
    }
}
