// $(document).on('click', '.deleteWishlist', function() {
//     var wishlistID = $(this).data('id');
//     if (confirm('Bạn đã chắc chắc muốn xóa sản phẩm này?')) {
//         $.ajax({
//             url: '/add-wistlist/' + product_id + '/' + user_id,
//             type: 'post',
//             data: { id: wishlistID },
//             success: function(data) {
//                 $('#AppendCartItems').html(data.view);
//             },
//             error: function() {
//                 console.log('error cart');
//             }
//         })
//     } else {
//         return false;
//     }

// })

function deleteWishlist(product, auth) {
    alert('123');
    var product_id = product;
    var user_id = auth;

    // $.ajax({
    //     url: '/add-wistlist/' + product_id + '/' + user_id,
    //     method: 'post',
    //     data: { product_id: product_id, user_id: user_id },
    //     success: function(data) {
    //         swal({
    //             icon: data.statuscode,
    //             title: data.status
    //         });
    //     },
    //     error: function() {
    //         alert('error');
    //     }
    // })
}