<?php

namespace App\Helpers;

class CurrencyConverstionHelper
{
    public static function convert($from, $to, $amount)
    {
        $url = 'https://free.currconv.com/api/v5/convert';
        $apiKey = "apiKey=".env('API_CURRENCY_CONVERSION');
        $compact = 'compact=ultra';

        $query = urldecode($from)."_".urldecode($to);
        $json = file_get_contents($url."?q=".$query."&".$compact."&".$apiKey);
        $conversion = json_decode($json, true);
        return $conversion[$query] * $amount;
    }
}