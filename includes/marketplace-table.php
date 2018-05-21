<?php ob_start();

if ( ! defined( 'ABSPATH' ) ) exit;
function register_marketplace_menu_page (){
    add_menu_page( 'MarketPlace', 'MarketPlace', 'manage_options', 'marketplace-registros', 'marketplace_menu_page' , 'dashicons-groups', 31 );
}
add_action( 'admin_menu', 'register_marketplace_menu_page' );
function marketplace_menu_page () { ?>

    <div class="wrap">

        <h2 style="position:relative;width:100%;float:left;margin-bottom:15px;"><?php _e('MarketPlace', 'marketplace');?>
            <a style="position:absolute;top:10px;right:15px;" class="button-primary" href="admin.php?page=marketplace-registros&action=download&total=-1"><?php _e('Descargar Excel (.xls)', 'marketplace');?></a>
        </h2>

        <?php require_once('class-marketplace-list-table.php');
        $wp_list_table = new MarketPlace_List_Table();
        if( isset( $_POST['s'] ) ){
            $wp_list_table->prepare_items( $_POST['s'] );
        } else {
            $wp_list_table->prepare_items();
        }
        ?>

        <?php $wp_list_table->display(); ?>

    </div>

<?php }
/**
 * Descarga un excel con los registros
 */
function marketplace_download() {
    if( current_user_can('manage_options' ) ) {
        if( isset( $_GET['total'] ) && $_GET['action'] == 'download' ) {
            $data = array();
            global $wpdb;
            $table_name = $wpdb->prefix . 'products_services';
            $id = $_GET['total'];
            $rows = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY id DESC" );
            foreach ( $rows as $row ) {

                array_push( $data, array(
                        "Title" => $row->title,
                        "Description" => $row->description,
                        "Price" => $row->price,
                    )
                );
            }
            function cleanData(&$str) {
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            }
            // filename for download
            $filename = "marketplace-" . date('d-m-Y') . ".xls";
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Content-Type: application/vnd.ms-excel");
            $flag = false;
            foreach($data as $row) {
                if(!$flag) {
                    // display field/column names as first row
                    echo implode("\t", array_keys($row)) . "\r\n";
                    $flag = true;
                }
                array_walk($row, 'cleanData');
                echo implode("\t", array_values($row)) . "\r\n";
            }
            exit;
        }
    }
}
add_action('init', 'marketplace_download' );

ob_end_flush();
