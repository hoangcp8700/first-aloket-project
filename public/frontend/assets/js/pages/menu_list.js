$('#sort').on('change', function() {
    // this.form.submit();
    let valueSort = (this).value;
    let urlSort = document.getElementById('url').value;
    let url = '/danh-muc/' + urlSort;

    $.ajax({
        url: url,
        method: 'get',
        data: { valueSort: valueSort, urlSort: urlSort },
        success: function(data) {
            console.log(data);
            $('#filter_products').html(data);

        }
    })

});

$('body').on('keyup', '#searchProduct', function() {
    var search = $(this).val()
    var category_id = $('#searchCategory').val()
    $.ajax({
        type: 'post',
        url: '/search',
        data: { search: search, category_id: category_id },
        success: function(data) {
            console.log(data);
            $('#filter_products').html(data);
        },
        error: function() {
            console.log('không tìm thấy');
        }
    })
})
