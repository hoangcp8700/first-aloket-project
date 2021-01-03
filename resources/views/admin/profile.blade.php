@extends('layouts.app_admin')

@section('content')

<div class="row mt">
    <div class="col-lg-12">
      <div class="form-panel">
        <h4 class="mb"><i class="fa fa-angle-right"></i> THÔNG TIN CÁ NHÂN</h4>
        <form class="form-horizontal style-form" method="post" id="profileForm">
            @csrf
            {{-- @if($profile->image)
                <div class="form-group">
                    <input type="hidden" name="image" value="{{$profile->image}}">
                    <img class="loadAvatar img-circle" src="/storage/{{$profile->image}}">
                </div>
            {{-- @else
                <div class="form-group">
                    <img id="loadAvatar" class="loadAvatar" style="">
                </div> --}}
            {{-- @endif --}}

          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Tên thành viên</label>
            <div class="col-sm-10">
              <input type="text" class="form-control"  name="name" value="{{$profile->name}}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Số điện thoại</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="phone" value="{{$profile->phone}}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input type="text" readonly value="{{ $profile->email}}"  class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Quyền</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" readonly value="{{ $profile->role->name}}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">Ảnh đại diện</label>
            <div class="col-sm-10">
              <input type="file"  name="image" value="{{$profile->phone}}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
                <button class="btn btn-theme" id="saveButton2" type="submit"><i class="fas fa-plus"></i> Save</button>
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
function loadName(name,image){
    var load_name = document.querySelector('#loadName');
    var load_avatar = document.querySelector('#loadAvatar');
    load_name.innerHTML = name;
    load_avatar.src = '/storage/'+image;
    //  $('.loadAvatar').load(function(){

    //                 }).attr('src','/storage/'+image);
}
$(function() {

	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
})

    $('#profileForm').on("submit",function(e){

        $('#saveButton2').prop('disabled', true); // disable
        e.preventDefault();
        var url = '{{route('profile.updateProfile')}}';
        var fcate =  new FormData($(this)[0]);
        $.ajax({
            type: 'post',
            url: url,
            data: fcate ,
            contentType: false, // có FormData mới bỏ vào
            processData: false,// có FormData mới bỏ vào
            success: function(response){
                if(response.errors){
                    $('#saveButton2').prop('disabled', false); // enable button

                    swal({
                        icon: "error",
                        title: response.errors
                    });
                }else{
                    $('#saveButton2').prop('disabled', false); // enable button

                    // document.querySelector('.loadAvatar').style.display = 'block';

                    swal({
                        icon: "success",
                        title: response.success
                    });
                    window.addEventListener('load',loadName(response.data.name,response.data.image));

                }

            },
        })
    });
</script>
@stop
