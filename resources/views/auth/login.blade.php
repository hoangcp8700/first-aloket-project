@extends('layouts.app')

@section('style')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/loginform.css')}}">
@stop

@section('nd')

<?php
    use App\Banner;
    $bannersM = Banner::banners('login');

?>
<div class="breadcrumb-area pt-205 pb-210" style="background-image: url({{$bannersM}})">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>login</h2>
            <ul>
            <li><a href="{{route('page.index')}}">home</a></li>
                <li> login </li>
            </ul>
        </div>
    </div>
</div>
<div class="registration-form">
    <form method="post" action="{{ route('login') }}" class="formPage">
        @csrf
        <div class="form-icon">
            <span><i class="icon icon-user"></i></span>
        </div>
        <div class="form-group">
            <input type="text" class="form-control item " value="{{ old('email') }}"  autocomplete="email" autofocus name="email" placeholder="Địa chỉ email">
        </div>
        <div class="form-group">
            <input type="password" class="form-control item" name="password" autofocus placeholder="Mật khẩu">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-block create-user">Đăng nhập</button>
        </div>
        <div class="form-group">
            <a href="{{route('register')}}" class="f-left mb-2">Chưa có tài khoản?</a>
            <a href="{{route('password.request')}}" class="f-right mb-2">Quên mật khẩu?</a>
        </div>
    </form>
    <div class="social-media">
        <h5>Đăng nhập bằng ứng dụng khác</h5>
        <div class="social-icons">
            <a href="{{ route('social.oauth', 'facebook') }}"><i class="icon-social-facebook" title="Facebook"></i></a>
            <a href="{{ route('social.oauth', 'google') }}"><i class="icon-social-google" title="Google"></i></a>
            <a href="{{ route('social.oauth', 'github') }}"><i class="icon-social-github" title="Github"></i></a>
        </div>
    </div>
</div>

@stop

@push('script')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script>
    $(document).ready(function(){
        $('#birth-date').mask('00/00/0000');
        $('#phone-number').mask('0000-0000');
    })
    </script>
@endpush

