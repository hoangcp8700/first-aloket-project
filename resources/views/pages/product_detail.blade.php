@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{asset('frontend/assets/css/easyzoom.css')}}">
@stop

@section('nd')

<?php
    use App\Banner;
    use App\Wishlist;
    $bannersM = Banner::banners('product-detail');
     // echo '<pre>'; print_r($bannersM); die;
    if(!$bannersM){
       $banner = asset('frontend/assets/img/bg/breadcrumb.jpg');
    }else{
        $banner = asset('/storage/'.$bannersM[0]->image);
    }
?>
<div class="breadcrumb-area pt-205 pb-210" style="background-image: url({{$banner}})">
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

                            {{-- <a class="mb-10" href="#pro-details2" data-toggle="tab" role="tab" aria-selected="true">
                                <img src="https://dummyimage.com/125x156/551251/0011ff.png" alt="">
                            </a>
                            <a class="mb-10" href="#pro-details3" data-toggle="tab" role="tab" aria-selected="true">
                                <img src="https://dummyimage.com/125x156/123123/0011ff.png" alt="">
                            </a>
                            <a class="mb-10" href="#pro-details4" data-toggle="tab" role="tab" aria-selected="true">
                                <img src="https://dummyimage.com/125x156/343312/0011ff.png" alt="">
                            </a> --}}
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
                            <div class="cart-plus-minus">
                                <input type="number" value="1" name="quantity" class="cart-plus-minus-box" id="quantityCart">
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
                           <tr><th>Size</th>
                            <td>
                                @foreach($product['product_attr'] as $attr)
                                {{$attr['size']}},
                                @endforeach
                            </td></tr>
                            @endif

                           <tr><th>Ngày khởi tạo</th><td>{{date('d-m-Y', strtotime($product['created_at']))}}</td></tr>
                       </tbody>
                   </table>
                 </div>
                <div class="tab-pane fade" id="pro-dec" role="tabpanel">
                   <p>{!! $product['description'] !!}</p>
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
                            <span>{{number_format($product['discount'])}}</span> <span style="font-size:14px">vnđ</span>
                         </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
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
                                <img src="assets/img/quick-view/l1.jpg" alt="">
                            </div>
                            <div class="tab-pane fade" id="modal2" role="tabpanel">
                                <img src="assets/img/quick-view/l2.jpg" alt="">
                            </div>
                            <div class="tab-pane fade" id="modal3" role="tabpanel">
                                <img src="assets/img/quick-view/l3.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="quick-view-list nav" role="tablist">
                        <a class="active" href="#modal1" data-toggle="tab" role="tab">
                            <img src="assets/img/quick-view/s1.jpg" alt="">
                        </a>
                        <a href="#modal2" data-toggle="tab" role="tab">
                            <img src="assets/img/quick-view/s2.jpg" alt="">
                        </a>
                        <a href="#modal3" data-toggle="tab" role="tab">
                            <img src="assets/img/quick-view/s3.jpg" alt="">
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
                                    <option>{{$product['color']}}</option>
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
<!-- modal -->
{{-- <div class="modal fade" id="exampleCompare" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span class="pe-7s-close" aria-hidden="true"></span>
    </button>
    <div class="modal-dialog modal-compare-width" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="#">
                    <div class="table-content compare-style table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>
                                        <a href="#">Remove <span>x</span></a>
                                        <img src="assets/img/cart/4.jpg" alt="">
                                        <p>Blush Sequin Top </p>
                                        <span>$75.99</span>
                                        <a class="compare-btn" href="#">Add to cart</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="compare-title"><h4>Description </h4></td>
                                    <td class="compare-dec compare-common">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has beenin the stand ard dummy text ever since the 1500s, when an unknown printer took a galley</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Sku </h4></td>
                                    <td class="product-none compare-common">
                                        <p>-</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Availability  </h4></td>
                                    <td class="compare-stock compare-common">
                                        <p>In stock</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Weight   </h4></td>
                                    <td class="compare-none compare-common">
                                        <p>-</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Dimensions   </h4></td>
                                    <td class="compare-stock compare-common">
                                        <p>N/A</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>brand   </h4></td>
                                    <td class="compare-brand compare-common">
                                        <p>HasTech</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>color   </h4></td>
                                    <td class="compare-color compare-common">
                                        <p>Grey, Light Yellow, Green, Blue, Purple, Black </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>size    </h4></td>
                                    <td class="compare-size compare-common">
                                        <p>XS, S, M, L, XL, XXL </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"></td>
                                    <td class="compare-price compare-common">
                                        <p>$75.99 </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}
@stop

@push('script')
<script src="{{asset('frontend/assets/js/pages/product_detail.js')}}"> </script>
@endpush
