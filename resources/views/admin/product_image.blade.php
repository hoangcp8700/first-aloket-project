@extends('layouts.app_admin')

@section('content')


<div class="row mt">
    <div class="col-lg-12 ">
        <div class="form-panel">
            <div class="row">
                <h4 class="mb"><i class="fa fa-angle-right"></i> TÙY BIẾN SẢN PHẨM</h4>
                <div class="col-md-8 col-sm-8 col-xs-8 form-horizontal style-form " >
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-4 control-label">Tên sản phẩm</label>
                        <label class="col-sm-9 col-xs-8 control-label">{{$product->name}}</label>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-4 control-label"> Mã code</label>
                        <label class="col-sm-9 col-xs-8 control-label" id="productAttrCode">{{$product->product_code}}</label>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-4 control-label"> Màu sắc</label>
                        <label class="col-sm-9 col-xs-8 control-label">{{$product->color}}</label>
                    </div>
                    <div class="form-group ">
                        <label class="col-sm-3 col-xs-4 control-label"> Trạng thái</label>
                        <label class="col-sm-9 col-xs-8 control-label ">
                            @if($product->status == 1)
                                <span class="label label-success">Đã Kích hoạt</span>
                            @else
                                <span class="label label-default">Chưa Kích hoạt</span>
                            @endif
                        </label>
                    </div>
                    <form method="post" id="productImageForm"  enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="product_id" value="{{$product->id}}">

                        <div class="form-group">
                            <div class="col-sm-3 col-xs-4 "> Upload file</div>
                            <div class="col-sm-9 col-xs-8 ">
                                <input multiple type="file" class="inputProductImage" name="image[]"/>
                                <small>(Có thể upload nhiều file)</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 mt-2" style="float:right">
                                <button class="btn btn-theme" id="saveButton" type="submit"><i class="fas fa-plus"></i> Save</button>
                                <a class="btn btn-theme04" href="{{route('product.index')}}"><i class="fas fa-backspace"></i> Quay lại</a>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="col-md-4 col-sm-4 col-xs-4 responsiveImageProductAttr ">
                    @if($product->image)
                        <img src="/storage/{{$product->image}}" class="image_attr">
                    @else
                        <img class="image_attr" src="https://dummyimage.com/100X115/f7f7f7/090a1a.png&text=No+Image" >
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>

<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 card-flex">
        <h3 class=" font-weight-bold text-primary text-center"> {{$product->name}}
            <input type="hidden" id="product_ajax_id" value="{{$product->id}}">
        </h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="productImageTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ảnh</th>
                        <th>Trạng thái</th>
                        <th>Công cụ</th>
                    </tr>
                </thead>
            </table>
        </div>
      </div>
    </div>
</div>
@include('admin.modal.modalProductImage')

@stop

@section('scripts')
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var urlAttr = $('#product_ajax_id').val();
    var productImageTable = $('#productImageTable').DataTable({
        dom: 'Pfrtip',
        language: {
                emptyTable: "Sản phẩm chưa có ảnh phụ nào!!!",
                info: 'Tổng : _TOTAL_'
        },
        ajax: "{{ route('product_image.index') }}" + '/' + urlAttr,

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'image', name:'image'},
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

    // $('#productImageForm').on('submit',function(e){
    //     $('#saveButton').prop('disabled', true); // disable
    //     e.preventDefault();
    //     var urlAttr = '{{route('attr_product.store')}}';
    //     var valueForm =  $(this).serialize();
    //     $.ajax({
    //         type: 'post',
    //         url: urlAttr,
    //         data: valueForm,

    //         success: function(response){
    //             if(response.errors){
    //                 $('#saveButton').prop('disabled', false); // enable button

    //                 swal({
    //                     icon: "error",
    //                     title: response.errors
    //                 });
    //             }else{
    //                 $('#saveButton').prop('disabled', false); // enable button
    //                 $('#formModalAttr').modal('hide'); // hide modal
    //                 $("#attrForm").trigger("reset") // reset form
    //                 productAttrTable.ajax.reload();

    //                 swal({
    //                     icon: "success",
    //                     title: response.success
    //                 });
    //             }

    //         },
    //     })
    // })
       //insert
       $('#productImageForm').on("submit",function(e){
            $('#saveButton').prop('disabled', true); // disable
            e.preventDefault();
            var url = '{{route('product_image.store')}}';
            var fcate =  new FormData($(this)[0]);
            $.ajax({
                type: 'post',
                url: url,
                data: fcate,
                contentType: false, // có FormData mới bỏ vào
                processData: false,// có FormData mới bỏ vào
                success: function(response){
                    console.log(response.error);
                    if(response.statuscode == 'error'){
                        $('#saveButton').prop('disabled', false); // enable button
                        swal({
                          icon: response.statuscode,
                          title: response.status
                        });
                    }else{
                        $('#saveButton').prop('disabled', false); // enable button
                        $(this).trigger("reset") // reset form
                        $('#formModalProductImage').modal('hide'); // hide modal
                        productImageTable.ajax.reload();

                        swal({
                          icon: response.statuscode,
                          title: response.status
                        });
                    }

                },
            })
        });

    //update status
    $('body').on('click', '.updateStatus', function (e) {
    	e.preventDefault();
        var status = $(this).data('id');
        $.get("{{ route('product_image.index') }}" + '/' + status +'/status', function(data) {
            productImageTable.ajax.reload();
            swal({
                icon: data.statuscode,
                title: data.status
            });
        })

    });

    //edit
    $('body').on('click', '.editProductImage', function (e) {

        e.preventDefault();
        // document.getElementById('boxProductImageOld').style.display = 'block';
        var attr_id = $(this).data('id');
        $('#form_output').text(' ');// set null
        $.get("{{ route('product_image.index') }}" + '/' + attr_id +'/edit', function(data) {

            $('.modal-title').html('Sửa ảnh');

        /*--------GET DATA-------*/
        $('#product_id').val(data.product_id);
        $('#productImageID').val(data.id);
        document.querySelector("#productImageOld").style.display = 'block';
        document.querySelector("#productImageOld").innerHTML = '<img class="imageOldBanner" src="/storage/'+data.image+'">';
        });
    })

        //delete
         $('body').on('click', '.deleteProductImage', function () {
            let delete_id = $(this).data("id");
            let token = $('#attrForm').find('input[name="_token"]').val();

            if (confirm('Bạn đã chắc chắc muốn xóa ảnh này?')){
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('product_image.store') }}"+'/'+delete_id,
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
                                productImageTable.ajax.reload();
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
