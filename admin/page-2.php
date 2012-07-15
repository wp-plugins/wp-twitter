<?php
require_once('page-2_twitteroauth.php');
$fdx_consumer_key = '02aKLZppFA5zVlPwZogUGQ';
$fdx_consumer_secret = 'J8SvzvH0HnknkMKYqeGVJ5SsIb8t64CW6DEAul1sM';
/* Plugin action when status changes to publish */
function fdx_updater_published($post) //$post_ID)
{
	//load plugin preferences
	$options = get_option('fdx_updater_options');

	if ( $options['newpost_update'] == "1" && fdx_updater_is_tweetable($post, $options) )
	{
		$post_ID = $post->ID;
		$title = $post->post_title;
//		$link = get_permalink($post_ID);
	    $link = wp_get_shortlink($post_ID);
		$tweet = '';

		// Format the message
		$tweet = fdx_updater_format_tweet( $options['newpost_format'], $title, $link, $post_ID, $options['url_method'] );

			if($tweet != '')
			{
				// Send the message
		    		$result = fdx_updater_update_status($tweet);
			}

	}

	return $post;
}
/* Action for when a post is published */
	add_action( 'draft_to_publish', 'fdx_updater_published', 1, 1 );
	add_action( 'new_to_publish', 'fdx_updater_published', 1, 1 );
	add_action( 'pending_to_publish', 'fdx_updater_published', 1, 1 );
	add_action( 'future_to_publish', 'fdx_updater_published', 1, 1 );


/* Plugin action when published is (re)published (i.e. updated) */

function fdx_updater_edited($post) //$post_ID)
{
	//load plugin preferences
	$options = get_option('fdx_updater_options');

	if ( $options['edited_update'] == "1" && fdx_updater_is_tweetable($post, $options) )
	{
		$post_ID = $post->ID;
		$title = $post->post_title;
//		$link = get_permalink($post_ID);
        $link = wp_get_shortlink($post_ID);
		$tweet = '';

		// Format the message
		$tweet = fdx_updater_format_tweet( $options['edited_format'], $title, $link, $post_ID, $options['url_method'] );

			if($tweet != '')
			{
				// Send the message
		    		$result = fdx_updater_update_status($tweet);
			}

	}

	return $post;
}
add_action( 'publish_to_publish', 'fdx_updater_edited', 1, 1 );




	/*** Additional Functions ***/


// checks if the post has either a given custom field key/value
// or is part of a selected category
function fdx_updater_is_tweetable($post, $options)
{
	if( $options['limit_activate'] == '1' )
	{
		// limiter is activated, check if the post is part of
		// a category which is tweetable
		if( is_array($options['limit_to_category']) && sizeof($options['limit_to_category']) > 0 )
		{
			$post_categories = wp_get_post_categories($post->ID);

			if( is_array($post_categories) && sizeof($post_categories) > 0 )
			{
				foreach( $post_categories as $key => $value )
				{
					if( $value > 0 && in_array( $value, $options['limit_to_category'] ) )
					{
						//echo "in cat: TRUE";
						return true;
					}
				}
			}
		}

		// Ok, no category found so continue with checking for the custom fields
		if( !empty( $options['limit_to_custom_field_key'] ) )
		{
			// If the custom_field_val is empty, just check the key for a match
			if( empty( $options['limit_to_custom_field_val'] ) || $options['limit_to_custom_field_val'] == '*' )
			{
				$custom_field_val = get_post_meta( $post->ID, $options['limit_to_custom_field_key'], true );

				if( !empty($custom_field_val) )
				{
					//echo "key matches: true";
					return true;
				}
			}
			// If there's a custom_field_val, check both match
			else if( !empty( $options['limit_to_custom_field_val'] ) )
			{
				$custom_field_val = get_post_meta( $post->ID, $options['limit_to_custom_field_key'], true );

				if( !empty($custom_field_val) && $custom_field_val == $options['limit_to_custom_field_val'] )
				{
					//echo "key and value match: true";
					return true;
				}
			}
		}

		// in all other cases return false
		return false;

	}
	else
	{
		// limit is not active so everything is tweetable
		return true;
	}
}


