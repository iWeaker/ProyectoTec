function readURL(input) {
    if (input.files && input.files[0]) {
        $.sweetModal.confirm('¿Seguro que desea cambiar la foto de perfil?', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);

            }
            reader.readAsDataURL(input.files[0]);
            let formData = new FormData();
            formData.append("imagen", $('#imageUpload').prop('files')[0]);
            let profileurl = $('#imageUpload').data('url');
            $.ajax({
                type: 'POST',
                url: profileurl,
                processData: false,
                contentType: false,
                data: formData,
                dataType: 'json',
                success: function(pChange) {
                    $.sweetModal({
                        content: 'Cambiado con exito la foto de perfil.',
                        icon: $.sweetModal.ICON_SUCCESS
                    });
                },
            });
        }, function(){
            $.sweetModal({
                content: 'Cancelado con exito.',
                icon: $.sweetModal.ICON_WARNING
            });
        });
    }
}
function readURLCover(inputCover) {
    if (inputCover.files && inputCover.files[0]) {
        $.sweetModal.confirm('¿Seguro que desea cambiar la foto de portada?', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.profile-img-cover').css('background-image', 'url('+e.target.result +')');
                $('.profile-img-cover').hide();
                $('.profile-img-cover').fadeIn(650);

            }
            reader.readAsDataURL(inputCover.files[0]);
            let formData = new FormData();
            formData.append("imagen", $('#imageUploadCover').prop('files')[0]);
            let coverurl = $('#imageUploadCover').data('url');
            $.ajax({
                type: 'POST',
                url: coverurl,
                processData: false,
                contentType: false,
                data: formData,
                dataType: 'json',
                success: function(pChange) {
                    $.sweetModal({
                        content: 'Cambiado con exito la portada.',
                        icon: $.sweetModal.ICON_SUCCESS
                    });
                },
            });
        }, function(){
            $.sweetModal({
                content: 'Cancelado con exito.',
                icon: $.sweetModal.ICON_WARNING
            });
        });
    }
}

$("#imageUploadCover").change(function() {
    readURLCover(this);
});
$("#imageUpload").change(function() {
    readURL(this);
});