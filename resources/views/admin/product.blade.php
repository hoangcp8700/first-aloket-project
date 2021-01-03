@extends('layouts.app_admin')

@section('content')

@include('admin.modal.modalProduct')

<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 card-flex">
        <h3 class=" font-weight-bold text-primary text-center">TẤT CẢ SẢN PHẨM
        </h3>
        <a class="btnModal" id="btnProduct" href="#" data-toggle="modal" data-target="#formModalProduct">
            <i class="fas fa-plus"></i></a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="productTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Lĩnh vực</th>
                        <th>Danh mục</th>
                        <TH>Ảnh</TH>
                        <th>Tên sản phẩm</th>
                        <th>Mã Code</th>
                        <th>Giá tiền</th>
                        <th>Trạng thái</th>
                        <th>Công cụ</th>
                    </tr>
                </thead>
            </table>
        </div>
      </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="productDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span class="pe-7s-close" aria-hidden="true"></span>
    </button>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-panel">
                    <form class="cmxform form-horizontal style-form">
                        <div class="form">
                            <div class="form-group ">
                                <div class="col-lg-3">
                                    <img id="imgP" class="imgP" src="{{asset('frontend/assets/img/cart/4.jpg')}}" alt="">
                                </div>
                                <div class="col-lg-9">
                                    <h1 id="nameP"></h1>
                                    <div class="form-group ">
                                        <label class="control-label col-lg-2">Lĩnh vực</label>
                                        <label class="control-label col-lg-10" id="sectionP"></label>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label col-lg-2">Danh mục</label>
                                        <label class="control-label col-lg-10 " id="categoryP"></label>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label col-lg-2">Trạng thái</label>
                                        <label class="control-label col-lg-10 " id="statusP"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2 lbp">Mã sản phẩm</label>
                                <label class="control-label col-lg-10" id="codeP">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2 lbp">Giá tiền</label>
                                <label class="control-label col-lg-10" id="priceP">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2 lbp">Giá khuyến mãi</label>
                                <label class="control-label col-lg-10" id="discountP">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2 lbp">Chất liệu</label>
                                <label class="control-label col-lg-10" id="fabricP">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2 lbp">Kiểu dáng</label>
                                <label class="v col-lg-10" id="fitP">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2 lbp">Từ khóa</label>
                                <label class="v col-lg-10" id="keywordP">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2 lbp">Số lượng</label>
                                <label class="v col-lg-10" id="stockP">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2 lbp">Size</label>
                                <label class="control-label col-lg-10" id="sizeP">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2 lbp">Số lượng tổng</label>
                                <label class="control-label col-lg-10" id="quantityP">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2 lbp">Mô tả</label>
                                <label class="control-label col-lg-10" id="descriptionP"></label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2 lbp">Ngày khởi tạo</label>
                                <label class="control-label col-lg-10" id="createdP">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2 lbp">Update lần cuối</label>
                                <label class="control-label col-lg-10" id="updatedP">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2 lbp">Ảnh</label>
                                <div class="col-lg-8 modal-productdetail" id="imgChildrenP">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
	var productTable = $('#productTable').DataTable({
		dom: 'Pfrtip',
        language: {
               emptyTable: "Bạn chưa có sản phẩm nào!!!",
               info: 'Tổng : _TOTAL_'
	    },
        ajax: "{{ route('product.index') }}",

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'section', name:'section'},
            { data: 'category', name:'category'},
            { data: 'image', name:'image'},
            { data: 'name', name: 'name' },
            { data: 'product_code', name: 'produce_code' },
            { data: 'price', name: 'price' },
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

	$('#btnProduct').click(function(){
		$("#productForm").trigger("reset") // reset form
        $('#product_id').val('');
        $('#form_output').val('');
        var coderandom = document.getElementById('productCode');
        coderandom.value = Math.floor(Math.random() * 100000000000000);
        CKEDITOR.instances["product-description-ckeditor"].setData('');
        $('.modal-title').html('Thêm sản phẩm');
        document.querySelector("#productImageOld").style.display = 'none';
        // document.getElementById('boxProductImageOld').style.display = 'none';

	})



	//insert
    $('#productForm').on("submit",function(e){
    	$('#saveButton').prop('disabled', true); // disable
    	e.preventDefault();
        var url = '{{route('product.store')}}';
        // var file = $('#productImage')[0].files[0];
        // var fcate = $(this).serialize();
        for ( instance in CKEDITOR.instances )
       		CKEDITOR.instances["product-description-ckeditor"].updateElement();
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
					productTable.ajax.reload();
	                $('#formModalProduct').modal('hide'); // hide modal
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
    $('body').on('click', '.editProduct', function (e) {
    	e.preventDefault();
        // document.getElementById('boxProductImageOld').style.display = 'block';
	    var product_id = $(this).data('id');
        $('#form_output').text(' ');// set null
      	$.get("{{ route('product.index') }}" + '/' + product_id +'/edit', function(data) {

          $('.modal-title').html('Sửa sản phẩm');
          $('#formModalProduct').modal('show');
            console.log(data);
        /*--------GET DATA-------*/
        /*-----------------selected --------------------------*/
        var categoryToProduct = document.querySelectorAll('.item_category');
        categoryToProduct.forEach(function(a){
            var categoryValue= Number(a.value);
            if(categoryValue == data.category_id){
               a.selected = true;
            }
        });

        var sectiontoCategory = document.querySelectorAll('.item_section');
        sectiontoCategory.forEach(function(a){
            var sectionValue= Number(a.value);
            if(sectionValue == data.section_id){
               a.selected = true;
            }
        });

        var fit = document.querySelectorAll('.item_fit');
        fit.forEach(function(a){
        if(a.value == data.fit){
            a.selected = true;
        }
        });

        $('#product_id').val(data.id);
        $('#productName').val(data.name);
        $('#productCode').val(data.product_code);
        $('#productColor').val(data.color);
        $('#productPrice').val(data.price);
        $('#productDiscount').val(data.discount);
        $('#productKeyWord').val(data.keyword);
        $('#productStock').val(data.stock);
        $('#productSlug').val(data.slug);
        $('#productFabric').val(data.fabric);
        $('#productFit').val(data.fit);

        CKEDITOR.instances["product-description-ckeditor"].setData(data.description);

        if(data.image){
            document.querySelector("#productImageOld").style.display = 'block';
            document.querySelector("#productImageOld").innerHTML =
             '<img id="imageOldProduct" class="imageOldProduct" alt="'+data.alt+'" src="/storage/'+data.image+'">'
            +'<a class="ml-1 deleteImagep" href="javascript:void(0)" data-id="'+data.id+'">  <span class="label label-danger">Xóa ảnh</span></a>';
        }else{
            document.querySelector("#productImageOld").styl .display = 'block';
            document.querySelector("#productImageOld").innerHTML = '<img class="imageOldProduct " src="https://dummyimage.com/100X115/f7f7f7/090a1a.png&text=No+Image">';
        }

        })
    });
    //update status
    $('body').on('click', '.updateStatus', function (e) {
    	e.preventDefault();
        var status = $(this).data('id');

        $.get("{{ route('product.index') }}" + '/' + status +'/status', function(data) {
            productTable.ajax.reload();
            swal({
                icon: data.statuscode,
                title: data.status
            });
        })

    });

    // show product
    $('body').on('click', '.img_datatable', function (e) {

    	e.preventDefault();
        // document.getElementById('boxProductImageOld').style.display = 'block';
	    var product_id = $(this).data('id');
      	$.get("{{ route('product.index') }}" + '/' + product_id, function(data) {

        /* ----SET NULL */
        document.querySelector('#sizeP').innerHTML = '';
        document.querySelector('#quantityP').innerHTML = '';
        document.querySelector('#imgChildrenP').innerHTML = '';
        /*--------GET DATA-------*/
        document.querySelector('#imgP').setAttribute('src','/storage/'+data.image);
        document.querySelector('#codeP').textContent = data.product_code;
        document.querySelector('#priceP').textContent = data.price;
        document.querySelector('#discountP').textContent = data.discount;
        document.querySelector('#fabricP').textContent = data.fabric;
        document.querySelector('#keywordP').textContent = data.keyword;
        document.querySelector('#stockP').textContent = data.stock;
        document.querySelector('#fitP').textContent = data.fit;
        document.querySelector('#descriptionP').innerHTML = data.description;
        document.querySelector('#categoryP').textContent = data.category.name;
        document.querySelector('#sectionP').textContent = data.section.name;
        document.querySelector('#nameP').textContent = data.name;

        var c = new Date(data.created_at);
        var u = new Date(data.updated_at);
        document.querySelector('#createdP').textContent = c.getDate()+ '/' +c.getMonth()+ '/' +c.getFullYear();
        document.querySelector('#updatedP').textContent = u.getDate()+ '/' +u.getMonth()+ '/' +u.getFullYear();

        if(data.status == 1){
            document.querySelector('#statusP').innerHTML = '<span class="label label-success"> Đã kích hoạt <span>';
        }else{
            document.querySelector('#statusP').innerHTML = '<span class="label label-default"> Chưa kích hoạt <span>';
        }

        data.product_attr.forEach((a) => {
            var elelementSize= ' <span class="label label-success">' +a.size+ ' <label>( '  +a.stock+' )<label> <label>( '+numberFormat(a.price)+' )</label></span> ';
            document.querySelector('#sizeP').insertAdjacentHTML('beforeend',elelementSize);
        });
        var sumAll = 0;
        var sumAttr = data.product_attr.reduce((sum, value) => {
            return sum + value.stock;
        }, 0);
        sumAll = data.stock + sumAttr;
        var elelementQuantity = '<span class="label label-success">' +sumAll+ '</span>';
        document.querySelector('#quantityP').innerHTML = elelementQuantity;

        data.product_image.forEach((a) => {
            var elelementImageChild = '<img class="imgChild" src="/storage/'+a.image+'">';
            document.querySelector('#imgChildrenP').insertAdjacentHTML('beforeend',elelementImageChild);
        })

        })
    });




    $('body').on('click', '.deleteImagep', function (e) {
    	e.preventDefault();
        var product_id= $(this).data('id');
        let token = $('#productForm').find('input[name="_token"]').val();
        if (confirm('Bạn đã chắc chắc muốn xóa ảnh sản phẩm này?')){
            $.ajax({
	            type: "DELETE",
	            url: "{{ route('product.index') }}"+ '/' + product_id + '/delete',
	            data: {
	            	"_token": "{{ csrf_token() }}",
                    "id": product_id,
                },
                success: function (data) {
	           		if(data.errors){
						console.log('Error:', data);
		                swal({
							  icon: "error",
							  title: 'Đã xảy ra lỗi!'
							});
					}else{
                        productTable.ajax.reload();
                         $('#imageOldProduct').load(function(){

                        }).attr('src','https://dummyimage.com/100X115/f7f7f7/090a1a.png&text=No+Image');
						swal({
						  icon: "success",
						  title: data.success
						});
					}
	            }
        })
        }else{
            return false;
        }
    });

    //delete
     $('body').on('click', '.deleteProduct', function () {
        let delete_id = $(this).data("id");
        let token = $('#productForm').find('input[name="_token"]').val();

        if (confirm('Bạn đã chắc chắc muốn xóa sản phẩm này?')){
        	$.ajax({
	            type: "DELETE",
	            url: "{{ route('product.store') }}"+'/'+delete_id,
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
						productTable.ajax.reload();
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
