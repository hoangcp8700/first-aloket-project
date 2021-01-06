{{-- <li id="contact_notification_bar" class="dropdown">
    <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
        <i class="fas fa-address-book"></i>
      <span class="badge bg-warning">7</span>
      </a>
    <ul class="dropdown-menu extended notification">
      <div class="notify-arrow notify-arrow-yellow"></div>
      <li>
        <p class="yellow">Bạn có 4 thông tin liên hệ <br>(chưa phản hồi)</p>
      </li>
      <li>
        <a href="index.html#">
          <span class="label label-danger"><i class="fa fa-bolt"></i></span>
          Server Overloaded.
          <span class="small italic">4 mins.</span>
          </a>
      </li>
      <li>
        <a href="index.html#">
          <span class="label label-warning"><i class="fa fa-bell"></i></span>
          Memory #2 Not Responding.
          <span class="small italic">30 mins.</span>
          </a>
      </li>
      <li>
        <a href="index.html#">
          <span class="label label-danger"><i class="fa fa-bolt"></i></span>
          Disk Space Reached 85%.
          <span class="small italic">2 hrs.</span>
          </a>
      </li>
      <li>
        <a href="index.html#">
          <span class="label label-success"><i class="fa fa-plus"></i></span>
          New User Registered.
          <span class="small italic">3 hrs.</span>
          </a>
      </li>
      <li>
        <a href="index.html#">See all notifications</a>
      </li>
    </ul>
</li> --}}
@extends('layouts.app_admin')

@section('content')

@include('admin.modal.modalContact')

<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 card-flex">
        <h3 class=" font-weight-bold text-primary text-center">TẤT CẢ THƯ PHẢN HỒI
        </h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="contactTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>Ngày gửi</th>
                        <th>Ngày phản hồi</th>
                        <th>Trạng thái</th>
                        <th>Công cụ</th>
                    </tr>
                </thead>
            </table>
        </div>
      </div>
    </div>
</div>

@stop

@section('scripts')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	var contactTable = $('#contactTable').DataTable({
		dom: 'Pfrtip',
        // processing: true,
        // serverSide: true,
        // retrieve: true,
        // info:false,
        language: {
	        processing: "<div class ='loading-db'><div class = 'blob-1'></div><div class = 'blob-2'></div></div>",
             emptyTable: "Bạn chưa có danh mục nào!!!",
             info: 'Tổng : _TOTAL_'
	    },
        ajax: "{{ route('contact.index') }}",

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'status', name: 'status'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        pageLength: 6,

        oLanguage: {
	      oPaginate: {
	        sNext: 'Next <i class="fas fa-angle-double-right"></i>',
	        sPrevious: '<i class="fas fa-angle-double-left"></i> Previous'
	      }
	    },
    });


     //update status
     $('body').on('click', '.updateStatus', function (e) {
    	e.preventDefault();
        var status = $(this).data('id');
  		// var url = '{{route('category.store')}}';
        $.get("{{ route('contact.index') }}" + '/' + status +'/status', function(data) {
            contactTable.ajax.reload();
            swal({
                icon: data.statuscode,
                title: data.status
            });
        })

    });

    //edit
    $('body').on('click', '.replyContact', function (e) {
    	e.preventDefault();
	    var contact_id = $(this).data('id');
      	$.get("{{ route('contact.index') }}" + '/' + contact_id , function(data) {
            $('.modal-title').html('Phản hồi');




            // /*******************************/
            // $('#contact_id').val(data.id);
            // $('#couponCode').val(data.code);
            // $('#couponValue').val(data.value);
            // $('#couponQuantity').val(data.quantity);



        })
    });


    //delete
    $('body').on('click', '.deleteContact', function () {
        let delete_id = $(this).data("id");
        let token = $('#contactForm').find('input[name="_token"]').val();
        if (confirm('Bạn đã chắc chắc muốn xóa liên hệ này?')){
        	$.ajax({
	            type: "DELETE",
	            url: "{{ route('contact.store') }}"+'/'+delete_id,
	            data: {
	            	"_token": "{{ csrf_token() }}",
	        		"id": delete_id
	            },
	           	success: function (data) {
	           		if(data.errors){
						console.log('Error:', data);
		                swal({
							  icon: "error",
							  title: 'Đã xảy ra lỗi!'
							});
					}else{
						contactTable.ajax.reload();
						swal({
						  icon: "success",
						  title: data.success
						});
					}
	            }
        	});
        }else{
        	return false;
        }

    });
</script>
@stop
