<?php
require_once('../../../../wp-load.php');
class Twitter_API {

//Sends HTTP requests for other functions.
private function send_request($url, $method='GET', $data='', $auth_user='', $auth_pass='') {

	if ($this->oauth_on && $auth_user != '') {
		$response = $this->oauth_request($url, $method, $auth_user, $auth_pass, $data);
	}
	else {
		$ch = curl_init($url);
		if (strtoupper($method)=="POST") {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		if (ini_get('open_basedir') == '' && ini_get('safe_mode') == 'Off'){
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		}
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if ($auth_user != '' && $auth_pass != '') {
			curl_setopt($ch, CURLOPT_USERPWD, "{$auth_user}:{$auth_pass}");
		}
		$response = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if ($httpcode != 200) {
			return $httpcode;
		}
	}
	return $response;

}


public function shorten_url($the_url) {

$shortuser1	= get_option('wp_short_user1');
$shortuser2	= get_option('wp_short_user2');

$setting_url_shortener = get_option('wp-url-shortener') != '' ? get_option('wp-url-shortener') : "tinyurl.com";
global $ManualOrRandom;
$ManualOrRandom = $setting_url_shortener;
switch ($ManualOrRandom){
  case "tinyurl.com":
      $url = "http://tinyurl.com/api-create.php?url={$the_url}";
      break;
  case "su.pr":
       $url = "http://su.pr/api/simpleshorten?url={$the_url}";
      break;
 case "u.nu":
       $url = "http://u.nu/unu-api-simple?url={$the_url}";
      break;
 case "cli.gs":
       $url= "http://cli.gs/api/v1/cligs/create?key={$shortuser1}&appid=URLBarExt&url={$the_url}"; 
      break; 
case "redir.ec":  
       $url = "http://redir.ec/_api/rest/redirec/create?url={$the_url}&appid=wp-twitter&apikey={$shortuser2}"; 
      break;   
case "is.gd":  
       $url = "http://is.gd/api.php?longurl={$the_url}"; 
      break;
	  case "th8.us":  
       $url = "http://th8.us/api.php?url={$the_url}"; 
      break;

 default:
       $url = "http://tinyurl.com/api-create.php?url={$postlink}";
      break;
  }


 $response = $this->send_request($url, 'GET');
	return $response;
}


}

if(!empty($_POST)) {
 $twitter = new Twitter_API();

	switch($_POST['do']) {
	
	case 'shorten-url':
			$theurl = rawurlencode($_POST['theurl']);
			$shorturl = $twitter->shorten_url($theurl);
			echo $shorturl;
		break;
			
		default:
			return FALSE;
		break;
	
	}

}

?>