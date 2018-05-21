<?php ob_start();

if (!defined('ABSPATH')) exit;

global $wpdb;

$action_slug = $wp_query->query_vars['name'];

if (is_user_logged_in() && isset($_POST['logout-submit'])) {
    wp_logout();
}

?>

    <form id="logout-marketplace" action="" method="post" name="logout-marketplace">
        <fieldset><input id="logout-submit" type="submit" name="logout-submit" value="Salir"/></fieldset>
    </form>

<?php
ob_end_flush();
?>