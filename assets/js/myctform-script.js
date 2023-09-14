(function ($) {
    $('#myctform_form').submit(function (event) {
        event.preventDefault();
        var name = $('#name').val();
        var email = $("#email").val();
        var tel = $("#tel").val();
        var msg = $("#msg").val();


        var form = new FormData();
        form.append('action', 'bisnu_form_submit');
        form.append('name', name);
        form.append('email', email);
        form.append('tel', tel);
        form.append('msg', msg);

        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            method: 'POST',
            data: form,
            processData: false,
            contentType: false,
            success: function (rs) {
                console.log("Success", rs)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error", errorThrown);
                // handle the error case
            }
        });

    });
})(jQuery)