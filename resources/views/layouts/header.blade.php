<?php
    use App\Section;
    use App\Cart;
    $carts = Cart::loadCart() ;
    $sections = Section::sections();
    // echo '<pre>'; print_r($sections); die;
?>

<header>
    <div class="header-top-furniture wrapper-padding-2 res-header-sm">
        <div class="container-fluid">
            <div class="header-bottom-wrapper">
                <div class="logo-2 furniture-logo ptb-30">
                    <a href="{{route('page.index')}}">
                    <img src="{{asset('frontend/assets/img/logo/2.png')}}" alt="">
                    </a>
                </div>
                <div class="menu-style-2 furniture-menu menu-hover">
                    <nav>
                        <ul>
                            <li><a href="{{route('page.index')}}">home</a></li>
                            <li><a href="#">shop</a>
                                <ul class="single-dropdown">
                                    @foreach($sections as $section)
                                    <li>
                                        <a href="#" class="parent_a_dropdown">{{$section['name']}}</a>
                                        @foreach($section['category'] as $category)
                                        <ul class="children-dropdown">
                                            <li><a href="{{route('page.menu_listen',$category['slug'])}}">{{$category['name']}}</a>   </li>
                                        </ul>
                                        @endforeach
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="{{route('page.contact')}}">contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="header-cart header-cart-all">
                    <a class="icon-cart-furniture" href="#">
                        <i class="ti-shopping-cart"></i>
                        <span class="shop-count green " id="countCart">{{count($carts)}}</span>
                        {{-- <span class="shop-count-furniture green " id="cart-count-all">0</span> --}}
                    </a>
                    <ul class="cart-dropdown">
                        @foreach($carts as $cart)
                        <li class="single-product-cart">
                            <div class="cart-img">
                                <a href="#"><img src="{{asset('/storage/'.$cart['product']['image'])}}" alt="" class="imgLoadCart"></a>
                            </div>
                            <div class="cart-title">
                                <h5><a href="#" class="nameLoadCart">{{$cart['product']['name']}}</a></h5>
                                <h6><a href="#" class="colorLoadCart">{{$cart['product']['color']}} <small>(size: {{$cart['size']}})</small></a></h6>
                                <span class="priceLoadCart">{{number_format($cart['price'])}} x {{$cart['quantity']}}</span>
                            </div>
                            <div class="cart-delete">
                                <a href="javascript:void(0)" class="removeCart" onClick="removeCart(this.parentElement.parentElement,{{$cart['id']}})"><i class="ti-trash"></i></a>
                            </div>
                        </li>
                        @endforeach
                        <div id="cartLoadHeader">
                            <p class="text-center" style="display:none">Không có sản phẩm nào</p>
                        </div>

                        <li class="cart-btn-wrapper">
                            <a class="cart-btn btn-hover" href="{{route('page.cart')}}">view cart</a>
                            <a class="cart-btn btn-hover" href="{{route('page.checkout')}}">checkout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom-furniture wrapper-padding-2 border-top-3 d-none d-md-block">
        <div class="container-fluid">
            <div class="furniture-bottom-wrapper">
                <div class="furniture-login">
                    @if(!Auth::user())
                    <ul>
                        <li><a href="{{route('login')}}">Đăng nhập </a></li>
                        <li><a href="{{route('register')}}">Đăng ký </a></li>
                    </ul>
                    @else
                    <div class="nav-item dropdown header-user-drop">

                        <a href="#" data-toggle="dropdown" class="nav-item nav-link dropdown-toggle user-action pl-5">
                            @if(!Auth::user()->image)
                                <img src="https://dummyimage.com/40x40/d6d6d6/001f5e.png&text=no+image" class="avatar rounded-circle " alt="Avatar" id="loadAvatarHeader">
                            @else
                                <img src="/storage/{{Auth::user()->image}}" class="avatar rounded-circle " alt="Avatar" id="loadAvatarHeader">
                            @endif
                            <span id="loadNameHeader">{{Auth::user()->name ?? 'No Name'}}</span> <b class="caret"></b>
                        </a>

                        <div class="dropdown-menu ml-4">
                            <a href="{{route('page.profile.index')}}" class="dropdown-item "><i class="fas fa-user-circle"> </i> Thông tin tài khoản</a>
                            <div class="divider dropdown-divider"></div>
                            <form  action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button  type="submit" class="dropdown-item dropButton"><i class="fas fa-sign-out-alt "></i> Đăng xuất</button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="furniture-search">
                    <form method="post" id="formSearchOrder">
                        @csrf
                        <input id="searchOrder" placeholder="Tra cứu đơn hàng (Nhập mã đơn hàng của bạn)" name="order_code" type="text">
                        <button  type="submit">
                            <i class="ti-search"></i>
                        </button>
                    </form>
                </div>

                <div class="furniture-wishlist">
                    <ul>
                        <li><a href="{{route('page.wishlist')}}"><i class="ti-heart"></i> Yêu thích</a></li>
                        <li><a href="{{route('page.cart')}}"><i class="fab fa-opencart"></i> Giỏ hàng</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="loader"></div>
