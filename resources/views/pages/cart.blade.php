@extends('layouts.app')

@section('nd')
<?php
    use App\Banner;
    use App\Cart;
    $bannersM = Banner::banners('cart');
    if(!$bannersM){
       $bannersM = asset('frontend/assets/img/bg/breadcrumb.jpg');
    }else{
        $bannersM = asset('/storage/'.$bannersM[0]->image);
    }

?>
<div class="breadcrumb-area pt-205 pb-210" style="background-image: url({{$bannersM}})">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>cart page</h2>
            <ul>
                <li><a href="#">home</a></li>
                <li> cart page</li>
            </ul>
        </div>
    </div>
</div>
<!-- shopping-cart-area start -->
<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 d-none d-xl-block  mt-5">
                <!-- CUSTOM BLOCKQUOTE -->
                <blockquote class="blockquote blockquote-custom bg-white p-5 shadow rounded">
                    <div class="blockquote-custom-icon bg-info shadow-sm"><i class="fas fa-phone text-white"></i></i></div>
                    <p class="mb-0 mt-2 font-italic">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo <a href="#" class="text-info">@consequat</a>."</p>
                    <footer class="blockquote-footer pt-4 mt-4 border-top">Someone famous in
                        <cite title="Source Title">Source Title</cite>
                    </footer>
                </blockquote><!-- END -->

            </div>
            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-xs-12" id="AppendCartItems">
                <h1 class="cart-heading">Cart</h1>
                @include('layouts.ajax_cart')
            </div>


        </div>
    </div>
</div>
@stop
@push('script')

<script src="{{asset('frontend/assets/js/pages/cart.js')}}"> </script>

@endpush
