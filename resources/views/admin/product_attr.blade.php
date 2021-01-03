@extends('layouts.app_admin')

@section('content')

@include('admin.modal.modalAttrProduct')
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
                            <label class="col-sm-3 col-xs-4 control-label"> Giá tiền</label>
                            <label class="col-sm-9 col-xs-8 control-label">{{number_format($product->price)}}đ</label>
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
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4 responsiveImageProductAttr ">
                        @if($product->image)
                            <img src="/storage/{{$product->image}}" class="image_attr">
                        @else
                            <img class="image_attr" src="https://dummyimage.com/100X115/f7f7f7/090a1a.png&text=No+Image" >
                        @endif
                    </div>
                    <form method="post" id="productAttrForm" style="padding:0 35px 0 15px;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <div class="field_wrapper">
                            <div class="addInputAttr">
                                <div class="row">
                                    <div class="col-sm-11 col-xs-11 ">
                                        <input type="text" onkeyup="SizeCodeSlug();" class="inputProductAttrSize" name="size[]" value="" placeholder="Size"/>
                                        <input type="text" class="inputProductAttrCode" name="product_attr_code[]" value="" readonly placeholder="Mã code"/>
                                        <input type="text" name="price[]" value="" placeholder="Giá tiền"/>
                                        <input type="text" name="stock[]" value="" placeholder="Số lượng"/>
                                    </div>
                                    <div class="col-sm-1 col-xs-1">
                                        <a href="javascript:void(0);" class="add_button btn btn-xs btn-info" title="Add field"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
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
                <table class="table table-bordered" id="productAttrTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã code</th>
                            <TH>Size</TH>
                            {{-- <th>Màu sắc</th> --}}
                            <th>Giá tiền</th>
                            <th>Tồn kho </th>
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
        var urlAttr = $('#product_ajax_id').val();
        var productAttrTable = $('#productAttrTable').DataTable({
            dom: 'Pfrtip',
            language: {
                   emptyTable: "Sản phẩm chưa có thuộc tính nào!!!",
                   info: 'Tổng : _TOTAL_'
            },
            ajax: "{{ route('attr_product.index') }}" + '/' + urlAttr,

            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'product_attr_code', name:'product_attr_code'},
                { data: 'size', name:'size'},
                // { data: 'color', name: 'color'},
                { data: 'price', name:'price'},
                { data: 'stock', name: 'stock' },
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

    $('#attrForm').on('submit',function(e){
        $('#saveButton').prop('disabled', true); // disable
        e.preventDefault();
        var urlAttr = '{{route('attr_product.store')}}';
        var valueForm =  $(this).serialize();
        $.ajax({
            type: 'post',
            url: urlAttr,
            data: valueForm,

            success: function(response){
                if(response.errors){
                    $('#saveButton').prop('disabled', false); // enable button

                    swal({
                        icon: "error",
                        title: response.errors
                    });
                }else{
                    $('#saveButton').prop('disabled', false); // enable button
                    $('#formModalAttr').modal('hide'); // hide modal
                    $("#attrForm").trigger("reset") // reset form
                    productAttrTable.ajax.reload();

                    swal({
                        icon: "success",
                        title: response.success
                    });
                }

            },
        })
    })
       //insert
       $('#productAttrForm').on("submit",function(e){
            $('#saveButton').prop('disabled', true); // disable
            e.preventDefault();
            var url = '{{route('attr_product.store')}}';
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
                        productAttrTable.ajax.reload();

                        swal({
                          icon: "error",
                          title: response.errors
                        });
                    }else{
                        $('#saveButton').prop('disabled', false); // enable button
                        $("#productAttrForm").trigger("reset") // reset form
                        productAttrTable.ajax.reload();

                        swal({
                          icon: "success",
                          title: response.success
                        });
                    }

                },
            })
        });

    //update


    //update status
    $('body').on('click', '.updateStatus', function (e) {
    	e.preventDefault();
        var status = $(this).data('id');
        $.get("{{ route('attr_product.index') }}" + '/' + status +'/status', function(data) {
            productAttrTable.ajax.reload();
            swal({
                icon: data.statuscode,
                title: data.status
            });
        })

    });

    //     //edit
    $('body').on('click', '.editAttr', function (e) {

        e.preventDefault();
        // document.getElementById('boxProductImageOld').style.display = 'block';
        var attr_id = $(this).data('id');
        $('#form_output').text(' ');// set null
            $.get("{{ route('attr_product.index') }}" + '/' + attr_id +'/edit', function(data) {

            $('.modal-title').html('Sửa thuộc tính');
            $('#formModalAttr').modal('show');

        /*--------GET DATA-------*/

        $('#attrID').val(data.id);
        $('#attrCode').val(data.product_attr_code);
        $('#attrSize').val(data.size);
        // $('#attrColor').val(data.color);
        $('#attrPrice').val(data.price);
        $('#attrStock').val(data.stock);

        });
    })

        //delete
         $('body').on('click', '.deleteAttr', function () {
            let delete_id = $(this).data("id");
            let token = $('#attrForm').find('input[name="_token"]').val();

            if (confirm('Bạn đã chắc chắc muốn xóa sản phẩm này?')){
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('attr_product.store') }}"+'/'+delete_id,
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
                            productAttrTable.ajax.reload();
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
