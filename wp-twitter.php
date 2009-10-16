<?php
/*
Plugin Name: (( WP Twitter ))
Plugin URI: http://webmais.com/wp-twitter
Description: Is a plugin that creates a integration between your WordPress blog and your Twitter account, including a BookMarklet.
Version: 2.3
Author: Fabrix DoRoMo
Author URI: http://webmais.com
*/
// Copyright (c) 2009-2009 Fabrix DoRoMo. All rights reserved.
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-3.0.html
// This is an add-on for WordPress
// http://wordpress.org/
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************
ob_start();

$wptwitter_version = '2.2.1';

if(get_option('wp_twitter_username') == "")
{
add_action('admin_notices', 'show_wp_warning');
}

add_action('admin_menu', 'wp_twitter_menu');
add_action('publish_post', 'wp_twitter_post');
add_action('save_post', 'wp_twitter_save_post_meta'); 
add_action('edit_form_advanced', 'wp_twitter_show_post_option');

function wp_twitter_save_post_meta($pid)
{
	if($_POST['do_wpt_post'] != "")
	{
		update_wpt_meta($pid, $_POST['do_wpt_post']);
	}
}

function wp_twitter_menu() {
add_options_page('(( WP Twitter ))', '(( WP Twitter ))', 8, __FILE__, 'wp_twitter_options');
}

function show_wp_warning()
{
	echo "<div class=\"error\"><p>".__('Please update ', 'wp-twitter')." <a href=\"".get_bloginfo('wpurl')."/wp-admin/options-general.php?page=wp-twitter/wp-twitter.php\">".__('(( WP Twitter ))', 'wp-twitter')."</a></p></div>";
}

function wptwitter_head() {
global $wptwitter_version;
echo "\n\n<!-- WP-Twitter ".$wptwitter_version." (http://webmais.com/wp-twitter) -->";
}
add_action( 'wp_head', 'wptwitter_head' );


function wptwitter_admin() {
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/wp-twitter/inc/admin.css" />';
}
add_action( 'admin_head', 'wptwitter_admin' );
$currentLocale = get_locale();
			if(!empty($currentLocale)) {
				$moFile = dirname(__FILE__) . "/lang/wp-twitter-" . $currentLocale . ".mo";
				if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('wp-twitter', $moFile);
			}
