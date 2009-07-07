<?php
require_once('../../../wp-load.php');
require_once('mh_twitter_class.php');

if(!empty($_POST)) {
 $twitter = new Twitter_API();

	switch($_POST['do']) {
	
	case 'shorten-url':
			$theurl = rawurlencode($_POST['theurl']);
			$shortener = get_option('tweetable_url_shortener');
			$shorturl = $twitter->shorten_url($theurl, $shortener);
			echo $shorturl;
		break;
			
		default:
			return FALSE;
		break;
	
	}

}

?>