$('#contactForm').on('submit', function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        type: 'post',
        url: '/admin/contact',
        data: data,
        success: function(data) {
            console.log(data);
            if (data.statuscode == 'success') {
                $('#contactForm').trigger("reset");
                swal({
                    icon: data.statuscode,
                    title: data.status,
                    buttons: 'Xác nhận',
                });

            } else {
                swal({
                    icon: data.statuscode,
                    title: data.status
                });

                var data = data.errors;
                var input = document.querySelectorAll('#contactForm .input');

                Object.keys(data).forEach(function(b) { // check data
                    input.forEach((a) => { // loop input
                        if (a.name == b) {
                            a.classList.remove('is-unvalid');
                            a.classList.add('is-invalid');

                            a.addEventListener('keyup', function(ddd) {
                                a.classList.remove('is-invalid');
                                a.classList.add('is-unvalid');
                            })
                        }
                    });
                });
            }
        },
        error: function() {
            alert('error');
        }
    })
})

var unvalid = document.querySelectorAll('#contactForm .input');
unvalid.forEach((a) => {
    console.log(a.class);
})