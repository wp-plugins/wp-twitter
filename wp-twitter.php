<?php
/*
Plugin Name: WP-Twitter
Plugin URI: http://webmais.com/wp-twitter
Description: WP-Twitter is a plugin that creates a integration between your WordPress blog and your <a href="http://twitter.com">Twitter</a> account.
Version: 1.5.1
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
$wptwitter_version = '1.5.1';
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
add_options_page('WP-Twitter', 'WP-Twitter', 8, __FILE__, 'wp_twitter_options');
}
function show_tb_warning()
{
	echo "<div class=\"error\"><p>".__('Please update your', 'wp-twitter')." <a href=\"".get_bloginfo('wpurl')."/wp-admin/options-general.php?page=wp-twitter/wp-twitter.php\">".__('WP-Twitter username and password', 'wp-twitter')."</a></p></div>";
}
function wptwitter_admin() {
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/wp-twitter/inc/styles.css" />';
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
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2><?php _e('WP-Twitter Options', 'wp-twitter') ?></h2>
<form method="post" action="options.php"><?php wp_nonce_field('update-options'); ?>
<div id="poststuff" class="metabox-holder">
<table border="0" cellpadding="5" cellspacing="10">
<tr><td valign="top">
<div id="dashboard_right_now" class="postbox">
<h3 class="hndle"><?php _e('Twitter Account ', 'wp-twitter') ?></h3>
<div class="inside">
<p><?php _e('Enter your Twitter username and password to enable to', 'wp-twitter') ?> <a href="<?php bloginfo('wpurl') ?>/wp-admin/edit.php?page=wp-twitter.php"><?php _e('post updates', 'wp-twitter') ?></a>.</p>		
<p>
<input type="text" name="wp_twitter_username" size="15" value="<?php echo get_option('wp_twitter_username'); ?>" style="background: #FAFAD2;"/> (<em><?php _e('Twitter Username', 'wp-twitter') ?></em>)<br>
<input type="password" name="wp_twitter_pw" size="15" value="<?php echo get_option('wp_twitter_pw'); ?>" style="background: #FAFAD2;"/> (<em><?php _e('Twitter Password', 'wp-twitter') ?></em>)
</p>
</div></div>
</td>
<td valign="top">
<div id="dashboard_right_now" class="postbox">
<h3 class="hndle"><?php _e('Twitter Profile', 'wp-twitter') ?></h3>
<div class="inside">
<ul><li>
<p><?php _e('The following information is associated with your Twitter credentials.', 'wp-twitter') ?> </p>
<?php if ( $settings['username'] ) { ?>
           <?php $ok = wptwitter_verify_credentials( $settings['username'], $settings['password'], $result );  ?>
            <?php if ( $ok ) { ?>
		<img class="wpavatar" src="<?php echo $result['user']['profile_image_url']; ?>" alt="Profile Image" />
             <div class="wpinfo">               
                <strong> <?php echo $result['user']['name']; ?>, <?php echo $result['user']['followers_count'] . ' ' . __('followers', 'wp-twitter'); ?></strong>
                 <br/><small><?php if ( is_array( $result['user']['description'] ) ) _e('No Description On Account', 'wp-twitter'); else echo $result['user']['description']; ?></small> 
            </div> 
            <?php } else { ?>
               <p class="wpsorry">
                  <?php _e('Sorry, the credentials you have supplied are invalid. Please re-enter them again below.', 'wp-twitter'); ?>
               </p>
            <?php } ?> 
       <?php } ?>
</li>
<li>&nbsp;</li>
</ul>
</div>
</div>
</td>
</tr>
<tr>
<td valign="top">
<div id="dashboard_right_now" class="postbox">
<h3 class="hndle">Settings</h3>
<div class="inside">
<ul><li>
<?php _e('Tweets to show in admin screen', 'wp-twitter') ?>: <input type="Text" size="2" maxlength="2" name="wp_twitter_tt" value="<?php echo get_option('wp_twitter_tt'); ?>" style="background: #FAFAD2;" >
</li>
<li>

</li>

</ul>
</div>
</div>
<div align="center"><input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="wp_twitter_username,wp_twitter_pw,wp_twitter_tt" />
<input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes', 'wp-twitter') ?>" />
</form></div>
</td>
<td valign="top">
<div id="dashboard_right_now" class="postbox">
<h3 class="hndle">WP-Twitter</h3>
<div class="inside">
<ul>
<li><img src="<?php bloginfo('wpurl') ?>/wp-content/plugins/wp-twitter/inc/logo.png" alt="" width="66" height="69" border="0" style="float:left; margin: 0px 5px 0px 0px; " /></li>
<li><p><?php global $wptwitter_version; ?>&nbsp;<?php echo __( "<strong>Version:</strong>", "wp-twitter" ) . ' ' . $wptwitter_version; ?></p></li>
<li><p>| <a href="http://webmais.com/" target="_blank"><?php _e('Author', 'wp-twitter') ?></a> | <a href="http://webmais.com/wp-twitter" target="_blank">Plugin Homepage</a> |</p>
</li>
<li>&nbsp;</li>
</ul>
</div>
</div>
</td>
</tr>
</table>
</div>
</div>
<?php } 
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
		echo '<!-- WP-Twitter => http://webmais.com/wp-twitter/ -->';
		echo '<style type="text/css">.wp_twitter ol { font-size: 85%; list-style-type:none; margin: 0; padding: 0; font-style: italic;}.wp_twitter ol li {list-style-type:none;}.time a{text-decoration: none;} .status a{text-decoration: none;}</style>';
		echo '<div id="wp_twitter" class="wp_twitter">'.__('Please wait while my tweets load, Retry', 'wp-twitter').' <img src="' . get_bloginfo('wpurl') . '/wp-content/plugins/wp-twitter/inc/load.gif" /></div>';
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
	register_sidebar_widget(array('WP-Twitter', 'widgets'), 'widget_WPtwitter');
	register_widget_control(array('WP-Twitter', 'widgets'), 'widget_WPtwitter_control', 300, 200);
}
add_action('widgets_init', 'widget_WPtwitter_init'); ?>