<?php ob_start();

echo "hola";

if (!defined('ABSPATH')) exit;

global $wpdb;

echo "hola despues";

$post = $_POST['id'];

echo "post";


$table_name = $wpdb->prefix . "post";

echo $table_name;

$table_name2 = $wpdb->prefix . "products_services";

echo $table_name2;

$query = $wpdb->query($wpdb->prepare("UPDATE %s set post_status = 'publish' where ID= %d", $table_name, $post));

$query2 = $wpdb->query($wpdb->prepare("UPDATE %s set status = 1 where post_id = %d", $table_name2, $post));


echo "se ha cambiado correctamente";

?>