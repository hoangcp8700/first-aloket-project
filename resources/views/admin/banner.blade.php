@extends('layouts.app_admin')

@section('content')

@include('admin.modal.modalBanner')

{{-- <div class="row-fluid sortable">
	<div class="box span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon user"></i><span class="break"></span>BANNERS</h2>
			<div class="box-icon">
				<a id="btnBanner" href="#" data-toggle="modal" data-target="#formModalBanner"><i class="fas fa-plus"></i></a>
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
				<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<table class="table table-striped table-condensed" id="bannerTable">
				<thead>
				  <tr>
                      <th>#</th>
                      <th>Tiêu đề</th>
                      <th>Ảnh</th>
                      <th>URL</th>
                      <th>Alt</th>
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
        <h3 class=" font-weight-bold text-primary text-center">TẤT CẢ BANNER
        </h3>
        <a class="btnModal" id="btnBanner" href="#" data-toggle="modal" data-target="#formModalBanner">
            <i class="fas fa-plus"></i></a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="bannerTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tiêu đề</th>
                        <th>Ảnh</th>
                        <th>URL</th>
                        <th>Alt</th>
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

	var bannerTable = $('#bannerTable').DataTable({
		dom: 'Pfrtip',
        language: {
            // processing: "<div class='loading'> <div class='circle'><div class='circle_space'></div></div> <div class='circle_1'><div class='circle_1_space'></div></div> <div class='circle_2'><div class='circle_2_space'></div></div> <div class='circle_3'><div class='circle_3_space'></div></div> <div class='circle_4'><div class='circle_4_space'></div></div> </div>",
            info: 'Tổng : _TOTAL_',
       		emptyTable: "Bạn chưa có ảnh nào!!!",
	    },
        ajax: "{{ route('banner.index') }}",

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'title', name:'title'},
            { data: 'image', name:'image'},
            { data: 'url', name: 'url' },
            { data: 'alt', name: 'alt' },
            { data: 'status', name: 'status' },
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

	$('#btnBanner').click(function(){
		$("#bannerForm").trigger("reset") // reset form
        // $('#banner_id').val('');
        $('.modal-title').html('Thêm banner');
        // $('#bannerImage').val('');
        document.getElementById("bannerImageOld").innerHTML = '';
        document.getElementById("valueImage").innerHTML = '';
        document.getElementById("bannerImage").innerHTML = '';
	})

	//insert
    $('#bannerForm').on("submit",function(e){

    	$('#saveButton').prop('disabled', true); // disable
    	e.preventDefault();
        var url = '{{route('banner.store')}}';
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
					bannerTable.ajax.reload();
	                $('#formModalBanner').modal('hide'); // hide modal
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
    $('body').on('click', '.editBanner', function (e) {

    	e.preventDefault();
	    var banner_id = $(this).data('id');
        $('#form_output').text(' ');// set null

      	$.get("{{ route('banner.index') }}" + '/' + banner_id +'/edit', function(data) {

          $('.modal-title').html('Sửa banner');
          $('#formModalBanner').modal('show');

        /*--------GET DATA-------*/

        var select_banners = document.querySelectorAll('.item_banner');
        select_banners.forEach(function(a){
            if(a.value == data.url){
               a.selected = true;
            }
        });

        $('#banner_id').val(data.id);
        $('#bannerTitle').val(data.title);
        $('#bannerALT').val(data.alt);
        $('#bannerURL').val(data.url);

        /* ------------- get image --------------*/
        document.querySelector("#valueImage").innerHTML = '<input type="hidden" value="'+data.image+'" name="image"> ';
        if(data.image){
            document.querySelector("#bannerImageOld").innerHTML = '<img class="imageOldBanner" alt="'+data.alt+'" src="/storage/'+data.image+'">';
        }

        })
    });

    $('body').on('click', '.updateStatus', function (e) {
    	e.preventDefault();
        var status = $(this).data('id');

        $.get("{{ route('banner.index') }}" + '/' + status +'/status', function(data) {
            bannerTable.ajax.reload();
            swal({
                icon: data.statuscode,
                title: data.status
            });
        })

    });

    $('body').on('click', '.deleteBanner', function () {

        let delete_id = $(this).data("id");
        let token = $('#bannerForm').find('input[name="_token"]').val();
        console.log(delete_id);
        console.log(token);
        if (confirm('Bạn đã chắc chắc muốn xóa banner này?')){
        	$.ajax({
	            type: "DELETE",
	            url: "{{ route('banner.store') }}"+'/'+delete_id,
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
						bannerTable.ajax.reload();
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
