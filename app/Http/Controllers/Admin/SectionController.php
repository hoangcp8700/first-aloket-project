<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class SectionController extends Controller
{
    public function index(){

        $sections = Section::orderBy('created_at','desc')->get();
      
        if (request()->ajax()) {

            return $this->datatables();
        }
        return view('admin.section',compact('sections'));
    }

    public function datatables()
    {
        $section = Section::orderBy('created_at','desc')->get();
    	$table = Datatables::of($section);
        $table->addIndexColumn();
        
        $table->addColumn('status',function($row){
            $stt = '';
            if($row->status == 1){
            $stt ='<a class="updateStatus" data-id="'.$row->id.'"
                        href="javascript:void(0)">
                            <span class="label label-success">Đã Kích hoạt</span></a> ';
            }else{
            $stt ='<a class="updateStatus" data-id="'.$row->id.'"
                        href="javascript:void(0)">
                        <span class="badge badge-secondary">Chưa kích hoạt</span></a> ';
            }
            return $stt;
        });
      $table->rawColumns(['status']);
      return $table->make(true);
    }
    
    public function updateStatus($id){
        $section = Section::find($id);
        if($section->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        $section->update([
            'status' => $status,
            'updated_at' => Carbon::now()
        ]);
        return response()->json([
                'statuscode' => 'success',
                'status' => 'Lĩnh vực đã điều chỉnh thành công'
            ]);

    }   
}
