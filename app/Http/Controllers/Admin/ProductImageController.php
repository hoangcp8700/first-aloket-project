<?php

namespace App\Http\Controllers\Admin;

// use Exception;
use App\Product;
use Carbon\Carbon;
use App\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
use Yajra\Datatables\Datatables;

class ProductImageController extends Controller
{
    public function show($id){

        if(request()->ajax()){
            return $this->datatables($id);
        }

        $product = Product::with(['productImage'])->select('id','name','product_code','color','image','status')->find($id);
        $product = json_decode(json_encode($product));
        // echo '<pre>'; print_r($product);die;
        return view('admin.product_image',compact('product'));
    }

    public function datatables($id){
        $productImages = ProductImage::where('product_id',$id)->orderBy('created_at','desc')->get();

    	$table = Datatables::of($productImages);
        $table->addIndexColumn();
        $table->addColumn('status',function($row){
            $stt = '<a class="updateStatus" data-id="'.$row->id.'"
                    href="javascript:void(0)">
                    <span class="label label-default">Chưa Kích hoạt</span></a>';
            if($row->status == 1){
                 $stt ='<a class="updateStatus" data-id="'.$row->id.'"
                    href="javascript:void(0)">
                    <span class="label label-success">Đã Kích hoạt</span></a>';
            }
            return $stt;
        });
        $table->addColumn('image',function($row){
            $url= asset('/storage/'.$row->image);
            $image = '<img class="img_datatable" src="https://dummyimage.com/100X115/f7f7f7/090a1a.png&text=No+Image" >';
            if($row->image){
                $image = '<img class="img_datatable" data-id="'.$row->id.'" src="'.$url.'"></div>';
            }
            return $image;

        });
        $table->addColumn('action', function($row){
            $btn = '<div style="display:flex">
                        <a style="margin-right:5px;" title="Edit Ảnh" class="btn btn-xs btn-info editProductImage" data-id="'.$row->id.'"
            data-toggle="modal" data-target="#formModalProductImage" href="javascript:void(0)">
                            <i class="far fa-edit"></i>
                        </a>
                        <a title="Delete Ảnh" class="btn btn-xs btn-danger deleteProductImage" data-id="'.$row->id.'"
            data-toggle="modal" href="javascript:void(0)">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>';
            return $btn;
        });
      $table->rawColumns(['image','status','action']);
      return $table->make(true);
    }

    public function store(Request $req)
    {

        $rules = [ 'image.*' => 'image',];
        $messages = ['imame.*.image' => 'Chỉ nhận file PNG,JPEG,JPG',];
        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->messages()->all()[0]
            ]);
        }else{
            if(empty($req->id)){
                $data = $req->all();
                $checkImageNull = Product::find($data['product_id']);
                if($checkImageNull->image == null){
                    return response()->json([
                        'statuscode' => 'error',
                        'status' => 'Bạn không thể thêm ảnh khi chưa có ảnh chính!'
                    ]);
                }
                foreach($data['image'] as $key => $value){
                    $DBProductImage = ProductImage::where('product_id',$data['product_id'])->get()->count();

                    $imagePath = $value->store('product_children/children_'. $data['product_id'] . '/' .Carbon::now()->toDateString(),'public');
                    Image::make(storage_path('app/public/'.$imagePath))->resize(125,156)->save();
                    $ArrImages= [
                        'product_id' => $data['product_id'],
                        'image' => $imagePath
                    ];
                    if($DBProductImage >= 3){
                        return response()->json([
                            'statuscode' => 'error',
                            'status' => 'Chỉ được tạo tối đa 3 ảnh!'
                        ]);
                    }
                    ProductImage::insert($ArrImages);
                }
                return response()->json([
                    'statuscode' => 'success',
                    'status' => 'Tạo thành công!'
                ]);
            }else{

                $productAttr =  ProductImage::find($req->id);
                $imagePath = $productAttr->image;
                if(Storage::disk('public')->exists($productAttr->image)){
                    Storage::disk('public')->delete($productAttr->image);
                }
                $imagePath = $req->file('image')->store('product_children/'.Carbon::now()->toDateString(),'public');
                Image::make(storage_path('app/public/'.$imagePath))->resize(125,156)->save();
                $productAttr->update([
                    'image' => $imagePath,
                    'updated_at' => Carbon::now()
                ]);

                return response()->json([
                    'statuscode' => 'success',
                    'status' => 'Sửa thành công!'
                ]);
            }
        }
    }

    public function updateStatus($id){
        $productImage = ProductImage::find($id);
        if($productImage->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        $productImage->update([
            'status' => $status,
            'updated_at' => Carbon::now()
        ]);
        return response()->json([
            'statuscode' => 'success',
            'status' => 'Sản phẩm đã được điều chỉnh trạng thái!'
        ]);
    }

    public function edit($id){
        $productimage = ProductImage::find($id);

        return response()->json($productimage);
    }

    public function destroy($id)
    {
        $productImage = ProductImage::find($id);
        if($productImage){
            if(Storage::disk('public')->exists($productImage->image)){
                Storage::disk('public')->delete($productImage->image);
            }
        }
        $productImage->delete();
        return response()->json([
          'success' => 'Xóa thành công!'
        ]);
    }

}
