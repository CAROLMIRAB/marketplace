<?php ob_start();

function marketplace_activation() {
    marketplace_database_install();
}

register_activation_hook( MARKETPLACE_PLUGIN_FILE, 'marketplace_activation' );


ob_end_flush();
