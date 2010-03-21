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
	background: #afd8d8;
}
#topSection{
	padding: 0 0 5px 0;
	position: fixed;
	top: 0;
	left: 0;
	background: #afd8d8;
	opacity: 0.95;
	border-bottom: 1px solid #000;
	}
#search {
height: 27px;
width: 29px;
cursor: pointer;
text-indent: -9999px;
border: none;
background: url(inc/search.png) no-repeat left top;
}
#searchbox {border: 1px #000;
	border-style: dashed dashed dashed dashed;
	color:#0000FF
}

</style>
</head>
<body>
<div id="topSection">
<div class="header"><input id="submit" type="Submit" value="<?php _e('Recent', 'wp-twitter') ?>" onclick="window.location.href='timeline.php'" /> <input id="submit" style="background: #D7932D" type="Submit" value="<?php _e('Mentions', 'wp-twitter') ?>" onclick="window.location.href='replies.php'" />  <input id="submit" type="Submit" value="<?php _e('Direct', 'wp-twitter') ?>" onclick="window.location.href='inbox.php'" /> <input id="submit" type="Submit" value="<?php _e('Archive', 'wp-twitter') ?>" onclick="window.location.href='user.php'" /> <input id="submit" style="background: #D7932D" type="Submit" value="<?php _e('Search', 'wp-twitter') ?>" onclick="window.location.href='search.php'" /></div></div>
<p style="margin:30px 0 0 0">&nbsp;</p>
<form action="" method="get">
  <label>
 <?php _e('Search twitter', 'wp-twitter') ?>: <input type="text" name="q" id="searchbox" />
  <input  type="Submit" name="submit" id="search" title="<?php _e('Find', 'wp-twitter') ?>"/>
  </label>
</form>
<?php include('date_func.php'); ?>

<?php
//Search API Script

$q=$_GET['q'];

if($_GET['q']==''){

$q = 'WP-Twitter';}

$search = "http://search.twitter.com/search.atom?q=".$q."";

$tw = curl_init();

curl_setopt($tw, CURLOPT_URL, $search);
curl_setopt($tw, CURLOPT_RETURNTRANSFER, TRUE);
$twi = curl_exec($tw);
$search_res = new SimpleXMLElement($twi);

echo "<h3 align=\"center\">". __('Twitter search results for', 'wp-twitter')." ". "<font color=\"#0000FF\">" .$q. "</font></h3>";

## Echo the Search Data

foreach ($search_res->entry as $twit1) {

$description = $twit1->content;

$description = preg_replace("#(^|[\n ])@([^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://www.twitter.com/\\2\" >@\\2</a>'", $description);
$description = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\2\" >\\2</a>'", $description);
$description = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://\\2\" >\\2</a>'", $description);


$date =  strtotime($twit1->updated);
$dayMonth = date('d M', $date);
$year = date('y', $date);
$message = $row['content'];
$datediff = datediff0($theDate, $date);

echo "<div class='user'><img border=\"0\" width=\"48\" class=\"twitter_followers\" src=\"",$twit1->link[1]->attributes()->href,"\" title=\"", $twit1->author->name, "\" />\n";
echo "<div class='name'><a href=\"",$twit1->author->uri,"\" target=\"_blank\">", $twit1->author->name,"</a></div>";
echo "<div class='text'>".$description."<hr><div class='description'>".$datediff."</div></div></div>";

}

curl_close($tw);

?>


<p style="margin:10px 0 0 130px"><small>Powered by <a href="http://webmais.com/wp-twitter" target="_blank" title="(( WP Twiterr ))">(( WP Twiterr ))</a></small></p>


</body>
</html>