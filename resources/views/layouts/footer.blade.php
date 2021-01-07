<?php
    use App\Banner;  use App\Section;
    $sections = Section::sections();
    $bannerFooter = Banner::banners('index-footer');
?>
<footer class="footer-area">
    <div class="footer-top-area bg-img pt-105 pb-65" style=" background-image: url({{$bannerFooter}})" data-overlay="9">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-md-3">
                    <div class="footer-widget mb-40">
                        <h3 class="footer-widget-title">Dịch vụ</h3>
                        <div class="footer-widget-content">
                            <ul>
                                <li><a href="{{route('page.cart')}}">Giỏ hàng</a></li>
                                <li><a href="{{route('page.wishlist')}}">Yêu thích</a></li>
                                <li><a href="{{route('login')}}">Đăng nhập</a></li>
                                <li><a href="{{route('register')}}">Đăng ký</a></li>
                                <li><a href="{{route('page.contact')}}">Liên hệ</a></li>
                                <li><a href="{{route('page.menu_list')}}">Cửa hàng</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-3">
                    <div class="footer-widget mb-40">
                        <h3 class="footer-widget-title">
                            @foreach($sections as $section)
                                {{$section['name']}}
                            @endforeach
                        </h3>
                        <div class="footer-widget-content">
                            <ul>
                                @foreach($sections as $section)
                                    @foreach($section['category'] as $category)
                                        <li><a href="#">{{$category['name']}}</a></li>
                                    @endforeach
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="footer-widget mb-40">
                        <h3 class="footer-widget-title">Liên hệ</h3>
                        <div class="footer-newsletter">
                            <p>Mọi giải đáp của khách hàng chúng tôi sẽ tiếp nhận và giúp AloKet ngày phát triển.</p>
                            <div class="footer-contact mt-5">
                                <p><span><i class="ti-location-pin"></i></span>QUẬN 12, THÀNH PHỐ HỒ CHÍ MINH</p>
                                <p><span><i class=" ti-headphone-alt "></i></span> 0584.230.050</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom black-bg ptb-20">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="copyright">
                        <p>
                            Copyright ©
                            <a href="https://hastech.company/"> Ezone</a> 2020 | Phiên bản thử nghiệm.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
