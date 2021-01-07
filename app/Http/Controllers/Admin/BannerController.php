<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function index(){
        if (request()->ajax()) {
            return $this->datatables();
        }
        $urlBanners = [
            'index' => 'Trang chủ (header)',
            'index-footer' => 'Trang chủ (footer)',
            'index-middle' => 'Trang chủ (middle)',
            'index-doc' => 'Trang chủ (phụ dọc)',
            'index-ngang-1' => 'Trang chủ (phụ ngang 1)',
            'index-ngang-2' => 'Trang chủ (phụ ngang 2)',
            'index-ngang-3' => 'Trang chủ (phụ ngang 3)',
            'index-ngang-4' => 'Trang chủ (phụ ngang 4)',
            'menu-list' => 'Trang menu',
            'login' => 'Trang đăng nhập',
            'register' => 'Trang đăng ký',
            'cart' => 'Trang giỏ hàng',
            'check-out' => 'Trang thanh toán',
            'wishlist' => 'Trang yêu thích',
            'contact' => 'Trang liên hệ',
            'product-detail' =>'Trang chi tiết sản phẩm'
        ];
        return view('admin.banner',compact('urlBanners'));
    }

    public function datatables(){
        $banners = Banner::orderBy('created_at','desc')->get();
    	$table = Datatables::of($banners);
        $table->addIndexColumn();
        $table->addColumn('image',function($row){
            $url= asset('/storage/'.$row->image);
            return '<img class="img_datatable" src="'.$url.'">';
        });
        $table->addColumn('status',function($row){
                $stt = '';
                if($row->status == 1){
                $stt ='<a class="updateStatus" data-id="'.$row->id.'"
                href="javascript:void(0)">
                            <span class="label label-success">Đã Kích hoạt</span></a>';
                }else{
                $stt ='<a class="updateStatus" data-id="'.$row->id.'"
                href="javascript:void(0)">
                            <span class="label label-default">Chưa kích hoạt</span></a>';
                }
                return $stt;
                });
      $table->addColumn('action', function($row){
            $btn = '
						<a class="btn btn-info btn-xs editBanner" data-id="'.$row->id.'"
            data-toggle="modal" href="javascript:void(0)">
                            <i class="far fa-edit"></i>
                        </a>
                        <a class="btn btn-danger btn-xs deleteBanner" data-id="'.$row->id.'"
            href="javascript:void(0)">
                            <i class="fas fa-trash"></i>
						</a>';

            return $btn;
        });
      $table->rawColumns(['action','status','image']);
      return $table->make(true);
    }

    public function store(Request $req){

        $rules = [
            'title' => 'required',
        ];

        $messages = [
            'title.required' => 'Yêu cầu nhập tiêu đề!!',
            'image.required' => 'Vui lòng chọn một ảnh banner',
            'image.image' => 'Chỉ nhận file PNG,JPEG,JPG',
            'url.unique' => 'Địa chỉ URL đã tồn tại'
        ];

        $validator = Validator::make($req->all(), $rules, $messages);
        $validator->sometimes('image','required | image', function($input){
            return empty($input->id);
        });
        $validator->sometimes('image','image', function($input){
            return !empty($input->id);
        });
        $validator->sometimes('url','required | unique:banners', function($input){
            return empty($input->id);
        });
      if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->messages()->all()[0]
        ]);
      }else{
        if(!empty($req->id)){
            $banner = Banner::find($req->id);
            if($req->file('image')){
                if(Storage::disk('public')->exists($banner->image)){
                    Storage::disk('public')->delete($banner->image);
                }
                $imagePath = $req->file('image')->store('banner/'.Carbon::now()->toDateString(),'public');
                Image::make(storage_path('app/public/'.$imagePath))->resize(1300,500)->save();

            }else{
                $req['image']= $banner->image;
                $imagePath = $req->image;
            }

            $values = [
                'image' => $imagePath,
                'updated_at' => Carbon::now(),
            ];
            $banner->update(array_merge(
                $req->except('_token'),
                $values
            ));
            return response()->json([
                'success' => ' Cập nhập thành công!'
            ]);
        }else{
            $imagePath = '';
            $imagePath = $req->file('image')->store('banner/'.Carbon::now()->toDateString(),'public');
            Image::make(storage_path('app/public/'.$imagePath))->resize(1300,500)->save();

            $values = [
                'image' => $imagePath,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $create = Banner::insert(array_merge(
                $req->except('_token'),
                $values
            ));
            return response()->json([
                'success' => 'Tạo thành công!',
            ]);
        }

      }
    }

    public function edit($id)
    {
        $banner = Banner::find($id);
        return response()->json($banner);
    }

    public function updateStatus($id){
        $banner = Banner::find($id);
        if($banner->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        $banner->update([
            'status' => $status,
            'updated_at' => Carbon::now()
        ]);
        return response()->json([
                'statuscode' => 'success',
                'status' => 'Banner đã điều chỉnh thành công'
            ]);

    }

    public function destroy($id)
    {
      $banner = Banner::find($id)->delete();
      return response()->json([
        'success' => 'Xóa thành công!'
      ]);
    }
}
