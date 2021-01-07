<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use Carbon\Carbon;
use App\Mail\ContactSend;
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
        $contacts = Contact::orderBy('status','asc')->orderBy('created_at','desc')->get()->toArray();

        $contact = Contact::orderBy('status','asc')->orderBy('created_at','desc')->first()->toArray();

        return view('admin.mail.inbox')
            ->with('contact',$contact)
            ->with('contacts',$contacts);

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
        $data = $req->all();
        $contact = Contact::find($data['id']);
        if(!empty($data['reply'])){
            $contact->update([
                'status' => 1,
            ]);

            $contacts = Contact::orderBy('status','asc')
            ->orderBy('updated_at','desc')->get()->toArray();

            return response()->json([
                'status' => 'Đánh dấu đã xem!',
                'statuscode' => 'success',
                'view' => (String)View::make('admin.mail.inbox_view')->with(compact('contacts'))
            ]);
        }
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

        $contact->update([
            'status' => 1,
            'reply_subject' => $data['subject'],
            'reply_content' => $data['content'],
            'reply_date' => Carbon::now(),
        ]);

        $contacts = Contact::orderBy('status','asc')
                ->orderBy('updated_at','desc')->get()->toArray();

        \Mail::send(new ContactSend($contact));

        return response()->json([
            'status' => 'Đã gửi phản hồi',
            'statuscode' => 'success',
            'view' => (String)View::make('admin.mail.inbox_view')->with(compact('contacts'))
        ]);



    }

    public function destroy($id)
    {
        $contact = Contact::find($id)->delete();
        $contacts = Contact::orderBy('status','asc')
                    ->orderBy('updated_at','desc')->get()->toArray();

        return response()->json([
                'status' => 'Xoá thành công!',
                'statuscode' => 'success',
                'view' => (String)View::make('admin.mail.inbox_view')->with(compact('contacts'))
            ]);
    }

}
