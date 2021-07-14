function login() {
    $.ajax({
        type: "post",
        url: "authC.php",
        dataType: "json",
        data: {
            function: 'login',
            username: $('#username').val(),
            password: $('#password').val()
        },
        success: function(response) {
            if(response.success) {
                location.href = "/video3/index.php";
            } else {
                toastr.error(response.msg, 'Hiba!');
            }
        }
    });
}

function register() {
    $.ajax({
        type: "post",
        url: "authC.php",
        dataType: "json",
        data: {
            function: 'register',
            username: $('#username').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            password2: $('#password2').val()
        },
        success: function(response) {
            if(response.success) {
                toastr.success(response.msg, 'Siker!');

                setTimeout(function() {
                    location.href = "/video3/login.php";
                }, 2000);
            } else {
                toastr.error(response.msg, 'Hiba!');
            }
        }
    });
}