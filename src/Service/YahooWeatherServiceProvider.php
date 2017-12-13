<?php

namespace App\Service;

class YahooWeatherServiceProvider implements WeatherServiceProviderInterface
{
    private $curlWrapper;
    private $math;

    public function __construct(CurlWrapper $curlWrapper, Math $math)
    {
        $this->curlWrapper = $curlWrapper;
        $this->math = $math;
    }

    /**
     * Returns 'current' temperature in Vilnius.
     * Since yahoo does not have current temperature, we get average from the today's forecast in Vilnius
     * @return int
     */
    public function getWeather(): int
    {
        $baseUrl = "http://query.yahoooapis.com/v1/public/yql";
        $yqlQuery = 'select * from weather.forecast where woeid in 
            (select woeid from geo.places(1) where text="Vilnius,lt") and u="c"';

        $yqlQueryUrl = $baseUrl . "?q=" . urlencode($yqlQuery) . "&format=json";

        $json = $this->curlWrapper->get($yqlQueryUrl);

        $weather = json_decode($json, true);

        $todayForecast = $weather['query']['results']['channel']['item']['forecast'][0];

        return $this->math->averageRoundedInteger($todayForecast['high'], $todayForecast['low']);
    }
}
