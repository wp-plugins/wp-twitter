<?php
/*
*------------------------------------------------------------*/
$tokens_default = array(
		'request_key' => '',
		'request_secret' => '',
		'request_link' => '',
		'access_key' => '',
		'access_secret' => '',
		'auth1_flag' => '0',
		'auth2_flag' => '0',
		'auth3_flag' => '0',
				);
add_option( 'fdx_updater_auth', $tokens_default);

$options_default = array(
		'newpost_update' => '1',
		'newpost_format' => 'New blog post: #title#: #url#',
		'edited_update' => '1',
		'edited_format' => 'Updated blog post: #title#: #url#',
		'limit_activate' => '0',
		'limit_to_category' => array(),
		'limit_to_custom_field_key' => '',
		'limit_to_custom_field_val' => '',
		'url_method' => 'default',
        'bitly_username' => '',
        'bitly_appkey' => '',
	 	'yourls_url' => 'http://',
		'yourls_token' => '',
				);
add_option( 'fdx_updater_options', $options_default);

/*
*------------------------------------------------------------*/
function fdx_updater_options_page() {
	$tokens = get_option('fdx_updater_auth');
	$options = get_option('fdx_updater_options');

/* show a warning
*------------------------------------------------------------*/
if ( $options['url_method'] == 'bitly' && ( empty( $options['bitly_username'] ) || empty( $options['bitly_appkey'] ) ) )
{
echo "<div class='error'><p><strong>Bit.ly is selected, but account information is missing.</strong></p></div>";
}

if ( $options['url_method'] == 'yourls' && ($options['yourls_url'] == 'http://' ||  empty($options['yourls_url']) || empty($options['yourls_token']) ) )
{
echo "<div class='error'><p><strong>YOURLS is selected, but account information is missing.</strong></p></div>";
}

?>
<div class="wrap">
<?php echo get_screen_icon('fdx-lock');?>
<h2><?php echo FDX1_PLUGIN_NAME;?>: <?php _e('Basic Settings and Connect', 'fdx-lang') ?></h2>
<?php
if ( ( isset( $_GET['updated'] ) && $_GET['updated'] == 'true' ) || ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == 'true' ) ) {
echo '<div class="updated fade"><p><strong>' . __( 'Settings updated', 'fdx-lang' ) . '.</strong></p></div>';
}
?>
<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">

<?php include('_sidebar.php'); ?>

<div class="postbox-container">
<div class="meta-box-sortables">

<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Connect to Twitter', 'fdx-lang') ?></span></h3>
<div class="inside">
<!-- ############################################################################################################### -->
<p><strong><?php echo FDX1_PLUGIN_NAME;?></strong> <?php _e('uses <acronym title="An open protocol to allow secure authorization in a simple and standard method from web, mobile and desktop applications.">OAuth</acronym> authentication to connect to Twitter. Follow the authentication process below to authorise this Plugin to access on your Twitter account. ', 'fdx-lang') ?> </p>

<form action="options.php" method="post" name="agreeform" onSubmit="return defaultagree(this)">

