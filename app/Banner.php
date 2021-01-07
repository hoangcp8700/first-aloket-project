<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';

    protected $guarded = [];

    public static function banners($url)
    {
        $banners = Banner::where('url',$url)
            ->where('status',1)
            ->get();

        $banners = json_decode(json_encode($banners));
        if(!$banners){
            $bannersM = asset('frontend/assets/img/bg/breadcrumb.jpg');
        }else{
            $bannersM = asset('/storage/'.$banners[0]->image);
        }
        return $bannersM;

    }
    public static function bannerIndex($url)
    {
        $banners = Banner::where('url',$url)
            ->where('status',1)
            ->get();

        $banners = json_decode(json_encode($banners));
        return $banners;

    }
}