function wp_twitter_options() {
include ('inc/credentials.php');

?>

<?php

	global $wpdb;
	//Update settings
	if ($_POST['issubmitted'] == 'yes') {
			$post_url_shortener = $wpdb->escape($_POST['url_shortener']);
			update_option("tweetable_url_shortener", $post_url_shortener);
			}
	//Retrieve current settings
	$setting_url_shortener = get_option('tweetable_url_shortener');
		
	?>




<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>WP Twitter <?php _e('Options', 'wp-twitter') ?></h2>
<form method="post" action="options.php"><?php wp_nonce_field('update-options'); ?>
<div id="poststuff" class="metabox-holder">
<table border="0" cellpadding="5" cellspacing="10" width="100%">
<tr><td valign="top" width="50%">
<div id="dashboard_right_now" class="postbox">
<h3 class="hndle"><?php _e('Twitter Account ', 'wp-twitter') ?></h3>
<div class="inside">

<p><?php _e('Enter your Twitter username and password to enable to post updates and activate your BookMarklet.', 'wp-twitter') ?></p>		
<p>
<input type="text" name="wp_twitter_username" size="15" value="<?php echo get_option('wp_twitter_username'); ?>" style="background: #FAFAD2;"/> (<em><?php _e('Twitter Username', 'wp-twitter') ?></em>)<br/>
<input type="password" name="wp_twitter_pw" size="15" value="<?php echo get_option('wp_twitter_pw'); ?>" style="background: #FAFAD2;"/> (<em><?php _e('Twitter Password', 'wp-twitter') ?></em>)
</p>

<?php if ( $settings['username'] ) { ?>
           <?php $ok = wptwitter_verify_credentials( $settings['username'], $settings['password'], $result );  ?>
            <?php if ( $ok ) { ?>
			<p align="center"><strong>~#~</strong></p>
	
			<img class="wpavatar" src="<?php echo $result['user']['profile_image_url']; ?>" alt="Profile Image" />
       	     <div class="wpinfo">  
	         <strong> <?php echo $result['user']['name']; ?></strong>, <?php echo $result['user']['followers_count'] . ' ' . __('followers', 'wp-twitter'); ?>
              <br/><small><?php if ( is_array( $result['user']['description'] ) ) _e('No Description On Account', 'wp-twitter'); else echo $result['user']['description']; ?></small> 
            </div> 
		<p>&nbsp;</p>
			
            <?php } else { ?>
               <p class="wpsorry">
                  <?php _e('Sorry, the credentials you have supplied are invalid. Please re-enter them again.', 'wp-twitter'); ?>
               </p>
            <?php } ?> 
       <?php } ?>



	
</div></div>
</td>
<td valign="top" width="50%">
<div id="dashboard_right_now" class="postbox">
<h3 class="hndle"><?php _e('Your BookMarklet', 'wp-twitter') ?>*</h3>
<div class="inside">
<p> <?php _e('<em>BookMarklet</em> is a "simple one-click" tool that adds functionality to the browser, This <em>BookMarklet</em> opens a small window that makes it easier follow and update your Twitter from anywhere.', 'wp-twitter') ?></li>
</p>
<p>
<?php _e('<strong>Easy to install</strong>: Drag the link below to your bookmarks bar, or right click and (Add to Favorites).', 'wp-twitter') ?>

<?php if ( $settings['username'] ) { ?>
           <?php $ok = wptwitter_verify_credentials( $settings['username'], $settings['password'], $result );  ?>
            <?php if ( $ok ) { ?>
			<p align="center"><strong><a href="javascript:void((function(){var%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','<?php bloginfo('wpurl') ?>/wp-content/plugins/wp-twitter/auth.php');document.body.appendChild(e)})());" onclick="window.alert('<?php _e('Drag the this link to your bookmarks bar, or right click and (Add to Favorites)', 'wp-twitter'); ?>');return false;" title="BookMarklet by <?php echo $result['user']['name']; ?>">(( WP Twitter ))</a></strong></p>
		<p>&nbsp;</p>
			
            <?php } else { ?>
               <p class="wpsorry" align="center">
                   <?php _e('ERROR: BookMarklet link Disabled!', 'wp-twitter'); ?>
               </p>
            <?php } ?> 
       <?php } ?>

<small>*<em><?php _e('*This BookMarklet is currently supported by: Firefox, Safari, Opera, Chrome, Internet Explorer 7+.', 'wp-twitter') ?></em></small>

</div>
</div>
</td>
</tr>
<tr>
<td valign="top" width="50%">
<div id="dashboard_right_now" class="postbox">
<h3 class="hndle"><?php _e('Tweet prefix options', 'wp-twitter'); ?>*</h3>
<div class="inside">
<p><?php _e('Prefix for new blog posts:', 'wp-twitter'); ?><br>
<input type="text" name="wp_new_prefix" size="40" value="<?php echo get_option('wp_new_prefix'); ?>" style="background: #FAFAD2;"/></p>
<br/>
<p><?php _e('Prefix for updated blog posts:', 'wp-twitter'); ?> <br>
<input type="text" name="wp_update_prefix" size=40" value="<?php echo get_option('wp_update_prefix'); ?>" style="background: #FAFAD2;"/></p>
<p>*<small><em><?php _e('Optional, leave in blank if prefer.', 'wp-twitter'); ?></em></small></p>

</div>
</div>
<div id="dashboard_right_now" class="postbox">
<?php $setting_url_shortener = get_option('wp-url-shortener') != '' ? get_option('wp-url-shortener') : "tinyurl.com"; ?>
<h3 class="hndle"><?php _e('Set your preferred URL Shortener', 'wp-twitter'); ?>: <strong><a href="http://<?=$setting_url_shortener?>"  target="_blank" title="<?php _e('Go to', 'wp-twitter'); ?> <?=$setting_url_shortener?>" ><?=$setting_url_shortener?></a></strong></h3>
<div class="inside">
<?php          $ShortOP01 = (get_option('wp-url-shortener') == 'tinyurl.com' || get_option('wp-url-shortener') == '') ? "checked" : ""; 
        	   $ShortOP02 = get_option('wp-url-shortener') == 'u.nu' ? "checked" : "";
        	   $ShortOP03 = get_option('wp-url-shortener') == 'cli.gs' ? "checked" : "";  
        	   $ShortOP04 = get_option('wp-url-shortener') == 'redir.ec' ? "checked" : ""; 
			   $ShortOP05 = get_option('wp-url-shortener') == 'is.gd' ? "checked" : ""; 
			   $ShortOP06 = get_option('wp-url-shortener') == 'th8.us' ? "checked" : ""; 
        ?>
<table border="0" cellpadding="0" cellspacing="10" width="100%">
<tr>
<td align="left"><pre><input type="radio" name="wp-url-shortener" id="wp-url-shortener" size="25" value="tinyurl.com"  <?php print $ShortOP01; ?>><strong><font color="#000099">TINYURL.COM</font></strong></pre></td>
<td align="left"><pre><input type="radio" name="wp-url-shortener" id="wp-url-shortener" size="25" value="th8.us"  <?php print $ShortOP06; ?>><strong><font color="#FF0000">TH8.US</font></strong></pre></td>
<td align="left"><pre><input type="radio" name="wp-url-shortener" id="wp-url-shortener" size="25" value="is.gd"  <?php print $ShortOP05; ?>><strong><font color="#FF9F04">IS.GD</font></strong></pre></td>
<td align="left"><pre><input type="radio" name="wp-url-shortener" id="wp-url-shortener" size="25" value="u.nu"  <?php print $ShortOP02; ?>><strong><font color="#669900">U.NU</font></strong></pre></td>
</tr>

<tr>
<td colspan="4" align="left" valign="top"><pre><input type="radio" name="wp-url-shortener" id="wp-url-shortener" size="25" value="cli.gs"  <?php print $ShortOP03; ?>><strong><font color="#800080">CLI.GS</font></strong>*-----&gt;api key:<input type="text" name="wp_short_user1" size="25" value="<?php echo get_option('wp_short_user1'); ?>" style="background: #FAFAD2;"/> <a href="http://cli.gs/user/api/" target="_blank" title="<?php _e('Get one free here!', 'wp-twitter'); ?>">[?]</a></pre></td>
</tr>

<tr>
<td colspan="4" align="left" valign="top"><pre><input type="radio" name="wp-url-shortener" id="wp-url-shortener" size="25" value="redir.ec"  <?php print $ShortOP04; ?>><strong><font color="#008080">REDIR.EC</font></strong>*---&gt;api key:<input type="text" name="wp_short_user2" size="25" value="<?php echo get_option('wp_short_user2'); ?>" style="background: #FAFAD2;"/> <a href="http://redir.ec" target="_blank" title="<?php _e('Get one free here!', 'wp-twitter'); ?>">[?]</a></pre></td>
</tr>
</tr>
</table>

<p>*<small><em><?php _e('api key required ', 'wp-twitter'); ?></em></small></p>
	
</div>
</div>

<div align="center">
	
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="wp_twitter_username,wp_twitter_pw,wp_new_prefix,wp_update_prefix,wp-url-shortener,wp_short_user1,wp_short_user2" />
<input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes', 'wp-twitter') ?>" />
</form></div>

</td>
<td valign="top" width="50%">
<div id="dashboard_right_now" class="postbox">
<h3 class="hndle">(( WP Twitter ))</h3>
<div class="inside">
<img src="<?php bloginfo('wpurl') ?>/wp-content/plugins/wp-twitter/inc/logo.png" alt="" width="66" height="72" border="0" style="float:left; margin: 0px 5px 0px 0px; " />
<p>&nbsp;</p>
<table border="0" align="center" cellspacing="15">
<tr>
	<td>| <a href="http://webmais.com/wp-twitter" target="_blank">Plugin Homepage</a> |</td>
	<td><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="7565084">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/pt_BR/i/scr/pixel.gif" width="1" height="1">
</form></td>
</tr>
</table>

</div>
</div>
</td>
</tr>
</table>
</div>
</div>



<?php } 
function wp_twitter_post($pid)
{
	if($_POST['action'] != "autosave" and $_POST['post_status'] != "draft" and $_POST['do_wpt_post'] != "no" ) //Don't post when autosaving or when saving a draft
	{
		$username = get_option('wp_twitter_username');
		$password = get_option('wp_twitter_pw');

		$title = @html_entity_decode(get_the_title($pid), ENT_COMPAT, 'UTF-8'); //$title = get_the_title($pid);
		$postlink = get_permalink($pid);
		
		update_wpt_meta($pid, $_POST['do_wpt_post']);

		if($_POST['original_post_status'] == 'publish') // We are updating a post, rather than publishing a new one
		{
			$prefix = get_option('wp_update_prefix');
           if (strlen($prefix) > 0) $title = $prefix . ' ' . $title;  // prefix space
		}
		else
		{
			 $prefix = get_option('wp_new_prefix');
            if (strlen($prefix) > 0) $title = $prefix . ' ' . $title; // prefix space
		}
				
$shortuser1	= get_option('wp_short_user1');
$shortuser2	= get_option('wp_short_user2');

$setting_url_shortener = get_option('wp-url-shortener') != '' ? get_option('wp-url-shortener') : "tinyurl.com";
global $ManualOrRandom;
$ManualOrRandom = $setting_url_shortener;
switch ($ManualOrRandom){
  case "tinyurl.com":
      $t_url = "http://tinyurl.com/api-create.php?url={$postlink}";
      break;
  case "su.pr":
       $t_url = "http://su.pr/api/simpleshorten?url={$postlink}";
      break;
 case "u.nu":
       $t_url = "http://u.nu/unu-api-simple?url={$postlink}";
      break;
 case "cli.gs":
       $t_url = "http://cli.gs/api/v1/cligs/create?key={$shortuser1}&appid=URLBarExt&url={$postlink}"; 
      break; 
case "redir.ec":  
       $t_url = "http://redir.ec/_api/rest/redirec/create?url={$postlink}&appid=wp-twitter&apikey={$shortuser2}"; 
      break;   
case "is.gd":  
       $t_url = "http://is.gd/api.php?longurl={$postlink}"; 
      break;
	  case "th8.us":  
       $t_url = "http://th8.us/api.php?url={$postlink}"; 
      break;

 default:
       $t_url = "http://tinyurl.com/api-create.php?url={$postlink}";
      break;
  }
		$url_contents = file_get_contents($t_url);
		$temp_length = (strlen($title)) + (strlen($url_contents));
		if($temp_length > 137) //We use 137 characters as we need three fir the hyphen
		{
			$remaining_chars = 134 - strlen($url_contents);
			$title = substr($title, 0, $remaining_chars);
			$title = $title . "...";
		}
		$message = $title . " - " . $url_contents;
		$url = 'http://twitter.com/statuses/update.xml';

		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, "$url");
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_POST, 1);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "status=$message&source=wp-twitter");
		curl_setopt($curl_handle, CURLOPT_USERPWD, "$username:$password");
		$buffer = curl_exec($curl_handle);
		curl_close($curl_handle);

	}
}