/* Single function to output a formatted tweet */

function fdx_updater_format_tweet( $tweet_format, $title, $link, $post_ID, $url_method )
{
	//initialise tweet
	$tweet = $tweet_format;

	//retieve the short url
	$short_url = fdx_get_shorturl($url_method,$link,$post_ID);

	// Error handling: If plugin is deacitvated, repeat to use default link supplier
	if( $short_url['error_code'] == '1' )
	{
		$short_url = fdx_get_shorturl($short_url['url_method'],$link,$post_ID);
	}

	// Additional error handing is possible: if $tweet is empty, sending will be aborted.

	//check string length and trim title if necessary (max $tweet_format length without placeholders is 100 chars)
	preg_match_all( '/#[a-z]{3,5}#/', $tweet, $placeholders, PREG_SET_ORDER);

	if ( $placeholders != NULL )
	{
		$tweet_length = strlen($tweet);
		$title_length = strlen($title);
		$url_length = strlen($short_url);

		//calculate the final tweet length
		foreach ($placeholders as $val)
		{
			if ( "$val[0]" == "#url#" )
			{
				$tweet_length = $tweet_length-5+$url_length;
				$url_count++;
			}
			elseif ( "$val[0]" == "#title#" )
			{
				$tweet_length = $tweet_length-7+$title_length;
				$title_count++;
			}

		}

		//If the tweet is too long, reduce the length of the placeholders in order of increasing importance

		//if too long, trim the title (if the placeholder was used)
		if ( $tweet_length > 140 && isset($title_count) && $title_count > 0 )
		{
			$max_title_length = $title_length-(($tweet_length-140)/$title_count);
			$max_title_length = floor($max_title_length);

			if ( $max_title_length > 0 ) { $title = substr( $title, 0, $max_title_length ); } else { $title = ''; }

			$tweet_length = $tweet_length-(($title_length+strlen($title))*$title_count);
		}

		//if still too long, force a url shortener
		if ($tweet_length > 140)
		{
			$short_url = fdx_get_shorturl('tinyurl',$link,$post_ID);
		}
	}

	//do the placeholder string replace
	$tweet = str_replace ( '#title#', $title, $tweet);
	$tweet = str_replace ( '#url#', $short_url, $tweet);

	return $tweet;
}

/* Get the selected short url */

function fdx_get_shorturl( $url_method, $link, $post_ID )
{
	//Internal URL providers:
    if ( $url_method == 'permalink' || $url_method == 'default' ) //set default shortener
	{
		$short_url = $link;
	}

	//Generic Shortener Engines

	else if ( $url_method == 'yourls' )
	{
		$options = get_option('fdx_updater_options');

		if ( !empty($options['yourls_token']) )
		{
			$timestamp = time();

			$attributes = array(     // Data to POST
					'url'      => $link,
					'keyword'  => '',
					'format'   => 'json',
					'action'   => 'shorturl',
					'timestamp' => $timestamp,
					'signature' => md5( $timestamp . $options['yourls_token'] ),
						);

			$response = fdx_updater_get_file_contents($options['yourls_url'], 'POST', $attributes);
		}
		else
		{
			$target_url = $options['yourls_url'] . "?format=json&action=shorturl&url=" . urlencode($link) ;

			$response = fdx_updater_get_file_contents($target_url);
		}

		$json = json_decode( $response, true );

		if ( $json['statusCode'] == "200" )
		{
			$short_url = $json['shorturl'];
		}
		else
		{
			$short_url = array(
				'error_code' => '1',
				'error_message' => 'No url returned. Repeat with default method.',
				'url_method' => 'default',
						);
		}
	}

	//External URL shorteners:
	else if ( $url_method == 'bitly' )
	{
		$options = get_option('fdx_updater_options');

		$bitly = 'http://api.bit.ly/v3/shorten?login=' . $options['bitly_username'] . '&apiKey=' . $options['bitly_appkey'] . '&format=json&longUrl=' . urlencode($link);
		$response = fdx_updater_get_file_contents($bitly);

		$json = json_decode( $response, true );

		if ( $json['status_code'] == "200" )
		{
			$short_url = $json['data']['url'];
		}
		else
		{
			$short_url = array(
				'error_code' => '1',
				'status_code' => $json['status_code'],
				'status_txt' => $json['status_txt'],
				'url_method' => 'default',
						);
		}
	}
	else if ( $url_method == 'tinyurl')
	{
		$target_url = "http://tinyurl.com/api-create.php?url=" . $link;
		$short_url = fdx_updater_get_file_contents($target_url);
	}
	if ( $url_method == 'is.gd' )
	{
	    $target_url = "http://is.gd/api.php?longurl=" . $link;
		$short_url = fdx_updater_get_file_contents($target_url);
	}


	return $short_url;
}


