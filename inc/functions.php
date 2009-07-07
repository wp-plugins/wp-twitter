<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php'); 
$username = get_option('wp_twitter_username');
$password = get_option('wp_twitter_pw');

$currentLocale = get_locale();
			if(!empty($currentLocale)) {
				$moFile = dirname(__FILE__) . "/lang/wp-twitter-" . $currentLocale . ".mo";
				if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('wp-twitter', $moFile);
			}
			
// login
ini_set('display_errors', 1);
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-config.php'); 
global $user_ID;

$wp_user = new WP_User($user_ID);
if (true == empty($wp_user) || $wp_user->ID < 1) {

wp_die("<strong>Requires <a href='".bloginfo('wpurl')."/wp-login.php'>login</a> to access this page</strong>");
}
?>
