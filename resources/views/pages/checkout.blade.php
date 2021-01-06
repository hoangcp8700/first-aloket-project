@extends('layouts.app')

@section('nd')
<?php
    use App\Banner;
    use App\Cart;
    $bannersM = Banner::banners('check-out');
     // echo '<pre>'; print_r($bannersM); die;
    if(!$bannersM){
       $bannersM = asset('frontend/assets/img/bg/breadcrumb.jpg');
    }else{
        $bannersM = asset('/storage/'.$bannersM[0]->image);
    }
?>
<div class="breadcrumb-area pt-205 pb-210"  style="background-image: url({{$bannersM}})">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>checkout</h2>
            <ul>
                <li><a href="#">home</a></li>
                <li> checkout </li>
            </ul>
        </div>
    </div>
</div>
<!-- checkout-area start -->
    <div class="checkout-area ptb-100">
        <div class="container">
            <div class="row position-relative">
                <div id="loader" style="display:none"></div>
                <div class="col-lg-6 col-md-12 col-12">
                    <form method="post" id="checkoutForm">
                        @csrf
                        <div class="checkbox-form">
                            <h3>Thanh toán</h3>
                            <div class="row">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id ?? null}}">
                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>Tên khách hàng <span class="required">*</span></label>
                                        <input autofocus type="text" name="name" placeholder="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>Số điện thoại  <span class="required">*</span></label>
                                        <input autofocus type="text" name="phone" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>Email <span class="required">*</span></label>
                                        <input autofocus type="email" name="email"  />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>Địa chỉ <span class="required">*</span></label>
                                        <input autofocus type="text" name="address" placeholder="Street address" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>Thành phố / Tỉnh <span class="required">*</span></label>
                                        <select name="province_id" id="province" class="province ">
                                            <option value="">Chọn Thành Phố/ Tỉnh</option>
                                            @foreach($provinces as $province)
                                                <option value="{{$province->id}}">{{$province->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>Quận / Huyện <span class="required">*</span></label>
                                        <select name="district_id" id="district" ></select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>Phường / Xã <span class="required">*</span></label>
                                        <select name="ward_id" id="ward"></select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list mrg-nn">
                                        <label>Ghi chú</label>
                                        <textarea autofocus id="checkout-mess" name="description" rows="10" placeholder="Ghi chú về hóa đơn của bạn." ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="order-button-payment">
                            <input type="submit" value="Xác nhận" />

                        </div>

                </div>

                <div class="col-lg-6 col-md-12 col-12">
                    <div class="your-order">
                        <h3>Hóa đơn của bạn</h3>
                        <div class="your-order-table table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product-name">Sản phẩm</th>
                                        <th class="product-total">Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0 ; $discount = 0?>

                                    @foreach($cartItems as $cart)
                                    <tr class="cart_item">
                                        <td class="product-name">
                                            {{$cart['product']['name']}}  -
                                            <small>( {{$cart['size']}} )</small>
                                            <strong class="product-quantity"> × {{$cart['quantity']}}</strong>
                                        </td>
                                        <td class="product-total">
                                            <span class="amount">{{number_format($cart['price'] * $cart['quantity'])}}₫</span>
                                        </td>
                                    </tr>

                                    <?php
                                        $total += $cart['price'] * $cart['quantity'];
                                        $discount += $cart['product']['price'] - $cart['price'];
                                    ?>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="cart-subtotal">
                                        <th>Thành tiên</th>
                                        <td><span class="amount">{{number_format($total)}}₫</span></td>
                                    </tr>
                                    <tr class="cart-subtotal" id="discountCart"  style="display:none">

                                    </tr>
                                    <tr class="order-total">
                                        <th style="color: #464646;font-size: 20px;">Thanh toán</th>
                                        <td><strong><span class="amount" id="valuePriceCart" >{{number_format($total)}}₫</span></strong>
                                        </td>
                                    </tr>
                                        <input type="hidden" name="order_code" >
                                        <input type="hidden" name="discount" id="totalPrice" >
                                        <input type="hidden" name="total" value="{{$total}}">
                                        <input type="hidden" name="code" id="codeCoupon">
                                    </form>


                                    <tr class="boxFormCoupon">
                                        <th>Sử dụng mã voucher <input type="checkbox" id="showcoupon" value="Click" style="all: revert!important;"></th>
                                    </tr>

                                    <Tr class="boxFormCoupon">
                                        <th colspan="2">
                                            <div id="checkout_coupon" class="coupon-checkout-content">
                                                <div class="coupon-info">
                                                <form  id="applyCoupon" method="post">
                                                    @csrf
                                                        <p class="checkout-coupon">
                                                            <input type="hidden" name="quantity" value="1">
                                                            <input type="text"  id="couponCode" name="code" placeholder="Coupon code" />
                                                            <input type="submit" value="Xác nhận"/>

                                                        </p>
                                                </form>
                                                </div>
                                            </div>
                                        </th>
                                    </Tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment-method mt-1">
                            <div class="payment-accordion">
                                <div class="panel-group" id="faq">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="panel-title"><a data-toggle="collapse" aria-expanded="true" data-parent="#faq" href="#payment-1">Direct Bank Transfer.</a></h5>
                                        </div>
                                        <div id="payment-1" class="panel-collapse collapse show">
                                            <div class="panel-body">
                                                <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="panel-title"><a class="collapsed" data-toggle="collapse" aria-expanded="false" data-parent="#faq" href="#payment-2">Cheque Payment</a></h5>
                                        </div>
                                        <div id="payment-2" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="panel-title"><a class="collapsed" data-toggle="collapse" aria-expanded="false" data-parent="#faq" href="#payment-3">PayPal</a></h5>
                                        </div>
                                        <div id="payment-3" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- checkout-area end -->
@stop

@push('script')
<script src="{{asset('frontend/assets/js/pages/checkout.js')}}"> </script>
@endpush
