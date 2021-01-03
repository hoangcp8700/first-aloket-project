<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->

        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Fashion') }}</title>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Font -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"/>

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend/assets/img/favicon.png')}}">

		<!-- all css here -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/magnific-popup.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/animate.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/themify-icons.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/pe-icon-7-stroke.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/slinky.min.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/bundle.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/responsive.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/icofont.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/meanmenu.min.css')}}">
        <script src="{{asset('frontend/assets/js/vendor/modernizr-2.8.3.min.js')}}"></script>

        <link rel="stylesheet" href="{{asset('frontend/assets/css/addStyle.css')}}">

    @yield('style')
</head>

<body>

    @include('layouts.header')

    @yield('nd')

    @include('layouts.footer')

    <div class="modal fade bd-example-modal-md" id="tableModalShowOrderEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="pe-7s-close" aria-hidden="true"></span>
        </button>
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-panel">
                        <form class="cmxform form-horizontal style-form">
                            <div class="form">
                                <div class="form-group d-flex">
                                    <label class="control-label col-lg-4 lbp">Email</label>
                                    <label class="control-label col-lg-8" id="showEmail">
                                    </label>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Ngày tạo đơn</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody id="showEmailTable">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="tableModalShowOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="pe-7s-close" aria-hidden="true"></span>
        </button>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-panel">
                        <form class="cmxform form-horizontal style-form">
                            <div class="form">
                                <div class="form-group d-flex">
                                    <label for="cname" class="control-label col-lg-4 lbp">Tên khách hàng</label>
                                    <label class="control-label col-lg-8" id="showNameO">
                                    </label>
                                </div>
                                <div class="form-group d-flex">
                                    <label for="cname" class="control-label col-lg-4 lbp">Email</label>
                                    <label class="control-label col-lg-8" id="showEmailO">
                                    </label>
                                </div>
                                <div class="form-group d-flex">
                                    <label for="cname" class="control-label col-lg-4 lbp">Số điện thoại</label>
                                    <label class="control-label col-lg-8" id="showPhoneO">
                                    </label>
                                </div>
                                <div class="form-group d-flex">
                                    <label for="cname" class="control-label col-lg-4 lbp">Địa chỉ</label>
                                    <label class="control-label col-lg-8" id="showAddressO">
                                    </label>
                                </div>
                                <div class="form-group d-flex">
                                    <label for="cname" class="control-label col-lg-4 lbp">Hóa đơn gốc</label>
                                    <label class="v col-lg-8" id="showTotalO">
                                    </label>
                                </div>
                                <div class="form-group d-flex">
                                    <label for="cname" class="control-label col-lg-4 lbp">Hóa đơn giảm  </label>
                                    <label class="v col-lg-8" id="showDiscountO">
                                    </label>
                                </div>
                                <div class="form-group d-flex">
                                    <label for="cname" class="control-label col-lg-4 lbp">Ngày tạo hóa đơn</label>
                                    <label class="v col-lg-8" id="showCreated_atO">
                                    </label>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tên sản phẩm</th>
                                                <th>Giá</th>
                                                <th>Số lượng</th>
                                                <th>Size</th>
                                                <th>Tổng</th>
                                            </tr>
                                        </thead>
                                        <tbody id="showValueOrderTable">

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- all js here -->
    <script src="{{asset('frontend/assets/js/vendor/jquery-1.12.0.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/popper.js')}}"></script>
    <script src="{{asset('frontend/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/waypoints.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/ajax-mail.js')}}"></script>
    <script src="{{asset('frontend/assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins.js')}}"></script>
    <script src="{{asset('frontend/assets/js/main.js')}}"></script>
    <script src="{{asset('frontend/assets/js/app.js')}}"></script>
    <script src="{{asset('backend/lib/sweetalert.js')}}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> --}}

    <script type="text/javascript">
        let errorForm = document.querySelector('.formPage');

        @if(session('formPage'))
            errorForm.classList.add('errorBox');
            errorForm.addEventListener('keyup',() => {
                errorForm.classList.add('completeBox');
            })
        @endif
        @if(session('status'))
            swal({
              title: "{{session('status')}}",
              // text: "You clicked the button!",
              icon: "{{session('statuscode')}}",
              button: "OK!",
            });
        @endif
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    </script>

    <script src="{{asset('frontend/assets/js/pages/header.js')}}"> </script>
    @stack('script')
</body>
</html>
