<?php
/*
 * Plugin Name: WP Twitter
 * Plugin URI: http://fabrix.net/wp-twitter
 * Description: Is a plugin that creates a complete integration between your WordPress blog and your Twitter account including a Twitter Button and Widgets.
 * Author: Fabrix DoRoMo
 * Version: 3.9.2
 * Author URI: http://fabrix.net
 * License: GPL2+
 * Text Domain: wp-twitter
 * Domain Path: /languages/
 */

class WP_Twitter {
    const PLUGIN_VERSION = '3.9.2';
    const PLUGIN_NAME = 'WP Twitter';
    const PLUGIN_P1 = 'wp-twitter-p1';
    const PLUGIN_P2 = 'wp-twitter-p2';
    const PLUGIN_P3 = 'wp-twitter-p3';

	function __construct() {
		load_plugin_textdomain( 'wp-twitter', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
        add_action( 'admin_menu', array( $this, 'action_menu_pages' ) );
      //-------------P3
        add_action('wp_head', 'fdx_sharethis_script' ) ;
        add_filter('the_content', 'filter_wp_twitter_fdx_tweet_button_show') ;
        add_filter('the_excerpt', 'filter_wp_twitter_fdx_tweet_button_show') ;
        add_action('wp_footer', 'filter_wp_twitter_fdx_tweet_button_show') ;
      //-------------P2
        add_action('init', 'fdx_widgets_init');
        add_filter('the_content',  'filter_wp_twitter_fdx_profile') ;
        add_filter('the_content',  'filter_wp_twitter_fdx_search') ;
      //-------------P1
        add_action('publish_post', 'fdx1_post_now_published'); // post
        add_action('publish_page', 'fdx1_post_now_published2');  // page
        add_filter( 'init', 'fdx1_init');
} // end constructor

public function register_admin_styles() {
	if ( isset( $_GET['page'] ) && $_GET['page'] == self::PLUGIN_P1 || isset( $_GET['page'] ) && $_GET['page'] == self::PLUGIN_P2 || isset( $_GET['page'] ) && $_GET['page'] == self::PLUGIN_P3)  {
	  wp_enqueue_style('admin-core', plugins_url( 'css/admin.css',__FILE__ ), array(), self::PLUGIN_VERSION );
    } if ( isset( $_GET['page'] ) && $_GET['page'] == self::PLUGIN_P2)  {
       wp_enqueue_style('colorpicker', plugins_url( 'css/colorpicker.css',__FILE__ ), array(), self::PLUGIN_VERSION );
    }
}

public function register_admin_scripts() {
    if ( isset( $_GET['page'] ) && $_GET['page'] == self::PLUGIN_P1 || isset( $_GET['page'] ) && $_GET['page'] == self::PLUGIN_P2 || isset( $_GET['page'] ) && $_GET['page'] == self::PLUGIN_P3)  {
      wp_enqueue_script('wpcore', admin_url() . 'load-scripts.php?c=0&amp;load=jquery-ui-core,jquery-ui-widget,jquery-ui-mouse,jquery-ui-sortable,postbox,post', array('jquery'));
      wp_enqueue_script('admin-core', plugins_url( 'js/admin.js',__FILE__ ), array(), self::PLUGIN_VERSION);
    } if ( isset( $_GET['page'] ) && $_GET['page'] == self::PLUGIN_P2)  {
      wp_enqueue_script('colorpicker', plugins_url( 'js/colorpicker.js',__FILE__ ), array(), self::PLUGIN_VERSION);
      wp_enqueue_script('goodies', plugins_url( 'js/goodies.js',__FILE__ ), array(), self::PLUGIN_VERSION);
   }
}


function action_menu_pages() {
   	add_menu_page('',self::PLUGIN_NAME, 'manage_options', self::PLUGIN_P1, array( $this, 'fdx1_options_subpanel' ),  plugins_url( '/images/menu.png',__FILE__ )  );
      add_submenu_page(self::PLUGIN_P1, __('Basic Settings and Connect', 'wp-twitter'), __('Settings', 'wp-twitter'), 'manage_options', self::PLUGIN_P1, array( $this, 'fdx1_options_subpanel' ));
      add_submenu_page(self::PLUGIN_P1, __('Widgets Settings', 'wp-twitter'), __('Widgets', 'wp-twitter'), 'manage_options', self::PLUGIN_P2, array( $this, 'wp_twitter_fdx_options_page'));
      add_submenu_page(self::PLUGIN_P1, __('Sharethis Button Integration', 'wp-twitter'), __('Integration', 'wp-twitter'), 'manage_options', self::PLUGIN_P3, array( $this, 'wp_twitter_fdx_social'));

	}


function fdx1_options_subpanel() {
include( dirname(__FILE__) . '/modules/p1.php' );
}

function wp_twitter_fdx_options_page() {
require_once dirname( __FILE__ ) . '/modules/p2.php';
}

function wp_twitter_fdx_social() {
require_once dirname( __FILE__ ) . '/modules/p3.php';
}
} // end class

/*
*------------------------------------------------------------*/
require_once dirname(__FILE__) . '/modules/p1/xml.php';
require_once dirname(__FILE__) . '/modules/p1/oauth-twitter.php';
require_once dirname(__FILE__) . '/modules/p1-function.php';
require_once dirname(__FILE__) . '/modules/p2-function.php';
require_once dirname(__FILE__) . '/modules/p3-function.php';



/* Widget_profile
*------------------------------------------------------------*/
class FDX_Widget_profile extends WP_Widget {

	function __construct() {
		$widget_options = array('classname' => 'widget_wp_twitter_fdx_profile', 'description' => __('Display Twitter Profile Widget', 'wp-twitter') );
		parent::__construct('fdxprofile',WP_Twitter::PLUGIN_NAME. ' - '.__('Profile Widget', 'wp-twitter'), $widget_options);
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
    echo __('Please go to', 'wp-twitter').': <b><a href="'. admin_url('admin.php?page='.WP_Twitter::PLUGIN_P2).'">'. WP_Twitter::PLUGIN_NAME . ' | Widgets</a></b> '. __('for options.', 'wp-twitter');
	}
}

/* Widget_search
*------------------------------------------------------------*/
class FDX_Widget_search extends WP_Widget {

	function __construct() {
		$widget_options = array('classname' => 'widget_wp_twitter_fdx_search', 'description' => __('Display Twitter Search Widget', 'wp-twitter') );
		parent::__construct('fdxsearch',WP_Twitter::PLUGIN_NAME. ' - '.__('Search Widget', 'wp-twitter'), $widget_options);
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
    echo __('Please go to', 'wp-twitter').': <b><a href="'. admin_url('admin.php?page='.WP_Twitter::PLUGIN_P2).'">'. WP_Twitter::PLUGIN_NAME . ' | Widgets</a></b> '. __('for options.', 'wp-twitter');
	}
}

function fdx_widgets_init() {
	register_widget('FDX_Widget_profile');
 	register_widget('FDX_Widget_search');
}

/* Update the instantiation call
*------------------------------------------------------------*/
$wp_twitter = new WP_Twitter();
