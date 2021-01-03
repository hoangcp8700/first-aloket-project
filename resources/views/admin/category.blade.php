@extends('layouts.app_admin')

@section('content')

@include('admin.modal.modalCategory')

    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3 card-flex">
            <h3 class=" font-weight-bold text-primary text-center">TẤT CẢ DANH MỤC
            </h3>
            <a class="btnModal" id="btnCategory" href="#" data-toggle="modal" data-target="#formModalCategory">
                <i class="fas fa-plus"></i></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="categoryTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                              <th>#</th>
                              <th>Lĩnh vực</th>
                            <th>Danh mục</th>
                            <th>Ngày khởi tạo</th>
                            <th>Cập nhập lần cuối</th>
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
	var categoryTable = $('#categoryTable').DataTable({
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
        ajax: "{{ route('category.index') }}",

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'section', name: 'section' },
            { data: 'name', name: 'name' },
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

	$('#btnCategory').click(function(){
		$("#categoryForm").trigger("reset") // reset form
		$('#category_id').val('');
		$('.modal-title').html('Thêm danh mục');
	})

	// insert
    $('#categoryForm').on("submit",function(e){
    	$('#saveButton').prop('disabled', true); // disable
    	e.preventDefault();
    	var url = '{{route('category.store')}}';
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
					categoryTable.ajax.reload();
	                $('#formModalCategory').modal('hide'); // hide modal
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
    $('body').on('click', '.editCategory', function (e) {
    	e.preventDefault();
	    var category_id = $(this).data('id');
	    $('#form_output').text(' ');// set null
      	$.get("{{ route('category.index') }}" + '/' + category_id +'/edit', function(data) {
          $('.modal-title').html('Sửa sản phẩm');
          $('#formModalCategory').modal('show');


        var sectionToCategory = document.querySelectorAll('.item_section');
        sectionToCategory.forEach(function(a){
            var sectionValue= Number(a.value);
            if(sectionValue == data.id){
               a.selected = true;
            }
        });

        $('#category_id').val(data.id);
		$('#categoryName').val(data.name);
		$('#categoryDescription').val(data.description);
		$('#categorySlug').val(data.slug);

      })
    });

    //update status
    $('body').on('click', '.updateStatus', function (e) {
    	e.preventDefault();
        var status = $(this).data('id');
  		// var url = '{{route('category.store')}}';
        $.get("{{ route('category.index') }}" + '/' + status +'/status', function(data) {
            categoryTable.ajax.reload();
            swal({
                icon: data.statuscode,
                title: data.status
            });
        })

    });

    //delete
     $('body').on('click', '.deleteCategory', function () {
        let delete_id = $(this).data("id");
        let token = $('#categoryForm').find('input[name="_token"]').val();
        console.log(delete_id);
        console.log(token);

        if (confirm('Bạn đã chắc chắc muốn xóa danh mục này?')){
        	$.ajax({
	            type: "DELETE",
	            url: "{{ route('category.store') }}"+'/'+delete_id,
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
						categoryTable.ajax.reload();
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
