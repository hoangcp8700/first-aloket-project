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
{{-- <body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body> --}}
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
@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>



<script>
$(document).ready(function(){
  $('#birth-date').mask('00/00/0000');
  $('#phone-number').mask('0000-0000');
 })
</script>
@stop