function wp_twitter_show_post_option()
{
global $post;

	$notify = get_post_meta($post->ID, 'wp_twitter', true);

	echo "<div id=\"tagsdiv-post_tag\" class=\"stuffbox\" >";
	echo "<h3><span>(( WP Twitter ))</span></h3>";
	echo "<div class=\"inside\">".__('Activate', 'wp-twitter')." <em>WP-Twitter</em> ".__('to this post', 'wp-twitter')."?<p> ";

	echo "<input id=\"skip_wpt_post\" type=\"radio\" name=\"do_wpt_post\" value=\"yes\"";
	if($notify == "yes" || $notify == "")
	{
		echo " checked=\"checked\"";
	}
	echo " /> <label for=\"skip_wpt_post\"><font color=\"#008000\">".__('Yes', 'wp-twitter')."</font></label><br/> ";


	echo "<input id=\"do_wpt_post\" type=\"radio\" name=\"do_wpt_post\" value=\"no\"";

	if($notify == "no")
	{
		echo " checked=\"checked\"";
	}

	echo " /> <label for=\"do_wpt_post\"><font color=\"#FF0000\">".__('No', 'wp-twitter')."</font></label></p>";

	echo "</div>";
	echo "</div>";
}

function update_wpt_meta($pid, $value)
{
	if (!update_post_meta($pid, 'wp_twitter', $value)) {
		add_post_meta($pid, 'wp_twitter', $value);
	}
}