/* Wordress alternative to file_get_contents/CURL/Snoopy/etc. - server independent*/
function fdx_updater_get_file_contents( $url, $method='GET', $body=array(), $headers=array() ) {
	if( !class_exists( 'WP_Http' ) )
		include_once( ABSPATH . WPINC. '/class-http.php' );
	$request = new WP_Http;
	$result = $request->request( $url , array( 'method'=>$method, 'body'=>$body, 'headers'=>$headers, 'user-agent'=>'WP Twitter - http://wp.webmais.com/wp-twitter' ) );

	if ( !is_wp_error($result) && isset($result['body']) )
	{
		return $result['body'];
	}
	else
	{
		echo '<div id="message" class="error"><p>fdx_updater_get_file_contents returned: <br /><pre>' . print_r($result, true) . '</pre></p></div>';
		return false;
	}
}


	/*** Twitter OAuth Functions ***/
/* Get Request Tokens */

function fdx_updater_register($tokens)
{
	global $fdx_consumer_key, $fdx_consumer_secret;
	$connection = new FDXTwitterOAuth($fdx_consumer_key, $fdx_consumer_secret);

	// Get the request tokens
	$request = $connection->getRequestToken();

	// Retrive tokens from request and store in array
	$tokens['request_key'] = $request["oauth_token"];
	$tokens['request_secret'] = $request["oauth_token_secret"];

	// Generate a request link and output it
	$tokens['request_link'] = $connection->getAuthorizeURL($request);

	return $tokens;
}

/* Get Access Tokens */

function fdx_updater_authorise($tokens)
{
    global $fdx_consumer_key, $fdx_consumer_secret;
	$connection = new FDXTwitterOAuth($fdx_consumer_key, $fdx_consumer_secret, $tokens['request_key'], $tokens['request_secret']);

	// Get the access tokens
	$request = $connection->getAccessToken();

	/*
	 ------------------------------------------------------------------------------------------
	 *** A failed request (e.g. not authorised by user in twitter) is not handled at all  	***
	 *** and outputs an error array from getAccessToken() 					***
	 ------------------------------------------------------------------------------------------
	 */

	// Retrieve access token from request:
	$tokens['access_key'] = $request['oauth_token'];
	$tokens['access_secret'] = $request['oauth_token_secret'];

	return $tokens;
}

/* Validate Access */

function fdx_updater_verify($tokens)
{
	global $fdx_consumer_key, $fdx_consumer_secret;
	$connection = new FDXTwitterOAuth($fdx_consumer_key, $fdx_consumer_secret, $tokens['access_key'], $tokens['access_secret']);

	$result = $connection->get('account/verify_credentials');

	$verify = array(
		'exit_code' => '',
		'user_name' => '',
			);

	if ($result->id)
	{
		$verify['exit_code'] = "1";
		$verify['user_name'] = $result->screen_name;
	}
	else
	{
		$verify['exit_code'] = "3";
	}

	return $verify;
}

/* Send a Tweet */

