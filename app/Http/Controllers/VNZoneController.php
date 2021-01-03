<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VNZoneController extends Controller
{
    public function district($id)
    {
    	$districts = DB::table('districts')->where('province_id',$id)->orderby('name','asc')->get();
    	return response()->json($districts);
    }
  	public function ward($id)
  	{
  		$wards = DB::table('wards')->where('district_id',$id)->orderby('name','asc')->get();
    	return response()->json($wards);
  	}
}
