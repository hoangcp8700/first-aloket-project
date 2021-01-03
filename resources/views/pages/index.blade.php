@extends('layouts.app')

@section('nd')
<?php
    use App\Banner;
    $bannerHeader   = Banner::banners('index');
    $bannerMiddle   = Banner::banners('index-middle');
    $bannerDoc      = Banner::banners('index-doc');
    $bannerNgang1   = Banner::banners('index-ngang-1');
    $bannerNgang2   = Banner::banners('index-ngang-2');
    $bannerNgang3   = Banner::banners('index-ngang-3');
    $bannerNgang4   = Banner::banners('index-ngang-4');
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

    // echo '<pre>';print_r($bannerMiddle); die;
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
                                    {{-- <div class="product-action">
                                        <a class="animate-left" title="Show" href="#">
                                            <i class="pe-7s-like"></i>
                                        </a>

                                        {{-- <form class="product-form">
                                            <input type="hidden" class="productCode " value="{{$product->product_code}}">
                                            <input type="hidden" class="productName" value="{{$product->name}}">
                                            <input type="hidden" class="productPrice" value="{{$product->price}}">
                                            <a class="animate-top add-cart" title="Add To Cart" href="javascript:void(0)">
                                                <i class="pe-7s-cart"></i>
                                            </a>
                                        </form> --}}

                                    {{-- </div> --}}

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
    <div class="testimonials-area pt-105 pb-105">
        <div class="container">
            <div class="section-title-2 text-center mb-35">
                <h2>Testimonial</h2>
            </div>
            <div class="testimonials-active owl-carousel">
                <div class="single-testimonial-4 text-center">
                    <img src="{{asset('frontend/assets')}}/img/icon-img/42.png" alt="">
                    <p>This product is best product i ever get. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt labore et dolore magna.</p>
                    <h4>Newaz Sharif  /  UI Ux Designer</h4>
                </div>
                <div class="single-testimonial-4 text-center">
                    <img src="{{asset('frontend/assets')}}/img/icon-img/42.png" alt="">
                    <p>This product is best product i ever get. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt labore et dolore magna.</p>
                    <h4>Newaz Sharif  /  UI Ux Designer</h4>
                </div>
                <div class="single-testimonial-4 text-center">
                    <img src="{{asset('frontend/assets')}}/img/icon-img/42.png" alt="">
                    <p>This product is best product i ever get. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt labore et dolore magna.</p>
                    <h4>Newaz Sharif  /  UI Ux Designer</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- testimonials area end -->

    <!-- modal -->
    {{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="pe-7s-close" aria-hidden="true"></span>
        </button>
        <div class="modal-dialog modal-quickview-width" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="qwick-view-left">
                        <div class="quick-view-learg-img">
                            <div class="quick-view-tab-content tab-content">
                                <div class="tab-pane active show fade" id="modal1" role="tabpanel">
                                    <img src="{{asset('frontend/assets')}}/img/quick-view/l1.jpg" alt="">
                                </div>
                                <div class="tab-pane fade" id="modal2" role="tabpanel">
                                    <img src="{{asset('frontend/assets')}}/img/quick-view/l2.jpg" alt="">
                                </div>
                                <div class="tab-pane fade" id="modal3" role="tabpanel">
                                    <img src="{{asset('frontend/assets')}}/img/quick-view/l3.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="quick-view-list nav" role="tablist">
                            <a class="active" href="#modal1" data-toggle="tab" role="tab">
                                <img src="{{asset('frontend/assets')}}/img/quick-view/s1.jpg" alt="">
                            </a>
                            <a href="#modal2" data-toggle="tab" role="tab">
                                <img src="{{asset('frontend/assets')}}/img/quick-view/s2.jpg" alt="">
                            </a>
                            <a href="#modal3" data-toggle="tab" role="tab">
                                <img src="{{asset('frontend/assets')}}/img/quick-view/s3.jpg" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="qwick-view-right">
                        <div class="qwick-view-content">
                            <h3>Handcrafted Supper Mug</h3>
                            <div class="price">
                                <span class="new">$90.00</span>
                                <span class="old">$120.00  </span>
                            </div>
                            <div class="rating-number">
                                <div class="quick-view-rating">
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                                <div class="quick-view-number">
                                    <span>2 Ratting (S)</span>
                                </div>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adip elit, sed do tempor incididun ut labore et dolore magna aliqua. Ut enim ad mi , quis nostrud veniam exercitation .</p>
                            <div class="quick-view-select">
                                <div class="select-option-part">
                                    <label>Size*</label>
                                    <select class="select">
                                        <option value="">- Please Select -</option>
                                        <option value="">900</option>
                                        <option value="">700</option>
                                    </select>
                                </div>
                                <div class="select-option-part">
                                    <label>Color*</label>
                                    <select class="select">
                                        <option value="">- Please Select -</option>
                                        <option value="">orange</option>
                                        <option value="">pink</option>
                                        <option value="">yellow</option>
                                    </select>
                                </div>
                            </div>
                            <div class="quickview-plus-minus">
                                <div class="cart-plus-minus">
                                    <input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
                                </div>
                                <div class="quickview-btn-cart">
                                    <a class="btn-hover-black" href="#">add to cart</a>
                                </div>
                                <div class="quickview-btn-wishlist">
                                    <a class="btn-hover" href="#"><i class="pe-7s-like"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

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
                    <a href="about-us.html">about us</a>
                </li>
                <li>
                    <a href="#">pages</a>
                    <ul>
                        <li><a href="{{route('page.about_us')}}">about us</a></li>
                        <li><a href="{{route('page.menu_list')}}">Danh mục</a></li>
                        <li><a href="{{route('login')}}">Đăng nhập</a></li>
                        <li><a href="{{route('register')}}">Đăng ký</a></li>
                        <li><a href="{{route('page.cart')}}">Giỏ hàng</a></li>
                        <li><a href="{{route('page.checkout')}}">Thanh toán</a></li>
                        <li><a href="{{route('page.wishlist')}}">Sản phẩm yêu thích</a></li>
                        <li><a href="{{route('page.contact')}}">Liên hệ</a></li>
                    </ul>
                </li>
                <li><a href="{{route('page.blog')}}">blogs</a></li>
            </ul>
        </div>
    </div>

@stop
