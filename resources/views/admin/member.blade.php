@extends('layouts.app_admin')

@section('content')
@include('admin.modal.modalUser')
{{-- <div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon user"></i><span class="break"></span>NGƯỜI DÙNG</h2>
			<div class="box-icon">
				<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<table class="table table-striped table-condensed" id="userTable">
				<thead>
				  <tr>
				  	  <th>#</th>
					  <th>Tên người dùng</th>
					  <th>Email</th>
					  <th>Ngày đăng ký</th>
					  <th>Quyền</th>
					  <th>Trạng thái</th>
					  <th>Công cụ</th>
				  </tr>
			  	</thead>

		  </table>

		</div>
	</div><!--/span-->

</div><!--/row--> --}}

<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 card-flex">
        <h3 class=" font-weight-bold text-primary text-center">TẤT CẢ THÀNH VIÊN
        </h3>
        {{-- <a class="btnModal" id="btnUser" href="#" data-toggle="modal" data-target="#formModalUser">
            <i class="fas fa-plus"></i></a> --}}
      </div>
      <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="userTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                          <th>#</th>
                        <th>Tên người dùng</th>
                        <th>Ảnh</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Ngày đăng ký</th>
                        <th>Quyền</th>
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
$(function() {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	var userTable = $('#userTable').DataTable({
		dom: 'Pfrtip',
        language: {
       		emptyTable: "Trang web chưa có member nào!!!",
               info: 'Tổng : _TOTAL_',
	    },
        ajax: "{{ route('member.index') }}",

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'name', name: 'name' },
            { data: 'image', name: 'image'},
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'created_at', name: 'created_at' },
            { data: 'role_id', name: 'role_id' },
            { data: 'status', name: 'status'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        pageLength: 8,

        oLanguage: {
	      oPaginate: {
	        sNext: 'Next <i class="fas fa-angle-double-right"></i>',
	        sPrevious: '<i class="fas fa-angle-double-left"></i> Previous'
	      }
	    },
    });


	// $('#btnUser').click(function(){
	// 	$("#userForm").trigger("reset") // reset form
    //     $('.modal-title').html('Thêm thành viên');
    //     $('#userName').prop('readonly', false);
    //     $('#userEmail').prop('readonly', false);
	// })
    //insert
    $('#userForm').on("submit",function(e){
    	$('#saveButton').prop('disabled', true); // disable
    	e.preventDefault();
        var url = '{{route('member.store')}}';
        // var file = $('#productImage')[0].files[0];
        // var fcate = $(this).serialize();

        var fcate =  new FormData($(this)[0]);
		$.ajax({
			type: 'post',
			url: url,
            data: fcate,
            contentType: false, // có FormData mới bỏ vào
            processData: false,// có FormData mới bỏ vào
			success: function(response){

				if(response.errors){
					$('#saveButton').prop('disabled', false); // enable button
					var error_html = '';
					error_html += '<div class="alert alert-danger"> <h2>'+response.errors+'</h2></div>';
					$('#form_output').html(error_html);
					swal({
					  icon: "error",
					  title: response.errors
					});
				}else{
					$('#saveButton').prop('disabled', false); // enable button
					userTable.ajax.reload();
	                $('#formModalUser').modal('hide'); // hide modal
					swal({
					  icon: "success",
					  title: response.success
					});
					$('#form_output').text(' ');// set null
				}

			},
		})
    });

    //edit
    $('body').on('click', '.editUser', function (e) {
    	e.preventDefault();
	    var user_id = $(this).data('id');
	    console.log(user_id);
	    $('#form_output').text(' ');// set null

      	$.get("{{ route('member.index') }}" + '/' + user_id +'/edit', function(data) {
      		var sttName;
          $('.modal-title').html('Cập nhập người dùng');
          $('#formModalUser').modal('show');

            var userRoles = document.querySelectorAll('.role_user');
                userRoles.forEach(function(a){
                    if(a.value == data.role_id){
                        a.selected = true;
                    }
                });
            var userSTT = document.querySelectorAll('.status_user');
            userSTT.forEach(function(a){
                if(a.value == data.status){
                    a.selected = true;
                }
            });
          $('#userID').val(user_id);
          $('#userName').prop('readonly', true);
          $('#userEmail').prop('readonly', true);

          $('#userName').val(data.name);
          $('#userEmail').val(data.email);

      })
    });


    //delete
    $('body').on('click', '.deleteUser', function () {
        let delete_id = $(this).data("id");
        let token = $('#userForm').find('input[name="_token"]').val();

        if (confirm('Bạn đã chắc chắc muốn xóa tài khoản này?')){
        	$.ajax({
	            type: "DELETE",
	            url: "{{ route('member.store') }}"+'/'+delete_id,
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
						userTable.ajax.reload();
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
});
</script>
@stop
