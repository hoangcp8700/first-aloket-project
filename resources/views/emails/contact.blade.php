
@component('mail::message')

    {!! $data['reply_content'] !!}

        # Cảm ơn khách hàng đã sử dụng dịch vụ. Hẹn gặp lại!

@component('mail::button',['url' => 'http://aloket.com/'])
                             Ghé thăm Aloket
@endcomponent

@endcomponent
