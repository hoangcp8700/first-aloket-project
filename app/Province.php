<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table= 'provinces';

    protected $guarded = [];

    public function district(){
        return $this->hasMany(District::class,'province_id');
    }
}
