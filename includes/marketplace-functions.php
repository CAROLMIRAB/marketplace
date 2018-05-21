<?php ob_start();

if (!defined('ABSPATH')) exit;


function marketplace_crea_ajaxurl()
{
    ?>
    <script type="text/javascript">
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>
    <?php
}

add_action('wp_head', 'marketplace_crea_ajaxurl');


/**
 *
 */
function marketplace_ajax()
{
    // verifica nonce
    if (!isset($_POST['marketplace_nonce_field']) || !wp_verify_nonce($_POST['marketplace_nonce_field'], 'marketplace_nonce')) {
        echo 'Lo siento, no verifica.';
        exit;
    } else {
        // comprobamos que existen
        if (isset($_POST['title']) && isset($_POST['description'])) {
            $title = strlen($_POST['title']);
            $description = strlen($_POST['description']);
            $price = $_POST['price'];
            $categories = $_POST['categories'];
            $type_prod = $_POST["type"];
            $tags = $_POST["tags"];
            $croped_image = $_POST['img'];

            // valida el máximo de carácteres permitido en cada string y si el email es válido
            if ($description > 10 && $title > 2) {

                // saneamos
                $title = sanitize_text_field($_POST['title']);
                $description = $_POST['description'];
                $price = sanitize_text_field($_POST['price']);
                $categories = $_POST['categories'];
                $type_prod = $_POST['type'];
                $slug = sanitize_title($_POST['title']);
                $img = $_POST['img'];
                $tags = $_POST["tags"];
                $status = 2;
                $user = wp_get_current_user()->ID;


                // insertamos
                $inserted = marketplace_insert($title, $description, $status, $price, $categories, $type_prod, $slug, $img, $user, $tags);
                // SI se ha creado, mostramos mensaje OK
                if ($inserted) {
                    $result['type'] = 'success';
                    $result['msg'] = 'Ud ha enviado su producto de forma exitosa!';
                    $result = json_encode($result);
                    echo $result;
                    wp_die();
                    // NO se ha creado, mostramos error en #encuesta-error
                } else {
                    $result['type'] = 'error';
                    $result['msg'] = 'Error al crear el registro en la base de datos';
                    $result = json_encode($result);
                    echo $result;
                    wp_die();
                }
            } else {
                $result['type'] = 'error';
                $result['msg'] = 'Error al enviar formulario';
                $result = json_encode($result);
                echo $result;
                wp_die();
            }
        }
    }
}

add_action('wp_ajax_marketplace_ajax', 'marketplace_ajax');
add_action('wp_ajax_nopriv_marketplace_ajax', 'marketplace_ajax');


function marketplace_business()
{
    // verifica nonce
    if (!isset($_POST['marketplace_nonce_field']) || !wp_verify_nonce($_POST['marketplace_nonce_field'], 'marketplace_nonce')) {
        echo 'Lo siento, no verifica.';
        exit;
    } else {
        // comprobamos que existen
        if (isset($_POST["bname"])) {
            $name = strlen($_POST['mname']);
            $lastname1 = strlen($_POST['mlastname1']);
            $lastname2 = $_POST['mlastname2'];
            $croped_image = $_POST["img"];

            $bname = strlen($_POST['bname']);
            $baddress = strlen($_POST['baddress']);
            $bworkers = $_POST['bworkers'];
            $bdescription = $_POST['bdescription'];
            $brut = $_POST['brut'];
            $bphone = $_POST['bphone'];
            $bphone2 = $_POST['bphone2'];
            $bweb = $_POST['bweb'];
            $bmail = $_POST['bmail'];
            $bvideo = $_POST['bvideo'];

            // valida el máximo de carácteres permitido en cada string y si el email es válido
            if ($bname > 4) {
                $id = $_POST['id'];
                $name = sanitize_text_field($_POST['mname']);
                $lastname1 = sanitize_text_field($_POST['mlastname1']);
                $lastname2 = sanitize_text_field($_POST['mlastname2']);


                $bname = sanitize_text_field($_POST['bname']);
                $baddress = sanitize_textarea_field($_POST['baddress']);
                $bworkers = sanitize_text_field($_POST['bworkers']);
                $bdescription = sanitize_textarea_field($_POST['bdescription']);
                $brut = sanitize_text_field($_POST['brut']);
                $bphone = sanitize_text_field($_POST['bphone']);
                $bvideo = sanitize_text_field($_POST['bvideo']);
                $bphone2 = sanitize_text_field($_POST['bphone2']);
                $bmail = sanitize_text_field($_POST['bmail']);
                $bweb = sanitize_text_field($_POST['bweb']);
                $image = $_POST["img"];


                /*  list($type, $croped_image) = explode(';', $croped_image);
                  list(, $croped_image) = explode(',', $croped_image);
                  $croped_image = base64_decode($croped_image);
                  $filename = time() . '.png';
                  $upload_dir = wp_upload_dir();
                  $image = $upload_dir['url'] . '/' . $filename;
                  $filedest = $upload_dir['path'] . '/' . $filename;
                  file_put_contents($filedest, $croped_image);
                */

                // insertamos
                $inserted = marketplace_insert_business($bname, $baddress, $bworkers, $brut, $bvideo, $bdescription, $bphone, $id, $image, $bphone2, $bweb, $bmail);
                // SI se ha creado, mostramos mensaje OK
                if ($inserted) {

                    $result['type'] = 'success';
                    $result['msg'] = 'Ud ha enviado su producto de forma exitosa!';
                    $result = json_encode($result);
                    echo $result;
                    wp_die();
                    // NO se ha creado, mostramos error en #encuesta-error
                } else {
                    $result['type'] = 'error';
                    $result['msg'] = 'Error al crear el registro en la base de datos';
                    $result = json_encode($result);
                    echo $result;
                    wp_die();
                }
            } else {
                $result['type'] = 'error';
                $result['msg'] = 'Error al enviar formulario';
                $result = json_encode($result);
                echo $result;
                wp_die();
            }
        }
    }
}

