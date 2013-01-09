<?php
include("Twitter.class.php");
$twitter = new Twitter();

$username = $_REQUEST["user"];

$json = $twitter->show('json', $username);
$user = json_decode($json);

$image_url = $user->profile_image_url;
header("Location: ".$image_url);
?>