function fdx_updater_update_status($tweet)
{

	$tokens = get_option('fdx_updater_auth');

	if( $tokens['auth3_flag'] == '1' )
	{
		global $fdx_consumer_key, $fdx_consumer_secret;
		$connection = new FDXTwitterOAuth($fdx_consumer_key, $fdx_consumer_secret, $tokens['access_key'], $tokens['access_secret']);

		// Post an update to Twitter via your application:
		$result = $connection->post('statuses/update', array('status' => $tweet));

	}
	else
	{
		$result = array(
			'plugin_error' => 'auth',
			'error_description' => '(( WP Twitter )) is not linked to a twitter account'
				);
	}

	return $result;
}


	/*** Default Values ***/


/* WP Twitter Consumer Keys for Twitter API. You can use your own keys instead by entering them on the admin page. */

global $fdx_updater_placeholders;
$fdx_updater_placeholders = "<br />
		   <small>Shortcodes:</small><br />
		   <code>#title#</code><small> (the title of your blog post) </small> <code>#url#</code><small> (the post URL)</small>
		   ";


/* Set defaults on first load. */

function fdx_updater_activate()
{
	// This won't overwrite the enries if the tokens and options are already set.

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

	add_option( 'fdx_updater_auth', $tokens_default, '', 'no' );

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
	 	'yourls_url' => '',
		'yourls_token' => '',
				);

	add_option( 'fdx_updater_options', $options_default, '', 'no' );

	// Load any new option defaults into the original options array
	$current_options = get_option('fdx_updater_options');

	// Check all options from the default array exist in the current array. If not, load the default values.
	// checking this way should eliminate any old items that are not in the default array.
	foreach( $options_default as $key => $value )
	{
		if( !isset($current_options[$key]) )
		{
			$new_options[$key] = $options_default[$key];
		}
		else
		{
			$new_options[$key] = $current_options[$key];
		}
	}

	//zz.gd has closed, removed for version 3.1, if chosen - reset to default
	if( $current_options['url_method'] == 'zzgd' ) { $new_options['url_method'] == 'default'; }

	update_option( 'fdx_updater_options', $new_options );
}

/* Intialise on first activation */
register_activation_hook( __FILE__, 'fdx_updater_activate' );



/* Display the Admin Options Page */

function fdx_updater_options_page() {
	$tokens = get_option('fdx_updater_auth');
	$options = get_option('fdx_updater_options');

	//style settings for form:
?>

<?php

	//If bit.ly is selected, but no account information is present, show a warning
	if ( $options['url_method'] == 'bitly' && ( empty( $options['bitly_username'] ) || empty( $options['bitly_appkey'] ) ) )
	{
		echo "<div class='error'><p><strong>Bit.ly is selected, but Bit.ly account information is missing.</strong></p></div>";
	}

	//If YOURLS is selected, but no API address is entered, show a warning
	if ( $options['url_method'] == 'yourls' && $options['yourls_url'] == 'http://' )
	{
		echo "<div class='error'><p><strong>YOURLS is selected, but an API page address is missing.</strong></p></div>";
	}

	//Twitter Authorisation form
?>
<div class="wrap">
<div id="icon-options-general" class="icon32 icon32-posts-post"><br /></div><h2><?php echo FDX1_PLUGIN_NAME;?>: <?php _e('Basic Settings and Connect', 'fdx-lang') ?></h2>
<?php
if ( ( isset( $_GET['updated'] ) && $_GET['updated'] == 'true' ) || ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == 'true' ) ) {
echo '<div class="updated fade"><p><strong>' . __( 'Settings updated', 'fdx-lang' ) . '.</strong></p></div>';
}
?>
<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">

<?php include('inc/sidebar.php'); ?>

<div class="postbox-container">
<div class="meta-box-sortables">

<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Basic Settings and Connect', 'fdx-lang') ?></span></h3>
<div class="inside">
<!-- ############################################################################################################### -->
<p><strong><?php echo FDX1_PLUGIN_NAME;?></strong> <?php _e('uses <acronym title="An open protocol to allow secure authorization in a simple and standard method from web, mobile and desktop applications.">OAuth</acronym> authentication to connect to Twitter. Follow the authentication process below to authorise this Plugin to access on your Twitter account. ', 'fdx-lang') ?> </p>
 <form action="options.php" method="post">
