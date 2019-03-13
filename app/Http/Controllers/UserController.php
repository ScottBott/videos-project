<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $countryName = $request->get('country', '');
        $validator = Validator::make([
            'country' => $countryName
        ],
        [
            'country' => 'required'
        ]);
        if($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }

        $countryName = $request->get('country');
        $userData = UserService::store($countryName);


        return response([
            'user_id' => $userData['user']->id,
            'country' => $userData['country']->name,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validator = Validator::make([
            'id' => $id,
        ],
        [
            'id' => 'exists:users,id,deleted_at,NULL|required',
        ]);
        if($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }

        $user = UserService::show($id);

        return compact('user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $countryName = $request->get('country', '');
        $validator = Validator::make([
            'id' => $id,
            'country' => $countryName
        ],
        [
            'id' => 'exists:users,id,deleted_at,NULL|required',
            'country' => 'required'
        ]);
        if($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }

        UserService::update($id, $countryName);

        return response(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validator = Validator::make([
            'id' => $id,
        ],
        [
            'id' => 'exists:users,id,deleted_at,NULL|required',
        ]);
        if($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }

        UserService::destroy();

        return response(['success' => true]);
    }
}
