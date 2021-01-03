<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class,'section_id');
    }

    public function productAttr()
   	{
   		return $this->hasMany(ProductAttr::class)->where('status',1);
    }

    public function productImage()
    {
        return $this->hasMany(ProductImage::class,'product_id')->where('status',1);
    }
}
