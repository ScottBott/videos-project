<?php

namespace App\Services;


use App\Country;

class CountryService
{
    /**
     * @param string $name
     *
     * @return Country
     */
    public static function showByName($name)
    {
        $country = Country::where('name', $name)->first();
        $country->total_users = $country->registrations()->count();
        $country->user_ids = $country->registrations()->pluck('user_id');

        return $country;
    }
}