<?php  settings_fields('fdx_updater_auth');

      if( $tokens['auth1_flag'] != '1' ) {
	   update_option('fdx_updater_auth', $tokens);
      echo "<input id='fdx_updater_auth1_flag' type='hidden' name='fdx_updater_auth[auth1_flag]' value='1' />";
       ?>

<div class="error fade"><p><strong><?php echo FDX1_PLUGIN_NAME;?> <?php _e('does not have access to a Twitter account yet.', 'fdx-lang') ?></strong></p></div>

<?php $tokens = fdx_updater_register($tokens);
      update_option('fdx_updater_auth', $tokens);

  $tokens = get_option('fdx_updater_auth');
    echo "<table style=\"width:100%;\" class=\"widefat\"><thead><tr><th> ". __('Now you need to tell Twitter that you want to allow this plugin to be able to post using your account.', 'fdx-lang');
    echo "</th> </tr></thead><tbody><tr class=\"alternate\"><td><ol><li><a href=\"javascript:void(0);\" onclick=\"PopupCenter('{$tokens['request_link']}', 'page1_id1',750,660,'no');\" title='{$tokens['request_link']}'><img src='". FDX1_PLUGIN_URL ."/images/twitter_signin_badge.png' width='151' height='24' border='0' alt='*' style='vertical-align: middle' /></a></li>";
    echo "<li>". __('Follow the instructions on the page to allow access to the plug-in.', 'fdx-lang')."</li>";
    echo "<li>". __('Wait close the popup window', 'fdx-lang')."</li></ol>";
    echo "<input id='fdx_updater_auth2_flag' type='hidden' name='fdx_updater_auth[auth2_flag]' value='1' />";
      ?>
<p><input name="agreecheck" type="checkbox" onClick="agreesubmit(this)"> <strong><?php _e('Mark if all previous steps were done.', 'fdx-lang') ?> (1,2,3)</strong> <input name="Submit" class="button-primary" disabled="disabled"  type="submit" value="<?php _e('Authorise', 'fdx-lang') ?>" />
</p><script>
document.forms.agreeform.agreecheck.checked=false
</script>
</td></tr>
<?php
} else {
       if ( $tokens['auth2_flag'] == '1' && $tokens['auth3_flag'] != '1' )
       {
       $tokens = fdx_updater_authorise($tokens);
	   }
            //validation
			$verify = fdx_updater_verify($tokens);
			switch ($verify['exit_code'])
			{
			case '1':
			echo "<table style=\"width:100%;\" class=\"widefat\"><thead><tr><th>".__('Connection checked OK. Now you can post to', 'fdx-lang')." <a href=\"javascript:void(0);\" onclick=\"PopupCenter('http://twitter.com/{$verify['user_name']}', 'page1_id2',933,660,'yes');\"><img src='".FDX1_PLUGIN_URL."libs/_showpic.php?user={$verify['user_name']}' style='vertical-align: middle'/> <strong>@{$verify['user_name']}</strong></a></th> </tr></thead><tbody>";
			$tokens['auth3_flag'] = '1'; //Will only validate until reset
			update_option('fdx_updater_auth', $tokens);
			break;

			case '2':
			echo "<div class='error'><p><strong>".__('Not able to validate access to account, Twitter is currently unavailable. Try checking again in a couple of minutes.', 'fdx-lang')."</strong></p></div>";
			$tokens['auth3_flag'] = '1'; //Will validate next time
			update_option('fdx_updater_auth', $tokens);
           	break;

			case '3':
			echo "<div class='error'><p><strong>". FDX1_PLUGIN_NAME .__('does not have access to a Twitter account yet.', 'fdx-lang')."</strong></p></div>";
   		    echo "<style media=\"all\">#hid {visibility: hidden; overflow: hidden;  display: none } </style>";
			echo "<div id='fdxerror'>".__('ERROR', 'fdx-lang')."~~C1</div>";
	    	break;

            default:
			echo "<div class='warning'>". FDX1_PLUGIN_NAME .__('is not currently authorised to use any account. Please reset and try again.', 'fdx-lang')."</strong></p></div>";
			update_option('fdx_updater_auth', $tokens);
			}
}

?>
</form>

    <tr><td>


		<form action="options.php" method="post" id="fdxReset">
		<?php settings_fields('fdx_updater_auth'); ?>
<div style="text-align: center; margin: 20px"> <input name="Submit" class="button-secondary"  type="submit" value="<?php _e('restart the authorisation procedure', 'fdx-lang') ?>" /></div>
<div style="visibility: hidden; overflow: hidden; margin: 0; padding: 0; display: none">
<input id='fdx_updater_auth1_reset' type='hidden' name='fdx_updater_auth[auth1_flag]' value='0' />
<input id='fdx_updater_auth2_reset' type='hidden' name='fdx_updater_auth[auth2_flag]' value='0' />
<input id='fdx_updater_auth3_reset' type='hidden' name='fdx_updater_auth[auth3_flag]' value='0' />
<input id='fdx_updater_req_key_reset' type='hidden' name='fdx_updater_auth[request_key]' value='' />
<input id='fdx_updater_req_sec_reset' type='hidden' name='fdx_updater_auth[request_secret]' value='' />
<input id='fdx_updater_req_link_reset' type='hidden' name='fdx_updater_auth[request_link]' value='' />
<input id='fdx_updater_acc_key_reset' type='hidden' name='fdx_updater_auth[access_key]' value='' />
<input id='fdx_updater_acc_sec_reset' type='hidden' name='fdx_updater_auth[access_secret]' value='' />
</div>
</form>

</td>
 </tr>
 </tbody>
 </table>
<!-- ############################################################################################################### -->
</div>
</div>

<form action="options.php" method="post">
<?php settings_fields('fdx_updater_options'); ?>
<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Basic Settings', 'fdx-lang') ?></span></h3>
<div class="inside">
<!-- ############################################################################################################### -->
<br />
<table style="width:100%;" class="widefat">
 <thead><tr><th><?php _e('Update when a post is published', 'fdx-lang');?></th> </tr></thead>
