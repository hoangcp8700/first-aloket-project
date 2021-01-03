function discount(type, value, priceCurrent) {
    var removeComma = priceCurrent.replaceAll(",", '');
    removeComma = parseInt(removeComma);
    if (type == '%' || type == '?') {
        var discount = removeComma * value / 100;
        removeComma = removeComma - discount;
    } else {
        var discount = value;
        removeComma = removeComma - discount;
    }
    var saveValueDiscount = discount;
    var saveValuePrice = removeComma;
    removeComma = numberFormat(removeComma);
    discount = numberFormat(discount);
    removeComma = removeComma.replaceAll(".", ',');
    discount = discount.replaceAll(".", ',')
    return [removeComma, discount, saveValueDiscount, saveValuePrice];
}

function numberFormat(price) {
    var comma = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price)
    return comma;
}

function closeCoupon(discount, price) {

    var priceCart = document.querySelector('#valuePriceCart');
    var value = discount + price;
    value = numberFormat(value);
    value = value.replaceAll(".", ',');

    priceCart.textContent = value; // inner

    var discountCart = document.querySelector('#discountCart');
    discountCart.textContent = '';
    discountCart.style.display = 'none';

    document.querySelectorAll('.boxFormCoupon').forEach((a) => {
        a.style.display = null;
    })

    $('#totalPrice').val('');
    $('#codeCoupon').val('');
    $('#applyCoupon').trigger("reset");

}

$('#applyCoupon').on("submit", function(e) {
    e.preventDefault();
    let code = $('#couponCode').val();
    $.ajax({
        url: '/apply-coupon',
        type: 'post',
        data: { code: code },
        success: function(data) {
            if (data.error) {
                swal({
                    icon: 'error',
                    title: data.error
                });
            } else {
                document.querySelector('#discountCart').style.display = 'contents';

                var priceCart = document.querySelector('#valuePriceCart');
                var discountCart = document.querySelector('#discountCart');
                var price = priceCart.innerHTML; ///get value

                var priceNew = discount(data[0].type, data[0].value, price);

                $('#codeCoupon').val(data[0].code);
                $('#totalPrice').val(priceNew[3]);
                priceCart.textContent = priceNew[0];
                discountCart.innerHTML =
                    '<th>Giảm ( ' + data[0].value + data[0].type + ' )</th><td><button class="closeCoupon" onClick="closeCoupon(' + priceNew[2] + ',' + priceNew[3] + ')">X</button><span class="amount">' + priceNew[1] + '</span> </td>';

                document.querySelectorAll('.boxFormCoupon').forEach((a) => {
                    a.style.display = 'none';
                })

            }

        },
        error: function() {
            alert('error');
        }
    })
})

$('#checkoutForm').on('submit', function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        type: 'post',
        url: '/thanh-toan',
        data: data,
        success: function(data) {

            if (data.statuscode == 'success') {
                swal({
                    icon: data.statuscode,
                    title: data.status
                });
                setTimeout(function() {
                    window.location.href = 'http://aloket.com/';
                }, 5000);
            } else {
                swal({
                    icon: data.statuscode,
                    title: data.status
                });
            }


        },
        error: function() {
            alert('error');
        }
    })
})
