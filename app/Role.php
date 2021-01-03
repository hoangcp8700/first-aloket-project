<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $guarded = [];

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
}
