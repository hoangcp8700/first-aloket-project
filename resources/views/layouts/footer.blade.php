
<?php
use App\Banner;
use App\Section;

$sections = Section::sections();
$bannerFooter = Banner::banners('index-footer');
if($bannerFooter){
    $banner = asset('/storage/'.$bannerFooter[0]->image);
}else{
    $banner = asset('frontend/assets/img/bg/breadcrumb.jpg');
}
?>
<footer class="footer-area">
    <div class="footer-top-area bg-img pt-105 pb-65" style=" background-image: url({{$banner}})" data-overlay="9">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-md-3">
                    <div class="footer-widget mb-40">
                        <h3 class="footer-widget-title">Dịch vụ</h3>
                        <div class="footer-widget-content">
                            <ul>
                                <li><a href="{{route('page.cart')}}">Giỏ hàng</a></li>
                                <li><a href="#">Tài khoản</a></li>
                                <li><a href="{{route('login')}}">Đăng nhập</a></li>
                                <li><a href="{{route('register')}}">Đăng ký</a></li>
                                <li><a href="{{route('page.contact')}}">Liên hệ</a></li>
                                <li><a href="{{route('page.blog')}}">Blog</a></li>
                                <li><a href="{{route('page.about_us')}}">about us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-3">
                    <div class="footer-widget mb-40">
                        <h3 class="footer-widget-title">Categories</h3>
                        <div class="footer-widget-content">
                            <ul>
                                @foreach($sections as $section)
                                    <li><a href="#">{{$section['name']}}</a></li>
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
                            <div id="mc_embed_signup" class="subscribe-form pr-40">
                                <form action="" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                                    <div id="mc_embed_signup_scroll" class="mc-form">
                                        <input type="email" value="" name="EMAIL" class="email" placeholder="Enter Your E-mail" required>

                                        <div class="mc-news" aria-hidden="true">
                                            <input type="text" name="#" tabindex="-1" value="">
                                        </div>
                                        <div class="clear">
                                            <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="footer-contact">
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
