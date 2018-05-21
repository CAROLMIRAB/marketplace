jQuery(document).ready(function ($) {
    $('.product-description').trunk8({
        lines: 5
    });

    $('.marketplace_publish').click(function () {
        var id = $(this).data('post');
        var url = $(this).data('url');
        var slug = $(this).data('slug');
        var email = $(this).data('email');
        var td = '.td-button' + id;

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: ajaxurl,
            data: {
                action: 'marketplace_publish',
                slug: slug,
                id: id,
                email: email
            },
            success: function (data) {
                $(td).html('Activo');
            },
            error: function () {
                console.log(id + ajaxurl);

            }

        });
        return false;
    });

});





$('#btn-saveb').on('click', function (ev) {
    var img = $('.div-imagen-actual img').data();
    $(this).button('loading');
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: ajaxurl,
        data: {
            action: 'marketplace_business',
            mname: $('#marketplace_mname').val(),
            mlastname1: $('#marketplace_mlastname1').val(),
            mlastname2: $('#marketplace_mlastname2').val(),
            bname: $('#marketplace_bname').val(),
            baddress: $('#marketplace_baddress').val(),
            bvideo: $('#marketplace_bvideo').val(),
            bphone: $('#marketplace_bphone').val(),
            bdescription: $('#marketplace_bdescription').val(),
            bworkers: $('#marketplace_bworkers').val(),
            brut: $('#marketplace_brut').val(),
            img: img,
            id: $('#marketplace_id').val(),
            marketplace_nonce_field: $('#marketplace_nonce_field').val(),
        },
        success: function (data) {
            swal({
                title: 'Exitoso!',
                text: 'Han sido cambiados sus datos correctamente.',
                timer: 6000,
                showCancelButton: false,
                showConfirmButton: false
            }).then(
                function () {
                },
                // handling the promise rejection
                function (dismiss) {
                    if (dismiss === 'timer') {
                        //console.log('I was closed by the timer')
                    }
                }
            );
        },
        complete: function () {
            $('#btn-saveb').button('reset');
        }
    });
    return false;
});

/*$('#btnCrop').click(function () {
						var croppedImageDataURL = canvasb.cropper('getCroppedCanvas').toDataURL("image/png")
						$('.div-imagen-actual img').remove();
						$('.preview img').remove();
						$('.div-imagen-actual').append($('<img class="desvanecer">').attr('src',croppedImageDataURL));
						$('.preview').append($('<img class="desvanecer">').attr('src',croppedImageDataURL));
						$('#inputimage').val(croppedImageDataURL);

						});*/