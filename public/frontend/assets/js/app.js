/*======================= dropdown city ---------------*/
$(document).ready(function() {
    $('#province').on('change', function(e) {
        let province_id = $(this).val();
        // alert(province_id);
        $.get("/district/" + province_id, function(data) {
            $('#district').html('<option value="">Chọn Quận/Huyện</option>');
            $.each(data, function(index, valueDistrict) {
                $('#district').append('<option value="' + valueDistrict.id + '">' + valueDistrict.name + ' </option>');
            });
        });

    });
    $('#district').on('change', function(e) {
        let district_id = $(this).val();
        $.get("/ward/" + district_id, function(data) {
            $('#ward').html('<option value="">Chọn Phường/Xã</option>');
            $.each(data, function(index, valueWard) {
                $('#ward').append('<option value="' + valueWard.id + '">' + valueWard.name + ' </option>');
            });
        });
    });

})


/*-------------------------------------------------------------------------*/
function dateString(value) {
    var date = new Date(value);
    var day = ("0" + date.getDate()).slice(-2);
    var month = ("0" + (date.getMonth() + 1)).slice(-2);
    var outdate = date.getFullYear() + "-" + (month) + "-" + (day);
    return outdate;
}


function numberFormat(price) {
    var comma = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price);
    return comma;
}

function labelStatus(value) {
    if (value == 1) {
        $stt = '<span class=" badge badge-pill badge-success">Đã thanh toán</span>';
    } else if (value == 2) {
        $stt = '<span class=" badge-pill badge-warning">Đang giao</span>';
    } else if (value == 3) {
        $stt = '<span class=" badge badge-pill badge-danger">Hủy đơn</span>';
    } else {
        $stt = '<span class=" badge badge-pill badge-secondary">Chờ xử lý</span> ';
    }
    return $stt;
}

/************************************* load cart  **************************/