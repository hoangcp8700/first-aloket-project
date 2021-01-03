<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use Carbon\Carbon;
use App\ProductAttr;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductAttrController extends Controller
{
    public function show($id){
        if(request()->ajax()){
            return $this->datatables($id);
        }

        $product = Product::find($id);
        return view('admin.product_attr',compact('product'));
    }

    public function datatables($id){
        $productAttrs = ProductAttr::where('product_id',$id)->orderBy('created_at','desc')->get();

    	$table = Datatables::of($productAttrs);
        $table->addIndexColumn();

        $table->addColumn('size',function($row){
            return '<span title="Size: '.$row->size.'" class="label label-info">'.$row->size.'</span>';
        });
        // $table->addColumn('color',function($row){
        //     return '<span class="label label-info">'.$row->color.'</span>';
        // });
        $table->addColumn('price',function($row){
            return number_format($row->price).' VNĐ';
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
            $btn = '<div style="display:flex">
                        <a style="margin-right:5px;" title="Edit Sản phẩm" class="btn btn-xs btn-info editAttr" data-id="'.$row->id.'"
            data-toggle="modal" data-target="#formModalAttr" href="javascript:void(0)">
                            <i class="far fa-edit"></i>
                        </a>
                        <a title="Delete Sản phẩm" class="btn btn-xs btn-danger deleteAttr" data-id="'.$row->id.'"
            data-toggle="modal" href="javascript:void(0)">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>';
            return $btn;
        });
      $table->rawColumns(['size','price','status','action']);
      return $table->make(true);
    }



    public function store(Request $req)
    {
        $rules = [
            'size.*' => 'required',
            'price.*' => 'required',
            'stock.*' => 'required',

        ];

        $messages = [
          'size.*.required' => 'Yêu cầu nhập size!!',
          'price.*.required' => 'Yêu cầu nhập giá tiền!!',
          'stock.*.required' => 'Yêu cầu nhập số lượng sản phẩm!!',

        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()->all()[0]
            ]);
        }else{
            $productAttr =  ProductAttr::find($req->id);
            $product = Product::find($req->product_id);

            $data = $req->all();
            if(!$productAttr){
                foreach($data['product_attr_code'] as $key => $value){
                    $ArrAttr = [
                        'product_id' => $data['product_id'],
                        'product_attr_code' => $value,
                        'size' => $data['size'][$key],
                        'price' => $data['price'][$key],
                        'stock' => $data['stock'][$key],

                    ];
                    $productAttrsCode = ProductAttr::where('product_attr_code',$value)->get()->count();
                    if($productAttrsCode > 0){
                        return response()->json([
                            'errors' => 'Mã sản phẩm đã tồn tại!',
                        ]);
                    }
                    $productAttrsSize = ProductAttr::where([
                        'product_id' => $req->id,
                        'size' => $data['size'][$key]
                    ])->get()->count();

                    if($productAttrsSize > 0){
                        return response()->json([
                            'errors' => 'Size đã tồn tại!',
                        ]);
                    }
                    if($data['price'][$key] > $product->price){
                        return response()->json([
                            'errors' => 'Số tiền lớn hơn số tiền gốc ban đầu!',
                        ]);
                    }
                    ProductAttr::insert($ArrAttr);
                }
                return response()->json([
                    'success' => 'Tạo thành công!',
                ]);
            }else{

                foreach($req->price as $price){
                    if($price  > $productAttr->product->price){
                        return response()->json([
                            'errors' => 'Số tiền lớn hơn số tiền gốc ban đầu!',
                        ]);
                    }
                }

                $productAttr->update([
                    'price' => $data['price'][0],
                    'stock' => $data['stock'][0],
                    'updated_at' => Carbon::now()
                ]);
                return response()->json([
                    'success' => 'Sửa thành công!',
                ]);
            }
        }

        // return back()->with('statuscode','success')->with('status','Update thành công!');

    }

    public function updateStatus($id){
        $productAttr = ProductAttr::find($id);
        if($productAttr->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        $productAttr->update([
            'status' => $status,
            'updated_at' => Carbon::now()
        ]);
        return response()->json([
            'statuscode' => 'success',
            'status' => 'Sản phẩm đã được điều chỉnh trạng thái!'
        ]);
    }

    public function edit($id){
        $attribute = ProductAttr::find($id);

        return response()->json($attribute);
    }

    public function destroy($id)
    {
      $attribute = ProductAttr::find($id)->delete();
      return response()->json([
        'success' => 'Xóa thành công!'
      ]);
    }
}
