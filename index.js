$(document).ready(function () {
    $('#loginform').submit(function (e) { 
        e.preventDefault();
        var isError = false;
        var userName = $('#username').val();
        var password = $('#password').val();

        regex = /^[a-zA-Z0-9]+([_\-]?[a-zA-Z0-9])*$/;
        message = 'Please enter a valid user name';
        checkData(regex, userName, '#userNameErr', message);

        regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        message = 'Must contain Capital and special characters';
        checkData(regex, password, '#passwordErr', message);

        if(isError == false){
            $.ajax({
                type: "post",
                url: "CheckUser.php",
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData(this),
                success: function (response) {
                    if(response == '1'){
                        window.location.replace('PhotoDashboard.php');
                    }else{
                        var messages = JSON.parse(response);
                        $('#userNameErr').html(messages.userNameErr);
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