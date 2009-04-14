<?php
/*
Plugin Name: WP-Twitter
Plugin URI: http://webmais.com/wp-twitter
Description: <strong>WP-Twitter</strong> is a plugin that creates a integration between your WordPress blog and your <a href="http://twitter.com">Twitter</a> account by giving you the following functionality: <strong>i)</strong> Post a tweet from the WordPress Admin Screens, including option to reduce the URL with API <a href="http://is.gd">is.gd</a> before sending. <strong>ii)</strong> Widget for displays yours latest tweets in your WordPress blog.
Version: 1.0
Author: Fabrix DoRoMo
Author URI: http://webmais.com
*/

// Copyright (c) 2009-2009 Fabrix DoRoMo. All rights reserved.
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-3.0.html
//
// This is an add-on for WordPress
// http://wordpress.org/
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************
ob_start();
if(get_option('wp_twitter_username') == "")
{
	add_action('admin_notices', 'show_tb_warning');
}
add_action('admin_menu', 'wp_twitter_menu');

function wp_twitter_save_post_meta($pid)
{
	if($_POST['do_tb_post'] != "")
	{
		update_tb_meta($pid, $_POST['do_tb_post']);
	}
}
function wp_twitter_menu() {
add_options_page('WP-Twitter &raquo;', 'WP-Twitter &raquo;', 8, __FILE__, 'wp_twitter_options');
add_submenu_page('post-new.php'	, __('WP-Twitter &raquo;', 'wp-twitter'), __('WP-Twitter &raquo;', 'wp-twitter'), 8	, basename(__FILE__), 'wp_twitter_add');
}
function show_tb_warning()
{
	echo "<div class=\"error\"><p>Please update your <a href=\"".get_bloginfo('wpurl')."/wp-admin/options-general.php?page=wp-twitter/wp-twitter.php\">WP-Twitter username and password</a>.</p></div>";
}
function wp_twitter_options() {
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>WP-Twitter Options:</h2>
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
<h3>Username and Password</h3>
<p>Enter your Twitter username and password to enable to <a href="<?php bloginfo('wpurl') ?>/wp-admin/edit.php?page=wp-twitter.php">post updates</a>.</p>		
<table class="widefat fixed" style="width: 370px;">
<thead>
<tr valign="top">
<th scope="row">Twitter Username</th>
<td><input type="text" name="wp_twitter_username" value="<?php echo get_option('wp_twitter_username'); ?>" /></td>
</tr>
<tr valign="top">
<th scope="row">Twitter Password</th>
<td><input type="password" name="wp_twitter_pw" value="<?php echo get_option('wp_twitter_pw'); ?>" /></td>
</tr>
</thead>
</table>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="wp_twitter_username,wp_twitter_pw" />
<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</form>
</div>


<?php
}?>


