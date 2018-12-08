<?php

namespace App\Http\Controllers;


class OuterApiController extends Controller
{
    public function weather()
    {
        $url = 'https://api.weather.yandex.ru/v1/forecast?lat=53.243325&lon=34.363731&extra=true';

        $headers = array('X-Yandex-API-Key: 00c10730-940b-43b3-a107-da6d6c4d61c5');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);
        curl_close ($ch);

        $weather = json_decode($response);

        return view('weather')->with('weather', $weather);
    }
}
