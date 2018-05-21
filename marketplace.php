<?php ob_start();

/*
 * Plugin Name: MarketPlace
 * Version: 1.0
 * Description: MarketPlace Nucleo Emprendedor
 * Author: Carol Mirabal
 * Requires at least: 4.3
 * Tested up to: 4.3
 *
 * Text Domain: marketplace
 * Domain Path: /languages/
 */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'MarketPlace' ) ) {
    final class MarketPlace {
        private static $instance;
        public static function instance() {
            if ( ! isset( self::$instance ) && ! ( self::$instance instanceof MarketPlace ) ) {
                self::$instance = new MarketPlace;
                self::$instance->setup_constants();
                add_action( 'plugins_loaded', array( self::$instance, 'marketplace_load_textdomain' ) );
                self::$instance->includes();
            }
            return self::$instance;
        }
        public function marketplace_load_textdomain() {
            load_plugin_textdomain( 'marketplace', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }
        private function setup_constants() {
            if ( ! defined( 'MARKETPLACE_VERSION' ) ) { define( 'MARKETPLACE_VERSION', '1.0' ); }
            if ( ! defined( 'MARKETPLACE_BBDD_VERSION' ) ) { define( 'MARKETPLACE_BBDD_VERSION', '1.0' ); }
            if ( ! defined( 'MARKETPLACE_PLUGIN_DIR' ) ) { define( 'MARKETPLACE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) ); }
            if ( ! defined( 'MARKETPLACE_PLUGIN_URL' ) ) { define( 'MARKETPLACE_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); }
            if ( ! defined( 'MARKETPLACE_PLUGIN_FILE' ) ) { define( 'MARKETPLACE_PLUGIN_FILE', __FILE__ ); }
        }
        private function includes() {
            require_once MARKETPLACE_PLUGIN_DIR . 'includes/marketplace-load-js-css.php';
            require_once MARKETPLACE_PLUGIN_DIR . 'includes/marketplace-functions.php';
            require_once MARKETPLACE_PLUGIN_DIR . 'includes/class-marketplace-template-loader.php';
            require_once MARKETPLACE_PLUGIN_DIR . 'includes/marketplace-shortcodes.php';
            require_once MARKETPLACE_PLUGIN_DIR . 'includes/marketplace-bbdd.php';
            require_once MARKETPLACE_PLUGIN_DIR . 'includes/marketplace-table.php';
            require_once MARKETPLACE_PLUGIN_DIR . 'includes/marketplace-install.php';
        }
        public function __clone() {
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'marketplace' ), MARKETPLACE_VERSION );
        }
        /* disabled fixes an integration test error
        public function __wakeup() {
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'marketplace' ), ENCUESTA_VERSION );
        }
        */
    }
}
function MarketPlace() {
    return MarketPlace::instance();
}
MarketPlace();

ob_end_flush();
