<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Role;
use App\User;
use App\Admin;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        $productCount = Product::count();
        $adminCount= Admin::count();
        $userCount= User::count();
    	return view('admin.dashboard',compact('productCount','adminCount','userCount'));
    }

    public function formlogin()
    {

        return view('admin.login_admin');
    }

    public function register(Request $req)
    {

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        $messages = [
            'name.required' => 'Yêu cầu nhập họ tên',
            'email.required' => 'Yêu cầu nhập địa chỉ email',
            'password.required' => 'Yêu cầu nhập mật khẩu',
            'name.string' => 'Tên không hợp lệ',
            'email.unique' => 'Email đã tồn tại vui lòng nhập địa chỉ email khác',
            'password.min' => 'Mật khẩu tói thiểu :min kí tự',
            'password.confirmed' => 'Mật khẩu không trùng khớp',
        ];
        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {

            return back()
            ->with('statuscode','error')
            ->with('register','error')
            ->with('status',$validator->messages()->all()[0]);
        }

        $create = Admin::create([
            'name' => $req->name,
            'email' =>  $req->email,
            'password' => Hash::make($req->password),
        ]);

        return back()
            ->with('statuscode','success')
            ->with('status','Đăng ký thành công! Hãy chờ kết quá từ quản trị viên');

    }

    public function login(Request $req)
    {
        $rules = [
            'email' => ['required'],
            'password' => ['required']
        ];

        $messages = [
            'email.required' => 'Yêu cầu nhập địa chỉ email',
            'password.required' => 'Yêu cầu nhập mật khẩu',
        ];
        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->with('statuscode','error')
            ->with('login','error')
            ->with('status',$validator->messages()->all()[0]);
        }
        $credentials = $req->only('email', 'password');

        if(Auth::guard('admin')->attempt($credentials)){
            $admin = Auth::guard('admin')->user();
            if($admin->status == 0){
                return back()
                ->with('login','error')
                ->with('statuscode','error')
                ->with('status','Tài khoản của bạn chưa kích hoạt');

            }elseif($admin->status == 2){
                return back()
                ->with('login','error')
                ->with('statuscode','error')
                ->with('status','Tài khoản của bạn tạm thời bị khóa');
            }
            if($admin->role_id !=3){
                return back()
                ->with('login','error')
                ->with('statuscode','error')
                ->with('status','Bạn không có quyền để truy cập');
            }
            return redirect()->route('dashboard.index');
        }else{
            return back()
                ->with('login','error')
                ->with('statuscode','error')
                ->with('status','Tài khoản hoặc mật khẩu không trùng khớp');;
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }


    public function index()
    {
        if (request()->ajax()) {
         return $this->datatables();
       }
        $roles = Role::all();
        $admins = Admin::orderBy('id','desc')->get()->unique('status');

        foreach($admins as $admin)
        {
            switch($admin->status)
            {
                case 0:
                    $admin->sttName= 'Đang xử lý';
                    $admin->sttID = 0;
                    break;
                case 1:
                    $admin->sttName = 'Đang hoạt động';
                    $admin->sttID = 1;
                    break;
                case 2:
                    $admin->sttName = 'Đã khóa';
                    $admin->sttID = 2;
                    break;
            }
        }

        return view('admin.member')
            ->with('roles',$roles)
            ->with('admins',$admins);
    }

    public function datatables()
    {
    	$users = Admin::orderBy('created_at','desc')->get();
    	$table = Datatables::of($users);
		$table->addIndexColumn();
		$table->addColumn('created_at',function($row){
		          return date('d-m-Y', strtotime($row->created_at));
		        });
		$table->addColumn('status',function($row){
		        $stt = '';
		        switch($row->status){
		        	case 0:
		        		$stt ='<a href="#"><span class="label label-default">Đang xử lý</span></a>';
		                break;
		            case 1:
		            	$stt ='<a href="#"><span class="label label-success">Đang hoạt động</span></a>';
		                break;
		            case 2:
		            	$stt ='<a href="#"><span class="label label-danger">Đã khóa</span></a>';
		                break;
		        }
		        return $stt;
                });
        $table->addColumn('image',function($row){
            $url= asset('/storage/'.$row->image);
            if($row->image){
                return '<img class="img_datatable" data-name="image" data-id="'.$row->id.'" src="'.$url.'"></div>';
            }


        });
		$table->addColumn('role_id',function($row){
		        $role = '';
		        switch($row->role_id){
		        	case 1:
		        		$role ='<span class="label label-default">Không </span>';
		                break;
		            case 2:
		            	$role ='<span class="label label-warning">Editor</span>';
		                break;
		            case 3:
		            	$role ='<span class="label label-success">Admin</span>';
		                break;
		            case 4:
		            	$role ='<span class="label label-danger">Super Admin</span></a>';
		                break;
		        }
		        return $role;
		        });
		$table->addColumn('action', function($row){
            $btn = '<div style="display:flex">
                        <a class="btn btn-info btn-xs editUser" data-id="'.$row->id.'"
                        data-toggle="modal" href="javascript:void(0)">
                                        <i class="far fa-edit"></i>
                                    </a>
                        <a class="btn btn-danger btn-xs deleteUser" data-id="'.$row->id.'"
                        data-toggle="modal" href="javascript:void(0)">
                                        <i class="fas fa-trash"></i>
                                    </a>
                    </div>
					';
		    return $btn;
		});
		$table->rawColumns(['action','created_at','role_id','status','image']);
		return $table->make(true);
    }

    public function store(Request $req)
    {
        if(!empty($req->id)){
            $user = Admin::find($req->id);

            $user->update(array_merge(
                $req->except('_token'),
                [
                    'updated_at' => Carbon::now(),
                ]
            ));
            return response()->json([
                'success' => ' Cập nhập thành công!'
            ]);
        };
        return response()->json([
            'error' => 'Đã xảy ra lỗi!'
        ]);


    }

    public function edit($user)
    {
    	$user= Admin::find($user);
    	return response()->json($user);
    }

    public function destroy($id)
    {
        $user = Admin::find($id)->delete();
        return response()->json([
            'success' => 'Đã xóa tài khoản thành công!'
        ]);
    }
}
