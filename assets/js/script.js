function sendContact() {
    let valid;
    valid = validationform();
    if (valid) {

        jQuery.ajax({
            url: "index.php",
            data: 'firstname=' + $("#firstname").val() + '&lastname=' +
                $("#lastname").val() + '&email=' +
                $("#email").val() + '&country=' +
                $("#country").val() + '&subject=' +
                $("#subject").val() + '&content=' +
                $("#content").val(),
            type: "POST",
            success: function (data) {
                $("#mail-request").html(data);

            },

            error: function () {}

        });


    }
}


function validationform() {
    let valid = true;
    $(".infoinput").css('background-color', '');
    $(".info").html('');
    if (!$("#firstname").val()) {
        $("#firstnameinfo").html("(required)");
        $("#firstname").css('border-color', 'red');
        valid = false;
    }

    return valid;
}