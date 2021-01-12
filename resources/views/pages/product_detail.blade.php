@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{asset('frontend/assets/css/easyzoom.css')}}">
@stop

@section('nd')

<?php
    use App\Banner;
    use App\Wishlist;
    $bannersM = Banner::banners('product-detail');
?>
<div class="breadcrumb-area pt-205 pb-210" style="background-image: url({{$bannersM}})">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>product details</h2>
            <ul>
                <li><a href="#">home</a></li>
                <li> product details </li>
            </ul>
        </div>
    </div>
</div>
<div class="product-details ptb-100 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-7 col-12">
                <div class="product-details-img-content">
                    <div class="product-details-tab mr-35 product-details-tab2">
                        <div class="product-details-large tab-content">
                            <div class="tab-pane active show fade" id="pro-details1" role="tabpanel">
                                <div class="easyzoom easyzoom--overlay ">
                                    @if($product['image'])
                                        <a href="{{asset('/storage/'.$product['image'])}}" style="width:1125px; height:1200px">
                                            <img src="{{asset('/storage/'.$product['image'])}}" alt="">
                                        </a>
                                    @else
                                        <a href="https://dummyimage.com/500x654/a6a6a6/1e1e24.png&text=No+image" style="width:1125px; height:1200px">
                                            <img src="https://dummyimage.com/500x654/a6a6a6/1e1e24.png&text=No+image">
                                        </a>

                                    @endif
                                </div>
                            </div>
                            @if(count($product['product_image']) > 0)
                                @foreach($product['product_image'] as $productImg)
                                <div class="tab-pane fade" id="pro-details{{$loop->index+2}}" role="tabpanel">
                                    <div class="easyzoom easyzoom--overlay">
                                        <a href="{{asset('/storage/'.$productImg['image'])}}">
                                            <img src="{{asset('/storage/'.$productImg['image'])}}" alt="">
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        @if(count($product['product_image']) > 0)
                        <div class="product-details-small nav ml-10 product-details-2" role=tablist>
                            <a class=" mb-10" href="#pro-details1" data-toggle="tab" role="tab" aria-selected="true">
                                @if($product['image'])
                                    <img src="{{asset('/storage/'.$product['image'])}}" alt="">
                                @else
                                    <img src="https://dummyimage.com/125x156/a6a6a6/1e1e24.png&text=No+image">

                                @endif
                            </a>
                            @foreach($product['product_image'] as $productImg)
                            <a class="mb-10" href="#pro-details{{$loop->index+2}}" data-toggle="tab" role="tab" aria-selected="true">
                                <img src="{{asset('/storage/'.$productImg['image'])}}" alt="">
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 col-xl-5 col-12">
                <div class="product-details-content">
                <h3>{{$product['name']}}</h3>
                    <div class="rating-number">
                        <div class="quick-view-rating">
                            <i class="pe-7s-star red-star"></i>
                            <i class="pe-7s-star red-star"></i>
                            <i class="pe-7s-star"></i>
                            <i class="pe-7s-star"></i>
                            <i class="pe-7s-star"></i>
                        </div>
                        <div class="quick-view-number">
                            <span>2 Ratting (S)</span>
                        </div>
                    </div>
                    <form method="post" id="addTocartForm">
                        @csrf
                        <input  type="hidden" name="price" id="priceCart">
                        @if($product['discount'])
                        <div class="discounts-price">
                            <span>{{number_format($product['price'])}}<span style="font-size:14px">₫</span></span>
                        </div>
                        <div class="details-price">
                            <span class="loadPriceDetail">{{number_format($product['discount'])}} <span style="font-size:14px">₫</span></span>
                        </div>
                        @else
                        <div class="details-price">
                            <span class="loadPriceDetail">{{number_format($product['price'])}} <span style="font-size:14px">₫</span></span>
                        </div>
                        @endif
                        <div class="quick-view-select">
                            <div class="select-option-part">
                                <label>Size*</label>
                                <select class="select" name="size" data-id="{{$product['id']}}" id="getSizePrice">
                                    <option value="">- Please Select -</option>
                                    @foreach($product['product_attr'] as $attr)
                                    <option value="{{$attr['size']}}">{{$attr['size']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="select-option-part">
                                <label>Màu*</label>
                                <select class="select">
                                    <option>{{$product['color']}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="quickview-plus-minus">
                            <div class="cart-plus-minus" onClick="changeQuantity()">
                                <input type="text" value="1" name="quantity" class="cart-plus-minus-box" id="quantityCart">
                            </div>
                            <div class="quickview-btn-cart">
                                    <input  type="hidden" name="product_id" id="cartID" value="{{$product['id']}}">
                                    <button autofocus type="submit" class="btn btn-info btm-lg">Add To Cart</button>
                            </div>
                            <div class="quickview-btn-wishlist">
                                @if(Auth::check())
                                    <?php    $wishlist = Wishlist::colorWishlist($product['id'],Auth::user()->id); ?>
                                    <a class="btn-hover @if($wishlist) colorWishlist @endif" id="colorWishlist" href="javascript:void(0)" onClick="addWishlist({{$product['id']}},{{Auth::user()->id}})"><i class="pe-7s-like"></i></a>
                                @else
                                    <a class="btn-hover" id="colorWishlist" href="javascript:void(0)" onClick="addWishlist({{$product['id']}},0)"><i class="pe-7s-like"></i></a>
                                @endif

                            </div>
                        </div>
                    </form>

                    <div class="product-share mt-35">
                        <ul>
                            <li class="categories-title">Share :</li>
                            <li>
                                <a href="#">
                                    <i class="icofont icofont-social-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icofont icofont-social-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icofont icofont-social-pinterest"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icofont icofont-social-flikr"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product-description-review-area pb-90">
    <div class="container">
        <div class="product-description-review text-center">
            <div class="description-review-title nav" role=tablist>
                <a class="active" href="#pro-detail" data-toggle="tab" role="tab" aria-selected="true">
                    Details
                </a>
                <a href="#pro-dec" data-toggle="tab" role="tab" aria-selected="false">
                    Description
                </a>
                <a href="#pro-review" data-toggle="tab" role="tab" aria-selected="false">
                    Reviews (0)
                </a>
            </div>
            <div class="description-review-text tab-content">
                <div class="tab-pane active show fade" id="pro-detail" role="tabpanel">
                   <table class="table table-bordered table-dark ">
                       <tbody>
                           <tr><th>Lĩnh vực</th><td>{{$product['section']['name']}}</td></tr>
                           <tr><th>Danh mục</th><td>{{$product['category']['name']}}</td></tr>
                           <tr><th>Tên sản phẩm</th><td>{{$product['name']}}</td></tr>
                           <tr><th>Mã sản phẩm</th><td>{{$product['product_code']}}</td></tr>
                           <tr><th>Chất liệu</th><td>{{$product['fabric']}}</td></tr>
                           <tr><th>Kiểu dáng</th><td>{{$product['fit']}}</td></tr>
                           <tr><th>Màu sắc</th><td>{{$product['color']}}</td></tr>
                            @if($product['product_attr'])
                                <tr>
                                    <th>Size</th>
                                    <td>
                                        @foreach($product['product_attr'] as $attr)
                                            {{$attr['size']}},
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                           <tr><th>Ngày khởi tạo</th><td>{{date('d-m-Y', strtotime($product['created_at']))}}</td></tr>
                       </tbody>
                   </table>
                 </div>
                <div class="tab-pane fade" id="pro-dec" role="tabpanel">
                   <p>{!! $product['description'] ? $product['description'] : 'Sản phẩm không có mô tả'!!}</p>
                </div>
                <div class="tab-pane fade" id="pro-review" role="tabpanel">
                    <a href="#">Be the first to write your review!</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product area start -->
<div class="product-area pb-95">
    <div class="container">
        <div class="section-title-3 text-center mb-50">
            <h2>Sản phẩm liên quan</h2>
        </div>
        <div class="product-style">
            <div class="related-product-active owl-carousel">
                @foreach($lqs as $lq)
                <div class="product-wrapper">
                    <div class="product-img">
                        <a href="{{route('page.productDetail',$lq->product_code)}}">
                        @if($lq->image)
                            <img src="{{asset('/storage/'.$lq->image)}}" alt="">
                        @else
                            <img src="https://dummyimage.com/370x374/bab4ba/010203.png&text=No+image">
                        @endif
                        </a>
                        @if($lq->keyword)
                            <span>{{$lq->keyword}}</span>
                        @endif
                        <div class="product-action">
                            <a class="animate-left" title="Wishlist" href="#">
                                <i class="pe-7s-like"></i>
                            </a>
                            <a class="animate-top" title="Add To Cart" href="#">
                                <i class="pe-7s-cart"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-content">
                        <h4><a href="#">{{$lq->name}}</a></h4>
                         <div class="details-price">
                            <span>{{$lq['discount'] ? number_format($lq['discount']) : number_format($lq['price'])}}</span> <span style="font-size:14px">vnđ</span>
                         </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@stop

@push('script')
<script src="{{asset('frontend/assets/js/pages/product_detail.js')}}"> </script>
@endpush
