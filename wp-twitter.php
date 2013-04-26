<?php
/*
 * Plugin Name: WP Twitter
 * Plugin URI: http://fabrix.net/wp-twitter
 * Description: Is a plugin that creates a complete integration between your WordPress blog and your Twitter account including a Twitter Button and Widgets.
 * Author: Fabrix DoRoMo
 * Version: 3.9
 * Author URI: http://fabrix.net
 * License: GPL2+
 * Text Domain: wp-twitter
 * Domain Path: /languages/
 */

include('compat.php' );  //???

define('FDX1_PLUGIN_NAME', 'WP Twitter' );
define('FDX1_PLUGIN_VERSION', '3.9' );
define('FDX1_PLUGIN_URL', plugin_dir_url(__FILE__));

define('FDX1_WPPAGE', 'http://wordpress.org/extend/plugins/wp-twitter');
define('FDX1_PLUGINPAGE', 'http://fabrix.net/wp-twitter');
define('FDX1_GLOTPRESS', 'http://translate.fabrix.net/projects/wp-twitter');
define('FDX1_SUPFORUM', 'http://wordpress.org/support/plugin/wp-twitter');
define('FDX1_DONATELINK', 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Z9SRNRLLDAFZJ');

define('FDX1_PLUGIN_P1', 'wp-twitter' ); //link1, plugin prefix (.mo)
define('FDX1_PLUGIN_P2', 'wp-twitter-widgets' ); //link2
define('FDX1_PLUGIN_P3', 'wp-twitter-integration' ); //link3

/* Locale
*------------------------------------------------------------*/
function fdx1_lang_init(){
load_plugin_textdomain('wp-twitter', false, dirname(plugin_basename( __FILE__ )).'/languages');
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

/*add_action( 'draft_to_publish', 'fdx_updater_published', 1, 1 );
add_action( 'new_to_publish', 'fdx_updater_published', 1, 1 );
add_action( 'pending_to_publish', 'fdx_updater_published', 1, 1 );
add_action( 'future_to_publish', 'fdx_updater_published', 1, 1 );
add_action( 'publish_to_publish', 'fdx_updater_edited', 1, 1 );
add_action( 'admin_init', 'fdx_updater_admin_init' );*/

add_action('wp_head', 'fdx_sharethis_script' );
add_action('wp_footer', 'filter_wp_twitter_fdx_tweet_button_show');
}


/* Loads CSS or JS
*------------------------------------------------------------*/
function fdx_1_enqueue_scripts() {
      wp_enqueue_style('fdx-css', FDX1_PLUGIN_URL . '_inc/fdx-inc.css', array(), FDX1_PLUGIN_VERSION);
      wp_enqueue_script('wpcore-js', admin_url() . 'load-scripts.php?c=0&amp;load=jquery-ui-core,jquery-ui-widget,jquery-ui-mouse,jquery-ui-sortable,postbox,post', array(), FDX1_PLUGIN_VERSION, true);
      wp_enqueue_script('fdx-js', FDX1_PLUGIN_URL . '_inc/fdx-inc.js', array(), FDX1_PLUGIN_VERSION, true);
   if ( isset( $_GET['page'] ) && $_GET['page'] == FDX1_PLUGIN_P2)  {
 	  wp_enqueue_style('fdx-colorpicker', FDX1_PLUGIN_URL . '_inc/colorpicker.css', array(), FDX1_PLUGIN_VERSION);
      wp_enqueue_script('fdx-colorpicker', FDX1_PLUGIN_URL . '_inc/colorpicker.js', array(), FDX1_PLUGIN_VERSION, true);
      wp_enqueue_script('fdx-goodies', FDX1_PLUGIN_URL . '_inc/goodies.js', array(), FDX1_PLUGIN_VERSION, true);
    }
 }


/*
*------------------------------------------------------------*/
require_once( dirname(__FILE__) . '/modules/p2.php' );
require_once( dirname(__FILE__) . '/modules/p3.php' );


/* P1-Settings Connect
*------------------------------------------------------------*/
require_once( dirname(__FILE__) . '/modules/p1/xml.php' );
require_once( dirname(__FILE__) . '/modules/p1/oauth-twitter.php' );


/* P1-Settings Connect
*------------------------------------------------------------*/
require_once( dirname(__FILE__) . '/modules/p1-function.php' );



/*function fdx1_add_plugin_option() {
	if ( function_exists( 'add_options_page' ) ) {
		add_menu_page( 'nome do plugin', 'nome do plugin2', 'manage_options', basename(__FILE__), 'fdx1_options_subpanel' );
    }
}*/



/*
*------------------------------------------------------------*/
function fdx_admin_add_page(){
	add_menu_page('',FDX1_PLUGIN_NAME, 'manage_options', FDX1_PLUGIN_P1, 'fdx1_options_subpanel', FDX1_PLUGIN_URL . '/_inc/images/menu.png' );
    add_submenu_page(FDX1_PLUGIN_P1, __('Basic Settings and Connect', 'wp-twitter'), __('Settings', 'wp-twitter'), 'manage_options', FDX1_PLUGIN_P1, 'fdx1_options_subpanel');
    add_submenu_page(FDX1_PLUGIN_P1, __('Widgets Settings', 'wp-twitter'), __('Widgets', 'wp-twitter'), 'manage_options', FDX1_PLUGIN_P2, 'wp_twitter_fdx_options_page');
    add_submenu_page(FDX1_PLUGIN_P1, __('Sharethis Button Integration', 'wp-twitter'), __('Integration', 'wp-twitter'), 'manage_options', FDX1_PLUGIN_P3, 'wp_twitter_fdx_social');
  }


/* P1-Settings Connect
*------------------------------------------------------------*/
function fdx1_options_subpanel() {
include( dirname(__FILE__) . '/modules/p1.php' );
}

/* Widget_profile
*------------------------------------------------------------*/
class FDX_Widget_profile extends WP_Widget {

	function __construct() {
		$widget_options = array('classname' => 'widget_wp_twitter_fdx_profile', 'description' => __('Display Twitter Profile Widget', 'wp-twitter') );
		parent::__construct('fdxprofile',FDX1_PLUGIN_NAME. ' - '.__('Profile Widget', 'wp-twitter'), $widget_options);
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
    echo __('Please go to', 'wp-twitter').': <b><a href="'. admin_url('admin.php?page='.FDX1_PLUGIN_P2).'">'. FDX1_PLUGIN_NAME . ' | Widgets</a></b> '. __('for options.', 'wp-twitter');
	}
}

// Widget_search
class FDX_Widget_search extends WP_Widget {

	function __construct() {
		$widget_options = array('classname' => 'widget_wp_twitter_fdx_search', 'description' => __('Display Twitter Search Widget', 'wp-twitter') );
		parent::__construct('fdxsearch',FDX1_PLUGIN_NAME. ' - '.__('Search Widget', 'wp-twitter'), $widget_options);
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
    echo __('Please go to', 'wp-twitter').': <b><a href="'. admin_url('admin.php?page='.FDX1_PLUGIN_P2).'">'. FDX1_PLUGIN_NAME . ' | Widgets</a></b> '. __('for options.', 'wp-twitter');
	}
}

function fdx_widgets_init() {
	register_widget('FDX_Widget_profile');
 	register_widget('FDX_Widget_search');
}


/* P1-Settings Connect
*------------------------------------------------------------*/
add_action( 'publish_post', 'fdx1_post_now_published' );
add_filter( 'init', 'fdx1_init');
//--------------------
add_action('init', 'fdx_1_init');
add_action('init', 'fdx_widgets_init', 1);
add_action('init', 'fdx1_lang_init');
?>