<?php
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

//Shorten long URLs with is.gd or bit.ly.
public function shorten_url($the_url) {

	if ($shortener=="is.gd") {
		$url = "http://is.gd/api.php?longurl={$the_url}";
		$response = $this->send_request($url, 'GET');
	} else {
		$url = "http://is.gd/api.php?longurl={$the_url}";
		$response = $this->send_request($url, 'GET');
	}
	return $response;

}

}

?>