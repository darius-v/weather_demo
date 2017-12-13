<?php

use App\Service\CurlWrapper;
use App\Service\Math;
use App\Service\YahooWeatherServiceProvider;
use PHPUnit\Framework\TestCase;

class YahooWeatherServiceProviderTest extends TestCase
{
    private function mockCurlWrapper(string $yahooOutput)
    {
        $curlWrapper = $this->getMockBuilder(CurlWrapper::class)
            ->setMethods(['get'])
            ->getMock();

        $curlWrapper
            ->expects($this->any())
            ->method('get')
            ->willReturn($yahooOutput);

        return $curlWrapper;
    }

    public function testGetWeatherTakesAverageFromTodayHighAndLow()
    {
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

        $curlWrapper = $this->mockCurlWrapper($yahooFakeOutput);

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

    /**
     * @expectedException App\ExceptionsForUser\GeneralException
     */
    public function testYahooServiceFailsToGiveResponse()
    {
        $curlWrapper = $this->mockCurlWrapper('');
        $math = $this->getMockBuilder(Math::class)
            ->getMock();

        $yahooWeather = new YahooWeatherServiceProvider($curlWrapper, $math);

        $yahooWeather->getWeather();
    }
}