<tbody><tr class="alternate"><td>
<p>
<?php
$options = get_option('fdx_updater_options');
echo "<input id='fdx_updater_newpost_update' type='checkbox' name='fdx_updater_options[newpost_update]' value='1'";
if( $options['newpost_update'] == '1' )
{
echo " checked='true'";
echo " /> ".__('Set the plugin behaviour for when a new post is published.', 'fdx-lang');
}
?>
</p><p>
<?php
_e('<strong>Tweet format for a new post:</strong>', 'fdx-lang');
$options = get_option('fdx_updater_options');
echo " <input id='fdx_updater_newpost_format' type='text' size='60' maxlength='100' name='fdx_updater_options[newpost_format]' value='{$options['newpost_format']}' />";
?>
<br />
<small>Shortcodes:</small><br />
<code>#title#</code> &raquo; <small><?php _e('The title of your blog post.', 'fdx-lang') ?>  </small>
<br /><code>#url#</code> &raquo; <small><?php _e('The post URL', 'fdx-lang')?></small>
</p>
</td>
 </tr>
 </tbody>
 </table>
 <br />

<table style="width:100%;" class="widefat">
 <thead><tr><th><?php _e('Update when a post is edited', 'fdx-lang');?></th> </tr></thead>
<tbody><tr class="alternate"><td>
<p>
<?php
$options = get_option('fdx_updater_options');
echo "<input id='fdx_updater_edited_update' type='checkbox' name='fdx_updater_options[edited_update]' value='1'";
if( $options['edited_update'] == '1' )
 {
  echo " checked='true'";
  echo " /> ".__('Set the plugin behaviour for when a previously published post is updated.', 'fdx-lang');
}
?>
</p><p>
<?php
_e('<strong>Tweet format for an updated post:</strong>', 'fdx-lang');
$options = get_option('fdx_updater_options');
echo " <input id='fdx_updater_edited_format' type='text' size='60' maxlength='100' name='fdx_updater_options[edited_format]' value='{$options['edited_format']}' />";
?>
<br />
<small>Shortcodes:</small><br />
<code>#title#</code> &raquo; <small><?php _e('The title of your blog post.', 'fdx-lang') ?>  </small>
<br /><code>#url#</code> &raquo; <small><?php _e('The post URL', 'fdx-lang')?></small>
</p>
</td>
 </tr>
 </tbody>
 </table>
<!-- ############################################################################################################### -->
</div>
</div>

<div class="postbox closed" >
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Limit Updating', 'fdx-lang') ?></span></h3>
<div class="inside">
<!-- ############################################################################################################### -->
<p><?php
$options = get_option('fdx_updater_options');
echo "<strong>".__('Limit Twitter updates using the rules below?', 'fdx-lang')." <input id='fdx_updater_limit_activate' type='checkbox' name='fdx_updater_options[limit_activate]' value='1'";
if( $options['limit_activate'] == '1' ) {
echo " checked='true'"; };
echo " /></strong>";
?></p>

<table style="width:100%;" class="widefat">
 <thead><tr><th><?php _e('Send tweets for posts with this category', 'fdx-lang');?>:</th> </tr></thead>
<tbody><tr class="alternate"><td>
<p>
<?php
	$options = get_option('fdx_updater_options');
	$categories=get_categories( array( 'orderby'=>'name', 'order'=>'ASC' , 'hide_empty'=>'0') );
	if ( !empty($categories) )
	{
		echo "</h3>";
        	echo "<ul>";
        foreach($categories as $category)

            {
				echo "<li>";
				echo "<input id='fdx_updater_limit_to_category_" . $category->name . "' type='checkbox' name='fdx_updater_options[limit_to_category][" . $category->name . "]' value='" . $category->cat_ID . "'";
				if(@$options['limit_to_category'][$category->name] == $category->cat_ID ) { echo " checked='true'"; };
				echo " />";
				echo " <label for='fdx_updater_limit_to_category_" . $category->name . "'>" . $category->name . "</label>";
            	echo "<li>";
			}
            echo "</ul>";
	}
	else
	{
		echo "No categories set. You must create categories before using them as limit criterion.";
	}
?>
<small><?php _e('If no categories are checked, limiting by category will be ignored, and all categories will be Tweeted.', 'fdx-lang');?></small>
</p>
</td>
 </tr>
 </tbody>
 </table>
  <br />
<table style="width:100%;" class="widefat">
 <thead><tr><th><?php _e('Send tweets for posts with this Meta Data', 'fdx-lang');?>:</th> </tr></thead>