add_action('wp_ajax_marketplace_business', 'marketplace_business');
add_action('wp_ajax_nopriv_marketplace_business', 'marketplace_business');


function marketplace_publish()
{


    $id = $_POST['id'];
    $slug = $_POST['slug'];
    $mail = $_POST['email'];

    $register = marketplace_publish_insert($id);

    $body = "<table width='600' border='0' style='font-family:arial'>
<tr>
<td>
<img src='http://nucleoemprendedor.cl/wp-content/uploads/2017/07/1-1.png' />
</td>
  <td style='text-align: right'>
  <img src='http://nucleoemprendedor.cl/wp-content/uploads/2017/07/3-1.png' />
  <td>
</tr>
<tr>
<td style='text-align: justify; color: #555 ' colspan='2'>
<br><br>
<p style='text-align: center; font-size: 18px; '><strong>¡Tu producto/servicio fue publicado exitosamente! </strong></p>
<br><br>
<p>Esperamos que tus ventas comiencen a subir desde hoy. Ingresa ya al <a href='" . esc_url(home_url('/')) . "marketplace/." . $slug . "'>MarketPlace</a>
</td>
</tr>
</table>";
    $to = $mail;
    $subject = 'Mensaje Publicación';
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'Nucleo Emprendedor <soporte@nucleoemprendedor.cl>';


    wp_mail($to, $subject, $body, $headers);


}

add_action('wp_ajax_marketplace_publish', 'marketplace_publish');
add_action('wp_ajax_nopriv_marketplace_publish', 'marketplace_publish');


function marketplace_rating()
{
    if (isset($_POST["id_adherent"]) && isset($_POST['id_product']) && isset($_POST['rating'])) {


        $id_adherent = $_POST['id_adherent'];
        $id_product = $_POST['id_product'];
        $rating = $_POST['rating'];
        $register = marketplace_rating_insert($id_adherent, $id_product, $rating);
        wp_die();
    }

}

add_action('wp_ajax_marketplace_rating', 'marketplace_rating');
add_action('wp_ajax_nopriv_marketplace_rating', 'marketplace_rating');


function marketplace_add_image()
{
    // verifica nonce
    if (!isset($_POST['marketplace_nonce_field']) || !wp_verify_nonce($_POST['marketplace_nonce_field'], 'marketplace_nonce')) {
        echo 'Lo siento, no verifica.';
        exit;
    } else {
        // comprobamos que existen
        if (isset($_POST['img']) || !is_null($_POST['img']) || $_POST['img'] != '') {

            $croped_image = $_POST['img'];
            list($type, $croped_image) = explode(';', $croped_image);
            list(, $croped_image) = explode(',', $croped_image);
            $croped_image = base64_decode($croped_image);
            $filename = time() . '.png';
            $upload_dir = wp_upload_dir();
            $image = $upload_dir['url'] . '/' . $filename;
            $filedest = $upload_dir['path'] . '/' . $filename;
            file_put_contents($filedest, $croped_image);

            $result['type'] = 'addimg';
            $result['msg'] = 'se ha agregado la img';
            $result['img'] = $image;
            $result = json_response($result, '200');
            echo $result;
            exit;
        }

    }
}

