$(document).ready(function() {
    //form validation rules
    $("#auth-form").validate({
        rules: {
            username: "required",
            password: {
                required: true,
                minlength: 5
            },
        },
        messages: {
            username: "Please enter your username",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
        },
        submitHandler: function(form) {
            user = $("#username").val();
            pass = $("#password").val();

            $.post('/auth/process', {username: user, password: pass},
            function(data) {
                if (!data.resultado) {
                    alert(data.mensaje);
                } else {
                    alert("Bienvenido " + data.username);
                    window.location.replace("/admin");
                }
            }, "json");
        }
    });
});