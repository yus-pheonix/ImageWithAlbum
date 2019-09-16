$(document).ready(function () {
    $('#formSignUp').submit(function (e) { 
        e.preventDefault();
        var isError = false;
        var name = $('#name').val();
        var email = $('#email').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var confirm = $('#confirm').val();

        var regex =/^[a-zA-Z ]*$/;
        var message = 'only Alphabets and spaces are allowed';
        checkData(regex, name, '#nameErr', message);

        regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        message = 'Please enter a valid Email';
        checkData(regex, email, '#emailErr', message);

        regex = /^[a-zA-Z0-9]+([_\-]?[a-zA-Z0-9])*$/;
        message = 'Please enter a valid user name';
        checkData(regex, username, '#usernameErr', message);

        regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        message = 'Must contain Capital and special characters';
        checkData(regex, password, '#passwordErr', message);

        if(password != confirm){
            isError = true;
            $('#confirmErr').html('Passwords does not match');
        }else{
            $('#confirmErr').html('');
        }

        if(isError == false){
            $.ajax({
                type: "post",
                url: "AddUser.php",
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData(this),
                success: function (response) {
                    if(response == '1'){
                        alert('signed Up');
                    }else{
                        var messages = JSON.parse(response);
                        $('#nameErr').html(messages.nameErr);
                        $('#emailErr').html(messages.emailErr);
                        $('#usernameErr').html(messages.userNameErr);
                        $('#passwordErr').html(messages.passwordErr);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');
    
                    $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
                    console.log('jqXHR:');
                    console.log(jqXHR);
                    console.log('textStatus:');
                    console.log(textStatus);
                    console.log('errorThrown:');
                    console.log(errorThrown);
                }
            });
        }

    });

    function checkData(regex, data, id, message){
        if(!regex.test(data)){
            isError = true;
            $(id).html(message);
        }else{
            $(id).html('');
        }
    }
});