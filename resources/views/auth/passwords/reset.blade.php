{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
@extends('layouts.app')
@section('style')

<link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('frontend/assets/css/loginform.css')}}">
@stop
@section('nd')

<?php
    use App\Banner;
    $bannersM = Banner::banners('login');
    if(!$bannersM){
       $bannersM = asset('frontend/assets/img/bg/breadcrumb.jpg');
    }else{
        $bannersM = asset('/storage/'.$bannersM[0]->image);
    }
?>

<div class="breadcrumb-area pt-205 pb-210" style="background-image: url({{$bannersM}})">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>Quên mật khẩu</h2>
            <ul>
            <li><a href="{{route('page.index')}}">home</a></li>
                <li> Quên mật khẩu </li>
            </ul>
        </div>
    </div>
</div>
<div class="registration-form">
    <form method="post" action="{{ route('password.update') }}" class="formPage">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-icon">
            <span><i class="icon icon-user"></i></span>
        </div>
        {{-- <div class="form-group">
            <input type="text" class="form-control item" value="{{ old('email') }}"  autocomplete="email" autofocus name="email" placeholder="Địa chỉ email">
        </div> --}}
        <div class="form-group">
            <input id="email" readonly type="email" class="item form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
        </div>

        <div class="form-group">
            <input id="password" type="password" class="item form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"  placeholder="Nhập mật khẩu mới">
        </div>

        <div class="form-group">
            <input id="password-confirm" type="password" class=" item form-control" name="password_confirmation" required autocomplete="new-password"  placeholder="Nhập lại mật khẩu">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-block create-user">Xác nhân</button>
        </div>
        <div class="form-group">
            <a href="{{route('login')}}" class="f-right mb-2">Quay lại</a>
        </div>
    </form>
    <div class="social-media">
        <h5>Đăng nhập bằng ứng dụng khác</h5>
        <div class="social-icons">
            <a href="#"><i class="icon-social-facebook" title="Facebook"></i></a>
            <a href="#"><i class="icon-social-google" title="Google"></i></a>
            <a href="#"><i class="icon-social-twitter" title="Twitter"></i></a>
        </div>
    </div>
</div>

@stop
@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>



<script>
$(document).ready(function(){
  $('#birth-date').mask('00/00/0000');
  $('#phone-number').mask('0000-0000');
 })
</script>
@stop

