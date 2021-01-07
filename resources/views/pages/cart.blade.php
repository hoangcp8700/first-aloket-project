@extends('layouts.app')

@section('nd')
<?php
    use App\Banner;
    use App\Cart;
    $bannersM = Banner::banners('cart');

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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" id="AppendCartItems">
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
