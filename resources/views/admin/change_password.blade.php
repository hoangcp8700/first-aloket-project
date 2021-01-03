@extends('layouts.app_admin')

@section('content')

<div class="row mt">
    <div class="col-lg-12">
      <div class="form-panel">
        <h4 class="mb"><i class="fa fa-angle-right"></i> ĐỔI MẬT KHẨU</h4>
        <form class="form-horizontal style-form" method="post" id='passwordForm'>
            @csrf
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Mật khẩu hiện tại</label>
            <div class="col-sm-10">
              <input type="password" name="password_current" class="form-control" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Mật khẩu mới</label>
            <div class="col-sm-10">
              <input type="password" name="password" class="form-control" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Nhập lại mật khẩu</label>
            <div class="col-sm-10">
              <input type="password" name="password_confirmation" class="form-control" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
                <button class="btn btn-theme" id="saveButton1" type="submit"><i class="fas fa-plus"></i> Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- col-lg-12-->
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
    })
    $('#passwordForm').on("submit",function(e){
        $('#saveButton1').prop('disabled', true); // disable
        e.preventDefault();
        var url = '{{route('profile.changePassword')}}';
            var fcate = $(this).serialize();
        $.ajax({
            type: 'post',
            url: url,
            data: fcate,
            success: function(response){

                if(response.errors){
                    $('#saveButton1').prop('disabled', false); // enable button
                    swal({
                        icon: "error",
                        title: response.errors
                    });
                }else{
                    $('#saveButton1').prop('disabled', false); // enable button

                    $('#passwordForm').trigger("reset");
                    swal({
                        icon: "success",
                        title: response.success
                    });

                }

            },
        })
    });
    </script>
@stop
