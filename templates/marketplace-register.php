<?php ob_start();

if (!defined('ABSPATH')) exit;

global $wpdb;


?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="wpcf7">
                <form id="form-marketplace-register" action="" method="post">
                    <div class="title-section">
                        <h1><span>Datos</span></h1>
                    </div>
                    <label>Nombres *</label>
                    <input type="text" class="form-control" id="marketplace_name"
                           name="marketplace_name">
                    <div class="mini-faq" style="color: firebrick"></div>
                    <br>
                    <label>Apellido Paterno *</label>
                    <input type="text" class="form-control" id="marketplace_lastname1"
                           name="marketplace_lastname1">
                    <div class="mini-faq" style="color: firebrick"></div>
                    <br>
                    <label>Apellido Materno *</label>
                    <input type="text" class="form-control" id="marketplace_lastname2"
                           name="marketplace_lastname2">
                    <div class="mini-faq" style="color: firebrick"></div>
                    <br>
                    <label>Email *</label>
                    <input type="email" class="form-control" id="marketplace_mail"
                           name="marketplace_mail">
                    <div class="mini-faq" style="color: firebrick"></div>
                    <br>
                    <label>Rut Empresa *</label>
                    <input type="text" class="form-control" id="marketplace_rut"
                           name="marketplace_rut" maxlength="10">
                    <div class="mini-faq" style="color: firebrick"></div>
                    <br>
                    <label>Username *</label>
                    <input type="text" class="form-control" id="marketplace_username"
                           name="marketplace_username">
                    <div class="mini-faq" style="color: firebrick"></div>
                    <br>
                    <label>Contraseña *</label>
                    <input type="password" class="form-control" id="marketplace_password1"
                           name="marketplace_password1">
                    <div class="mini-faq" style="color: firebrick"></div>
                    <br>
                    <label>Repita su contraseña *</label>
                    <input type="password" class="form-control" id="marketplace_password2"
                           name="marketplace_password2">
                    <div class="mini-faq" style="color: firebrick"></div>
                    <br>
                    <div></div>

                    <?php wp_nonce_field('marketplace_nonce', 'marketplace_nonce_field'); ?>


                    <button type='submit' id="btn-register" name="btn-register"
                            class='btn btn-success'
                            data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Enviando">
                        Enviar
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

<?php
ob_end_flush();
?>



