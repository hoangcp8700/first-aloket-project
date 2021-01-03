function regex(name, slugClass, option) {
    console.log(name);
    console.log(slugClass);
    console.log(option);
    slug = name.value.toLowerCase();
    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    //Xóa các ký tự đặt biệt
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    //Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/ /gi, "-");
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    //Xóa các ký tự gạch ngang ở đầu và cuối
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    //In slug ra textbox có id “slug”
    if (option) {
        slugClass.value = option + '-' + slug;
    } else {
        slugClass.value = slug;
    }

}


function ChangeToSlug() {

    var categoryName = document.getElementsByClassName("categoryName")[0];
    var categorySlug = document.getElementsByClassName('categorySlug')[0];
    regex(categoryName, categorySlug);
}


function productToSlug() {
    var productName = document.getElementsByClassName("productName")[0];
    var productSlug = document.getElementsByClassName('productSlug')[0];
    regex(productName, productSlug);
}

//----------------------------- add field product attribute ------------------------------///
var maxField = 8; //Input fields increment limitation
var addButton = $('.add_button'); //Add button selector
var wrapper = $('.field_wrapper'); //Input field wrapper
var fieldHTML = '<div class="addInputAttr">' +
    ' <div class="row"> ' +
    ' <div class="col-sm-11 col-xs-11"> ' +
    ' <input type="text" onkeyup="SizeCodeSlugN();" class="inputProductAttrSize" name="size[]" value=""  placeholder="Size"/> ' +
    ' <input type="text" class="inputProductAttrCode"  name="product_attr_code[]" readonly value="" placeholder="Mã code"/> ' +
    ' <input type="text" name="price[]" value="" placeholder="Giá tiền"/> ' +
    ' <input type="text" name="stock[]" value="" placeholder="Số lượng"/> ' +
    ' </div> ' +
    ' <div class="col-sm-1 col-xs-1">' +
    ' <a href="javascript:void(0);" class="btn btn-xs btn-danger remove_button"> ' +
    '<i class="fas fa-trash"></i> </a></div> </div></div>';
var x = 1; //Initial field counter is 1

// set value code
var productCode = document.getElementById('productAttrCode');

function SizeCodeSlug() {
    var inputCodeFirst = document.getElementsByClassName('inputProductAttrCode')[0];
    var inputSizeFirst = document.getElementsByClassName('inputProductAttrSize')[0];
    regex(inputSizeFirst, inputCodeFirst, productCode.innerText);

}

function SizeCodeSlugN() {
    var inputCodeLast = document.querySelectorAll('.inputProductAttrCode');
    var inputSizeLast = document.querySelectorAll('.inputProductAttrSize');
    inputCodeLast = inputCodeLast[inputCodeLast.length - 1];
    inputSizeLast = inputSizeLast[inputSizeLast.length - 1];

    regex(inputSizeLast, inputCodeLast, productCode.innerText);
}
//Once add button is clicked
$(addButton).click(function() {
    //Check maximum number of input fields
    if (x < maxField) {
        x++; //Increment field counter
        $(wrapper).append(fieldHTML); //Add field html


        // inputCodeLast[inputCodeLast.length - 1].value = productCode;
        // inputSizeLast[inputCodeLast.length - 1].addEventListener('change', (n) => {
        //     inputCodeLast[inputCodeLast.length - 1].value = productCode + '-' + n.target.value;
        // });

        ////end code
    } else {
        swal({
            icon: "error",
            title: 'Tối đa 8 lần!'
        });
    }
});

//Once remove button is clicked
$(wrapper).on('click', '.remove_button', function(e) {
    e.preventDefault();
    $(this).parents('.addInputAttr').remove(); //Remove field html
    x--; //Decrement field counter
});

/*888888888888888888888888888888888888*/
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