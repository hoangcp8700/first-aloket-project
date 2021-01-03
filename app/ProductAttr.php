<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttr extends Model
{
    protected $table = 'products_attr';

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