<tbody><tr class="alternate"><td>
<p>
<?php
	$options = get_option('fdx_updater_options');
	echo "<input id='fdx_updater_limit_to_custom_field_key' type='text' size='20' maxlength='250' name='fdx_updater_options[limit_to_custom_field_key]' value='{$options['limit_to_custom_field_key']}' />";
	echo "<label for='fdx_updater_limit_to_custom_field_key'> <code>".__('Custom Field Title (key)', 'fdx-lang')."</code></label><br />";
	echo "<input id='fdx_updater_limit_to_custom_field_val' type='text' size='20' maxlength='250' name='fdx_updater_options[limit_to_custom_field_val]' value='{$options['limit_to_custom_field_val']}' />";
	echo "<label for='fdx_updater_limit_to_custom_field_val'> <code>".__('Custom Field Value (leave blank to match any value)', 'fdx-lang')."</code></label>";
?>
</p>
</td>
 </tr>
 </tbody>
 </table>

<p><?php _e('Twitter messages can be sent only when the post is a member of a "Selected Category" or that have a specified custom field in "Meta Data"', 'fdx-lang') ?>.</p>

<!-- ############################################################################################################### -->
</div>
</div>

<div class="postbox closed">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('URL Shortener Account Settings', 'fdx-lang') ?></span></h3>
<div class="inside">
<!-- ############################################################################################################### -->
   <br />
<table style="width:100%;" class="widefat">
 <thead><tr><th><?php _e('Choose your short URL service (account settings below)', 'fdx-lang') ?></th> </tr></thead>
<tbody><tr class="alternate"><td>
<p>
<?php
  $options = get_option('fdx_updater_options');
 	// Full length WordPress Permalink
	echo "<ul><li><input id='fdx_updater_chose_url' type='radio' name='fdx_updater_options[url_method]' value='permalink'";
	if( $options['url_method'] == 'permalink' || $options['url_method'] == 'default' ) { echo " checked='true'"; };
	echo " /><label for='fdx_updater_chose_url'> <strong>".__('Wordpress default URL format', 'fdx-lang')."</strong> <code>Ex: http://domain.com/?p=123</code></label></li>";
// is.gd
	echo "<li><input id='fdx_updater_chose_url' type='radio' name='fdx_updater_options[url_method]' value='is.gd'";
	if( $options['url_method'] == 'is.gd' ) { echo " checked='true'"; };
	echo " /> <label for='fdx_updater_chose_url'><a href='http://is.gd'><strong>is.gd</strong></a></label></li>";

	// TinyURL
	echo "<li><input id='fdx_updater_chose_url' type='radio' name='fdx_updater_options[url_method]' value='tinyurl'";
	if( $options['url_method'] == 'tinyurl' ) { echo " checked='true'"; };
	echo " /> <label for='fdx_updater_chose_url'><a href='http://tinyurl.com/'><strong>TinyURL</strong></a></label></li>";
 echo"<li><h3></h3></li>";
//yourls
	echo "<li><input id='fdx_updater_chose_url' type='radio' name='fdx_updater_options[url_method]' value='yourls'";
	if( $options['url_method'] == 'yourls' ) { echo " checked='true'"; };
	echo " /> <label for='fdx_updater_chose_url'><a href='http://yourls.org/'><strong>YOURLS.org</strong></a>&nbsp; (".__('A free GPL URL shortener service', 'fdx-lang').")</label>";
//yourls Options
		echo "<p><label for='fdx_updater_yourls_url'>API url:</label><input id='fdx_updater_yourls_url' type='text' size='40' name='fdx_updater_options[yourls_url]' value='{$options['yourls_url']}' /> &nbsp; <label for='fdx_updater_yourls_token'>Signature Token: </label><input id='fdx_updater_yourls_token' type='text' size='20' name='fdx_updater_options[yourls_token]' value='{$options['yourls_token']}' /><label></p>
        <code>Ex: http://domain.com/yourls-api.php</code></li>";
 echo"<li><h3></h3></li>";
	//Bit.ly
	echo "<li><input id='fdx_updater_chose_url' type='radio' name='fdx_updater_options[url_method]' value='bitly'";
	if( $options['url_method'] == 'bitly' ) { echo " checked='true'"; };
	echo " /> <label for='fdx_updater_chose_url'><a href='http://bit.ly'><strong>Bit.ly</strong></a></label>";
		//Bit.ly Options
    	echo "<br /><label for='fdx_updater_bitly_username'>Username: </label><input id='fdx_updater_bitly_username' type='text' size='20' name='fdx_updater_options[bitly_username]' value='{$options['bitly_username']}' /> <label for='fdx_updater_bitly_appkey'>&nbsp;&nbsp;API Key: </label><input id='fdx_updater_bitly_appkey' type='text' size='40' name='fdx_updater_options[bitly_appkey]' value='{$options['bitly_appkey']}' /></li>";
      echo"</ul>";
