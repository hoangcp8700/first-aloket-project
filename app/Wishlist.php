<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlist';

    protected $guarded = [];

    public $timestamps = false;

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public static function colorWishlist($product,$auth)
    {
        $wishlist = Wishlist::where('product_id',$product)->where('user_id',$auth)->first();
        if(!empty($wishlist)){
            return true;
        }else{
            return false;
        }

    }
}
