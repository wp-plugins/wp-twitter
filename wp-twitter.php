<?php
/*
Plugin Name: WP Twitter
Description: Is a plugin that creates a complete integration between your WordPress blog and your Twitter account including a Twitter Button and Widgets.
Version: 3.8.5
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
define('FDX1_PLUGIN_VERSION', '3.8.5' );
define('FDX1_PLUGIN_URL', plugin_dir_url(__FILE__));

define('FDX1_WPPAGE', 'http://wordpress.org/extend/plugins/wp-twitter');
define('FDX1_PLUGINPAGE', 'http://fabrix.net/wp-twitter');
define('FDX1_GLOTPRESS', 'http://translate.fabrix.net/projects/wp-twitter');
define('FDX1_SUPFORUM', 'http://wmais.in/?forum=wp-twitter');
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



 function fdx_1_init() {
    if (is_admin() && current_user_can('administrator')) {
      add_action( 'admin_menu', 'fdx_admin_add_page' );
      //------------------------------
       if ( isset( $_GET['page'] ) && $_GET['page'] == FDX1_PLUGIN_P1 || isset( $_GET['page'] ) && $_GET['page'] == FDX1_PLUGIN_P2 || isset( $_GET['page'] ) && $_GET['page'] == FDX1_PLUGIN_P3)  {
           add_action('admin_enqueue_scripts', 'fdx_1_enqueue_scripts');
           }
 }
add_filter('the_content', 'filter_wp_twitter_fdx_profile');
add_filter('the_content', 'filter_wp_twitter_fdx_search');

add_filter('the_content', 'filter_wp_twitter_fdx_tweet_button_show', 1);
add_filter('the_excerpt', 'filter_wp_twitter_fdx_tweet_button_show', 1);

add_action( 'draft_to_publish', 'fdx_updater_published', 1, 1 );
add_action( 'new_to_publish', 'fdx_updater_published', 1, 1 );
add_action( 'pending_to_publish', 'fdx_updater_published', 1, 1 );
add_action( 'future_to_publish', 'fdx_updater_published', 1, 1 );
add_action( 'publish_to_publish', 'fdx_updater_edited', 1, 1 );
add_action( 'admin_init', 'fdx_updater_admin_init' );

add_action('wp_head', 'fdx_sharethis_script' );
add_action('wp_footer', 'filter_wp_twitter_fdx_tweet_button_show');
}

/* Loads CSS or JS
*------------------------------------------------------------*/
function fdx_1_enqueue_scripts() {
      wp_enqueue_style('fdx-css', FDX1_PLUGIN_URL . 'css/fdx-inc.css', array(), FDX1_PLUGIN_VERSION);
      wp_enqueue_script('wpcore-js', admin_url() . 'load-scripts.php?c=0&amp;load=jquery-ui-core,jquery-ui-widget,jquery-ui-mouse,jquery-ui-sortable,postbox,post', array(), FDX1_PLUGIN_VERSION, true);
      wp_enqueue_script('fdx-js', FDX1_PLUGIN_URL . 'js/fdx-inc.js', array(), FDX1_PLUGIN_VERSION, true);
   if ( isset( $_GET['page'] ) && $_GET['page'] == FDX1_PLUGIN_P2)  {
 	  wp_enqueue_style('fdx-colorpicker', FDX1_PLUGIN_URL . 'css/colorpicker.css', array(), FDX1_PLUGIN_VERSION);
      wp_enqueue_script('fdx-colorpicker', FDX1_PLUGIN_URL . 'js/colorpicker.js', array(), FDX1_PLUGIN_VERSION, true);
      wp_enqueue_script('fdx-goodies', FDX1_PLUGIN_URL . 'js/goodies.js', array(), FDX1_PLUGIN_VERSION, true);
    }
 }


/*
*------------------------------------------------------------*/
require_once( dirname(__FILE__) . '/libs/twitteroauth.php' );
require_once( dirname(__FILE__) . '/admin/settings_connect.php' );
require_once( dirname(__FILE__) . '/admin/settings.php' );
require_once( dirname(__FILE__) . '/admin/widgets.php' );
require_once( dirname(__FILE__) . '/admin/integration.php' );

/*
*------------------------------------------------------------*/
function fdx_admin_add_page(){
	add_menu_page('',FDX1_PLUGIN_NAME, 'manage_options', FDX1_PLUGIN_P1, 'fdx_updater_options_page', FDX1_PLUGIN_URL . '/images/menu.png' );
    add_submenu_page(FDX1_PLUGIN_P1, __('Basic Settings and Connect', 'fdx-lang'), __('Settings', 'fdx-lang'), 'manage_options', FDX1_PLUGIN_P1, 'fdx_updater_options_page');
    add_submenu_page(FDX1_PLUGIN_P1, __('Widgets Settings', 'fdx-lang'), __('Widgets', 'fdx-lang'), 'manage_options', FDX1_PLUGIN_P2, 'wp_twitter_fdx_options_page');
    add_submenu_page(FDX1_PLUGIN_P1, __('Sharethis Button Integration', 'fdx-lang'), __('Integration', 'fdx-lang'), 'manage_options', FDX1_PLUGIN_P3, 'wp_twitter_fdx_social');
  }

