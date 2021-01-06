
@component('mail::message')
# Chào {{$data[0]['order']['name']}},
Mã đơn hàng: {{ $data[0]['order']['order_code']}}

Số điện thoại: {{$data[0]['order']['phone']}}

Địa chỉ: {{$data[0]['order']['address'].', '.$data[0]['order']['ward']['name'].', '.$data[0]['order']['district']['name'].', '.$data[0]['order']['province']['name']}}

Đặt ngày : {{date('d-m-Y', strtotime($data[0]['order']['created_at']))}}

@component('mail::table')
<?php $total = 0 ?>

| Tên sản phẩm | Số lượng |   Size  | Màu |   Đơn giá |
| :------------|:--------:|--------:|----:|----------:|
@foreach($data as $item)
{{$item['product']['name']}} | {{$item['quantity']}} | {{$item['size']}} | {{$item['product']['color']}} | {{number_format($item['price'])}}đ
<?php $total +=  $item['price'] * $item['quantity'] ?>
@endforeach

Tổng giá trị đơn hàng: {{number_format($total)}}đ

@if($data[0]['order']['total'] - $data[0]['order']['discount'] != 0)

Giảm giá: {{number_format($data[0]['order']['total'] - $data[0]['order']['discount'])}}đ

Thanh toán : {{number_format($data[0]['order']['discount'])}}đ
@endif


Vui lòng kiểm tra lại hóa đơn! Nếu có sai xin hãy liên hệ lại với chúng tôi

        # Cảm ơn khách hàng đã sử dụng dịch vụ. Hẹn gặp lại!

@endcomponent
@component('mail::button',['url' => 'http://aloket.com/'])
                             Ghé thăm Aloket
@endcomponent
@endcomponent