// ********************** widget ********************************
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
		echo '<style type="text/css">.wp_twitter ol { font-size: 85%; list-style-type:none; margin: 0; padding: 0; font-style: italic;}.wp_twitter ol li {list-style-type:none;}.time a{text-decoration: none;} .status a{text-decoration: none;}</style>';
		echo '<div id="wp_twitter" class="wp_twitter"><p align="center"><img src="' . get_bloginfo('wpurl') . '/wp-content/plugins/wp-twitter/inc/load.gif" /></p></div>';
		echo '<script  type="text/javascript" src="' . get_bloginfo('wpurl') . '/wp-content/plugins/wp-twitter/inc/twitter.js" charset="utf-8"></script>';
        echo '<script type="text/javascript" charset="utf-8">
              getTwitters(\'wp_twitter\', { 
              id: \''.$account.'\', 
              count: '.$show.', 
              enableLinks: true, 
              ignoreReplies: false, 
              clearContents: true,
              template: \'<span class="prefix"><a href="http://twitter.com/%user_screen_name%" title="%user_name%"><img height="30" width="30" src="%user_profile_image_url%" border="0"/></a></span> <span class="status">%text%</span> <span class="time">(<a href="http://twitter.com/%user_screen_name%/statuses/%id%">%time%</a>)</span>\'
              });</script>';
		 echo $after_widget;
	}
	function widget_WPtwitter_control() {
		$options = get_option('widget_WPtwitter');
		if ( !is_array($options) )
			$options = array('account'=>'fdoromo', 'title'=>'Twitter', 'show'=>'5');
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
				<label for="Twitter-account">' . __('Account:', 'wp-twitter') . '
				<input style="width: 200px;" id="Twitter-account" name="Twitter-account" type="text" value="'.$account.'" />
				</label></p>';
		echo '<p style="text-align:right;">
				<label for="Twitter-title">' . __('Title:', 'wp-twitter') . '
				<input style="width: 200px;" id="Twitter-title" name="Twitter-title" type="text" value="'.$title.'" />
				</label></p>';
		echo '<p style="text-align:right;">
				<label for="Twitter-show">' . __('Tweets:', 'wp-twitter') . '
				<input style="width: 200px;" id="Twitter-show" name="Twitter-show" type="text" value="'.$show.'" />
				</label></p>';
		echo '<input type="hidden" id="Twitter-submit" name="Twitter-submit" value="1" />';
	}
	// Register settings for use, 300x200 pixel form
	register_sidebar_widget(array('(( WP Twitter ))', 'widgets'), 'widget_WPtwitter');
	register_widget_control(array('(( WP Twitter ))', 'widgets'), 'widget_WPtwitter_control', 300, 200);
}
add_action('widgets_init', 'widget_WPtwitter_init'); ?>