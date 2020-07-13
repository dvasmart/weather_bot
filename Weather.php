<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Weather
 */
class Weather
{
    protected $token = "";

    /**
     * @param $lat
     * @param $lon
     * @return mixed|null
     * @throws GuzzleException
     */
    public function getWeather($lat, $lon)
    {
        $url = 'api.openweathermap.org/data/2.5/weather';

        $params = [];
        $params['lat'] = $lat;
        $params['lon'] = $lon;
        $params['APPID'] = $this->token;

        $url .= "?" . http_build_query($params);

        $client = new Client([
            "base_uri" =>  $url
        ]);

        $result = $client->request("GET");

        return json_decode($result->getBody());
    }
}