<?php
function wp_twitter_add() {
$twitter_username = get_option('wp_twitter_username');
$twitter_psw = get_option('wp_twitter_pw');
function postToTwitter($username,$password,$message){
    $host = "http://twitter.com/statuses/update.xml?status=".urlencode(stripslashes(urldecode($message)));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $host);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, "source=wp-twitter");
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    $result = curl_exec($ch);
    $resultArray = curl_getinfo($ch);
    curl_close($ch);
    if($resultArray['http_code'] == "200"){
         $twitter_status='Your message has been sended! <a href="http://twitter.com/'.$username.'" target="_blank">See your profile</a>';
    } else {
         $twitter_status="Error posting to Twitter. Retry";
    }
	return $twitter_status;
}
if(isset($_POST['twitter_msg'])){
	$twitter_message=$_POST['twitter_msg'];
	if(strlen($twitter_message)<1){
	$error=1;
	} else {
	$twitter_status=postToTwitter($twitter_username, $twitter_psw, $twitter_message);
	}
}
?>
<script type="text/javascript">
//<![CDATA[
function textCounter(field, countfield, maxlimit) {
if (field.value.length > maxlimit)
field.value = field.value.substring(0, maxlimit);
else 
countfield.value = maxlimit - field.value.length;
}
//]]>
</script>
<div class="wrap">
<div id="icon-edit" class="icon32"><br /></div>
<h2>Post a message on Twitter</h2>
<?php if(isset($_POST['twitter_msg']) && !isset($error)){?>
<div id="message" class="updated fade"><p><strong><?php echo $twitter_status ?></strong></p></div>
<?php } else if(isset($error)){?>
<div id="message" class="updated fade"><p><strong>Error: please insert a message!</strong></p></div>
<?php }?>
<div id="poststuff" class="metabox-holder" style="width: 470px;">
<div id="submitdiv" class="postbox">
<h3 class='hndle'><span>What are you doing?</span></h3>
<form action="<?php bloginfo('wpurl') ?>/wp-admin/edit.php?page=wp-twitter.php" method="post" name="myform">
<div align="center"><textarea name="twitter_msg" type="text" id="twitter_msg" rows="4" style="width: 458px;border: none" maxlength="140" onKeyDown="textCounter(this.form.twitter_msg,this.form.remLen,140);" onKeyUp="textCounter(this.form.twitter_msg,this.form.remLen,140);"></textarea></div>
</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr>
<td align="left"><input disabled readonly type="text" name="remLen" size="3" maxlength="3" style="font-size:10px" value="140"> <small>(characters left)</small></td>
<td align="right"><input type="submit" name="button" id="button" class="button-primary" value=" Update " /></td>
</tr>
</table>
</div></form>
<p>&nbsp;</p>
<div id="icon-edit" class="icon32"><br /></div>
<h2>Optional</h2>
<p><em>"Your message + "BIG URL" = 140 Characters"</em><br><strong>TIP:</strong> before posting, reduce the size of URL for leave more space for your text.<br/>
Enter the URL you'd like a short URL, click "<strong>Get URL</strong>", and the new URL will appear for you!</p>
<table class="widefat fixed" style="width: 390px;">
<tr><td>
<iframe scrolling="No" frameborder="0" width="390" height="85" src="<?php bloginfo('wpurl') ?>/wp-content/plugins/wp-twitter/tiny-url.php"></iframe>
</td></tr></table>
</div><!-- wrap -->
<?php }?>
<?php
function widget_WPtwitter_init() {
	if ( !function_exists('register_sidebar_widget') )
		return;
	function widget_WPtwitter($args) {
		extract($args);
		$options = get_option('widget_WPtwitter');
		$account = $options['account'];  
		$title = $options['title'];  
		$show = $options['show'];  
        // Output
		echo $before_widget ;
		echo $before_title ;
		echo $title ;
		echo $after_title;
		echo '<div id="twitter_div">';
		echo '<ul id="twitter_update_list"></ul></div>
		      <script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>';
		echo '<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/'.$account.'.json?callback=twitterCallback2&amp;count='.$show.'"></script>';
		echo $after_widget;
	}
	function widget_WPtwitter_control() {
		$options = get_option('widget_WPtwitter');
		if ( !is_array($options) )
			$options = array('account'=>'Fallcom', 'title'=>'Twitter', 'show'=>'5');
		if ( $_POST['Twitter-submit'] ) {
			$options['account'] = strip_tags(stripslashes($_POST['Twitter-account']));
			$options['title'] = strip_tags(stripslashes($_POST['Twitter-title']));
			$options['show'] = strip_tags(stripslashes($_POST['Twitter-show']));
			update_option('widget_WPtwitter', $options);
		}
		$account = htmlspecialchars($options['account'], ENT_QUOTES);
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$show = htmlspecialchars($options['show'], ENT_QUOTES);
		echo '<p style="text-align:right;">
				<label for="Twitter-account">' . __('Account:') . '
				<input style="width: 200px;" id="Twitter-account" name="Twitter-account" type="text" value="'.$account.'" />
				</label></p>';
		echo '<p style="text-align:right;">
				<label for="Twitter-title">' . __('Title:') . '
				<input style="width: 200px;" id="Twitter-title" name="Twitter-title" type="text" value="'.$title.'" />
				</label></p>';
		echo '<p style="text-align:right;">
				<label for="Twitter-show">' . __('Tweets:') . '
				<input style="width: 200px;" id="Twitter-show" name="Twitter-show" type="text" value="'.$show.'" />
				</label></p>';
		echo '<input type="hidden" id="Twitter-submit" name="Twitter-submit" value="1" />';
	}
	// Register settings for use, 300x200 pixel form
	register_sidebar_widget(array('WP-Twitter', 'widgets'), 'widget_WPtwitter');
	register_widget_control(array('WP-Twitter', 'widgets'), 'widget_WPtwitter_control', 300, 200);
}
add_action('widgets_init', 'widget_WPtwitter_init');
?>

