<?php ob_start();

if ( ! defined( 'ABSPATH' ) ) exit;
add_action( 'wp_enqueue_scripts', 'marketplace_enqueue_styles', 15 );
add_action( 'wp_enqueue_scripts', 'marketplace_enqueue_scripts', 10 );
add_action( 'admin_enqueue_scripts', 'marketplace_admin_enqueue_scripts', 10, 1 );
add_action( 'admin_enqueue_scripts', 'marketplace_admin_enqueue_styles', 10, 1 );
function marketplace_enqueue_styles() {
    wp_register_style( 'marketplace-desoslide', plugins_url( 'marketplace/assets/css/jquery.desoslide.css' ), array(), MARKETPLACE_VERSION );
    wp_enqueue_style( 'marketplace-desoslide' );
    wp_register_style( 'marketplace-sweetalert2', plugins_url( 'marketplace/assets/sweetalert2/sweetalert2.css' ), array(), MARKETPLACE_VERSION );
    wp_enqueue_style( 'marketplace-sweetalert2' );
    wp_register_style( 'marketplace-frontend', plugins_url( 'marketplace/assets/css/frontend.css' ), array(), MARKETPLACE_VERSION );
    wp_enqueue_style( 'marketplace-frontend' );
    wp_register_style( 'marketplace-star', plugins_url( 'marketplace/assets/css/star-rating.min.css' ), array(), MARKETPLACE_VERSION );
    wp_enqueue_style( 'marketplace-star' );
}

function marketplace_enqueue_scripts() {
    wp_register_script( 'marketplace-jqueryrut', plugins_url( 'marketplace/assets/js/jquery.rut.js' ), array( 'jquery' ), '1.13.1', true );
    wp_enqueue_script( 'marketplace-jqueryrut');
    wp_register_script( 'marketplace-desoslide', plugins_url( 'marketplace/assets/js/jquery.desoslide.min.js' ), array( 'jquery' ), '1.13.1', true );
    wp_enqueue_script( 'marketplace-desoslide');
    wp_register_script( 'marketplace-sweetalert2', plugins_url( 'marketplace/assets/sweetalert2/sweetalert2.min.js' ), array( 'jquery' ), '1.13.1', true );
    wp_enqueue_script( 'marketplace-sweetalert2');
    wp_register_script( 'marketplace-validate', plugins_url( 'marketplace/assets/js/jquery.validate.min.js' ), array( 'jquery' ), '1.13.1', true );
    wp_enqueue_script( 'marketplace-validate' );
    wp_register_script( 'marketplace-truncate', plugins_url( 'marketplace/assets/js/trunk8.js' ), array( 'jquery', 'underscore' ), MARKETPLACE_VERSION, true );
    wp_enqueue_script( 'marketplace-truncate' );
    wp_register_script( 'marketplace-star', plugins_url( 'marketplace/assets/js/star-rating.min.js' ), array( 'jquery', 'underscore' ), MARKETPLACE_VERSION, true );
    wp_enqueue_script( 'marketplace-star' );
    wp_register_script( 'marketplace-frontend', plugins_url( 'marketplace/assets/js/frontend.js' ), array( 'jquery', 'underscore' ), MARKETPLACE_VERSION, true );
    wp_enqueue_script( 'marketplace-frontend' );
}

function marketplace_admin_enqueue_styles( $hook = '' ) {

    wp_register_style( 'marketplace-admin', plugins_url( 'marketplace/assets/css/admin.css' ), array(), MARKETPLACE_VERSION );
    wp_enqueue_style( 'marketplace-admin' );
}

function marketplace_admin_enqueue_scripts( $hook = '' ) {
    wp_register_script( 'marketplace-truncate', plugins_url( 'marketplace/assets/js/trunk8.js' ), array( 'jquery', 'underscore' ), MARKETPLACE_VERSION, true );
    wp_enqueue_script( 'marketplace-truncate' );
    wp_register_script( 'marketplace-admin', plugins_url( 'marketplace/assets/js/admin.js' ), array('jquery'), MARKETPLACE_VERSION, true);
    wp_enqueue_script( 'marketplace-admin' );
}

ob_end_flush();

