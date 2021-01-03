<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Section;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index()
    {
        $sections = Section::where('status',1)->get();
        if (request()->ajax()) {
            return $this->datatables();
        }

        return view('admin.category',compact('sections'));

    }
    public function datatables()
    {
        $categories = Category::whereHas('section', function($section)
        {
            $section->where('status','=', 1);
        })->orderBy('created_at','desc')->get();
    	$table = Datatables::of($categories);
        $table->addIndexColumn();
        $table->addColumn('section',function($row){
            return '<span class="label label-info">'.$row->section->name.'</button>';
        });
        $table->addColumn('created_at',function($row){
                  return date('d-m-Y', strtotime($row->created_at));
                });
        $table->addColumn('updated_at',function($row){
                  return date('d-m-Y', strtotime($row->updated_at));
                });
        $table->addColumn('status',function($row){
            // <a href="'.URL('/admin/category/status/'.$row->id.'').'">
            //                 <span class="label label-success">Đã Kích hoạt</span></a>
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
      $table->addColumn('action', function($row){
            $btn = '
						<a class="btn btn-info editCategory" data-id="'.$row->id.'"
            data-toggle="modal" href="javascript:void(0)">
                            <i class="far fa-edit"></i>
						</a>
						<a class="btn btn-danger deleteCategory" data-id="'.$row->id.'"
            data-toggle="modal" href="javascript:void(0)">
                            <i class="fas fa-trash"></i>
						</a>';
            return $btn;
        });
      $table->rawColumns(['action','created_at','updated_at','status','section']);
      return $table->make(true);
    }

    public function store(Request $req)
    {
    	$rules = [
        'name' => 'required',
        'description' => 'max:255',
        // 'slug' => 'unique:categories,slug'
      ];

      $messages = [
          'required' => 'Yêu cầu nhập tên danh mục!!',
          'max' => 'Tối đa :max kí tự!!!',
        //   'unique' => 'Địa chỉ danh mục đã tồn tại!!!'
      ];
      $validator = Validator::make($req->all(), $rules, $messages);
      if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->messages()->all()[0]
        ]);
      }else{
        if(!empty($req->id)){
          $findID = Category::find($req->id)->update(array_merge(
            $req->except('_token'),
            ['updated_at' => Carbon::now()]
          ));
          return response()->json([
            'success' => ' Cập nhập thành công!'
          ]);
        }else{
          $values = [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
          ];
          $create = Category::insert(array_merge(
            $req->except('_token'),
            $values
          ));
          return response()->json([
              'success' => 'Tạo thành công!',
          ]);
        }

      }
    }

    public function edit($category)
    {
      $category = Category::find($category);
      return response()->json($category);
    }

    public function destroy($category)
    {
      $category = Category::find($category)->delete();
      return response()->json([
        'success' => 'Xóa thành công!'
      ]);
    }

    public function updateStatus($category)
    {

        $categories = Category::where('status',1)->get();
        $category  = Category::find($category);
        if(count($categories) > 10){
            return response()->json([
                'statuscode' => 'warning',
                'status' => 'Chỉ được công khai 10 danh mục!'
            ]);
        }


        if($category->status == 1){
            $category->update([
                'status' => 0,
                'updated_at' => Carbon::now()
            ]);
            return response()->json([
                'statuscode' => 'success',
                'status' => 'Danh mục đã được ẩn thành công!'
            ]);
        }else{
            $category->update([
            'status' => 1,
            'updated_at' => Carbon::now()
            ]);
            return response()->json([
                'statuscode' => 'success',
                'status' => 'Danh mục đã được công khai !'
            ]);
        }
    }
}
