function loadAvatar(image) {
    var header = document.querySelector('#loadAvatarHeader');
    var profile = document.querySelector('#loadAvatarProfile');
    header.src = '/storage/' + image;
    profile.src = '/storage/' + image;
}

function loadName(name) {
    var header = document.querySelector('#loadNameHeader');
    var profile = document.querySelector('#loadNameProfile');
    header.innerHTML = name;
    profile.innerHTML = name;
}

function submitUpload(theForm) {
    $.ajax({
        type: 'post',
        url: '/profile/upload',
        data: new FormData($(theForm)[0]),
        contentType: false, // có FormData mới bỏ vào
        processData: false, // có FormData mới bỏ vào
        success: function(response) {
            console.log(response);
            swal({
                icon: response.statuscode,
                title: response.status
            });
            if (response.statuscode == 'success') {
                window.addEventListener('load', loadAvatar(response.data.image));
            }
        }
    })
}
// change profile
$(document).on('submit', '#formProfile', function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        type: 'post',
        url: '/profile/store',
        data: data,
        success: function(data) {
            console.log(data);
            swal({
                icon: data.statuscode,
                title: data.status
            });
            if (data.statuscode == 'success') {
                window.addEventListener('load', loadName(data.data.name));
            }
        },
        error: function() {
            alert('error');
        }
    })
})

// change password
$(document).on('submit', '#formPassword', function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        type: 'post',
        url: '/profile/password',
        data: data,
        success: function(data) {
            swal({
                icon: data.statuscode,
                title: data.status
            });
            if (data.statuscode == 'success') {
                $("#formPassword").trigger("reset")
            }

        },
        error: function() {
            alert('error');
        }
    })
})

// show order
$(document).on('click', '.showOrderProfile', function() {
    var order_id = $(this).data('id');
    $.ajax({
        type: 'get',
        url: '/profile/order',
        data: { order_id: order_id },
        success: function(data) {
            document.querySelector('#showNameOF').textContent = data.name;
            document.querySelector('#showEmailOF').textContent = data.email;
            document.querySelector('#showPhoneOF').textContent = data.phone;
            document.querySelector('#showAddressOF').textContent = data.address + ', ' + data.ward.name + ', ' + data.district.name + ', ' + data.province.name;
            document.querySelector('#showTotalOF').textContent = numberFormat(data.total);
            document.querySelector('#showDiscountOF').textContent = numberFormat(data.discount);
            document.querySelector('#showCreated_atOF').textContent = dateString(data.created_at); // function

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
            document.querySelector('#showProfileOrderTable').innerHTML = showDetail;
        },
        error: function() {
            alert('error1 ');
        }
    })
})