/* Widget_profile
*------------------------------------------------------------*/
class FDX_Widget_profile extends WP_Widget {

	function __construct() {
		$widget_options = array('classname' => 'widget_wp_twitter_fdx_profile', 'description' => __('Display Twitter Profile Widget', 'fdx-lang') );
		parent::__construct('fdxprofile',FDX1_PLUGIN_NAME. ' - '.__('Profile Widget', 'fdx-lang'), $widget_options);
	}

	function widget($args) {
	extract($args);
	$wp_twitter_fdx_widget_title1 = get_option('wp_twitter_fdx_widget_title');
	echo $before_widget;
	echo $before_title . $wp_twitter_fdx_widget_title1 . $after_title;
    echo wp_twitter_fdx_profile();
    echo $after_widget;
	}

    function form() {
    echo __('Please go to', 'fdx-lang').': <b><a href="'. admin_url('admin.php?page='.FDX1_PLUGIN_P2).'">'. FDX1_PLUGIN_NAME . ' | Widgets</a></b> '. __('for options.', 'fdx-lang');
	}
}

// Widget_search
class FDX_Widget_search extends WP_Widget {

	function __construct() {
		$widget_options = array('classname' => 'widget_wp_twitter_fdx_search', 'description' => __('Display Twitter Search Widget', 'fdx-lang') );
		parent::__construct('fdxsearch',FDX1_PLUGIN_NAME. ' - '.__('Search Widget', 'fdx-lang'), $widget_options);
	}

	function widget($args) {
	extract($args);
	$wp_twitter_fdx_widget_title1 = get_option('wp_twitter_fdx_search_widget_sidebar_title');
	echo $before_widget;
	echo $before_title . $wp_twitter_fdx_widget_title1 . $after_title;
    echo wp_twitter_fdx_search();
    echo $after_widget;
	}

    function form() {
    echo __('Please go to', 'fdx-lang').': <b><a href="'. admin_url('admin.php?page='.FDX1_PLUGIN_P2).'">'. FDX1_PLUGIN_NAME . ' | Widgets</a></b> '. __('for options.', 'fdx-lang');
	}
}


function fdx_widgets_init() {
	register_widget('FDX_Widget_profile');
 	register_widget('FDX_Widget_search');
    //------------------------------
	do_action('widgets_init');
}


/* clean-up when deactivated
*------------------------------------------------------------*/
function fdx_1_deactivate() {
//Settings
delete_option('fdx_updater_auth');
delete_option('fdx_updater_options');

//Sharethis Button integration
delete_option('wp_twitter_fdx_tweet_button_display_single');
delete_option('wp_twitter_fdx_tweet_button_display_page');
delete_option('wp_twitter_fdx_tweet_button_display_home');
delete_option('wp_twitter_fdx_tweet_button_display_arquive');
delete_option('wp_twitter_copynshare');
delete_option('wp_twitter_fdx_tweet_button_place');
delete_option('wp_twitter_fdx_tweet_button_style');
delete_option('wp_twitter_fdx_tweet_button_choose');
delete_option('wp_twitter_fdx_tweet_button_container');
delete_option('wp_twitter_fdx_tweet_button_twitter_username');
delete_option('wp_twitter_fdx_logo_top');
delete_option('wp_twitter_fdx_tweet_button_style2');
delete_option('wp_twitter_fdx_tweet_button_style3');
delete_option('wp_twitter_fdx_services');

//widgets
delete_option('wp_twitter_fdx_widget_title');
delete_option('wp_twitter_fdx_username');
delete_option('wp_twitter_fdx_height');
delete_option('wp_twitter_fdx_width');
delete_option('wp_twitter_fdx_scrollbar');
delete_option('wp_twitter_fdx_behavior');
delete_option('wp_twitter_fdx_shell_bg');
delete_option('wp_twitter_fdx_shell_text');
delete_option('wp_twitter_fdx_tweet_bg');
delete_option('wp_twitter_fdx_tweet_text');
delete_option('wp_twitter_fdx_links');

delete_option('wp_twitter_fdx_search_widget_sidebar_title');
delete_option('wp_twitter_fdx_widget_search_query');
delete_option('wp_twitter_fdx_widget_search_title');
delete_option('wp_twitter_fdx_widget_search_caption');
delete_option('wp_twitter_fdx_search_height');
delete_option('wp_twitter_fdx_search_width');
delete_option('wp_twitter_fdx_search_scrollbar');
delete_option('wp_twitter_fdx_search_shell_bg');
delete_option('wp_twitter_fdx_search_shell_text');
delete_option('wp_twitter_fdx_search_tweet_bg');
delete_option('wp_twitter_fdx_search_tweet_text');
delete_option('wp_twitter_fdx_search_links');
 }

add_action('init', 'fdx_1_init');
add_action('init', 'fdx_widgets_init', 1);

register_deactivation_hook( __FILE__, 'fdx_1_deactivate'); // when deativated clean up
?>