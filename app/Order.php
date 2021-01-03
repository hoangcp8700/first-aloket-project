<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $guarded = [];

    public static function status(){
        $status = [
            '0' => 'Đang xử lý',
            '1' => 'Đã thanh toán',
            '2' => 'Đang giao',
            '3' => 'Hủy đơn'
        ];
        return $status;
    }
    public static function checkStatus($status){
        $span = '';
        if($status == 0){
            $span = '<span class="badge badge-secondary">Đang xử lý</span>';
        }elseif($status == 1){
            $span = '<span class="badge badge-success">Đã thanh toán</span>';
        }elseif($status == 2){
            $span = '<span class="badge badge-info">Đang giao</span>';
        }else{
            $span = '<span class="badge badge-danger">Hủy đơn</span>';
        }
        return $span;
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class,'order_id');
    }

    public function province(){
        return $this->belongsTo(Province::class,'province_id');
    }
    public function district(){
        return $this->belongsTo(District::class,'district_id');
    }
    public function ward(){
        return $this->belongsTo(Ward::class,'ward_id');
    }
}
