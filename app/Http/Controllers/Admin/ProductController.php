<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Section;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        if (request()->ajax()) {
            return $this->datatables();
        }

        $categories = Category::whereHas('section',function($section){
            $section->where('status',1);
        })->get();
        $sections = Section::where('status',1)->get();
        $fabrics = ['Vải Cotton','Vải kaki','Vải Jeans','Vải nỉ','Vải len','Vải kate','Vải thô','Vải voan','Vải lụa','Vải Nylon','Vải Canvas','Vải Lanh','Vải Viscose','Vải Spandex','Vải Modal','Vải Tencel','Vải Polyester (PE)','Vải Ren','Vải Đũi','Vải Bamboo','Vải Tuyết Mưa','Vải Jacquard'];
        $fits = ['Vừa vặn','Rộng rãi, thoải mái','Ôm sát cơ thể'];


        return view('admin.product',compact('categories','sections','fabrics','fits'));
    }

    public function datatables(){
        $products = Product::whereHas('section', function($section)
        {
            $section->where('status','=', 1);
        })->whereHas('category',function($category){
            $category->where('status','=',1);
        })->orderBy('created_at','desc')->get();

    	$table = Datatables::of($products);
        $table->addIndexColumn();
        $table->addColumn('section',function($row){
            return '<span title="'.$row->section->name.'" class="label label-success">'.$row->section->name.'</span>';
        });
        $table->addColumn('category',function($row){
            return '<span title="'.$row->category->name.'" class="label label-info">'.$row->category->name.'</span>';
        });
        $table->addColumn('price',function($row){
            return number_format($row->discount ? $row->discount : $row->price).' VNĐ';
        });
        $table->addColumn('image',function($row){
            $url= asset('/storage/'.$row->image);
            $image = '<img class="img_datatable" src="https://dummyimage.com/100X115/f7f7f7/090a1a.png&text=No+Image" >';
            if($row->image){
                $image = '<img class="img_datatable" data-id="'.$row->id.'" data-toggle="modal" data-target="#productDetailModal" src="'.$url.'"></div>';
            }
            return $image;

        });
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
        $table->addColumn('action', function($row){
          // <a class="btn btn-success" data-id="'.$row->id.'"
          //     data-toggle="modal" href="javascript:void(0)">
          //       <i class="halflings-icon white zoom-in"></i>
          //     </a>

            $btn = '<div style="display:flex">
                        <a title="Add/Edit Anh" class="btn btn-xs btn-info"
                            href="'.route('product_image.show',$row->id).'" style="margin-right:5px;">
                            <i class="fas fa-images"></i>
                        </a>
                        <a title="Add/Edit Thuộc tính" class="btn btn-xs btn-danger"
                        href="'.route('attr_product.show',$row->id).'" style="margin-right:5px;">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a title="Edit Sản phẩm" class="btn btn-xs btn-warning editProduct" data-id="'.$row->id.'"
            data-toggle="modal" href="javascript:void(0)">
                            <i class="far fa-edit"></i>
                        </a>
                        <a title="Delete Sản phẩm" class="btn btn-xs btn-danger deleteProduct" data-id="'.$row->id.'"
            data-toggle="modal" href="javascript:void(0)">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>';
            return $btn;
        });
      $table->rawColumns(['action','category','status','section','image']);
      return $table->make(true);
    }

    public function store(Request $req)
    {
    	$rules = [
            'section_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
            'product_code' => 'required',
            'color' => 'required',
            'price' => 'required',
            'slug' => 'unique:categories,slug',
        ];

        $messages = [
          'section_id.required' => 'Yêu cầu chọn lĩnh vực!!',
          'category_id.required' => 'Yêu cầu chọn danh mục!!',
          'name.required' => 'Yêu cầu nhập tên sản phẩm!!',
          'product_code.required' => 'Yêu cầu nhập mã Code!!',
          'color.required' => 'Chưa nhập màu!!',
          'price.required' => 'Yêu cầu nhập giá tiền!!',

          'unique' => 'Địa chỉ danh mục đã tồn tại!!!',
          'image.required' => 'Yêu cầu phải có ảnh sản phẩm!!',
          'image.image' => 'Chỉ nhận file PNG,JPEG,JPG',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        $validator->sometimes('image','required | image', function($input){
            return empty($input->id);
        });
        $validator->sometimes('image','image', function($input){
            return !empty($input->id);
        });


      if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->messages()->all()[0]
        ]);
      }else{
        if(!empty($req->id)){
            $product = Product::find($req->id);
            $imagePath  = $product->image;
            if($req->file('image')){
                if(Storage::disk('public')->exists($product->image)){
                    Storage::disk('public')->delete($product->image);
                }
                $imagePath = $req->file('image')->store('product/'.Carbon::now()->toDateString(),'public');
                Image::make(storage_path('app/public/'.$imagePath))->resize(500,654)->save();

            }
            $values = [
                'image'  => $imagePath,
                'updated_at' => Carbon::now()
            ];

            $product->update(array_merge(
                $req->except('_token'),
                $values
            ));
            return response()->json([
                'success' => ' Cập nhập thành công!'
            ]);
        }else{
            $imagePath = '';
            $imagePath = $req->file('image')->store('product/'.Carbon::now()->toDateString(),'public');
            Image::make(storage_path('app/public/'.$imagePath))->resize(500,654)->save();
            $values = [
                'image' => $imagePath,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $create = Product::insert(array_merge(
                $req->except('_token'),
                $values
            ));
            return response()->json([
                'success' => 'Tạo thành công!',
            ]);
        }

      }
    }

    public function edit($product)
    {
        $product = Product::find($product);

        return response()->json($product);
    }

    public function destroy($product){
        $product = Product::find($product);
        if($product){
            if(Storage::disk('public')->exists($product->image)){
                Storage::disk('public')->delete($product->image);
            }
        }
        $product->delete();
        return response()->json([
          'success' => 'Xóa thành công!'
        ]);
    }

    public function updateStatus($id){
        $product = Product::find($id);
        if($product->status == 1){
            $product->update([
                'status' => 0,
                'updated_at' => Carbon::now()
                ]);
            return response()->json([
                'statuscode' => 'success',
                'status' => 'Sản phẩm đã được ẩn!'
            ]);
        }else{
            $product->update([
            'status' => 1,
            'updated_at' => Carbon::now()
            ]);
            return response()->json([
                'statuscode' => 'success',
                'status' => 'Sản phẩm đã được công khai!'
            ]);
        }

    }

    public function deleteImage($product)
    {
        $product = Product::find($product);
        if($product){
            if(Storage::disk('public')->exists($product->image)){
                Storage::disk('public')->delete($product->image);
            }
        }
        $product->update([
            'image' => null,
            'updated_at' => Carbon::now()
        ]);
        return response()->json([
            'success' => 'Xóa ảnh thành công! Hãy thay thế một tấm ảnh khác đẹp hơn.'
          ]);
    }

    public function show($id)
    {
        $product = Product::with(['category' => function($query){
            $query->select('id','name');
        },'section' => function($query){
            $query->select('id','name');
        },'productImage','productAttr'])->find($id);

        $product = json_decode(json_encode($product));
        // echo '<pre>';print_r($product); die;
        return response()->json($product);
    }
}
