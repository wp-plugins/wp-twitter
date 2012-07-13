<?php
//carregar javascript e css
function fdx_load_custom_admin(){
        wp_register_style( 'custom_wp_admin_css', FDX_PLUGIN_U1. '/css/admin.css', false, FDX_PLUGIN_V1 );
        wp_enqueue_script( 'custom_wp_admin_js', FDX_PLUGIN_U1. '/js/admin.js', false, FDX_PLUGIN_V1 );

        wp_enqueue_style( 'custom_wp_admin_css' );
        wp_enqueue_script( 'custom_wp_admin_js' );
}
add_action('admin_enqueue_scripts', 'fdx_load_custom_admin');
?>