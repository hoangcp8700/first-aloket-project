@extends('layouts.app')

@section('nd')
<?php
    use App\Banner;
    $bannersM = Banner::banners('contact');
     // echo '<pre>'; print_r($bannersM); die;
    if(!$bannersM){
       $bannersM = asset('frontend/assets/img/bg/breadcrumb.jpg');
    }else{
        $bannersM = asset('/storage/'.$bannersM[0]->image);
    }
?>
<div class="breadcrumb-area pt-205 pb-210" style="background-image: url({{$bannersM}})">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>contact us</h2>
            <ul>
                <li><a href="#">home</a></li>
                <li> contact us</li>
            </ul>
        </div>
    </div>
</div>
<!-- shopping-cart-area start -->
<div class="contact-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="contact-map-wrapper">
                    <div class="contact-message">
                        <div class="contact-title">
                            <h4>Thông tin liên lạc</h4>
                        </div>
                        <form  class="contact-form" id="contactForm" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="contact-input-style mb-30">
                                        <label>Họ tên *</label>
                                        <input name="name" class="input @error('name') is-invalid @enderror" value="{{ old('name') }}" type="text" autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="contact-input-style mb-30">
                                        <label>Email*</label>
                                        <input name="email" class="input @error('email') is-invalid @enderror" type="text" value="{{ old('email') }}" autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="contact-input-style mb-30">
                                        <label>Số điện thoại *</label>
                                        <input name="phone" class="input @error('phone') is-invalid @enderror"  type="text" value="{{ old('phone') }}" autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="contact-input-style mb-30">
                                        <label>Tiêu đề</label>
                                        <input name="subject" class="input @error('subject') is-invalid @enderror" type="text" value="{{ old('subject') }}" autofocus>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="contact-textarea-style mb-30">
                                        <label>Nội dung *</label>
                                        <textarea class="input form-control2 @error('content') is-invalid @enderror"  name="content" value="{{ old('content') }}"  autofocus></textarea>
                                    </div>
                                    <button class="submit contact-btn btn-hover" type="submit" >
                                        Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-info-wrapper">
                    <div class="contact-title">
                        <h4>Liên hệ</h4>
                    </div>
                    <div class="contact-info">
                        <div class="single-contact-info">
                            <div class="contact-info-icon">
                                <i class="ti-location-pin"></i>
                            </div>
                            <div class="contact-info-text">
                                <p><span>Địa chỉ:</span> 28 Đông hưng thuận 19 <br> TP.HÔ Chí Minh</p>
                            </div>
                        </div>
                        <div class="single-contact-info">
                            <div class="contact-info-icon">
                                <i class="pe-7s-mail"></i>
                            </div>
                            <div class="contact-info-text">
                                <p><span>Email: </span> hoangcp8700@gmail.com</p>
                            </div>
                        </div>
                        <div class="single-contact-info">
                            <div class="contact-info-icon">
                                <i class="pe-7s-call"></i>
                            </div>
                            <div class="contact-info-text">
                                <p><span>Số điện thoại: </span> 0584 230 050</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@push('script')

<script>
    $('#contactForm').on('submit', function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        type: 'post',
        url: '{{route('contact.store')}}',
        data: data,
        success: function(data) {
            console.log(data);
            if (data.statuscode == 'success') {
                $('#contactForm').trigger("reset");
                swal({
                    icon: data.statuscode,
                    title: data.status,
                    buttons: 'Xác nhận',
                });

            } else {
                swal({
                    icon: data.statuscode,
                    title: data.status
                });

                var data  = data.errors;
                var input = document.querySelectorAll('#contactForm .input');

                Object.keys(data).forEach(function(b) { // check data
                    input.forEach((a) => { // loop input
                        if(a.name == b){
                            a.classList.remove('is-unvalid');
                            a.classList.add('is-invalid');

                            a.addEventListener('keyup',function(ddd){
                                a.classList.remove('is-invalid');
                                a.classList.add('is-unvalid');
                            })
                        }
                    });
                });
            }
        },
        error: function() {
            alert('error');
        }
    })
})

    var unvalid = document.querySelectorAll('#contactForm .input');
    unvalid.forEach((a) => {
        console.log(a.class);
    })
</script>
@endpush
