<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $guarded = [];

    public static function date($date)
    {
        if(Carbon::today() > Carbon::parse($date) ){
            return date('d-m-Y', strtotime($date));
        }else{
            // dd(date('H', strtotime($date)));
            if(date('H', strtotime($date)) < 12){

                return date('H : i', strtotime($date)).' AM';
            }else{
                return date('H : i', strtotime($date)).' PM';
            }
        }
    }

    public static function headerContact(){
        $contacts = Contact::where('status',0)
                ->orderBy('created_at','desc')->get()->toArray();
        return $contacts;
    }

}
