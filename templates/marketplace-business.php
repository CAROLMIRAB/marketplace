<?php
$dbh = new wpdb(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

$table_adherent = $wpdb->prefix . "adherent";
$table_business = $wpdb->prefix . "business";
$table_users = $wpdb->prefix . "users";



$user = wp_get_current_user()->ID;

$query = "SELECT 
$table_business.name as bname, 
$table_business.address, 
$table_business.workers,
$table_business.rut, 
$table_business.video, 
$table_business.description, 
$table_business.phone, 
$table_business.phone2, 
$table_business.web, 
$table_business.image, 
$table_adherent.name, 
$table_adherent.lastname, 
$table_adherent.lastname2,
$table_users.user_email as email,
$table_business.email as bemail
  FROM 
$table_business
INNER JOIN $table_adherent ON $table_adherent.id_user = $table_business.id_user
INNER JOIN $table_users on $table_users.ID = $table_business.id_user
where $table_business.id_user = $user";


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
$phone2 = "";
$web = "";
$image = "";
$email = "";
$bemail = "";


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
    $phone2 = $row->phone2;
    $web = $row->web;
    $image = $row->image;
    $email = $row->email;
    $bemail = $row->bemail;
}

?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="title-card-top" style=""><h4 class="card-title"><strong>Mi Empresa<strong</h4></div>
                <div class="card-header card-header-icon" data-background-color="green">
                    <i class="material-icons">bookmark</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title"></h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive table-sales">
                                <form id="form-marketplace-business">
                                    <h5>Datos Personales</h5>


                                    <label>Nombres</label>
                                    <input type="text" class="form-control" id="marketplace_mname"
                                           name="marketplace_mname" value="<?php echo $name ?>" readonly>
                                    <br>
                                    <label>Apellido Paterno</label>
                                    <input type="text" class="form-control" id="marketplace_mlastname1"
                                           name="marketplace_mlastname1"
                                           value="<?php echo $lastname ?>" readonly>
                                    <br>
                                    <label>Apellido Materno</label>
                                    <input class="form-control" id="marketplace_mlastname2"
                                           name="marketplace_mlastname2"
                                           value="<?php echo $lastname2 ?>" readonly>
                                    <br>
                                    <label>Email Usuario</label>
                                    <input class="form-control" id="marketplace_memail"
                                           name="marketplace_memail"
                                           value="<?php echo $email ?>" readonly>
                                    <br>
                                    <h5> Datos de mi empresa</h5>

                                    <label>Nombre *</label>
                                    <input type="text" class="form-control" id="marketplace_bname"
                                           name="marketplace_bname" value="<? echo $bname ?>">
                                    <br>
                                    <label>Rut *</label>
                                    <input type="text" class="form-control" id="marketplace_brut"
                                           name="marketplace_brut" value="<? echo $rut ?>" maxlength="10">
                                    <br>
                                    <label>Dirección</label>
                                    <textarea class="form-control" id="marketplace_baddress"
                                              name="marketplace_baddress"><? echo $address ?></textarea>
                                    <br>
                                    <label>Cantidad de Trabajadores</label>
                                    <input type="number" class="form-control" id="marketplace_bworkers"
                                           name="marketplace_bworkers" value="<? echo $workers ?>">
                                    <br>
                                    <label>Descripción *(realiza una breve reseña de tu empresa, la que se publicará junto a tu producto o servicio)</label>
                                    <textarea class="form-control" id="marketplace_bdescription"
                                              name="marketplace_bdescription"
                                              maxlength="360"><? echo $description ?></textarea>
                                    <br>
                                    <label>Teléfono 1* (Ejemplo: 999999999)</label>
                                    <input type="number" class="form-control" id="marketplace_bphone"
                                           name="marketplace_bphone" value="<? echo $phone ?>">
                                    <br>
                                    <label>Teléfono 2</label>
                                    <input type="number" class="form-control" id="marketplace_bphone2"
                                           name="marketplace_bphone2" value="<? echo $phone2 ?>">
                                    <br>
                                    <label>Email Empresa* </label>
                                    <input type="text" class="form-control" id="marketplace_bmail"
                                           name="marketplace_bmail" value="<? echo $bemail ?>">
                                    <br>
                                    <label>Página Web</label>
                                    <input type="text" class="form-control" id="marketplace_bweb"
                                           name="marketplace_bweb" value="<? echo $web ?>">
                                    <br>
                                    <label>Video de tu Empresa (Link Youtube)</label>
                                    <input type="text" class="form-control" id="marketplace_bvideo"
                                           name="marketplace_bvideo" value="<? echo $video ?>">
                                    <br>

                                    <input type="hidden" id="marketplace_id"
                                           value="<?php echo wp_get_current_user()->ID ?>">
                                    <input type="hidden" id="marketplace_img"
                                           value="<?php echo $image ?>">
                                    <p style="font-size: 10px">Los campos con asterisco (*) son obligatorios para completar tu perfil.</p>

                                    <?php wp_nonce_field('marketplace_nonce', 'marketplace_nonce_field'); ?>
                                    <button id="btn-saveb" value='Guardar'
                                            class='btn btn-success'
                                            data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Guardando">
                                        Guardar Cambios
                                    </button>
                                </form>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="div-imagen-actual">
                                <?php if ($image != "") { ?>
                                    <img class="desvanecer" src="<?php echo $image ?>" style="width: 100%"/>
                                <?php } else { ?>
                                    <img style="opacity: 0.5; width: 100%"
                                         src="<?php echo get_template_directory_uri() . '/' . 'marketplace/img/prohibido.png'; ?>"
                                         class="desvanecer">
                                <?php } ?>
                                <button class="change-img" data-toggle="modal" data-target="#modalCanvas"
                                        style="padding: 15px; background: #ccc; width: 100%"> Cambiar Imagen de Perfil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCanvas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true"
     style="top: 5px; z-index: 999999; bottom: auto">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <div>
                            <canvas id="bcanvas">
                            </canvas>
                        </div>
                        <p>
                           <!-- <input type="button" id="btnCrop" value="Agregar"/>-->
                            <input type="file" id="bfileInput" accept="image/*"/>
                           <!-- <input type="button" id="btnRestore" value="Restaurar"/>-->
                        </p>
                    </div>
                    <div class="col-md-3">
                        <div class="preview">

                        </div>
                        <input type="hidden" id="inputimage">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btnCrop" class="btn btn-secondary closet-modal" data-dismiss="modal">Aceptar
                </button>
            </div>
        </div>
    </div>
</div>










