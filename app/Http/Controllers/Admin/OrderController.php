<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
class OrderController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return $this->datatables();
        }
        $status = Order::status();
        return view('admin.order',compact('status'));

    }
    public function datatables()
    {
        $orders = Order::orderBy('id','desc')->get();

    	$table = Datatables::of($orders);
        $table->addIndexColumn();
        $table->addColumn('created_at',function($row){
                  return date('d-m-Y', strtotime($row->created_at));
        });
        $table->addColumn('total',function($row){
            return number_format($row->total).'đ';
        });
        $table->addColumn('status',function($row){
                $stt = '';
                if($row->status == 1){
                    $stt ='<span data-id="'.$row->id.'" class="updateStatus label label-success">Đã thanh toán</span>';
                }else if($row->status == 2){
                    $stt ='<span data-id="'.$row->id.'" class="updateStatus label label-info">Đang giao</span>';
                }else if($row->status == 3){
                    $stt ='<span data-id="'.$row->id.'" class="updateStatus label label-danger">Hủy đơn</span>';
                }else{
                    $stt ='<span data-id="'.$row->id.'" class="updateStatus label label-default">Chờ xử lý</span> ';
                }
                return $stt;
                });
      $table->addColumn('action', function($row){
            $btn = '
                        <a class="btn btn-success showOrder" data-id="'.$row->id.'"
                            data-toggle="modal" href="javascript:void(0)" data-target="#formModalShowOrder">
                            <i class="far fa-eye"></i>
                        </a>
                        <a class="btn btn-info editOrder" data-id="'.$row->id.'"
                            data-toggle="modal" href="javascript:void(0)" data-target="#formModalOrder">
                            <i class="far fa-edit"></i>
                        </a>
                       ';
            return $btn;
        });
      $table->rawColumns(['action','created_at','status','total']);
      return $table->make(true);
    }

    public function store(Request $req)
    {
        $data = $req->except('_token');
        Order::find($data['id'])->update(['status' => $data['status']]);
        return response()->json([
            'success' => 'Cập nhập thành công trạng thái'
        ]);
    }

    public function edit($id)
    {
      $order = Order::find($id);
      return response()->json($order);
    }
    // ,'district' => function($d){
    //     $d->select('name');
    // },'ward' => function($w){
    //     $w->select('name');
    // }
    public function show($id){
        $order = Order::with(['province','district','ward','orderDetail' => function($query){
                    $query->with(['product' => function($query1){
                        $query1->select('id','name');
                    }]);
                }])->find($id)->toArray();
       return response()->json($order);
    }
}
