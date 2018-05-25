$("#forgot_password").click(function(){
    $.ajax({
        url: BASE_URL+'index.php/Login/forgot_password_email',
        data: $("#form_login").serialize(),
        cache: false,
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
           alert(data);
        },
        error: function (data) {
           alert(data);
        }
    });
});

$("#form_login").validate({
    rules: {
        email: {
            required: true
        },
        password: {
            required: true,
            check_login_details: true
        }
    },

    ignore:":not(:visible)",
    onkeyup: false,
    onfocusout: false,
    onclick: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_login_details", function (value, element) {
    var result = 0;
    
    if ($.trim($("#email").val())=="" || $.trim($("#password").val())=="") {
        result = 1;
    } else {
        $.ajax({
            url: BASE_URL+'index.php/login/check_login_details',
            data: 'username=' + $("#email").val() + '&password=' + $("#password").val(),
            type: "POST",
            dataType: 'html',
            global: false,
            async: false,
            success: function (data) {
                result = parseInt(data);
            },
            error: function () {
                result = 0;
            }
        });
    }
    
    if (result) {
        return true;
    } else {
        return false;
    }
}, "The email and password you entered don't match.");

$("#otp_form").validate({
    ignore: [],
    rules: {
        otp: {
            required: true,
            check_otp_details: true
        }
    },
    // messages: {
    //     otp: "Enter OTP"
    // },

    ignore:":not(:visible)",
    onkeyup: false,
    onfocusout: false,
    onclick: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_otp_details", function (value, element) {
    var result = 0;
    
    if ($.trim($("#otp").val())=="") {
        result = 1;
    } else {
        $.ajax({
            url: BASE_URL+'index.php/login/check_otp',
            data: 'email=' + $("#email").val() + '&password=' + $("#password").val() + '&otp=' + $("#otp").val(),
            type: "POST",
            dataType: 'html',
            global: false,
            async: false,
            success: function (data) {
                result = parseInt(data);
            },
            error: function (xhr, status, error) {
                result = 0;
            }
        });
    }
    
    if (result) {
        return true;
    } else {
        return false;
    }
}, "The OTP you entered don't match.");

$('#modal-otp').on('shown.bs.modal', function () {
    setTimeout(function (){
        $('#otp').focus();
    }, 1000);
});

$('#email').keypress(function(e) {
    if(e.which == 13) {
        // submit_login_form();
        checkCredentials();
    }
});
$('#password').keypress(function(e) {
    if(e.which == 13) {
        // submit_login_form();
        checkCredentials();
    }
});

$('#log_in').click(function(){
    // submit_login_form();
    checkCredentials();
});

var submit_login_form = function() {
    if ($("#form_login").valid()) {
        var result = 0;
        
        $.ajax({
            url: BASE_URL+'index.php/login/get_otp',
            data: 'email=' + $("#email").val() + '&password=' + $("#password").val(),
            type: "POST",
            dataType: 'html',
            global: false,
            async: false,
            success: function (data) {
                result = parseInt(data);
            },
            error: function (xhr, status, error) {
                result = 0;
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            }
        });

        if(result==0){
            checkCredentials();
        } else {
            $('#otp').val('');
            $('#otp_error').html('');
            $('#otp_resend').html('');
            $( '#' + $('#log_in').data('modal-id')).modal();
        }
    }
}

var checkCredentials = function() {
    if ($("#form_login").valid()) {
        $.ajax({
            url: BASE_URL+'index.php/login/checkcredentials',
            data: 'email=' + $("#email").val() + '&password=' + $("#password").val(),
            type: "POST",
            dataType: 'json',
            global: false,
            async: false,
            success: function (data) {
                if(data.msg!=''){
                    alert(data.msg);
                }
                if(data.redirect_url!=''){
                    window.location.href = data.redirect_url;
                }
            },
            error: function (xhr, status, error) {
                result = 0;
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            }
        });
    }
}

$('#btn_save').click(function(){
    submit_otp_form();
});

$('#otp').keypress(function(e) {
    if(e.which == 13) {
        submit_otp_form();
    }
});

$('#otp_form').submit(function () {
    return false;
});

var submit_otp_form = function() {
    if ($("#otp_form").valid()) {
        var result = 0;
        
        $.ajax({
            url: BASE_URL+'index.php/login/check_otp',
            data: 'email=' + $("#email").val() + '&password=' + $("#password").val() + '&otp=' + $("#otp").val(),
            type: "POST",
            dataType: 'html',
            global: false,
            async: false,
            success: function (data) {
                result = parseInt(data);
            },
            error: function (xhr, status, error) {
                result = 0;
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            }
        });

        if (result) {
            checkCredentials();
        } else {
            $('#otp_error').html("Wrong OTP");
        }
    }
}

$('#resend_otp').click(function(){
    if ($("#form_login").valid()) {
        var result = 0;
        
        $.ajax({
            url: BASE_URL+'index.php/login/get_otp',
            data: 'email=' + $("#email").val() + '&password=' + $("#password").val(),
            type: "POST",
            dataType: 'html',
            global: false,
            async: false,
            success: function (data) {
                result = parseInt(data);
            },
            error: function (xhr, status, error) {
                result = 0;
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            }
        });
        
        if (result) {
            $('#otp_resend').html("OTP sent.");
        } else {
            $('#otp_resend').html("OTP sending failed.");
        }
    }
});