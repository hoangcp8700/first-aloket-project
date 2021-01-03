@extends('layouts.app_admin')

@section('content')

@include('admin.modal.modalCoupon')

    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3 card-flex">
            <h3 class=" font-weight-bold text-primary text-center">TẤT CẢ COUPON
            </h3>
            <a class="btnModal" id="btnCoupon" href="#" data-toggle="modal" data-target="#formModalCoupon">
                <i class="fas fa-plus"></i></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="couponTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã code</th>
                            <th>Gía trị</th>
                            <th>Số lượng</th>
                            <th>Ngày tạo</th>
                            <th>Ngày kết thúc</th>
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
	var couponTable = $('#couponTable').DataTable({
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
        ajax: "{{ route('coupon.index') }}",

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'code', name: 'code' },
            { data: 'type', name: 'type' },
            { data: 'quantity', name: 'quantity'},
            { data: 'created_at', name: 'created_at' },
            { data: 'outdate', name: 'outdate' },
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

	$('#btnCoupon').click(function(){
		$("#couponForm").trigger("reset") // reset form
		$('#coupon_id').val('');
        var coderandom = document.getElementById('couponCode');
        coderandom.value = Math.floor(Math.random() * 10000000);
		$('.modal-title').html('Thêm coupon');
	})

	// insert
    $('#couponForm').on("submit",function(e){
    	$('#saveButton').prop('disabled', true); // disable
    	e.preventDefault();
    	var url = '{{route('coupon.store')}}';
    	var fcate = $(this).serialize();
		$.ajax({
			type: 'post',
			url: url,
			data: fcate,
			success: function(response){
				if(response.errors){
					$('#saveButton').prop('disabled', false); // enable button
					var error_html = '';
					error_html += '<div class="alert alert-danger"> '+response.errors+'</div>';
					$('#form_output').html(error_html);
					swal({
					  icon: "error",
					  title: response.errors
					});
				}else{
					$('#saveButton').prop('disabled', false); // enable button
					couponTable.ajax.reload();
	                $('#formModalCoupon').modal('hide'); // hide modal
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
    $('body').on('click', '.editCoupon', function (e) {
    	e.preventDefault();
	    var coupon_id = $(this).data('id');
	    $('#form_output').text(' ');// set null
      	$.get("{{ route('coupon.index') }}" + '/' + coupon_id +'/edit', function(data) {
          $('.modal-title').html('Sửa coupon');

            /************ select coupon *********/
            var couponSelect = document.querySelectorAll('.item_coupon');
            couponSelect.forEach(function(a){
                if(a.value == data.type){
                a.selected = true;
                }
            });

            if(data.type == '?'){
                document.getElementById('couponValue').readOnly = true;
            }
            var selectCoupon = document.querySelector('#changeValueCoupon');
            selectCoupon.addEventListener('change',(e) => {
                if(e.target.value != '?'){
                    document.getElementById('couponValue').readOnly = false;
                }else{
                    document.getElementById('couponValue').readOnly = true;
                    $('#couponValue').val(data.value);
                }
            })

            $('#couponOutdate').val(dateString(data.outdate)); // function

            /*******************************/
            $('#coupon_id').val(data.id);
            $('#couponCode').val(data.code);
            $('#couponValue').val(data.value);
            $('#couponQuantity').val(data.quantity);



        })
    });

    //update status
    $('body').on('click', '.updateStatus', function (e) {
    	e.preventDefault();
        var status = $(this).data('id');
  		// var url = '{{route('category.store')}}';
        $.get("{{ route('coupon.index') }}" + '/' + status +'/status', function(data) {
            couponTable.ajax.reload();
            swal({
                icon: data.statuscode,
                title: data.status
            });
        })

    });

    //delete
     $('body').on('click', '.deleteCoupon', function () {
        let delete_id = $(this).data("id");
        let token = $('#couponForm').find('input[name="_token"]').val();
        if (confirm('Bạn đã chắc chắc muốn xóa coupon này?')){
        	$.ajax({
	            type: "DELETE",
	            url: "{{ route('coupon.store') }}"+'/'+delete_id,
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
						couponTable.ajax.reload();
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