<?php 		settings_fields('fdx_updater_auth');

		// Logic to display the correct form, depending on authorisation stage
		if( $tokens['auth1_flag'] != '1' )
		{
			update_option('fdx_updater_auth', $tokens);
			do_settings_sections('auth_1a');?>
<div class="error fade"><p><strong><?php echo FDX1_PLUGIN_NAME;?> <?php _e('does not have access to a Twitter account yet.', 'fdx-lang') ?></strong></p></div>
<input name="Submit" class="button-primary"  type="submit" value="<?php _e('Register', 'fdx-lang') ?>" />
<?php		}
		elseif( $tokens['auth1_flag'] == '1' && $tokens['auth2_flag'] != '1' )
		{

			//do registration and generate the register link
			$tokens = fdx_updater_register($tokens);
			update_option('fdx_updater_auth', $tokens);

			do_settings_sections('auth_2a');
?>			<input name="Submit" class="button-primary"  type="submit" value="<?php _e('Authorise', 'fdx-lang') ?>" />
<?php		}
		else
		{
			if ( $tokens['auth2_flag'] == '1' && $tokens['auth3_flag'] != '1' )
			{
			//do authorisation
				$tokens = fdx_updater_authorise($tokens);
			}

			//do validation
			$verify = fdx_updater_verify($tokens);
			switch ($verify['exit_code'])
			{
			case '1':
				echo "<p>".__('Connection checked OK. Now you can post to', 'fdx-lang')." <a href='http://twitter.com/{$verify['user_name']}'><strong>@{$verify['user_name']}</strong></a></p>";
				$tokens['auth3_flag'] = '1'; //Will only validate until reset
				update_option('fdx_updater_auth', $tokens);?>
<?php 				break;
			case '2':
				echo "<div class='error'><p><strong>".__('Not able to validate access to account, Twitter is currently unavailable. Try checking again in a couple of minutes.', 'fdx-lang')."</strong></p></div>";
				$tokens['auth3_flag'] = '1'; //Will validate next time
				update_option('fdx_updater_auth', $tokens);
?>				<p class="submit" ><input name="Refresh" class="button-primary"  type="button" value="<?php _e('Check again', 'fdx-lang') ?>" onClick="history.go(0)" /></p>
<?php				break;
			case '3':
				echo "<div class='error'><p><strong>".__('WP Twitter does not have access to a Twitter account yet.', 'fdx-lang')."</strong></p></div>";
				$tokens['auth3_flag'] = '0';
				update_option('fdx_updater_auth', $tokens);
				do_settings_sections('auth_2a');
?>				<p class="submit" ><input name="Submit" class="button-primary"  type="submit" value="<?php _e('Authorise', 'fdx-lang') ?>" /></p>
<?php				break;
			default:
				echo "<div class='warning'>".__('WP Twitter is not currently authorised to use any account. Please reset and try again.', 'fdx-lang')."</strong></p></div>";
				update_option('fdx_updater_auth', $tokens);
			}
		}
?>
		</form>


<?php	// Button to reset OAuth process ?>
		<form action="options.php" method="post">
		<?php settings_fields('fdx_updater_auth'); ?>
         <h3></h3>
        <p><input name="Submit" class="button-secondary"  type="submit" value="<?php _e('Reset', 'fdx-lang') ?>" /> <em>(<?php _e('restart the authorisation procedure', 'fdx-lang') ?>)</em></p>
        <div class="hid">
				<?php do_settings_sections('fdx_auth_reset'); ?>
			</div>

		</form>
<!-- ############################################################################################################### -->
</div>
</div>

<form action="options.php" method="post">
<?php settings_fields('fdx_updater_options'); ?>
<div class="postbox closed">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Basic Settings', 'fdx-lang') ?></span></h3>
<div class="inside">
<!-- ############################################################################################################### -->
<?php do_settings_sections('fdx_new_post'); ?>

<?php do_settings_sections('fdx_edited_post'); ?>
<!-- ############################################################################################################### -->
</div>
</div>