?>
</p>
</td>
 </tr>
 </tbody>
 </table>
<!-- ############################################################################################################### -->
</div>
</div>


<div align="center"><input name="Submit" class="button-primary"  type="submit" value="<?php _e('Save All Options', 'fdx-lang') ?>" /></div>
</form>
</div> <!-- /postbox-container -->
</div><!-- /meta-box-sortables -->



</div><!-- /post-body -->
</div><!-- /poststuff -->


</div><!-- /wrap -->
<?php include('_footer_js.php'); ?>
<div class="clear"></div>
<?php } ?>
<?php
function fdx_updater_admin_init()
{
register_setting( 'fdx_updater_auth', 'fdx_updater_auth', 'fdx_updater_auth_validate' ); // Settings for OAuth procedure with Twitter
register_setting( 'fdx_updater_options', 'fdx_updater_options', 'fdx_updater_options_validate' ); // Settings for WP Twitter
}

/* Form validaton functions. The WordPress Settings API will overwrite arrays in the database with only the fields used in the form */

function fdx_updater_auth_validate($input) //n.b. else statements required for checkboxes
{
	$tokens = get_option('fdx_updater_auth');
	if( isset( $input['request_key'] ) ) 		{ $tokens['request_key'] = 	$input['request_key']; }
	if( isset( $input['request_secret'] ) ) 	{ $tokens['request_secret'] = 	$input['request_secret']; }
	if( isset( $input['request_link'] ) ) 		{ $tokens['request_link'] = 	$input['request_link']; }
	if( isset( $input['access_key'] ) ) 		{ $tokens['access_key'] = 	$input['access_key']; }
	if( isset( $input['access_secret'] ) ) 		{ $tokens['access_secret'] = 	$input['access_secret']; }
	if( isset( $input['auth1_flag'] ) ) 		{ $tokens['auth1_flag'] = 	$input['auth1_flag']; }
	if( isset( $input['auth2_flag'] ) ) 		{ $tokens['auth2_flag'] = 	$input['auth2_flag']; }
	if( isset( $input['auth3_flag'] ) ) 		{ $tokens['auth3_flag'] = 	$input['auth3_flag']; }
	return $tokens;
}

function fdx_updater_options_validate($input)
{
	$options = get_option('fdx_updater_options');
	if( !empty( $input['newpost_update'] ) ) 	{ $options['newpost_update'] = 	$input['newpost_update']; } 	else { $options['newpost_update'] = '0'; }
	if( isset( $input['newpost_format'] ) ) 	{ $options['newpost_format'] = 	$input['newpost_format']; }
	if( !empty( $input['edited_update'] ) ) 	{ $options['edited_update'] = 	$input['edited_update']; } 	else { $options['edited_update'] = '0'; }
	if( isset( $input['edited_format'] ) ) 		{ $options['edited_format'] = 	$input['edited_format']; }
	if( !empty( $input['limit_activate'] ) ) 	{ $options['limit_activate'] = 	$input['limit_activate']; }  	else { $options['limit_activate'] = '0'; }
	if( !empty( $input['limit_to_category'] ) ) 	{ $options['limit_to_category'] = $input['limit_to_category']; } else { $options['limit_to_category'] = array(); }
	if( isset( $input['limit_to_custom_field_key'] ) ) { $options['limit_to_custom_field_key'] = $input['limit_to_custom_field_key']; }
	if( isset( $input['limit_to_custom_field_val'] ) ) { $options['limit_to_custom_field_val'] = $input['limit_to_custom_field_val']; }
	if( isset( $input['url_method'] ) ) 		{ $options['url_method'] = 	$input['url_method']; }
	if( isset( $input['bitly_username'] ) ) 	{ $options['bitly_username'] = 	$input['bitly_username']; }
	if( isset( $input['bitly_appkey'] ) ) 		{ $options['bitly_appkey'] = 	$input['bitly_appkey']; }
	if( !empty( $input['yourls_url'] ) ) 		{ $options['yourls_url'] = 	$input['yourls_url']; }	// 	else { $options['yourls_url'] = 'http://'; }
	if( isset( $input['yourls_token'] ) ) 		{ $options['yourls_token'] = 	$input['yourls_token']; }
	return $options;
}
?>