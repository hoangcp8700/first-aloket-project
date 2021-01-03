<div class="table-content table-responsive">
    <table>
        <thead>
            <tr>
                <th>remove</th>
                <th>images</th>
                <th>Product</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($wishlists as $wishlist)
            <tr>
                <td class="product-remove"><a href="javascript:void(0)" onClick="deleteWishlist({{$wishlist['id']}},{{Auth::user()->id}})"><i class="pe-7s-close"></i></a></td>
                <td class="product-thumbnail">
                    <a href="{{route('page.productDetail',$wishlist['product']['product_code'])}}"><img src="{{asset('/storage/'.$wishlist['product']['image'])}}" alt="" class="imgWishlist"></a>
                </td>
                <td class="product-name"><a href="#">{{$wishlist['product']['name']}} </a></td>
                <td class="product-price-cart">
                    <span class="amount line">{{number_format($wishlist['product']['price'])}}đ</span><br>
                    <span class="amount discount">{{number_format($wishlist['product']['discount'])}}đ</span>
                </td>

            </tr>

            @endforeach

        </tbody>
    </table>
</div>