<div class="postbox closed" >
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Limit Updating', 'fdx-lang') ?></span></h3>
<div class="inside">
<!-- ############################################################################################################### -->
<p><?php _e('Twitter messages can be sent only when the post is a member of a [selected category], OR that have a specified Custom Field [title] OR [title AND value].', 'fdx-lang') ?></p>
<?php do_settings_sections('fdx_limit_tweets'); ?>
<!-- ############################################################################################################### -->
</div>
</div>

<div class="postbox closed">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('URL Shortener Account Settings', 'fdx-lang') ?></span></h3>
<div class="inside">
<!-- ############################################################################################################### -->
<p><?php _e('Choose your short URL service (account settings below)', 'fdx-lang') ?></p>
<?php do_settings_sections('fdx_short_url'); ?>
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
<?php include('inc/footer_js.php'); ?>
<!-- carregar javascript especifico aqui -->
<div class="clear"></div>
<?php }

/* Set the Allowed Form Fields */

function fdx_updater_admin_init()
{
// Settings for OAuth procedure with Twitter
register_setting( 'fdx_updater_auth', 'fdx_updater_auth', 'fdx_updater_auth_validate' );

    	// Consumer Key fields
		add_settings_section('fdx_updater_auth1_flag', '', 'fdx_updater_auth1_flag', 'auth_1a', 'fdx_updater_consumer_keys');

    	// Register Keys switch
     	add_settings_section('fdx_updater_register_keys', 'test', 'fdx_updater_auth_2a', 'auth_2a');
		add_settings_field('fdx_updater_auth2_flag', '', 'fdx_updater_auth2_flag', 'auth_2a', 'fdx_updater_register_keys');

	// Reset button fields
    	add_settings_section('fdx_updater_reset', '', 'fdx_updater_reset', 'fdx_auth_reset');
		add_settings_field('fdx_updater_auth1_reset', '', 'fdx_updater_auth1_reset', 'fdx_auth_reset', 'fdx_updater_reset');
		add_settings_field('fdx_updater_auth2_reset', '', 'fdx_updater_auth2_reset', 'fdx_auth_reset', 'fdx_updater_reset');
		add_settings_field('fdx_updater_auth3_reset', '', 'fdx_updater_auth3_reset', 'fdx_auth_reset', 'fdx_updater_reset');
		add_settings_field('fdx_updater_req_key_reset', '', 'fdx_updater_req_key_reset', 'fdx_auth_reset', 'fdx_updater_reset');
		add_settings_field('fdx_updater_req_sec_reset', '', 'fdx_updater_req_sec_reset', 'fdx_auth_reset', 'fdx_updater_reset');
		add_settings_field('fdx_updater_req_link_reset', '', 'fdx_updater_req_link_reset', 'fdx_auth_reset', 'fdx_updater_reset');
		add_settings_field('fdx_updater_acc_key_reset', '', 'fdx_updater_acc_key_reset', 'fdx_auth_reset', 'fdx_updater_reset');
		add_settings_field('fdx_updater_acc_sec_reset', '', 'fdx_updater_acc_sec_reset', 'fdx_auth_reset', 'fdx_updater_reset');

// Settings for WP Twitter
register_setting( 'fdx_updater_options', 'fdx_updater_options', 'fdx_updater_options_validate' );

	//Section 1: New Post published
	add_settings_section('fdx_updater_new_post', '', 'fdx_updater_new_post', 'fdx_new_post');
		add_settings_field('fdx_updater_newpost_update', 'Update when a post is published.', 'fdx_updater_newpost_update', 'fdx_new_post', 'fdx_updater_new_post');
		add_settings_field('fdx_updater_newpost_format', 'Tweet format for a new post:', 'fdx_updater_newpost_format', 'fdx_new_post', 'fdx_updater_new_post');

	//Section 2: Updated Post
	add_settings_section('fdx_updater_edited_post', '', 'fdx_updater_edited_post', 'fdx_edited_post');
		add_settings_field('fdx_updater_edited_update', 'Update when a post is edited.', 'fdx_updater_edited_update', 'fdx_edited_post', 'fdx_updater_edited_post');
		add_settings_field('fdx_updater_edited_format', 'Tweet format for an updated post:', 'fdx_updater_edited_format', 'fdx_edited_post', 'fdx_updater_edited_post');

	// Section 3: Limit tweets to posts with certain custom field/value pair or part of a specific category
      	add_settings_section('fdx_updater_limit_tweets', '', 'fdx_updater_limit_tweets' ,'fdx_limit_tweets');
 	  	add_settings_field('fdx_updater_limit_to_category', 'If no categories are checked, limiting by category will be ignored, and all categories will be Tweeted.', 'fdx_updater_limit_to_category', 'fdx_limit_tweets', 'fdx_updater_limit_tweets');
		add_settings_field('fdx_updater_limit_to_customfield', 'Send tweets for posts with this Meta [Title] OR [Title AND Value]', 'fdx_updater_limit_to_customfield', 'fdx_limit_tweets', 'fdx_updater_limit_tweets');

	//Section 4: Short Url service
		add_settings_section('fdx_updater_chose_url', '', 'fdx_updater_chose_url1', 'fdx_short_url');
}
add_action( 'admin_init', 'fdx_updater_admin_init' );


