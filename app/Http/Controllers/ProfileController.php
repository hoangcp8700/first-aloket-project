<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $orders =  Order::with(['province','district','ward','orderDetail' => function($query){
            $query->with(['product' => function($query1){
                $query1->select('id','name');
            }]);
         }])->where('email',Auth::user()->email)->get()->toArray();

        return view('pages.profile',compact('orders'));
    }

    public function uploadProfile(Request $req)
    {
        $rules = [
            'image' => 'required | image',
        ];

        $messages = [
            'image.required' => 'Vui lòng chọn ảnh đại diện',
            'image.image' => 'Chỉ nhận file PNG,JPEG,JPG'

        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()->all()[0]
            ]);
        }

        $user = Auth::user();
        $imagePath = $user->image;

        if($req->file('image')){
            if(Storage::disk('public')->exists($user->image)){
                Storage::disk('public')->delete($user->image);
            }
            $imagePath = $req->file('image')->store('profile/'.Carbon::now()->toDateString(),'public');
            Image::make(storage_path('app/public/'.$imagePath))->resize(245,163)->save();
        }

        $user = User::find($user->id);
        $user->update(['image' => $imagePath]);

        return response()->json([
            'status' => 'Thay đổi thông tin thành công!',
            'statuscode' =>'success',
            'data' => $user
        ]);


    }

    public function store(Request $req)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required | email'
        ];

        $messages = [
            'name.required' => 'Yêu cầu nhập tên đầy đủ',
            'phone.numeric' => 'Số điện thoại không hợp lệ',
            'email.required' => 'Yêu cầu nhập địa chỉ email',
            'email.email' => 'Email không hợp lệ',
            'address.max' => 'Tối đa :max ký tự'

        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        $validator->sometimes('phone','numeric', function($input){
            return !empty($input->phone);
        });
        $validator->sometimes('address','max:255', function($input){
            return !empty($input->address);
        });

        if ($validator->fails()) {
            return response()->json([
                'statucode' => 'error',
                'status' => $validator->messages()->all()[0]
            ]);
        }
        $user = Auth::user();

        $user->fill([
            'name' => $req->name,
            'email' => $req->email,
            'phone' => $req->phone,
            'address' => $req->address

        ])->save();

        return response()->json([
            'status' => 'Thay đổi thông tin thành công!',
            'statuscode' => 'success',
            'data' => $user
        ]);


    }

    public function password(Request $req)
    {
        $rules = [
            // 'password_current' => 'required ',
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ];

        $messages = [
        //   'password_current.required' => 'Yêu cầu nhập mật khẩu hiện tại',
          'password.required' => 'Yêu cầu nhập mật khẩu mới',
          'password.min' => 'Mật khẩu tói thiểu :min kí tự',
          'password.confirmed' => 'Mật khẩu không trùng khớp',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' =>  $validator->messages()->all()[0],
                'statuscode' => 'error'
            ]);
            return response()->json([
                'errors' => $validator->messages()->all()[0]
            ]);
        }
        // dd(Auth::user()->password);
        $data = $req->all();
        if(Auth::user()->password == null && $data['password_current'] == null){
            Auth::user()->fill([
                'password' => Hash::make($data['password'])
            ])->save();
            return response()->json([
                'status' => 'Đổi mật khẩu thành công!',
                'statuscode' => 'success'
            ]);
        }
        if(Hash::check($data['password_current'],Auth::user()->password)){

            Auth::user()->fill([
                'password' => Hash::make($data['password'])
            ])->save();
            return response()->json([
                'status' => 'Đổi mật khẩu thành công!',
                'statuscode' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'Mật khẩu hiện tại không chính xác! Vui lòng nhập lại',
                'statuscode' => 'error'
            ]);
        }

    }

    public function show(Request $req){
        if(request()->ajax()){
            $order = Order::with(['province','district','ward','orderDetail' => function($query){
                $query->with(['product' => function($query1){
                    $query1->select('id','name');
                }]);
            }])->find($req->order_id);

            if($order){
                $order = $order->toArray();
                    return response()->json($order);
            }
            return response()->json([
                'statuscode' => 'error',
                'status' => 'Đơn hàng của bạn đang trong quá trình xử lý!! Vui lòng chờ đợi'
            ]);

        }
    }

}
