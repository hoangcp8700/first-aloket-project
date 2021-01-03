<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table= 'wards';

    protected $guarded = [];

    public function district(){
        return $this->belongsTo(District::class,'district_id');
    }
}
