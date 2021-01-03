function numberFormat(price) {
    var comma = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price)
    return comma;
}



$('#addTocartForm').on('submit', function(e) {
    e.preventDefault();
    var size = $('#getSizePrice').val();
    var quantity = $('#quantityCart').val();
    var price = $('#priceCart').val();
    var product_id = $('#cartID').val();

    $.ajax({
        type: 'post',
        url: '/add-to-cart',
        data: { product_id: product_id, price: price, quantity: quantity, size: size },
        success: function(data) {
            swal({
                icon: data.statuscode,
                title: data.status
            });

            if (data.statuscode == 'success') {
                var cart = data.cart[data.cart.length - 1];
                document.querySelector('#countCart').innerHTML = data.cart.length;
                window.addEventListener('load', loadCart(cart['id'], cart['product']['name'], cart['product']['color'], cart['size'], cart['price'], cart['quantity'], cart['product']['image']));

            }
            if (data.cart.length > 0) {
                document.querySelector('#cartLoadHeader p ').innerHTML = '';
            }
        },
        error: function() {
            alert('error');
        }
    })
})

$('#getSizePrice').change(function() {
    var size = $(this).val();
    if (size == '') {
        swal({
            icon: "error",
            title: 'Vui lòng chọn size!!'
        });
        return false;
    }
    var product_id = $(this).data('id');
    $.ajax({
        url: '/product-detail/loadPrice',
        type: 'post',
        data: { size: size, id: product_id },
        success: function(data) {
            $('#priceCart').val(data);
            $('.loadPriceDetail').html(new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(data));
        },
        error: function(data) {
            console.log(data)
        }

    })
})

function addWishlist(product, auth) {
    var product_id = product;
    if (auth == 0) {
        swal({
            icon: 'warning',
            title: 'Vui lòng dăng nhập!'
        });
        return false;
    }
    var user_id = auth;

    $.ajax({
        url: '/add-wistlist/' + product_id + '/' + user_id,
        method: 'get',
        data: { product_id: product_id, user_id: user_id },
        success: function(data) {
            swal({
                icon: data.statuscode,
                title: data.status
            });
            console.log(this);
            if (data.active == 1) {
                document.querySelector('#colorWishlist').classList.add('colorWishlist');
            } else {
                document.querySelector('#colorWishlist').classList.remove('colorWishlist');
            }
        },
        error: function() {
            alert('error');
        }
    })
}