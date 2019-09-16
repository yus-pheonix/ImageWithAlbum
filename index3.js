$(document).ready(function () {
    var albumId = '';
    var isUpdate = '';
    $('#cancelButton').hide();
    $('#addAlbumForm').submit(function (e) { 
        e.preventDefault();
        var isError = false;
        var albumName = $('#albumName').val();
        var regex = /^[a-zA-Z ]*$/;
        if(albumName === ''){
            isError = true;
            $('#albumNameErr').html('Album name cannot be empty');
        }else if(!regex.test(albumName)){
            isError = true;
            $('#albumNameErr').html('Album name can only be text and spaces');
        }else{
            var data = new FormData(this);
            data.append('albumId', albumId);
            data.append('isUpdate', isUpdate);
            $.ajax({
                type: "post",
                url: "AddAlbum.php",
                data: data,
                contentType : false,
                processData : false,
                cache : false,
                success: function (response) {
                    if(response == '1'){
                        $('#message').html('Album Added Successfully');
                    }else{
                        var messages = JSON.parse(response);
                        $('#albumNameErr').html(messages.albumNameErr);
                    }
                }
            });
        }
    });

    $('.edit').on('click', function(){
        albumId = $(this).attr('id');
        isUpdate = 'yes';
        $('#albumName').val($(this).closest('tr').find('.albumName').html());
        $('#cancelButton').show();
        $('#addButton').html('Update Album');
    });

    $('#cancelButton').on('click', function(){
        albumId = '';
        isUpdate = '';
        $('#addButton').html('Add Album');
        $('#cancelButton').hide();
        $('#albumName').val('');
    });
});