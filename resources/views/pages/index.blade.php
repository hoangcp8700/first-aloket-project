@extends('layouts.app')

@section('nd')
<?php
    use App\Banner;
    $bannerHeader   = Banner::bannerIndex('index');
    $bannerMiddle   = Banner::bannerIndex('index-middle');
    $bannerDoc      = Banner::bannerIndex('index-doc');
    $bannerNgang1   = Banner::bannerIndex('index-ngang-1');
    $bannerNgang2   = Banner::bannerIndex('index-ngang-2');
    $bannerNgang3   = Banner::bannerIndex('index-ngang-3');
    $bannerNgang4   = Banner::bannerIndex('index-ngang-4');


    if($bannerHeader){
        $banner1 = asset('/storage/'.$bannerHeader[0]->image);
    }
    if($bannerMiddle){
        $banner2 = asset('/storage/'.$bannerMiddle[0]->image);
    }
    if($bannerDoc){
        $bannerD = asset('/storage/'.$bannerDoc[0]->image);
    }
    if($bannerNgang1){
        $bannerN1 = asset('/storage/'.$bannerNgang1[0]->image);
    }
    if($bannerNgang2){
        $bannerN2 = asset('/storage/'.$bannerNgang2[0]->image);
    }
    if($bannerNgang3){
        $bannerN3 = asset('/storage/'.$bannerNgang3[0]->image);
    }
    if($bannerNgang4){
        $bannerN4 = asset('/storage/'.$bannerNgang4[0]->image);
    }
