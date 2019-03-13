<?php

namespace App\Services;


use App\Country;
use App\Registration;
use App\User;

class UserService
{

    /**
     * @param string $countryName
     *
     * @return array
     */
    public static function store($countryName)
    {
        $country = Country::where('name', $countryName)->first();
        if(!$country) {
            $country = Country::create([
                'name' => $countryName,
            ]);
        }

        $user = User::create();

        Registration::create([
            'user_id' => $user->id,
            'country_id' => $country->id
        ]);

        return [
            'user' => $user,
            'country' => $country
        ];
    }


    /**
     * @param int $id
     *
     * @return User
     */
    public static function show($id)
    {
        $user = User::find($id);

        $user->watches = $user->watches()->pluck('id');
        $user->likes = $user->likes()->pluck('id');
        $user->uploads = $user->uploads()->pluck('id');
        $user->country = $user->registration->country()->pluck('name');

        $user->totalVideosUploaded = $user->uploads->count();
        $user->totalVideosWatched = $user->watches->count();
        $user->totalVideosLiked = $user->likes->count();

        $user->makeHidden([
            'created_at',
            'updated_at',
            'deleted_at'
        ]);

        unset($user->registration);

        return $user;
    }

    /**
     * @param int $id
     * @param string $countryName
     */
    public static function update($id, $countryName)
    {
        $user = User::find($id);
        $country = Country::where('name', $countryName)->first();

        if(!$country) {
            $country = Country::create([
                'name' => $countryName
            ]);
        }

        $user->registration->load('country');
        $user->registration->country_id = $country->id;
        $user->registration->save();
    }

    /**
     * @param int $id
     */
    public static function destroy($id)
    {
        $user = User::find($id);

        $user->watches()->delete();
        $user->likes()->delete();
        $user->uploads()->delete();
        $user->registration()->delete();
        $user->delete();
    }
}