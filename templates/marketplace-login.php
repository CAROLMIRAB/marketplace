<?php ob_start();

if (!defined('ABSPATH')) exit;

global $wpdb;


if (isset($_POST["login-username"]) && isset($_POST["login-pass"])) {

    $user_login = $_POST["login-username"];
    $user_password = $_POST["login-pass"];

    echo $user_login;
// Inserting new user to the db
//wp_insert_user( $user_data );


    $creds = array();
    $creds['user_login'] = $user_login;
    $creds['user_password'] = $user_password;
    $creds['remember'] = true;

    $user = wp_signon($creds, false);

    if ( is_wp_error($user) )
        echo '<div class="jerror">'.$user->get_error_message().'</div>';
    else
    {
        wp_set_current_user( $user );
        wp_redirect(get_permalink());
    }

    add_action( 'after_setup_theme', 'custom_login' );



}

?>

    <form id="login-marketplace" action="" method="post" name="login-marketplace">
        <div class="row">
            <div class="col-md-5">
                <label>Username</label>
                <input id="login-username" type="text" name="login-username" value=""/>
            </div>
            <div class="col-md-5">
                <label>Contraseña</label>
                <input id="login-pass" type="password" name="login-pass" value=""/>
            </div>
            <div class="col-md-2">
                <label style="color: #FFFFFF">Entrar</label>
                <input id="login-submit" type="submit" name="login-submit" value="Entrar" style="bottom: 0"/>
            </div>
        </div>
    </form>

<?php
ob_end_flush();
?>