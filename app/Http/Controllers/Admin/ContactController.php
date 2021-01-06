<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return $this->datatables();
        }

        return view('admin.mail.contact');
    }
    public function mailbox()
    {
        $contacts = Contact::orderBy('status','asc')->orderBy('created_at','desc')->whereNotNull('status')->get()->toArray();

        $contact = Contact::orderBy('status','asc')->orderBy('created_at','desc')->whereNotNull('status')->first()->toArray();
        // dd($contact);
        return view('admin.mail.inbox')->with('contact',$contact)->with('contacts',$contacts);

    }

    public function datatables()
    {

        $contacts = Contact::orderBy('created_at','desc')->get();

    	$table = Datatables::of($contacts);
        $table->addIndexColumn();

        $table->addColumn('created_at',function($row){
            return date('d-m-Y', strtotime($row->created_at));
        });
        $table->addColumn('updated_at',function($row){
            return date('d-m-Y', strtotime($row->updated_at));
        });
        $table->addColumn('status',function($row){
            $stt = '<a class="updateStatus" data-id="'.$row->id.'"
                    href="javascript:void(0)">
                    <span class="label label-default">Chưa phản hồi</span></a>';
            if($row->status == 1){
                $stt ='<a class="updateStatus" data-id="'.$row->id.'"
                    href="javascript:void(0)">
                    <span class="label label-success">Đã phàn hồi</span></a>';
            }
            return $stt;
                });
      $table->addColumn('action', function($row){
            $btn = '
						<a data-target="#formModalContact" class="btn btn-info replyContact" data-id="'.$row->id.'"
            data-toggle="modal" href="javascript:void(0)">
                            <i class="fas fa-reply-all"></i>
						</a>
						<a data-target="#formModalContact" class="btn btn-danger deleteContact" data-id="'.$row->id.'"
            data-toggle="modal" href="javascript:void(0)">
                            <i class="fas fa-trash"></i>
						</a>';
            return $btn;
        });
      $table->rawColumns(['action','created_at','updated_at','status']);
      return $table->make(true);
    }
    public function store(Request $req)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required | email',
            'phone' => 'required',
            'subject' => 'required',
            'content' => 'required',
        ];

        $messages = [
          'name.required' => 'Yêu cầu nhập tên!!',
          'email.required' => 'Yêu cầu nhập địa chỉ email!!',
          'email.email' => 'Email không hợp lệ',
          'phone.required' => 'Yêu cầu nhập số điện thoại!!',
          'subject.required' => 'Yêu cầu nhập tiêu đề!!',
          'content.required' => 'Yêu cầu nhập nội dung!',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'statuscode' => 'error',
                'status' => $validator->messages()->all()[0],
                'errors' => $validator->errors()

            ]);
        }

        DB::table('contacts')->insert(array_merge(
            $req->except('_token'),
            ['updated_at' => Carbon::now()],
            ['created_at' => Carbon::now()],
        ));

        return response()->json([
            'statuscode' => 'success',
            'status' => 'Cảm ơn quý khách đã phản hồi với chúng tôi!
            Nếu là câu hỏi giải đáp vui lòng check mail để biết thêm thông tin',
        ]);
    }

    public function updateStatus($id){
        $contacts = DB::table('contacts')->find($id);
        // dd($contacts);
        if($contacts->status == 1){
            return response()->json([
                'statuscode' => 'warning',
                'status' => 'Bạn đã phản hồi email này!'
            ]);
        }
        DB::table('contacts')->where('id',$id)->update([
            'status' => 1,
            'updated_at' => Carbon::now(),
        ]);
        return response()->json([
            'statuscode' => 'success',
            'status' => 'Đã phản hồi email này!'
        ]);
    }

    public function show($id)
    {
      $contact = Contact::find($id)->toArray();
      return response()->json([
            'contact' => $contact,
            'view' => (String)View::make('admin.mail.mail_view')->with(compact('contact'))
      ]);
    }

    public function reply(Request $req)
    {

        $rules = [
            'subject' => 'required | max:255',
            'content' => 'required ',
        ];

        $messages = [
              'subject.required' => 'Yêu cầu nhập tên tiêu đề!!',
              'content.required' => 'Yêu cầu nhập tên nội dung!!',
              'max' => 'Tiêu đề tối đa :max kí tự!!!',
            //   'unique' => 'Địa chỉ danh mục đã tồn tại!!!'
        ];
        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => $validator->messages()->all()[0],
                'statuscode' => 'error'
            ]);
        }
        $data = $req->all();
        $contact = Contact::find($data['id']);
        $contact->update(['status' => 1]);

        $contacts = Contact::orderBy('status','asc')
                ->orderBy('updated_at','desc')->whereNotNull('status')->get()->toArray();

        return response()->json([
            'status' => 'Đã gửi phản hồi',
            'statuscode' => 'success',
            'view' => (String)View::make('admin.mail.inbox_view')->with(compact('contacts'))
        ]);

    }

    public function destroy($id)
    {
        if(!empty($id)){
            DB::table('contacts')->where('id',$id)->delete();
        }
        return response()->json([
            'success' => 'Xóa thành công!'
        ]);
    }
}