add_action('wp_ajax_marketplace_add_image', 'marketplace_add_image');
add_action('wp_ajax_nopriv_marketplace_add_image', 'marketplace_add_image');

function marketplace_delete_image()
{
    // verifica nonce
    if (!isset($_POST['marketplace_nonce_field']) || !wp_verify_nonce($_POST['marketplace_nonce_field'], 'marketplace_nonce')) {
        echo 'Lo siento, no verifica.';
        exit;
    } else {
        // comprobamos que existen
        if (isset($_POST['image'])) {
            $img = $_POST['image'];
            unlink($img);
            $result['type'] = 'deleteimg';
            $result['msg'] = 'se ha agregado la img';
            $result['img'] = $img;
            $result = json_response($result, '200');
            echo $result;
            exit;
        }
    }
}

add_action('wp_ajax_marketplace_add_image', 'marketplace_add_image');
add_action('wp_ajax_nopriv_marketplace_add_image', 'marketplace_add_image');


function marketplace_register()
{
    // verifica nonce
    if (!isset($_POST['marketplace_nonce_field']) || !wp_verify_nonce($_POST['marketplace_nonce_field'], 'marketplace_nonce')) {
        echo 'Lo siento, no verifica.';
        exit;
    } else {
        // comprobamos que existen
        if (isset($_POST['marketplace_username']) && isset($_POST['marketplace_password1'])) {

            $mail = $_POST['marketplace_mail'];
            $username = $_POST["marketplace_username"];


            $user_id = username_exists($username);
            $mail_id = email_exists($mail);

            $mail = $_POST['marketplace_mail'];
            $username = $_POST["marketplace_username"];
            $user_id = username_exists($username);
            $mail_id = email_exists($mail);

            if ($user_id) {
                global $user_exist;
                $user_exist = $user_id;
                $errore = "user";
            }
            if ($mail_id) {
                global $mail_exist;
                $mail_exist = $mail_id;
                $errore = "mail";
            }
            // if username is empty
            if ($_POST['marketplace_username'] == '' || $_POST['marketplace_username'] == ' ') {
                $username = '';
                $result['type'] = 'error';
                $result['msg'] = 'El usuario no puede estar vacio';
                $result = json_encode($result);
                $username_cond = false;
                echo $result;
                wp_die();


            } elseif (isset($user_exist)) {
                // if username already exist
                $username = $_POST['marketplace_username'];
                $result['type'] = 'error';
                $result['msg'] = 'El Usuario ya existe';
                $result = json_encode($result);
                $username_cond = false;
                echo $result;
                wp_die();

            } else {
                // if username is ok
                $username = $_POST['marketplace_username'];
                $username_msg = "";
                $form_username_class = "";
                $username_cond = true;
            }

            if ($_POST['marketplace_name'] == '' || $_POST['marketplace_name'] == ' ') {
                $name = '';
                $result['type'] = 'error';
                $result['msg'] = 'El nombre no debe estar vacío';
                $result = json_encode($result);
                $name_cond = false;
                echo $result;
                wp_die();

            } else {
                // if username is ok
                $name = $_POST['marketplace_name'];
                $name_msg = "";
                $form_username_class = "";
                $name_cond = true;
            }

            if ($_POST['marketplace_lastname1'] == '' || $_POST['marketplace_lastname1'] == ' ') {
                $lastname1 = '';
                $result['type'] = 'error';
                $result['msg'] = 'El apellido no puede estar vacío';
                $lastname1_cond = false;
                $result = json_encode($result);
                echo $result;
                wp_die();


            } else {
                // if username is ok
                $lastname1 = $_POST['marketplace_lastname1'];
                $lastname1_msg = "";
                $form_username_class = "";
                $lastname1_cond = true;
            }


            if ($_POST['marketplace_password1'] != $_POST['marketplace_password2']) {
                // if the pass confirmation is not correct
                $password = "";
                $result['type'] = 'error';
                $result['msg'] = 'Las contraseñas no coinciden';
                $password_cond = false;
                $result = json_encode($result);
                echo $result;
                wp_die();


            } else {
                $password = "";
                $password_msg = "";
                $form_pass_class = "";
                $password_cond = true;
            }

            if ($_POST['marketplace_mail'] == '') {
                // if mail field is empty
                $mail = "";
                $result['type'] = 'error';
                $result['msg'] = 'El email no puede estar vacío';
                $mail_cond = false;
                $result = json_encode($result);
                echo $result;
                wp_die();


            } elseif (isset($mail_exist)) {
                // if mail is already asociated to other user
                $mail = $_POST['marketplace_mail'];
                $result['type'] = 'error';
                $result['msg'] = 'Este email ya existe';
                $mail_cond = false;
                $result = json_encode($result);
                echo $result;
                wp_die();


            } else {
                $mail = $_POST['marketplace_mail'];
                $mail_msg = "";
                $form_mail_class = "";
                $mail_cond = true;
            }

            $name = $_POST['marketplace_name'];
            $lastname1 = $_POST['marketplace_lastname1'];
            $lastname2 = $_POST['marketplace_lastname2'];
            $mail = $_POST['marketplace_mail'];
            $rut = $_POST["marketplace_rut"];
            $username = $_POST["marketplace_username"];
            $pass1 = $_POST["marketplace_password1"];
            $pass2 = $_POST["marketplace_password2"];

            if ($name_cond && $username_cond && $lastname1_cond && $mail_cond && $password_cond) {

                $inserted = marketplace_register_insert($name, $lastname1, $lastname2, $rut, $mail, $username, $pass1, $pass2);


                $body = "<table width='600' border='0' style='font-family:arial'>
<tr>
<td>
<img src='http://nucleoemprendedor.cl/wp-content/uploads/2017/07/1-1.png' />
</td>
  <td style='text-align: right'>
  <img src='http://nucleoemprendedor.cl/wp-content/uploads/2017/07/3-1.png' />
  <td>
</tr>
<tr>
<td style='text-align: justify; color: #555 ' colspan='2'>
<br><br>
<p style='text-align: center; font-size: 18px; '><strong>¡Bienvenido a nuestro Mercado Nucleo Emprendedor de Mutual de Seguridad! </strong></p>
<br><br>
<p>Te has registrado exitosamente. Comienza a publicar tus productos y servicios y dale una mayor visualización a tu negocio.</p>

<p> Tus datos de registro son los siquientes: </p>

<p><strong>Usuario: </strong> $username </p>
<p><strong>Email: </strong> $mail </p>

<p>Ingresa <a href='".esc_url(home_url('/'))."marketplace'>Aquí</a> para empezar a publicar tus productos</p>
<td>
</tr>
</table>";


                if ($inserted) {
                    $to = $mail;
                    $subject = 'Mensaje Inscripción Exitosa';
                    $headers[] = 'Content-Type: text/html; charset=UTF-8';
                    $headers[] = 'Nucleo Emprendedor <soporte@nucleoemprendedor.cl>';
                    wp_mail($to, $subject, $body, $headers);
                    $result['type'] = 'success';
                    $result['msg'] = 'Ud ha enviado su producto de forma exitosa!';
                    $result = json_encode($result);
                    echo $result;
                    wp_die();
                    // NO se ha creado, mostramos error en #encuesta-error
                } else {
                    $result['type'] = 'error';
                    $result['msg'] = 'Error al crear el registro en la base de datos';
                    $result = json_encode($result);
                    echo $result;
                    wp_die();
                }

            } else {
                $result['type'] = 'error';
                $result['msg'] = 'Error al enviar formulario';
                $result = json_encode($result);
                echo $result;
                wp_die();
            }
        }
    }
}

add_action('wp_ajax_marketplace_register', 'marketplace_register');
add_action('wp_ajax_nopriv_marketplace_register', 'marketplace_register');

function json_response($message = null, $code = 200)
{
    // clear the old headers
    header_remove();
    // set the actual code
    http_response_code($code);
    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json');
    $status = array(
        200 => '200 OK',
        400 => '400 Bad Request',
        422 => 'Unprocessable Entity',
        500 => '500 Internal Server Error'
    );
    // ok, validation error, or failure
    header('Status: ' . $status[$code]);
    // return the encoded json
    return json_encode(array(
        'status' => $code < 300, // success or not?
        'message' => $message
    ));
}

ob_end_flush();
