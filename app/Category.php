<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   	protected $table = 'categories';

    protected $guarded = [];


    public static function categories()
    {
        $categories = Category::with(['product'])->where('status',1)->get();
        $categories = json_decode(json_encode($categories),true);
        return $categories;
        //  echo '<pre>'; print_r($categories); die;
    }

    public function product()
   	{
   		return $this->hasMany(Product::class)->where('status',1);
    }


    public function section()
    {
        return $this->belongsTo(Section::class,'section_id')->select('id','name','status');
    }

    public function categoryDetails($slug)
    {
        $categoryDetails = Category::select('id','name','slug')->with('section')->where('slug',$slug)->first()->toArray();
        return $categoryDetails;
        // dd($categoryDetails); die;
    }
}
