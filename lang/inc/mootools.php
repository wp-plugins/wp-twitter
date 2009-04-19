<?php
if(isset($_GET['url'])) 
{
	die(get_tiny_url(urldecode($_GET['url'])));
}

//http://tinyurl.com/api-create.php?url=
function get_tiny_url($url)  
{  
	$ch = curl_init();  
	$timeout = 5;              
	curl_setopt($ch,CURLOPT_URL,'http://is.gd/api.php?longurl='.$url);  
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
	$data = curl_exec($ch);  
	curl_close($ch);  
	return $data;  
}
?>