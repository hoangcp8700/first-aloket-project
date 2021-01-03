$('#formSearchOrder').on('submit', function(e) {
    e.preventDefault();
    var searchOrder = $('#searchOrder').val();
    $.ajax({
        type: 'post',
        url: '/search-order-code',
        data: { search: searchOrder },
        success: function(data) {

            if (data.statuscode == 'error') {
                swal({
                    icon: data.statuscode,
                    title: data.status
                });
                $('#formSearchOrder').trigger("reset");
            } else {
                $('#tableModalShowOrderEmail').modal('show');
                document.querySelector('#showEmail').textContent = data.data[0].email;
                var showEmail = '';
                // for (let i = 0; i < data.length; i++) {
                showEmail += '<tr>' +
                    '<td>' + dateString(data.data[0].created_at) + '</td>' +
                    '<td>' + numberFormat(data.data[0].discount) + '</td>' +
                    '<td>' + labelStatus(data.data[0].status) + '</td>' +
                    '<td>' +
                    '<a class="btn btn-success showOrderDetail" data-id="' + data.data[0].id + '"' +
                    'data-toggle="modal" href="javascript:void(0)" data-target="#tableModalShowOrder">' +
                    '<i class="far fa-eye"></i>' +
                    '</a></td>' +
                    '</<tr>';
                // }
                document.querySelector('#showEmailTable').innerHTML = showEmail;
            }
        },
        error: function() {
            alert('error');
        }
    })
})

$('body').on('click', '.showOrderDetail', function() {
    var order_id = $(this).data('id');

    $.ajax({
        type: 'post',
        url: '/search-order',
        data: { order_id: order_id },
        success: function(data) {
            document.querySelector('#showNameO').textContent = data.name;
            document.querySelector('#showEmailO').textContent = data.email;
            document.querySelector('#showPhoneO').textContent = data.phone;
            document.querySelector('#showAddressO').textContent = data.address + ', ' + data.ward.name + ', ' + data.district.name + ', ' + data.province.name;
            document.querySelector('#showTotalO').textContent = numberFormat(data.total);
            document.querySelector('#showDiscountO').textContent = numberFormat(data.discount);
            document.querySelector('#showCreated_atO').textContent = dateString(data.created_at); // function

            var showDetail = '';
            for (let i = 0; i < data.order_detail.length; i++) {
                showDetail += '<tr>' +
                    '<td>' + data.order_detail[i].product.name + '</td>' +
                    '<td>' + numberFormat(data.order_detail[i].price) + '</td>' +
                    '<td>' + data.order_detail[i].quantity + '</td>' +
                    '<td>' + data.order_detail[i].size + '</td>' +
                    '<td>' + numberFormat(data.order_detail[i].price * data.order_detail[i].quantity) + '</td>' +
                    '</<tr>';
            }
            document.querySelector('#showValueOrderTable').innerHTML = showDetail;
        },
        error: function() {
            alert('error1 ');
        }
    })
});
/*--------------------------------------------------load cart ------------------------*/
function elementCart(id, name, color, size, price, quantity, img) {
    var html = '';
    html = '<li class="single-product-cart">' +
        '<div class="cart-img">' +
        '<a href="#"><img src="/storage/' + img + '" alt="" class="imgLoadCart"></a>' +
        '</div>' +
        '<div class="cart-title">' +
        '<h5><a href="#" class="nameLoadCart">' + name + '</a></h5>' +
        '<h6><a href="#" class="colorLoadCart">' + color + ' <small>(size: ' + size + ')</small></a></h6>' +
        '<span class="priceLoadCart">' + numberFormat(price) + ' x ' + quantity + '</span>' +
        '</div>' +
        '<div class="cart-delete">' +
        '<a href="javascript:void(0)" class="removeCart" onClick="removeCart(this.parentElement.parentElement,' + id + ')"><i class="ti-trash"></i></a>' +
        '</div>';
    return html;
}

function loadCart(idCart, nameCart, colorCart, sizeCart, priceCart, quantityCart, imgCart) {
    var maxField = 2;
    var wrapper = $('#cartLoadHeader');
    var x = 0;
    var fieldHTML = elementCart(idCart, nameCart, colorCart, sizeCart, priceCart, quantityCart, imgCart);

    console.log(fieldHTML);
    if (x < maxField) {
        x++;
        $(wrapper).append(fieldHTML);
    }

}

function loadAgainCart(count) {
    var countCart = document.querySelector('#countCart');
    countCart.innerHTML = count;

}

function removeCart(element, id) {
    let url = window.location.href;

    if (url.search('gio-hang') > 0) {
        var cartPage = true;
    } else {
        var cartPage = false;
    }

    if (confirm('Bạn đã chắc chắc muốn xóa sản phẩm này?')) {
        $.ajax({
            url: '/delete-cart',
            type: 'post',
            data: { cartID: id, loadCart: true, cartPage: cartPage },
            success: function(data) {
                swal({
                    icon: data.statuscode,
                    title: data.status
                });
                if (data.statuscode == 'success') {
                    $(element).remove();
                    window.addEventListener('load', loadAgainCart(data.cart.length));
                }
                if (data.view) {
                    $('#AppendCartItems').html(data.view);
                }

                if (data.cart.length < 1) {
                    document.querySelector('#cartLoadHeader').innerHTML = ' <p class="text-center">Không có sản phẩm nào</p>';
                }

            },
            error: function() {
                console.log('error cart');
            }
        })
    } else {
        return false;
    }
}