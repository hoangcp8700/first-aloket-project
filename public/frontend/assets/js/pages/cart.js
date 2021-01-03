$(document).on('change', '.plusQuantity', function() {
    var quantity = $(this).val();
    if (quantity < 1) {
        alert('Qúa mức tối thiểu');
        return false;
    }
    var cartID = $(this).data('id');
    $.ajax({
        url: '/update-cart',
        type: 'post',
        data: { quantity: quantity, cartID: cartID },
        success: function(data) {
            if (data.statuscode == 'error') {
                swal({
                    icon: data.statuscode,
                    title: data.status
                });
            }
            $('#AppendCartItems').html(data.view);
        },
        error: function() {
            console.log('error cart');
        }
    })
})

$(document).on('click', '.deleteCart', function() {
    var cartID = $(this).data('id');
    if (confirm('Bạn đã chắc chắc muốn xóa sản phẩm này?')) {
        $.ajax({
            url: '/delete-cart',
            type: 'post',
            data: { cartID: cartID },
            success: function(data) {
                $('#AppendCartItems').html(data.view);
            },
            error: function() {
                console.log('error cart');
            }
        })
    } else {
        return false;
    }

})
