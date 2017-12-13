<?php

use App\Service\CurlWrapper;
use App\Service\Math;
use App\Service\YahooWeatherServiceProvider;
use PHPUnit\Framework\TestCase;

class YahooWeatherServiceProviderTest extends TestCase
{
    private function mockCurlWrapper()
    {
        $curlWrapper = $this->getMockBuilder(CurlWrapper::class)
            ->setMethods(['get'])
            ->getMock();

        $yahooFakeOutput = [
            'query' => [
                'results' => [
                    'channel' => [
                        'item' => [
                            'forecast' => [
                                [
                                    'high' => 5,
                                    'low' => -2,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $yahooFakeOutput = json_encode($yahooFakeOutput);

        $curlWrapper
            ->expects($this->any())
            ->method('get')
            ->willReturn($yahooFakeOutput);

        return $curlWrapper;
    }

    public function testGetWeatherTakesAverageFromTodayHighAndLow()
    {
        $curlWrapper = $this->mockCurlWrapper();

        $math = $this->getMockBuilder(Math::class)
            ->setMethods(['averageRoundedInteger'])
            ->getMock();

        $math
            ->expects($this->once())
            ->method('averageRoundedInteger')
            ->with(5, -2);

        $yahooWeather = new YahooWeatherServiceProvider($curlWrapper, $math);

        $yahooWeather->getWeather();
    }
}
