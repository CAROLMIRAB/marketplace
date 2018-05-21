<?php
$dbh = new wpdb(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

$table_adherent = $wpdb->prefix . "adherent";
$table_business = $wpdb->prefix . "business";
$table_cat = $wpdb->prefix . "categories";


$user = wp_get_current_user()->ID;

$query = "SELECT $table_business.name as bname, $table_business.address, $table_business.workers, $table_business.rut, $table_business.video, $table_business.description, $table_business.phone, $table_business.image, $table_adherent.name, $table_adherent.lastname, $table_adherent.lastname2  FROM $table_adherent, $table_business where $table_adherent.id_user = $user and $table_business.id_user = $table_adherent.id_user";


$content = $dbh->get_results($query);


$name = '';
$lastname = '';
$lastname2 = "";
$bname = "";
$address = "";
$workers = "";
$rut = "";
$video = "";
$description = "";
$phone = "";
$image = "";

foreach ($content as $row) {

    $name = $row->name;
    $lastname = $row->lastname;
    $lastname2 = $row->lastname2;

    $bname = $row->bname;
    $address = $row->address;
    $workers = $row->workers;
    $rut = $row->rut;
    $video = $row->video;
    $description = $row->description;
    $phone = $row->phone;
    $image = $row->image;

}

$querycat = "select slug, name from $table_cat";
$contentcat = $dbh->get_results($querycat);

?>

<div class="container-fluid">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="title-card-top" style=""><h4 class="card-title"><strong>Agregar Producto o Servicio</strong></h4></div>
                <div class="card-header card-header-icon" data-background-color="green">
                    <img src="<?php echo get_template_directory_uri() . '/' . 'marketplace/img/product.png'; ?>"
                         style="width: 33px; height: 33px"></div>
                <div class="card-content">

                    <div class="row">
                        <?php if ($bname == '' || $description == '' || $phone == '') { ?>
                        <div class="col-md-8 col-md-offset-2">
                            <div style="background-image: url('../assets/img/mutual-img.jpg'); background-repeat: no-repeat; font-size: 20px; text-align: justify">
                                Para empezar a publicar tus productos y/o servicios, debes completar tu perfil,
                                ingresando
                                <a href="<?php echo esc_url(home_url('/')) . 'marketplace/mi-perfil/' ?>"
                                   style="color: #f18802; font-size: 22px">Aquí</a>
                                o haciendo click en la opción "Mi Perfil" en el menú lateral.
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="col-md-6 col-xs-12">
                        <div class="table-responsive table-sales">
                            <br id='marketplace-container' class="col-md-5">
                            <form id='form-marketplace' method='post'
                                  enctype="multipart/form-data"
                                  class="form-newsletter ">
                                <!--<h2>Agregar Producto</h2>-->

                                <label class="">Titulo de Producto o Servicio *</label>
                                <input type='text'
                                       name='marketplace_title'
                                       id='marketplace_title'
                                       size='40'
                                       class='form-control'>
                                <br>
                                <label class="">Precio (desde)</label>
                                <input
                                        type='text' name='marketplace_price'
                                        id='marketplace_price'
                                        size='10'
                                        class='form-control'>
                                <br>

                                <label class="">Tipo *</label></br>

                                <label> Servicio <input
                                            type='radio' name='marketplace_type'
                                            id='marketplace_type'
                                            value="1"
                                            class='' required></label>
                                <label> Producto <input
                                            type='radio' name='marketplace_type'
                                            id='marketplace_type'
                                            value="2"
                                            class='' checked>
                                </label>
                                <br>

                                <label class="">Categorias *</label>
                                <select id="marketplace_categories" data-placeholder="Seleccione sus categorias"
                                        class="form-control">
                                    <?php foreach ($contentcat as $rowcat) { ?>
                                    <option value="<?php echo $rowcat->slug ?>"><?php echo $rowcat->name ?></option>
                                    <?php } ?>
                                </select>
                                <br>

                                <div class="inbox-form-group">
                                    <label class="">Description Producto o Servicio *</label>
                                    <textarea
                                            type='text' name='marketplace_description'
                                            id='marketplace_description'
                                            class=''></textarea></br>
                                </div>
                                <br>

                                <label class="">Tags</label>
                                <input type='text' name='marketplace_tags'
                                       id='marketplace_tags'
                                       class='form-control'>

                                <p style="font-size: 10px">Los campos con asterisco (*) son obligatorios para enviar tu producto o servicio.</p>

                                <?php wp_nonce_field('marketplace_nonce', 'marketplace_nonce_field'); ?>
                                <button id="btn-save" value='Enviar'
                                        class='btn btn-success '
                                        data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Enviando">
                                    Enviar
                                </button>
                            </form>

                        </div>

                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div id="canvas-div">
                            <canvas id="canvas">

                            </canvas>
                        </div>
                        <p style="font-size: 10px">Puedes agregar un máximo de 3 imagenes</p>
                        <br>

                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
                        <div class="buttons-upload" style="float: left; width: 100%">
                            <div style="float: left; width: 60%; display: inline-block;"><input type="file" id="fileInput" accept="image/*"/></div>
                            <div style="float: left; width: 20%; display: inline-block;"><button type="button" id="btnCrop" value="Aceptar"
                                         data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Cargando Imagen...">
                                    Agregar
                                </button>
                            </div>
                            <div style="float: left; width: 20%; display: inline-block;"><input type="button" id="btnRestore" value="Eliminar"/></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="preview" style="display: table-cell; width: 100%">

                        </div>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>





