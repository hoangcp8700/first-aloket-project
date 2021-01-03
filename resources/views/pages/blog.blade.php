@extends('layouts.app')

@section('nd')
<?php
    use App\Banner;
    $bannersM = Banner::banners('blog');
    if(!$bannersM){
       $bannersM = asset('frontend/assets/img/bg/breadcrumb.jpg');
    }else{
        $bannersM = asset('/storage/'.$bannersM[0]->image);
    }
?>
<div class="breadcrumb-area pt-205 pb-210" style="background-image: url({{$bannersM}})">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>blog page</h2>
            <ul>
                <li><a href="#">home</a></li>
                <li> blog </li>
            </ul>
        </div>
    </div>
</div>
<!-- shopping-cart-area start -->
<div class="blog-area pt-95 pb-100">
    <div class="container">
        <div class="blog-mesonry">
            <div class="row grid">
                <div class="col-lg-4 col-md-6 grid-item">
                    <div class="blog-wrapper mb-40">
                        <div class="blog-img">
                            <a href="#"><img src="{{asset('frontend/assets/img/blog/4.jpg')}}" alt=""></a>
                        </div>
                        <div class="blog-info-wrapper">
                            <div class="blog-meta">
                                <ul>
                                    <li><a href="#">Fashion </a></li>
                                    <li>October 26, 2018</li>
                                </ul>
                            </div>
                            <h4><a href="#">5 Things You Didn’t Know About Kim Kardashian West.</a></h4>
                            <p>Formfitting clothing is all about a sweet spot. That elusive place where an item is tight but not clingy, sexy but not cloying, cool but not over the top. Alexandra Alvarez’s label, Alix, hits that mark with its range of comfortable, minimal, and neutral-hued bodysuits. </p>
                            <a class="blog-btn btn-hover" href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 grid-item">
                    <div class="blog-wrapper mb-40">
                        <div class="blog-img">
                            <a href="#"><img src="{{asset('frontend/assets/img/blog/5.jpg')}}" alt=""></a>
                        </div>
                        <div class="blog-info-wrapper">
                            <div class="blog-meta">
                                <ul>
                                    <li><a href="#">Fashion </a></li>
                                    <li>October 26, 2018</li>
                                </ul>
                            </div>
                            <h4><a href="#">Alix Debuts a Swim Line for Spring 2016.</a></h4>
                            <p>Formfitting clothing is all about a sweet spot. That elusive place where an item is tight but not clingy, sexy but not cloying, </p>
                            <a class="blog-btn btn-hover" href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 grid-item">
                    <div class="blog-wrapper mb-40">
                        <div class="blog-img">
                            <a href="#"><img src="{{asset('frontend/assets/img/blog/6.jpg')}}" alt=""></a>
                        </div>
                        <div class="blog-info-wrapper">
                            <div class="blog-meta">
                                <ul>
                                    <li><a href="#">Fashion </a></li>
                                    <li>October 26, 2018</li>
                                </ul>
                            </div>
                            <h4><a href="#">Plucked From Our Favorite Painting And Drawing</a></h4>
                            <p>Formfitting clothing is all about a sweet spot. That elusive place where an item is tight but not clingy, sexy but not cloying,  </p>
                            <a class="blog-btn btn-hover" href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 grid-item">
                    <div class="blog-wrapper mb-40">
                        <div class="blog-img">
                            <a href="#"><img src="{{asset('frontend/assets/img/blog/9.jpg')}}" alt=""></a>
                        </div>
                        <div class="blog-info-wrapper">
                            <div class="blog-meta">
                                <ul>
                                    <li><a href="#">Fashion </a></li>
                                    <li>October 26, 2018</li>
                                </ul>
                            </div>
                            <h4><a href="#">Plucked From Our Favorite Painting And Drawing.</a></h4>
                            <p>Formfitting clothing is all about a sweet spot. That elusive place where an item is tight but not clingy, sexy but not cloying, </p>
                            <a class="blog-btn btn-hover" href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 grid-item">
                    <div class="blog-wrapper mb-40">
                        <div class="blog-img">
                            <a href="#"><img src="{{asset('frontend/assets/img/blog/7.jpg')}}" alt=""></a>
                        </div>
                        <div class="blog-info-wrapper">
                            <div class="blog-meta">
                                <ul>
                                    <li><a href="#">Fashion </a></li>
                                    <li>October 26, 2018</li>
                                </ul>
                            </div>
                            <h4><a href="#">5 Things You Didn’t Know About Kim Kardashian West.</a></h4>
                            <p>Formfitting clothing is all about a sweet spot. That elusive place where an item is tight but not clingy, sexy but not cloying, cool but not over the top. Alexandra Alvarez’s label, Alix, hits that mark with its range of comfortable, minimal, and neutral-hued bodysuits. </p>
                            <a class="blog-btn btn-hover" href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 grid-item">
                    <div class="blog-wrapper mb-40">
                        <div class="blog-img">
                            <a href="#"><img src="assets/img/blog/8.jpg" alt=""></a>
                        </div>
                        <div class="blog-info-wrapper">
                            <div class="blog-meta">
                                <ul>
                                    <li><a href="#">Fashion </a></li>
                                    <li>October 26, 2018</li>
                                </ul>
                            </div>
                            <h4><a href="#">Alix Debuts a Swim Line for Spring 2016.</a></h4>
                            <p>Formfitting clothing is all about a sweet spot. That elusive place where an item is tight but not clingy, sexy but not cloying,  </p>
                            <a class="blog-btn btn-hover" href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 grid-item">
                    <div class="blog-wrapper mb-40">
                        <div class="blog-img">
                            <a href="#"><img src="assets/img/blog/12.jpg" alt=""></a>
                        </div>
                        <div class="blog-info-wrapper">
                            <div class="blog-meta">
                                <ul>
                                    <li><a href="#">Fashion </a></li>
                                    <li>October 26, 2018</li>
                                </ul>
                            </div>
                            <h4><a href="#">Alix Debuts a Swim Line for Spring 2016.</a></h4>
                            <p>Formfitting clothing is all about a sweet spot. That elusive place where an item is tight but not clingy, sexy but not cloying, </p>
                            <a class="blog-btn btn-hover" href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 grid-item">
                    <div class="blog-wrapper mb-40">
                        <div class="blog-img">
                            <a href="#"><img src="assets/img/blog/10.jpg" alt=""></a>
                        </div>
                        <div class="blog-info-wrapper">
                            <div class="blog-meta">
                                <ul>
                                    <li><a href="#">Fashion </a></li>
                                    <li>October 26, 2018</li>
                                </ul>
                            </div>
                            <h4><a href="#">5 Things You Didn’t Know About Kim Kardashian West.</a></h4>
                            <p>Formfitting clothing is all about a sweet spot. That elusive place where an item is tight but not clingy, sexy but not cloying, cool but not over the top. Alexandra Alvarez’s label, Alix, hits that mark with its range of comfortable, minimal, and neutral-hued bodysuits. </p>
                            <a class="blog-btn btn-hover" href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 grid-item">
                    <div class="blog-wrapper mb-40">
                        <div class="blog-img">
                            <a href="#"><img src="assets/img/blog/11.jpg" alt=""></a>
                        </div>
                        <div class="blog-info-wrapper">
                            <div class="blog-meta">
                                <ul>
                                    <li><a href="#">Fashion </a></li>
                                    <li>October 26, 2018</li>
                                </ul>
                            </div>
                            <h4><a href="#">Plucked From Our Favorite Painting And Drawing.</a></h4>
                            <p>Formfitting clothing is all about a sweet spot. That elusive place where an item is tight but not clingy, sexy but not cloying,  </p>
                            <a class="blog-btn btn-hover" href="#">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pagination-style mt-20 text-center">
            <ul>
                <li><a href="#"><i class="ti-angle-left"></i></a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">...</a></li>
                <li><a href="#">19</a></li>
                <li class="active"><a href="#"><i class="ti-angle-right"></i></a></li>
            </ul>
        </div>
    </div>
</div>


@stop
