<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Requests;
use App\Services\CountryService;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    /**
     * @param string $name
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function showByName($name)
    {
        $validator = Validator::make([
            'country' => $name
        ],
        [
            'country' => 'required|exists:countries,name'
        ]);
        if($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }

        $country = CountryService::showByName($name);

        return response($country);
    }
}
