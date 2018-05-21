var canvasb = $('#bcanvas'),
    contextb = canvasb.get(0).getContext('2d');

var croppedImageDataURL;



$('#bfileInput').on('change', function () {
    var maxFileSize = 300000; // 2MB
    var fileUpload = $('#bfileInput');
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
                    var readerb = new FileReader();
                    readerb.onload = function (evtb) {
                        var imgb = new Image();
                        imgb.onload = function () {
                            canvasb.cropper('destroy');
							
							var MAX_WIDTH = 800;
							var MAX_HEIGHT = 600;
							var width = imgb.width;
							var height = imgb.height;
 
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
							
                            contextb.canvas.height = height;
                            contextb.canvas.width = width;
							
                            contextb.drawImage(imgb, 0, 0, width, height);
                            var cropperb = canvasb.cropper({
                                aspectRatio: 4 / 3,
                                cropBoxResizable: true,
                                background: true,
                                viewMode: 1

                            });

                            $('#btnRestore').click(function () {
                                canvasb.cropper('reset');
                                $('.preview').empty();
                                $('.error-pad').addClass('hidden');

                            });
                        };
                        imgb.src = evtb.target.result;
                    };
                    readerb.readAsDataURL(this.files[0]);
                }
                else {
                    alert('Invalid file type! Please select an image file.');
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
    var croppedImageDataURL = canvasb.cropper('getCroppedCanvas').toDataURL("image/png");
    $('.div-imagen-actual img').remove();
    $('.preview img').remove();
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
            $('.div-imagen-actual img').remove();
            $('.preview img').remove();
			$('#marketplace_img').val(imgurl);
            $('.div-imagen-actual').prepend($('<img class="desvanecer">').attr({'src': croppedImageDataURL, 'data-img': imgurl}));
            $('.preview').prepend($('<img class="desvanecer">').attr({'src': croppedImageDataURL, 'data-img': imgurl}));
		    $('#modalCanvas').modal('hide');

        },
        error: function (data) {
            var obj = data;
            $('.imagen-add').html('<div class="error-pad" style="border-left: 3px solid #ffdddd; background: #d48382; padding:5px">Ha habido un error no se pudo subir tu imagen</div>');
            $('#btnCrop').button('reset');
        },
        complete: function () {
            $('#btnCrop').button('reset');
        }
    });

});


	/*$('#btnCrop').click(function () {
						var croppedImageDataURL = canvasb.cropper('getCroppedCanvas').toDataURL("image/png")
						$('.div-imagen-actual img').remove();
						$('.preview img').remove();
						$('.div-imagen-actual').append($('<img class="desvanecer">').attr('src',croppedImageDataURL));
						$('.preview').append($('<img class="desvanecer">').attr('src',croppedImageDataURL));
						$('#inputimage').val(croppedImageDataURL);
						
						});*/


$('#btn-saveb').on('click', function (ev) {
    var img = $('#marketplace_img').val();
    $('#form-marketplace-business').validate({
        rules: {
            marketplace_bname: {
                required: true
            },
			  marketplace_bphone: {
                required: true
            },
			  marketplace_bmail: {
                required: true,
				email:true
            },
			  marketplace_bdescription: {
                required: true,
				minlength: 10,
				maxlength: 500
            },
			  marketplace_brut: {
                required: true,
				maxlength: 10,
				minlength: 2
            },
			  marketplace_image: {
                required: true
            }
        },

        messages: {
               marketplace_bname: {
                required: 'El nombre de la empresa no puede estar vacío'
            },
			  marketplace_bphone: {
                required: 'El telefono no puede estar vacío'
            },
			  marketplace_bmail: {
                required: 'El email es está vacío',
				email: 'Email no válido'
            },
			  marketplace_bdescription: {
                required: 'La descripcion está vacía',
				minlength: 'Es una descripcion muy corta',
				maxlength: 'La descripción es demasiado larga'
            },
			  marketplace_brut: {
                required: 'El rut no debe estar vacío',
				maxlength: 'No es un rut válido',
				minlength: 'No es un rut válido'
            },
			  marketplace_image: {
                required: 'No ha subido ninguna imagen'
            }
        },

        submitHandler: function(form) {
			 $('#btn-saveb').button('loading');
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
                    bphone2: $('#marketplace_bphone2').val(),
                    bweb: $('#marketplace_bweb').val(),
                    bmail: $('#marketplace_bmail').val(),
                    bdescription: $('#marketplace_bdescription').val(),
                    bworkers: $('#marketplace_bworkers').val(),
                    brut: $('#marketplace_brut').val(),
                    img: img,
                    id: $('#marketplace_id').val(),
                    marketplace_nonce_field: $('#marketplace_nonce_field').val(),
                },
                success: function (data) {
                    var obj = data;
                    if (obj.type == 'success') {
                        swal({
                                title: '¡Felicidades! ya eres miembro de Mercado Nucleo Emprendedor',
                                text: 'Ya puedes empezar a publicar tus productos',
                                type: 'success',
                                confirmButtonText: 'OK'
                            }).then(
                        function () {
  $(location).attr('href', 'http://nucleoemprendedor.cl/marketplace/agregar-producto/');                        });     
   
                    } else {

                        swal({
                            title: 'Hubo un error',
                            text: obj.msg,
                            type: 'error',
                        });
                    }
                },

                complete: function () {
                    $('#btn-saveb').button('reset');
                }
            });
        }
    })

});


//$('').mask("9999999[9]-*");

$("input#marketplace_brut").rut({formatOn: 'keyup', ignoreControlKeys: false, useThousandsSeparator : false});


$('.change-img').click(function(){
	$('#modalCanvas').modal('show');
	})
	
 






