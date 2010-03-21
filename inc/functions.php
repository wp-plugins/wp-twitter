<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php'); 
$username = get_option('wp_twitter_username');
$password = get_option('wp_twitter_pw');

$currentLocale = get_locale();
			if(!empty($currentLocale)) {
				$moFile = dirname(__FILE__) . "/lang/wp-twitter-" . $currentLocale . ".mo";
				if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('wp-twitter', $moFile);
			}
			
?>
