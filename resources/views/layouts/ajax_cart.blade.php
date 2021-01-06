<?php use App\Cart; ?>
<div class="table-content table-responsive ">
    <table class="table table-bordered ">
        <thead>
            <tr>
                <th>Xóa</th>
                <th>Ảnh</th>
                <th>Description</th>
                <th>Giá</th>
                <th>Giá Khuyến Mãi</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; $discount = 0;?>
            @if(count($cartItems) < 1)
                <Tr><td colspan="7">Giỏ hàng chưa có sản phẩm nào</td></tr>
            @else
            @foreach($cartItems as $cart)
            <tr>
                <td class="product-remove"><a href="javascript:void(0)" class="deleteCart" data-id="{{$cart['id']}}"><i class="pe-7s-close"></i></a></td>
                <td class="product-thumbnail">
                <a href="#"><img src="{{asset('/storage/'.$cart['product']['image'])}}" alt=""></a>
                </td>
                <td class="product-name text-left" >
                    <a href="#">
                        <p>Tên sản phẩm: {{$cart['product']['name']}}</p>
                        <p>Size:{{$cart['size']}}</p>
                        <p>Màu:{{$cart['product']['color']}}</p>
                    </a>
                </td>

                <td class="product-price-cart"><span class="amount">{{number_format($cart['product']['price'])}}₫</span></td>
                <td class="product-price-cart"><span class="amount">{{number_format($cart['price'])}}₫</span></td>
                <td class="product-quantity">
                    <input autofocus value="{{$cart['quantity']}}" class="plusQuantity" type="number" data-id="{{$cart['id']}}">
                </td>

                <td class="product-subtotal">{{number_format($cart['price'] * $cart['quantity'])}}₫</td>
            </tr>
            <?php
                $total += $cart['price'] * $cart['quantity'];
                $discount += ($cart['product']['price'] - $cart['price']) * $cart['quantity'];
            ?>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
<div class="row flex-row-reverse ">

    {{-- <div class="col-md-5 ml-auto"> --}}
    <div class="col-lg-6 col-md-8 col-sm-12">
        <div class="cart-page-total">
            <h2>Cart totals</h2>
            <ul>
                <li>Tiết kiệm<span>{{number_format($discount)}}₫</span></li>
                <li>Thanh toán<span>{{number_format($total)}}₫</span></li>
            </ul>

            <a href="{{route('page.checkout')}}">Thanh toán ngay</a>
        </div>
    </div>
</div>
