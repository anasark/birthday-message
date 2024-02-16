<?php

use Carbon\Carbon;
use Igaster\LaravelCities\Geo;

if (!function_exists('getCountries')) {
    function getCountries()
    {
        return [
            'ID' => 'Indonesia',
            'AU' => 'Australia'
        ];
    }
}

if (!function_exists('getCountryName')) {
    function getCountryName($code)
    {
        return getCountries()[$code];
    }
}

if (!function_exists('getRandomGeo')) {
    function getRandomGeo($code)
    {
        return Geo::country($code)
            ->level(Geo::LEVEL_2)
            ->where('timezone', '<>', '')
            ->get()
            ->random(1)
            ->first();
    }
}
