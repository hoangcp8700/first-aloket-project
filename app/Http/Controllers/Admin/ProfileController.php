<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index($page)
    {

        $profile = Admin::where('email',Auth::guard('admin')->user()->email)->first();
        return view('admin.'.$page,compact('profile'));
    }

    public function changePassword(Request $req)
    {

        $rules = [
            'password_current' => 'required ',
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ];

        $messages = [
          'password_current.required' => 'Yêu cầu nhập mật khẩu hiện tại',
          'password.required' => 'Yêu cầu nhập mật khẩu mới',
          'password.min' => 'Mật khẩu tói thiểu :min kí tự',
          'password.confirmed' => 'Mật khẩu không trùng khớp',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()->all()[0]
            ]);
        }

        if(Hash::check($req->password_current,Auth::guard('admin')->user()->password)){
            Auth::guard('admin')->user()->fill([
                'password' => Hash::make($req->password)
            ])->save();
            return response()->json([
                'success' => 'Đổi mật khẩu thành công!'
            ]);
        }else{
            return response()->json([
                'errors' => 'Mật khẩu hiện tại không chính xác! Vui lòng nhập lại'
            ]);
        }

    }

    public function updateProfile(Request $req)
    {
        $rules = [
            'name' => ['required',],
            'phone' => ['required', 'alpha_num', 'max:12'],
        ];

        $messages = [
            'name.required' => 'Yêu cầu nhập tên đầy đủ',
            'phone.required' => 'Yêu cầu nhập số điện thoại',
            'phone.alpha_num' => 'Số điện thoại không hợp lệ',
            'phone.max' => 'Số điện thoại không hợp lệ',
            'image.required' => 'Vui lòng chọn ảnh đại diện',
            'image.image' => 'Chỉ nhận file PNG,JPEG,JPG'

        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        $validator->sometimes('image','required | image', function($input){
            return empty($input->image);
        });
        if($req->file('image')){
            $validator->sometimes('image','image', function($input){
                return !empty($input->image);
            });
        }
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()->all()[0]
            ]);
        }
        $admin = Auth::guard('admin')->user();
        $imagePath = $admin->image;
        if($req->file('image')){
            if(Storage::disk('public')->exists($admin->image)){
                Storage::disk('public')->delete($admin->image);
            }
            $imagePath = $req->file('image')->store('avatar/'.Carbon::now()->toDateString(),'public');
            Image::make(storage_path('app/public/'.$imagePath))->resize(150,150)->save();
        }

        $admin->fill([
            'name' => $req->name,
            'phone' => $req->phone,
            'image' => $imagePath
        ])->save();

        return response()->json([
            'success' => 'Thay đổi thông tin thành công!',
            'data' => $admin
        ]);

    }
}
