<?php

namespace App\Services;


use App\Video;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class VideoService
{

    /**
     * @param int $videoId
     */
    public static function show($videoId)
    {
        $video = Video::find($videoId);

        $video->total_views = $video->watches()->count();

        $viewsByCountry = [];
        foreach($video->watches as $watch) {
            $country = $watch->user->registration->country;
            if(isset($viewsByCountry[$country->id])) {
                $viewsByCountry[$country->id]['views']++;
            } else {
                $viewsByCountry[$country->id] = [
                    'views' => '1',
                    'name' => $country->name,
                ];
            }

            $video->views_by_country = array_values($viewsByCountry);
        }

        unset($video->watches);

        return $video;
    }


    /**
     * @param $amountOfTopVideos
     *
     * @return mixed
     */
    public static function getTopVideos($amountOfTopVideos)
    {
        $watches = DB::table('videos')
            ->selectRaw('videos.id, COUNT(*) as count')
            ->join('watches', 'watches.video_id', '=', 'videos.id')
            ->groupBy('videos.id')
            ->orderBy('count', 'DESC')
            ->limit($amountOfTopVideos)
            ->get();

        return Collection::make($watches)->pluck('id');
    }
}
