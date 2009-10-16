<?php include('inc/functions.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>WP-Twitter - BookMaklert</title>
<link rel="stylesheet" type="text/css" media="screen" href="inc/styles.css">
<style type="text/css">
body{
	font-family: verdana;
	color: #333;
	font-size: 11px;
	background: #FEEDD9;
}
#topSection{
	padding: 0 0 5px 0;
	position: fixed;
	top: 0;
	left: 0;
	background: #FEEDD9;
	opacity: 0.95;
	border-bottom: 1px solid #000;

}
</style>
</head>
<body>
<div id="topSection">
<div class="header"><span style="margin-left:30px"><input id="submit" type="Submit" value="<?php _e('Recent', 'wp-twitter') ?>" onclick="window.location.href='timeline.php'" /> <input id="submit" type="Submit" value="<?php _e('Mentions', 'wp-twitter') ?>" onclick="window.location.href='replies.php'" />  <input id="submit" type="Submit" value="<?php _e('Direct', 'wp-twitter') ?>" onclick="window.location.href='inbox.php'" /> <input id="submit" style="background: #D7932D" type="Submit" value="<?php _e('Archive', 'wp-twitter') ?>" onclick="window.location.href='user.php'" /> </span></div></div>
<p style="margin:24px 0 0 0">&nbsp;</p>
<?php
$tweets = "http://twitter.com/statuses/user_timeline.xml?count=25";

$tw = curl_init();
curl_setopt($tw, CURLOPT_URL, $tweets);
curl_setopt($tw, CURLOPT_USERPWD, "$username:$password");
curl_setopt($tw, CURLOPT_RETURNTRANSFER, TRUE);

$twi = curl_exec($tw);
$tweeters = new SimpleXMLElement($twi);
$latesttweets = count($tweeters);

//echo the data
foreach ($tweeters->status as $twit1) {
//This finds any links in $description
$data1 = date("G:i F j, Y",strtotime($twit1->created_at));

$description = $twit1->text;

$description = preg_replace("#(^|[\n ])@([^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://www.twitter.com/\\2\" target=\"_blank\">@\\2</a>'", $description);  
$description = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\2\" target=\"_blank\">\\2</a>'", $description);
$description = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>'", $description);

echo "<div class='user'><img border=\"0\" class=\"twitter_followers\" src=\"", $twit1->user->profile_image_url, "\"  width=\"48\" height=\"48\" />\n";
echo "<div class='name'><a class=\"name1\" href=\"http://www.twitter.com/", $twit1->user->screen_name,"\" target=\"_blank\" title=\"", $twit1->user->name,"\" \">", $twit1->user->screen_name,"</a></div>";
echo "<div class='text'>".$description." </div>";
echo "<hr><div class='description'><a href=\"http://www.twitter.com/", $twit1->user->screen_name,"/status/", $twit1->id,"\" target=\"_blank\"> ".$data1."</a> from ", $twit1->source,"</div></div>";}

curl_close($tw);
?>

<p style="margin:10px 0 0 130px"><small>Powered by <a href="http://webmais.com/wp-twitter" target="_blank" title="(( WP Twiterr ))">(( WP Twiterr ))</a></small></p>


</body>
</html>