<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table= 'districts';

    protected $guarded = [];

    public function district(){
        return $this->hasMany(Ward::class,'district_id');
    }

    public function province(){
        return $this->belongsTo(Province::class,'province_id');
    }
}