/* Return Form components for the Allowed Form Fields */


// Consumer Keys form
function fdx_updater_auth1_flag()
	{ echo "<input id='fdx_updater_auth1_flag' type='hidden' name='fdx_updater_auth[auth1_flag]' value='1' />"; }

// Request link form
function fdx_updater_auth_2a()
	{ $tokens = get_option('fdx_updater_auth');
    echo "<h3>". __('Now you need to tell Twitter that you want to allow this plugin to be able to post using your account.', 'fdx-lang');
    echo "</h3><ol><li>". __('Go to:', 'fdx-lang')." <code><a href=\"javascript:void(0);\" onclick=\"PopupCenter('{$tokens['request_link']}', 'idunico',750,660,'no');\">{$tokens['request_link']}</a></code></li>";
    echo "<li>". __('Follow the instructions on the page to allow access to the plug-in.', 'fdx-lang')."</li>";
    echo "<li>". __('Return to this page to complete the process.', 'fdx-lang')."</li></ol>";
    }
function fdx_updater_auth2_flag()
		{ echo "<input id='fdx_updater_auth2_flag' type='hidden' name='fdx_updater_auth[auth2_flag]' value='1' />"; }

// Hidden status' for OAuth reset button
function fdx_updater_reset() { }
function fdx_updater_auth1_reset()
	{ echo "<input id='fdx_updater_auth1_reset' type='hidden' name='fdx_updater_auth[auth1_flag]' value='0' />"; }
function fdx_updater_auth2_reset()
	{ echo "<input id='fdx_updater_auth2_reset' type='hidden' name='fdx_updater_auth[auth2_flag]' value='0' />"; }
function fdx_updater_auth3_reset()
	{ echo "<input id='fdx_updater_auth3_reset' type='hidden' name='fdx_updater_auth[auth3_flag]' value='0' />"; }
function fdx_updater_req_key_reset()
	{ echo "<input id='fdx_updater_req_key_reset' type='hidden' name='fdx_updater_auth[request_key]' value='' />"; }
function fdx_updater_req_sec_reset()
	{ echo "<input id='fdx_updater_req_sec_reset' type='hidden' name='fdx_updater_auth[request_secret]' value='' />"; }
function fdx_updater_req_link_reset()
	{ echo "<input id='fdx_updater_req_link_reset' type='hidden' name='fdx_updater_auth[request_link]' value='' />"; }
function fdx_updater_acc_key_reset()
	{ echo "<input id='fdx_updater_acc_key_reset' type='hidden' name='fdx_updater_auth[access_key]' value='' />"; }
function fdx_updater_acc_sec_reset()
	{ echo "<input id='fdx_updater_acc_sec_reset' type='hidden' name='fdx_updater_auth[access_secret]' value='' />"; }

//New Post published
function fdx_updater_new_post() { }
function fdx_updater_newpost_update()
	{ $options = get_option('fdx_updater_options'); echo "<input id='fdx_updater_newpost_update' type='checkbox' name='fdx_updater_options[newpost_update]' value='1'"; if( $options['newpost_update'] == '1' ) { echo " checked='true'"; }; echo " /> <code>Set the plugin behaviour for when a new post is published.</code>"; }
