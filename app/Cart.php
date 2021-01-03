<?php

namespace App;

use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    protected $table = 'carts';

    protected $guarded = [];

    public static function cartItems(){
        if(Auth::check()){
            $cartItems = Cart::with(['product' => function($query){
                $query->select('id','product_code','name','image','color','discount','price');
            }])->where(['user_id' => Auth::user()->id])->get()->toArray();
        }else{
            $cartItems =Cart::with(['product' => function($query){
                $query->select('id','product_code','name','image','color','discount','price');
            }])->where(['session_id' => Session::get('session_id')])->get()->toArray();
        }
        return $cartItems;
    }

    public static function getPriceAttr($product_id,$size){
        $priceAttr = ProductAttr::select('price')->where(['product_id' => $product_id, 'size' => $size])->first()->toArray();
        return $priceAttr['price'];
    }

    public static function loadCart()
    {
        $carts = Cart::with(['product' => function($query){
            $query->select('id','product_code','name','color','image');
        }])->where('session_id',Session::get('session_id'))->get()->toArray();

        // if(Auth::user()){
        //     $carts = Cart::with(['product' => function($query){
        //             $query->select('id','product_code','name','color','image');
        //         }])->where('session_id',Session::get('session_id'))
        //             ->where('user_id',Auth::user()->id)->get()->toArray();
        // }
        return $carts;
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function productAttr(){
        return $this->belongsTo(ProductAttr::class,'product_id');
    }
}
