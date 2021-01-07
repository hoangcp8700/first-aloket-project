@extends('layouts.app')

@section('nd')

<?php
    use App\Banner;
    $bannersM = Banner::banners('wishlist');
?>
<div class="breadcrumb-area pt-205 pb-210" style="background-image: url({{$bannersM}})">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>wishlist</h2>
            <ul>
                <li><a href="#">home</a></li>
                <li> wishlist </li>
            </ul>
        </div>
    </div>
</div>
<!-- shopping-cart-area start -->
<div class="cart-main-area pt-95 pb-100 wishlist">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="AppendCartItems">
                <h1 class="cart-heading">wishlist</h1>
                @include('layouts.ajax_wishlist')
            </div>
        </div>
    </div>
</div>

@stop

@push('script')
    <script src="{{asset('frontend/assets/js/pages/wishlist.js')}}"> </script>
@endpush
