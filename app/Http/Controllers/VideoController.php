<?php

namespace App\Http\Controllers;

use App\Services\VideoService;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function top()
    {
        $amountOfTopVideos = 5;
        $videoIds = VideoService::getTopVideos($amountOfTopVideos);

        return response(['video_ids' => $videoIds]);
    }


    /**
     * @param int $videoId
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function show($videoId)
    {
        $validator = Validator::make([
            'id' => $videoId,
        ],
        [
            'id' => 'exists:videos,id,deleted_at,NULL|required',
        ]);
        if($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }

        $video = VideoService::show($videoId);

        return response($video);
    }
}
