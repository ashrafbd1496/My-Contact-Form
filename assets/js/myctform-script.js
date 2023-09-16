(function ($) {
    $('#myctform_form').submit(function (event) {
        event.preventDefault();
        let name = $('#name').val();
        let email = $("#email").val();
        let tel = $("#tel").val();
        let msg = $("#msg").val();


        let form = new FormData();
        form.append('action', 'bisnu_form_submit');
        form.append('name', name);
        form.append('email', email);
        form.append('tel', tel);
        form.append('msg', msg);
        if (email == '' || name == '' || tel == '' || msg == '') {
            alert("Please fill all the fieald");
            return;
        }

        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            method: 'POST',
            data: form,
            processData: false,
            contentType: false,
            success: function (rs) {
                $('#myctform_form').trigger("reset");
                console.log("Success", rs)
                alert('Form Submit Successfully');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error", errorThrown);
                // handle the error case
            }
        });

    });
})(jQuery)