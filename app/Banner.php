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
        return $banners;
        // echo '<pre>'; print_r($banners); die;
    }
}
