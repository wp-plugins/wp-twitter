<?php
/*
Plugin Name: WP Twitter
Description: Is a plugin that creates a complete integration between your WordPress blog and your Twitter account including a Twitter Button and Widgets.
Version: 3.0
Author: Fabrix DoRoMo
Author URI: http://fabrix.net
Plugin URI: http://wordpress.webmais.com/wp-twitter

*/

//The minimum version of WordPress and php for notices
define('FDX1_MINIMUM_WP_VER', '3.4.1');
define('FDX1_MINIMUM_PHP_VER', '5.0.0');

//testar e remover para func
$currentLocale = get_locale();
			if(!empty($currentLocale)) {
				$moFile = dirname(__FILE__) . "/languages/wp-twitter-" . $currentLocale . ".mo";
				if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('fdx-lang', $moFile);
			}


define('FDX_PLUGIN_N1', 'WP Twitter' ); //plugin name
define('FDX_PLUGIN_P1', 'wp-twitter' ); //plugin prefix
define('FDX_PLUGIN_V1', '3.0' ); // plugin version
define('FDX_PLUGIN_U1', plugins_url('', __FILE__) ); // plugin URL


//CARREGA AS FUNÇÕS
require_once( dirname(__FILE__) . '/admin/functions.php' );

require_once( dirname(__FILE__) . '/admin/page-1.php' );

require_once( dirname(__FILE__) . '/admin/page-2.php' );


/* Add the Admin Options Page to the Settings Menu */
function fdx_admin_add_page() {
	add_menu_page(' ',FDX_PLUGIN_N1, 'manage_options', FDX_PLUGIN_P1, 'fdx_updater_options_page', FDX_PLUGIN_U1 . '/images/menu_fdx.png' );
    add_submenu_page(FDX_PLUGIN_P1, __('Basic Settings and Connect', 'fdx-lang'), __('Settings', 'fdx-lang'), 'manage_options', FDX_PLUGIN_P1, 'fdx_updater_options_page');
    add_submenu_page(FDX_PLUGIN_P1, __('Integration and Widget', 'fdx-lang'), __('Integration', 'fdx-lang'), 'manage_options', 'integration', 'wp_twitter_fdx_options_page');
}
add_action( 'admin_menu', 'fdx_admin_add_page' );

add_action( 'admin_init', 'fdx_updater_admin_init' );



/*** WordPress Hooks ***/


/* Action for when a post is published */
	add_action( 'draft_to_publish', 'fdx_updater_published', 1, 1 );
	add_action( 'new_to_publish', 'fdx_updater_published', 1, 1 );
	add_action( 'pending_to_publish', 'fdx_updater_published', 1, 1 );
	add_action( 'future_to_publish', 'fdx_updater_published', 1, 1 );

/* Action when post is updated */
	add_action( 'publish_to_publish', 'fdx_updater_edited', 1, 1 );


/* Intialise on first activation */
	register_activation_hook( __FILE__, 'fdx_updater_activate' );


/* Add settings link on plugins admin page */
function fdx_updater_add_settings_link( $links ) {
	$settings_link = '<a href="' . admin_url( 'admin.php?page=wp-twitter' ) . '">' . __( 'Settings', 'fdx-lang' ) . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}
 	$plugin = plugin_basename(__FILE__);
	add_filter("plugin_action_links_$plugin", 'fdx_updater_add_settings_link' );
?>
