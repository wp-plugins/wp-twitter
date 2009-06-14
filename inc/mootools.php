<?php
if(isset($_GET['url'])) 
{
	die(get_tiny_url(urldecode($_GET['url'])));
}

// http://tinyurl.com/api-create.php?url=
// http://is.gd/api.php?longurl=
function get_tiny_url($url)  
{  
	$ch = curl_init();  
	$timeout = 5;              
	curl_setopt($ch,CURLOPT_URL,'http://u.nu/unu-api-simple?url='.$url);  
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
	$data = curl_exec($ch);  
	curl_close($ch);  
	return $data;  
}
?>