function fdx_updater_newpost_format()
	{ global $fdx_updater_placeholders; $options = get_option('fdx_updater_options'); echo "<input id='fdx_updater_newpost_format' type='text' size='60' maxlength='100' name='fdx_updater_options[newpost_format]' value='{$options['newpost_format']}' />" . $fdx_updater_placeholders; }

//Updated Post
function fdx_updater_edited_post() { echo "<h3>&nbsp;</h3>"; }
function fdx_updater_edited_update()
	{ $options = get_option('fdx_updater_options'); echo "<input id='fdx_updater_edited_update' type='checkbox' name='fdx_updater_options[edited_update]' value='1'"; if( $options['edited_update'] == '1' ) { echo " checked='true'"; }; echo " /> <code>Set the plugin behaviour for when a previously published post is updated.</code>"; }
function fdx_updater_edited_format()
	{ global $fdx_updater_placeholders; $options = get_option('fdx_updater_options'); echo "<input id='fdx_updater_edited_format' type='text' size='60' maxlength='100' name='fdx_updater_options[edited_format]' value='{$options['edited_format']}' />" . $fdx_updater_placeholders; }

// Limit tweets to Categories and Custom Fields
function fdx_updater_limit_tweets()
	{ $options = get_option('fdx_updater_options');
       echo "<h3>Limit Twitter updates using the rules below? <input id='fdx_updater_limit_activate' type='checkbox' name='fdx_updater_options[limit_activate]' value='1'"; if( $options['limit_activate'] == '1' ) { echo " checked='true'"; }; echo " /></h3>";
    }

function fdx_updater_limit_to_category()
	{

	$options = get_option('fdx_updater_options');
	$categories=get_categories( array( 'orderby'=>'name', 'order'=>'ASC' , 'hide_empty'=>'0') );
	if ( !empty($categories) )
	{
		echo "</h3>";
			foreach($categories as $category)

            {
				echo "";
				echo "<input id='fdx_updater_limit_to_category_" . $category->name . "' type='checkbox' name='fdx_updater_options[limit_to_category][" . $category->name . "]' value='" . $category->cat_ID . "'";
				if(@$options['limit_to_category'][$category->name] == $category->cat_ID ) { echo " checked='true'"; };
				echo " />";
				echo " <label for='fdx_updater_limit_to_category_" . $category->name . "'>" . $category->name . "</label>";
            	echo "&nbsp;&nbsp;";
			}
	}
	else
	{
		echo "No categories set. You must create categories before using them as limit criterion.";
	}

	}
function fdx_updater_limit_to_customfield()
	{
	$options = get_option('fdx_updater_options');
	echo "<input id='fdx_updater_limit_to_custom_field_key' type='text' size='20' maxlength='250' name='fdx_updater_options[limit_to_custom_field_key]' value='{$options['limit_to_custom_field_key']}' />";
	echo "<label for='fdx_updater_limit_to_custom_field_key'> <code>Custom Field Title (key)</code></label><br />";
	echo "<input id='fdx_updater_limit_to_custom_field_val' type='text' size='20' maxlength='250' name='fdx_updater_options[limit_to_custom_field_val]' value='{$options['limit_to_custom_field_val']}' />";
	echo "<label for='fdx_updater_limit_to_custom_field_val'> <code>Custom Field Value (leave blank to match any value)</code></label>";
	}



//Short Url service

function fdx_updater_chose_url1()
{ 	$options = get_option('fdx_updater_options');

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
}




/* Form validaton functions */

function fdx_updater_auth_validate($input) //n.b. else statements required for checkboxes
{
	$tokens = get_option('fdx_updater_auth');

	// The WordPress Settings API will overwrite arrays in the database with only the fields used in the form
	// To retain all the fields, the use the changed items to update the original array.
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

	// The WordPress Settings API will overwrite arrays in the database with only the fields used in the form
	// To retain all the fields, the use the changed items to update the original array.
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