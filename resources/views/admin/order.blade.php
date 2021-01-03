@extends('layouts.app_admin')

@section('content')



<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 card-flex">
        <h3 class=" font-weight-bold text-primary text-center">TẤT CẢ ĐƠN HÀNG
        </h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="orderTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <TH>Tổng tiền</TH>
                        <th>Ngày mua</th>
                        <th>Trạng thái</th>
                        <th>Công cụ</th>
                    </tr>
                </thead>

            </table>
        </div>
      </div>
    </div>
</div>
@include('admin.modal.modalOrder')


@stop

@section('scripts')
<script>

$(function() {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	var orderTable = $('#orderTable').DataTable({
		dom: 'Pfrtip',

        language: {
	        processing: "<div class ='loading-db'><div class = 'blob-1'></div><div class = 'blob-2'></div></div>",
             emptyTable: "Bạn chưa có đơn hàng nào!!!",
             info: 'Tổng : _TOTAL_'
	    },
        ajax: "{{ route('order.index') }}",

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'address', name: 'address' },
            { data: 'total', name: 'total'},
            { data: 'created_at', name: 'created_at' },
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

    $('#orderForm').on("submit",function(e){
    	$('#saveButton').prop('disabled', true); // disable
    	e.preventDefault();
    	var url = '{{route('order.store')}}';
    	var fcate = $(this).serialize();
		$.ajax({
			type: 'post',
			url: url,
			data: fcate,
			success: function(response){
                $('#saveButton').prop('disabled', false); // enable button
                orderTable.ajax.reload();
                $('#formModalOrder').modal('hide'); // hide modal
                swal({
                    icon: "success",
                    title: response.success
                });
			},
		})
    });

    $('body').on('click', '.editOrder', function (e) {
    	e.preventDefault();
	    var order_id = $(this).data('id');
	    $('#form_output').text(' ');// set null
      	$.get("{{ route('order.index') }}" + '/' + order_id +'/edit', function(data) {
            $('.modal-title').html('Cập nhập trạng thái');
            // $('#formModalOrder').modal('show');

            var status = document.querySelectorAll('.item_status');
            status.forEach(function(a){
                var statusValue= Number(a.value);
                if(statusValue == data.status){
                a.selected = true;
                }
            });
            $('#order_id').val(data.id);
      })
    });


    $('body').on('click', '.showOrder', function (e) {
    	e.preventDefault();
	    var order_id = $(this).data('id');
        $('#form_output').text(' ');// set null
      	$.get("{{ route('order.index') }}" + '/' + order_id , function(data) {
            $('.modal-title').html('Chi tiết đơn hàng');

            console.log(data);
            document.querySelector('#nameO').textContent = data.name;
            document.querySelector('#emailO').textContent = data.email;
            document.querySelector('#phoneO').textContent = data.phone;
            document.querySelector('#addressO').textContent = data.address +', '+ data.ward.name +', '+ data.district.name +', '+ data.province.name;
            document.querySelector('#totalO').textContent = numberFormat(data.total);
            document.querySelector('#discountO').textContent = numberFormat(data.discount);
            document.querySelector('#created_atO').textContent = dateString(data.created_at); // function

            var text = '';
            for(let i =0 ; i< data.order_detail.length; i++){
                text +=  '<tr>'+
                    '<td>'+data.order_detail[i].product.name+'</td>'+
                    '<td>'+numberFormat(data.order_detail[i].price)+'</td>'+
                    '<td>'+data.order_detail[i].quantity+'</td>'+
                    '<td>'+data.order_detail[i].size+'</td></<tr>';
            }
            document.querySelector('#valueOrderTable').innerHTML = text;


      })
    });
});

</script>
@stop
