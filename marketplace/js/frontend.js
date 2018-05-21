/*$('textarea#marketplace_description').froalaEditor({
    toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', '|', 'fontSize', '|', 'align', 'formatOL', 'formatUL', '-', 'insertLink', '|', 'undo', 'redo'],
    pluginsEnabled: null,
    quickInsertButtons: null,
    quickInsert: false,
    height: 200
});*/

var page_url = window.location.pathname;
var base_url = window.location.origin;
var url_this = base_url + page_url;

$('.nav-dash li[data-url="' + url_this + '"]').addClass('active');
$('.nav li[data-url="' + url_this + '"]').addClass('active');

var getCroppedCanvasURL;
var canvas = $("#canvas"),
    context = canvas.get(0).getContext("2d"),
    $result = $('#result'),
    cont = 0;


$(document).on('click', '.images-preview', function () {
    var img = $(this).data('img');
	$(this).remove();
});

$('#btnCrop').prop('disabled', true);


$('#fileInput').on('change', function () {
    var maxFileSize = 300000; // 2MB
    var fileUpload = $('#fileInput');
    if (fileUpload.val() == '') {
        return false;
    } else {
        //Check if the file size is less than maximum file size
        if (fileUpload[0].files[0].size > maxFileSize) {
            alert('El tamaño de su imagen sobrepasa el permitido 300KB');
            fileUpload.val('');
            return false;
        } else {
            if (this.files && this.files[0]) {
                if (this.files[0].type.match(/^image\//)) {
					$('#btnCrop').prop('disabled', false);
                    var reader = new FileReader();
                    reader.onload = function (evt) {
                        var img = new Image();
                        img.onload = function () {
                            canvas.cropper('destroy');
							
							var MAX_WIDTH = 800;
							var MAX_HEIGHT = 600;
							var width = img.width;
							var height = img.height;
 
							if (width > height) {
  								if (width > MAX_WIDTH) {
   									 height *= MAX_WIDTH / width;
   									 width = MAX_WIDTH;
 								 }
							} else {
  								if (height > MAX_HEIGHT) {
   								width *= MAX_HEIGHT / height;
   								height = MAX_HEIGHT;
  							}
						}
                            context.canvas.height = height;
                            context.canvas.width = width;
                            context.drawImage(img, 0, 0, width, height);
							
                            var cropper = canvas.cropper({
                                aspectRatio: NaN,
                                cropBoxResizable: true, 
                                background: true,
                                viewMode: 1,
								width: 800
                            });

                            $('#btnRestore').click(function () {
                                canvas.cropper('reset');
                                $('.preview').empty();
                                $('.error-pad').addClass('hidden');
                                cont = 0;

                            });
                        };
                        img.src = evt.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                }
                else {
                    alert("Invalid file type! Please select an image file.");
                }
            }
            else {
                alert('No file(s) selected.');
            }
        }
    }
});


$('#btnCrop').click(function (evento) {
			evento.preventDefault();
	$('.imagen-add').html('');
    $(this).button('loading');
    var cont2 = $('.preview img').length;
    var croppedImageDataURL = canvas.cropper('getCroppedCanvas').toDataURL("image/png");
    var imgex = $('.preview img').last().attr('src');
    if (imgex != croppedImageDataURL) {
        if (cont2 < 3) {

            $.ajax({
                type: 'post',
                url: ajaxurl,
                dataType: "json",
                data: {
                    action: 'marketplace_add_image',
                    img: croppedImageDataURL,
                    marketplace_nonce_field: $('#marketplace_nonce_field').val()
                },
                success: function (data) {
                    var imgurl = data.message.img;
                    $('.preview').append($('<img id="'+ cont +'" data-id="' + cont + '"  class="images-preview" title="Eliminar" style="width: 33.3%; float: left">').attr({'src': croppedImageDataURL, 'data-img': imgurl}));

                },
                error: function(data){
                    var obj =  data;
                    $('.imagen-add').html('<div class="error-pad" style="border-left: 3px solid #ffdddd; background: #d48382; padding:5px">Ha habido un error no se pudo subir tu imagen</div>');
                    $('#btnCrop').button('reset');
                },
                complete: function () {
                    $('#btnCrop').button('reset');
                }
            });

        } else {
            $('.imagen-add').html('<div class="error-pad" style="border-left: 3px solid #ffdddd; background: #d48382; padding:5px">Solo puede subir un máximo de 3 imagenes</div>');
            $('#btnCrop').button('reset');
        }
    }else{
        $('.imagen-add').html('<div class="error-pad" style="border-left: 3px solid #ffdddd; background: #d48382; padding:5px">Está intentando subir la misma imagen</div>');
        $('#btnCrop').button('reset');
    }
})





$('#btn-save').on('click', function (ev) {
    $('#form-marketplace').validate({
        rules: {
            marketplace_title: {
                required: true
            },
            marketplace_description: {
                required: true,
                minlength: 10,
                maxlength: 500
            }
        },
        messages: {
            marketplace_title: {
                required: 'El titulo del producto no puede estar vacío'
            },
            marketplace_description: {
                required: 'La descripcion está vacía',
                minlength: 'Es una descripcion muy corta',
                maxlength: 'La descripción es demasiado larga'
            }
        },

        submitHandler: function(form) {
			
            var img = '';
            var str1 = '';
            var str2 = '';
            var str3 = '';
            $('.preview img').each(function (index, element) {
                if (index == 0) {
                    str1 = $(element).data('img');
                }
                if (index == 1) {
                    str2 = '|' + $(element).data('img');
                }
                if (index == 2) {
                    str3 = '|' + $(element).data('img');
                }
            });
            img = str1 + str2 + str3;
            if (img != '') {
		 $('#btn-save').button('loading');
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: ajaxurl,
                    data: {
                        action: 'marketplace_ajax',
                        title: $('#marketplace_title').val(),
                        description: $('#marketplace_description').val(),
                        categories: $('#marketplace_categories').val(),
                        tags: $('#marketplace_tags').val(),
                        img: img,
                        price: $('#marketplace_price').val(),
                        marketplace_nonce_field: $('#marketplace_nonce_field').val(),
                        type: $('#marketplace_type').val(),
                    },
                    success: function (data) {
                        swal({
                            type: 'success',
                            title: 'Has enviado tu producto',
                            text: 'El producto será revisado por el administrador antes de publicarlo te llegará un email de confirmación',
                            showConfirmButton: true,
                            type: 'success'
                        }).then(
                            function () {
								 $(location).attr('href','http://nucleoemprendedor.cl/marketplace/dashboard/');
                            },
                            // handling the promise rejection
                            function (dismiss) {
                                if (dismiss === 'timer') {
                                    $(location).attr('href','http://nucleoemprendedor.cl/marketplace/dashboard/');

                                }
                            }
                        );

                        $('#marketplace_title').val('');
                        $('#marketplace_description').text('');
                        $('#marketplace_price').val('');
                        $('#marketplace_type').val('');
                        $('#marketplace_tags').val('');
                        $('.preview').html('');
                        canvas.cropper('destroy');
                        $('imagen-add').html('');
                        cont = 0;
                    },

                    complete: function () {
                        $('#btn-save').button('reset');
                        $('.imagen-add').html();
                    }
                });

            } else {
                $('.imagen-add').html('<div class="error-pad" style="border-left: 3px solid #ffdddd; background: #d48382; padding:5px">No ha subido ninguna imagen</div>');
			 $('#btn-save').button('reset');

            }
        }
    })
});


$('#marketplace_price').on('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});



//$( this ).parent().find( 'li.active' ).removeClass( 'active' );








