<?php include('inc/functions.php');
if ( $can_edit_posts = current_user_can( 'edit_posts' ) ) : ?>
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
	background: #94E4E8;
}
#topSection{
	padding: 0 0 5px 0;
	position: fixed;
	top: 0;
	left: 0;
	background: #94E4E8;
	opacity: 0.95;
	border-bottom: 1px solid #000;

}
</style>
<script type="text/javascript" src="<?php bloginfo('url'); ?>/wp-includes/js/jquery/jquery.js"></script>
<script type="text/javascript" src="/inc/admin_scripts.js"></script>
</head>
<body>
<div id="topSection">
<div class="header">&nbsp;&nbsp;&nbsp;<input id="submit" type="Submit" style="background: #D7932D" value="<?php _e('Recent', 'wp-twitter') ?>" onclick="window.location.href='timeline.php'" /> <input id="submit" type="Submit" value="<?php _e('Mentions', 'wp-twitter') ?>" onclick="window.location.href='replies.php'" />  <input id="submit" type="Submit" value="<?php _e('Direct', 'wp-twitter') ?>" onclick="window.location.href='inbox.php'" /> <input id="submit" type="Submit" value="<?php _e('Archive', 'wp-twitter') ?>" onclick="window.location.href='user.php'" /> </div></div>
<?php
require('inc/twitterAPI.php');
if(isset($_POST['tweet'])){
	$twitter_message=$_POST['tweet'];
	if(strlen($twitter_message)<1){
	$error=1;
	} else {
	$twitter_status=postToTwitter($username, $password, $twitter_message);
	}
}
?>
<a name="update"></a>
<p style="margin-top:25px">&nbsp;</p>
<script language="javascript">
function showDetails(){
details=document.getElementById('details')
if(details.style.display=='none'){
document.getElementById('details').style.display="block";
} else {
document.getElementById('details').style.display="none";
}
}
</script>
<p style="margin:0 0 0 160px"><a href="#" onclick="javascript:showDetails();" title="<?php _e('Post: on/off', 'wp-twitter') ?>"><img src="inc/post.png" width="48" height="48" alt="Post" border="0" style="filter:alpha(opacity=100); ..-opacity:1.0; opacity:1.0; -khtml-opacity:1.0;"/></a></p>
<div class="msg"><?php echo $twitter_status ?></div>
<div id="details" style="display:none">
<form action="timeline.php" method="post" name="post-twitter">
<div class="updateform">
<p id="tweet-tools"><span id="twitter-tools" style="float:right; margin: 0 0 0 0;"><a href="#" id="shorten-url" title="<?php _e('Shorten Link', 'wp-twitter') ?>"><img src="inc/page_link.png" style="filter:alpha(opacity=100); ..-opacity:1.0; opacity:1.0; -khtml-opacity:1.0;" alt="Shorten Link" border="0"></a></span></p>
<h3><em>Twitter: <a href="http://www.twitter.com/<?php print get_option('wp_twitter_username'); ?>" target="_blank">@<?php print get_option('wp_twitter_username'); ?></a></em></h3>
<textarea name="tweet" type="text" id="tweet" rows="3" style="background: #fff;border: solid 1px black;width: 355px;" maxlength="140" onKeyDown="textCounter(this.form.tweet,this.form.remLen,140);" onKeyUp="textCounter(this.form.tweet,this.form.remLen,140);"></textarea>
<input type="hidden" name="do" id="do_action" value="update-status" />
<input type="hidden" name="post_to" id="post_to" value="<?php bloginfo('wpurl') ?>/form_post.php" />
	
<table border="0" cellpadding="0" cellspacing="0" width="355"><tr>
<td align="left"><input disabled readonly type="text" name="remLen" size="3" maxlength="3" style="font-size:10px; color:red" value="140"> <small><?php _e('characters left', 'wp-twitter') ?></small></td>
<td align="right"><input type="submit" name="button" id="submit" value="<?php _e('Update', 'wp-twitter') ?>" /></td>
</tr>
</table>
</form>
</div>
</div>
<?php
$tweets = "http://twitter.com/statuses/friends_timeline.xml?count=25";

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

echo "<div class='user'><span class='status' id='", $twit1->id,"'><img border=\"0\" class=\"twitter_followers\" src=\"", $twit1->user->profile_image_url, "\"  width=\"48\" height=\"48\" />\n";
echo "<div class='name'><a class=\"name1\" href=\"http://www.twitter.com/", $twit1->user->screen_name,"\" target=\"_blank\" title=\"", $twit1->user->name,"\" \">", $twit1->user->screen_name,"</a><table style=\"float:right;\"><tr><td><a class=\"reply\" href=\"#update\" title=\"Reply\"><img src=\"inc/reply.png\" width=\"16\" height=\"16\" border=\"0\" style=\"float:right;\"/></a></td></tr><tr><td><a class=\"retweet\" href=\"#update\" title=\"Retweet\"><img src=\"inc/rt.png\" width=\"16\" height=\"16\" border=\"0\"/></a></p></td></tr></table></div>";
echo "<div class='text'>".$description." </span></div>";
echo "<hr><div class='description'><a href=\"http://www.twitter.com/", $twit1->user->screen_name,"/status/", $twit1->id,"\" target=\"_blank\"> ".$data1."</a> from ", $twit1->source,"</div></div>";}

curl_close($tw);
?>

<p style="margin:10px 0 0 130px"><small>Powered by <a href="http://webmais.com/wp-twitter" target="_blank" title="WP-Twitter">WP-Twiterr</a></small></p>


</body>
</html>
<?php else : ?>
<div style="padding: 5px; width: 350px;height: 100px;background: Black;color: Red; font: 12px Verdana, Geneva, Arial, Helvetica, sans-serif;text-align: center;" >
<h1 style="color:#fff"><?php printf($user_identity) ?></h1>
<strong>&raquo; You do not have permission to access this page!</strong>



</div>



<?php endif; ?>