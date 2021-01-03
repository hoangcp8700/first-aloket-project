<?php

namespace App\Http\Controllers\Admin;

use App\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            return $this->datatables();
        }
        $typeCode = [
            '%' => 'Phần trăm',
            '$' => 'Số tiền',
            '?' => 'Ngẫu nhiên nhưng không quá 10% giá trị sản phẩm'
        ];
        return view('admin.coupon',compact('typeCode'));
    }

    public function datatables(){
        $coupons = Coupon::orderBy('created_at','desc')->get();
        $table = Datatables::of($coupons);
        $table->addIndexColumn();

        $table->addColumn('type',function($row){
            return '<span class="label label-info">'.$row->value.' <label>'.$row->type.'</label></span>';
        });
        $table->addColumn('created_at',function($row){
            return date('d-m-Y h:m', strtotime($row->created_at));
          });
        $table->addColumn('outdate',function($row){
                    return date('d-m-Y h:m', strtotime($row->outdate));
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
                        <a style="margin-right:5px;" title="Edit Coupon" class="btn btn-xs btn-info editCoupon" data-id="'.$row->id.'"
            data-toggle="modal" data-target="#formModalCoupon" href="javascript:void(0)">
                            <i class="far fa-edit"></i>
                        </a>
                        <a title="Delete Sản phẩm" class="btn btn-xs btn-danger deleteCoupon" data-id="'.$row->id.'"
            data-toggle="modal" href="javascript:void(0)">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>';
            return $btn;
        });
        $table->rawColumns(['type','status','action','outdate','created_at']);
        return $table->make(true);
    }

    public function store(Request $req)
    {
    	$rules = [
            'type' => 'required',
            'quantity' => 'required',
        ];

      $messages = [
          'type.required' => 'Yêu cầu chọn loại coupon!!',
          'value.required' => 'Yêu cầu nhập giá trị coupon!!',
          'quantity.required' => 'Yêu cầu nhập số lượng!!',
      ];


      $validator = Validator::make($req->all(), $rules, $messages);

        $validator->sometimes('value','required', function($input){
            return !($input->type == '?');
         });

      if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->messages()->all()[0]
        ]);
      }else{
        $data= $req->except('_token');
        if(!empty($req->id)){
            $findID = Coupon::find($data['id'])->update(array_merge(
                $data,
                ['updated_at' => Carbon::now()]
            ));
            return response()->json([
                'success' => ' Cập nhập thành công!'
            ]);
        }else{
            $CouponCheck = Coupon::where('code',$data['code'])->get();
            if(!empty($CouponCheck)){
                $data['code'] = $data['code'] + rand(1,20);
            }
            if($data['type'] == '?'){
                $data['value'] = rand(1,9);
            }
            $values = [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $create = Coupon::insert(array_merge($data,$values));
            return response()->json([
                'success' => 'Tạo thành công!',
            ]);
        }

      }
    }

    public function edit($id)
    {
      $coupon = Coupon::find($id);
      return response()->json($coupon);
    }

    public function destroy($id)
    {
      $coupon = Coupon::find($id)->delete();
      return response()->json([
        'success' => 'Xóa thành công!'
      ]);
    }

    public function updateStatus($id){
        $coupon = Coupon::find($id);
        if($coupon->status == 1){
            $status = 0;
        }else{
            $status = 1;
        }
        $coupon->update([
            'status' => $status,
            'updated_at' => Carbon::now()
        ]);
        return response()->json([
            'statuscode' => 'success',
            'status' => 'Coupon đã được điều chỉnh trạng thái!'
        ]);
    }
}
