<?php
/*
Plugin Name: WP Twitter
Description: Is a plugin that creates a complete integration between your WordPress blog and your Twitter account including a Twitter Button and Widgets.
Version: 3.6.1
Author: Fabrix DoRoMo
Author URI: http://fabrix.net
Plugin URI: http://fabrix.net/wp-twitter
*/
/*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/*********************************************************************************/
define('FDX1_PLUGIN_NAME', 'WP Twitter' );
define('FDX1_PLUGIN_VERSION', '3.6.1' );
define('FDX1_PLUGIN_URL', plugin_dir_url(__FILE__));

define('FDX1_WPPAGE', 'http://wordpress.org/extend/plugins/wp-twitter/');
define('FDX1_PLUGINPAGE', 'http://fabrix.net/wp-twitter/');
define('FDX1_GLOTPRESS', 'http://translate.fabrix.net/projects/wp-twitter/');
define('FDX1_SUPFORUM', 'http://wmais.in/?forum=wp-twitter/');
define('FDX1_DONATELINK', 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Z9SRNRLLDAFZJ');

define('FDX1_PLUGIN_P1', 'wp-twitter' ); //link1, plugin prefix (.mo)
define('FDX1_PLUGIN_P2', 'wp-twitter-widgets' ); //link2
define('FDX1_PLUGIN_P3', 'wp-twitter-integration' ); //link3
/*
*------------------------------------------------------------*/
$currentLocale = get_locale();
			if(!empty($currentLocale)) {
				$moFile = dirname(__FILE__) . "/languages/".FDX1_PLUGIN_P1."-" . $currentLocale . ".mo";
				if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('fdx-lang', $moFile);
}

/*
*------------------------------------------------------------*/
require_once( dirname(__FILE__) . '/admin/page-1.php' );
require_once( dirname(__FILE__) . '/admin/page-2.php' );
require_once( dirname(__FILE__) . '/admin/page-3.php' );

/*
*------------------------------------------------------------*/
function fdx_admin_add_page(){
  if (function_exists('add_menu_page')) {
	add_menu_page(' ',FDX1_PLUGIN_NAME, 'manage_options', FDX1_PLUGIN_P1, 'fdx_updater_options_page', FDX1_PLUGIN_URL . '/images/menu.png' );
    add_submenu_page(FDX1_PLUGIN_P1, __('Basic Settings and Connect', 'fdx-lang'), __('Settings', 'fdx-lang'), 'manage_options', FDX1_PLUGIN_P1, 'fdx_updater_options_page');
    add_submenu_page(FDX1_PLUGIN_P1, __('Widgets Settings', 'fdx-lang'), __('Widgets', 'fdx-lang'), 'manage_options', FDX1_PLUGIN_P2, 'wp_twitter_fdx_options_page');
    add_submenu_page(FDX1_PLUGIN_P1, __('Sharethis Button Integration', 'fdx-lang'), __('Integration', 'fdx-lang'), 'manage_options', FDX1_PLUGIN_P3, 'wp_twitter_fdx_social');
     }
  }
add_action( 'admin_menu', 'fdx_admin_add_page' );

/* ADICIONA JS E CSS EM PAGINAS ESPECIFICAS DO ADM
*------------------------------------------------------------*/
function fdx_admin_files() {
	if ( isset( $_GET['page'] ) && $_GET['page'] == FDX1_PLUGIN_P1 ||
         isset( $_GET['page'] ) && $_GET['page'] == FDX1_PLUGIN_P2 ||
         isset( $_GET['page'] ) && $_GET['page'] == FDX1_PLUGIN_P3 ) {
       echo "<link rel='stylesheet' type='text/css' href='" . FDX1_PLUGIN_URL . "/css/fdx-inc.css' />\n";
       echo "<link rel='stylesheet' type='text/css' href='" . FDX1_PLUGIN_URL . "/css/colorpicker.css' />\n";
       echo "<script type='text/javascript' src='" . FDX1_PLUGIN_URL . "/js/fdx-inc.js'></script>\n";
	}
}
add_action( 'admin_head', 'fdx_admin_files' );


?>