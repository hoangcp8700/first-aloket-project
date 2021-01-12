
<div id="grid-sidebar3" class="tab-pane fade active show">
    <div class="row justify-content-center">
        @if(count($products) > 0)
            @foreach($products as $product)
            <div class="col-md-6 col-xl-4 col-sm-6 col-7 ">
                <div class="product-wrapper mb-30">
                    <div class="product-img">
                        <a href="{{route('page.productDetail',$product->product_code)}}">
                            @if($product->image)
                                <img src="{{asset('/storage/'.$product->image)}}" alt="">
                            @else
                                <img src="https://dummyimage.com/500x654/a6a6a6/1e1e24.png&text=No+image">
                            @endif
                        </a>
                        @if($product->keyword)
                        <span>{{$product->keyword}}</span>
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
                        <h4><a href="#"> {{$product->name}}</a></h4>
                        <span><span>đ</span>
                        {{ ($product['discount']) ? number_format($product->discount) : number_format($product->price)}}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            Danh mục chưa có sản phẩm nào!!!
        @endif
    </div>
</div>
<div id="grid-sidebar4" class="tab-pane fade">
    <div class="row">
        @if(count($products) > 0)
            @foreach($products as $product)
            <div class="col-lg-12 col-xl-6 col-md-12 d-none d-md-block">
                <div class="product-wrapper mb-30 single-product-list product-list-right-pr mb-60">
                    <div class="product-img list-img-width">
                        <a href="{{route('page.productDetail',$product->product_code)}}">
                            @if($product->image)
                                <img src="{{asset('/storage/'.$product->image)}}" alt="">
                            @else
                                <img src="https://dummyimage.com/500x654/a6a6a6/1e1e24.png&text=No+image">
                            @endif
                        </a>
                        @if($product->keyword)
                        <span>{{$product->keyword}}</span>
                        @endif
                    </div>
                    <div class="product-content-list">
                        <div class="product-list-info">
                            <h4><a href="#"> {{$product->name}} </a></h4>
                            <span><span>đ</span>
                             {{ ($product['discount']) ? number_format($product->discount) : number_format($product->price)}}
                            </span>
                            <div class="product-des"><p>{!!$product->description!!}</p></div>
                        </div>
                        <div class="product-list-cart-wishlist">
                            <div class="product-list-cart">
                                <a class="btn-hover list-btn-wishlist" href="#">
                                    <i class="fas fa-cart-plus"></i>
                                </a>
                            </div>
                            <div class="product-list-wishlist">
                                <a class="btn-hover list-btn-wishlist" href="#">
                                    <i class="pe-7s-like"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
        Danh mục chưa có sản phẩm nào!!!
        @endif
    </div>
</div>
<div style="display:flex; justify-content:center">
    @if(empty($_GET['sort']))
    {{$products->links()}}
    @else
    {{$products->appends(['sort' => $_GET['sort']])->links() }}
    @endif
</div>
