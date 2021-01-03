<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';

    protected $guarded = [];

    public static function sections()
    {
        $sections = Section::with(['category'])->where('status',1)->get();
        $sections = json_decode(json_encode($sections),true);
        return $sections;
    }

    public function category()
   	{
   		return $this->hasMany(Category::class,'section_id')->where('status',1);
       }

}