?>
    @if($banner1 ?? '')
    <div class="slider-area">
        <div class="slider-active owl-carousel">
            <div class="single-slider single-slider-hm1 bg-img height-100vh" style="background-image: url({{$banner1 ?? ''}})">
                <div class="container">
                    <div class="slider-content slider-animation slider-content-style-fashion slider-animated-1">
                        <div class="text-bg animated">
                            <img class="tilter-2 animated" src="{{asset('frontend/assets/img/icon-img/45.png')}}" alt="{{$bannerHeader[0]->alt}}">
                        </div>
                        <p class="animated">{{$bannerHeader[0]->title}} </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="currency-2">
            <ul>
                <li>
                <a href="#">{{$day}}</a>
                </li>
                <li>
                <a href="#">{{$month}}</a>
                </li>
            </ul>
        </div>
        <div class="clickable-mainmenu-btn">
            <a class="clickable-mainmenu-active" href="#"><img src="{{asset('frontend/assets/img/icon-img/43.png')}}" alt=""></a>
        </div>
    </div>
    @endif
    <!-- banner5 area start -->
    @if(($bannerDoc && $bannerN1 && $bannerN2 && $bannerN3 && $bannerN4) ?? '')
    <div class="banner-area3 pt-120  d-none d-md-block ">
        <div class="pl-100 pr-100">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-md-12 col-lg-4 col-xl-4">
                        <div class="banner-wrapper bnD mrgn-negative">
                            <a href="#"><img src="{{$bannerD ?? ''}}" alt=""></a>
                            <div class="banner-wrapper2-content">
                                <h3>Street </h3>
                                <h2>Style</h2>
                                <span>from aloket.com</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-8 col-xl-8">
                        <div class="row no-gutters banner-mrg">
                            <div class="col-md-6">
                                <div class="banner-wrapper bnN mrgn-b-5 mrgn-r-5 ">
                                    <img src="{{$bannerN1}}" alt="">
                                    <div class="banner-wrapper3-content">
                                        <a href="#">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="banner-wrapper bnN mrgn-b-5">
                                    <img src="{{$bannerN2}}" alt="">
                                    <div class="banner-wrapper3-content banner-text-color">
                                        <a href="#">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="banner-wrapper bnN mrgn-r-5">
                                    <img src="{{$bannerN3}}" alt="">
                                    <div class="banner-wrapper3-content">
                                        <a href="#">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="banner-wrapper bnN">
                                    <img src="{{$bannerN4}}" alt="">
                                    <div class="banner-wrapper3-content">
                                        <a href="#">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- banner5 area end -->

    <!-- all products area start -->
    <div class="all-products-area pt-120 pb-70">
        <div class="pl-100 pr-100">
            <div class="container-fluid">
                <div class="row  justify-content-center">
                    @foreach($products as $product)
                    <div class="col-lg-3 col-xl-3 col-md-4 col-sm-6 col-7 product-box-index">
                        <div class="product-wrapper mb-45">
                            <div class="product-img">
                                <a href="{{route('page.productDetail',$product->product_code)}}">
                                    <img src="{{asset('/storage/'.$product->image)}}" alt="">
                                </a>
                                @if($product->keyword)
                                    <span>{{$product->keyword}}</span>
                                @endif
                            </div>
                            <div class="product-content">
                                <h4><a href="{{route('page.productDetail',$product->product_code)}}">{{$product->name}}</a></h4>
                                <span>{{number_format($product->price)}}</span> <span style="font-size:14px">vnđ</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- all products area end -->

    <!-- fashion banner area start -->
    @if($banner2 ?? '')
    <div class="fashion-banner-area pb-120">
        <div class="container">
            <div class="fashion-banner-wrapper">
                <img src="{{$banner2 ?? ''}}" alt="">
                <div class="fashion-banner-content">
                    <h2 style="width:5em">{{$bannerMiddle[0]->title}} </h2>
                    <a class="btn-hover fashion-2-btn" href="product-details.html">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- testimonials area start -->
    <div class="testimonials-area  pb-105">
        <div class="container">
            <div class="section-title-2 text-center mb-35">
                <h2>Giới thiệu</h2>
            </div>

            <div class="testimonials-active owl-carousel">
                <div class="single-testimonial-4 text-center">
                    <img src="{{asset('frontend/assets')}}/img/icon-img/42.png" alt="">
                    <p>Aloket xuất hiện trên thị trường từ đầu năm 2021,
                        Aloket mang sức mạnh của một thương hiệu local brand đầy cá tính với những sản phẩm thời trang hàng đầu xu thế.</p>
                    <h4>Aloket</h4>
                </div>
                <div class="single-testimonial-4 text-center">
                    <img src="{{asset('frontend/assets')}}/img/icon-img/42.png" alt="">
                    <p>Với sức hút của mình, Aloket trở thành biểu tượng cho phong cách thời trang mạnh mẽ, táo bạo, và được ưa chuộng rộng rãi.</p>
                    <h4>Aloket</h4>
                </div>
                <div class="single-testimonial-4 text-center">
                    <img src="{{asset('frontend/assets')}}/img/icon-img/42.png" alt="">
                    <p>Aloket mang đến một cái góc độ độc đáo không những về phong cách sống mà còn về gout ăn mặc hiện đại.
                        Aloket nhận thức được nhu cầu đang phát triển của thị trường Streetwear Việt Nam.</p>
                    <h4>Aloket</h4>
                </div>
                <div class="single-testimonial-4 text-center">
                    <img src="{{asset('frontend/assets')}}/img/icon-img/42.png" alt="">
                    <p>Đây là cách Aloket mang đến giá trị cho cộng đồng trẻ yêu thích Streetwear, khuyến khích họ mạo hiểm trong gu ăn mặc của mình</p>
                    <h4>Aloket</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="clickable-mainmenu text-center">
        <div class="clickable-mainmenu-icon">
            <button class="clickable-mainmenu-close">
                <span class="pe-7s-close"></span>
            </button>
        </div>
        <div id="menu" class="text-left">
            <ul>
                <li><a href="{{route('page.index')}}">Home</a></li>
                <li>
                    <a href="#">Shops</a>
                    <ul>
                        @foreach($categories as $category)
                            <li><a href="#">{{$category->name}}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li>
                    <a href="#">Services</a>
                    <ul>
                        <li><a href="{{route('page.menu_list')}}">Danh mục</a></li>
                        <li><a href="{{route('login')}}">Đăng nhập</a></li>
                        <li><a href="{{route('register')}}">Đăng ký</a></li>
                        <li><a href="{{route('page.cart')}}">Giỏ hàng</a></li>
                        <li><a href="{{route('page.checkout')}}">Thanh toán</a></li>
                        <li><a href="{{route('page.wishlist')}}">Sản phẩm yêu thích</a></li>
                        <li><a href="{{route('page.contact')}}">Liên hệ</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
@stop
