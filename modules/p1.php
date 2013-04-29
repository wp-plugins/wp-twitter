<?php $settings = fdx1_get_settings(); ?>

<div class="wrap"><?php echo get_screen_icon('fdx-lock');?>
<h2><?php echo WP_Twitter::PLUGIN_NAME;?>: <?php _e('Widgets Settings', 'wp-twitter') ?></h2>
<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">

<?php include('_sidebar.php'); ?>

<div class="postbox-container">
<div class="meta-box-sortables">

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<input type="hidden" name="info_update" id="info_update" value="true" />

<div class="postbox" >
<div class="handlediv" title="<?php _e('Click to toggle', 'wp-twitter') ?>"><br /></div><h3 class='hndle'><span class="icon1">&nbsp;</span><?php _e('Connect to Twitter', 'wp-twitter') ?></h3>
<div class="inside">
<!-- ############################################################################################################### -->





<?php if ( !$settings['oauth_access_token'] ) { ?>

<div class="fdx-left-content">
<p><?php _e('uses OAuth authentication to connect to Twitter. Follow the authentication process below to authorise this Plugin to access on your Twitter account. ', 'wp-twitter') ?></p>
</div><!-- left content -->

<div class="fdx-right-content">
<?php $auth_url = fdx1_get_auth_url(); ?>
<?php if ( $auth_url ) { ?>
<p><a href="<?php echo $auth_url; ?>" title="<?php _e( 'Sign in with Twitter', 'wp-twitter' ); ?>"><img src="<?php echo plugins_url( 'images/sign-in-with-twitter-gray.png', dirname(__FILE__));?>" width="158" height="28" alt=""></a></p>

<?php } else { ?>
<h4><?php _e( 'Not able to validate access to account, Twitter is currently unavailable. Try checking again in a couple of minutes.', 'wp-twitter' ); ?></h4>
<?php } ?>


</div><!-- right content -->
<?php } else { ?>
<div class="fdx-left-content">
<div style=" float: left; margin-right: 10px">
<img class="avatar" src="<?php echo $settings['profile_image_url']; ?>" alt="" /></div>
<h3><?php echo $settings['screen_name']; ?></h3>
<?php if ( $settings['location'] ) { ?>
<?php echo $settings['location']; ?>
<?php } ?>
</div><!-- left content -->

<div class="fdx-right-content">
<p><?php _e( 'Your account has  been authorized.', 'wp-twitter' ); ?> (<strong><a href="<?php echo $_SERVER['REQUEST_URI']; ?>&fdx1=deauthorize" onclick="return confirm( '<?php _e( 'Are you sure you want to deauthorize your Twitter account?', 'wp-twitter' ); ?>');"><?php _e( 'Deauthorize', 'wp-twitter' ); ?></a></strong>)</p>
</div><!-- right content -->
<?php } ?>



<div class="fdx-clear"></div>
<!-- ############################################################################################################### -->
</div>
</div>

<div class="postbox" >
<div class="handlediv" title="<?php _e('Click to toggle', 'wp-twitter') ?>"><br /></div><h3 class='hndle'><span class="icon3">&nbsp;</span><?php _e('Basic Settings', 'wp-twitter') ?></h3>
<div class="inside">
<!-- ############################################################################################################### -->

     <div class="fdx-left-content">
<p><strong><?php _e('Shortcodes', 'wp-twitter');?></strong></p>

<div style="width: 60px; float: left"><strong><code>[title]</code><br /><code>[link]</code><br /><code>[author]</code><br/><code>[cat]</code><br/><code>[tags]</code></strong></div>
<small><?php _e('The title of your blog post.', 'wp-twitter') ?>.</small><br/>
<small><?php _e('The post URL', 'wp-twitter')?>. </small><br/>
<small><?php _e('Post author\'s', 'wp-twitter')?>.</small> <br/>
<small><?php _e('The first category', 'wp-twitter')?>.</small> <br/>
<small><?php _e('Post tags', 'wp-twitter')?>.</small>* <br/>
<p style="margin-top: 10px"><small>*<?php _e('Modified into hashtags, show only 3 tags of less than 15 characters each, and space replaced by', 'wp-twitter')?> (<code>_</code>)</small></p>
</div><!-- left content -->
<div class="fdx-right-content">

<p><strong> <?php _e('Text for new post updates', 'wp-twitter')?>:</strong> </p>

<input type="text" name="message" value="<?php echo( htmlentities( $settings['message'], ENT_COMPAT, "UTF-8" ) ); ?>" class="long" />


                        	</div><!-- right content -->
			<div class="fdx-clear"></div>
<!-- ############################################################################################################### -->
</div>
</div>

<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'wp-twitter') ?>"><br /></div><h3 class='hndle'><span class="icon2">&nbsp;</span><?php _e('URL Shortener Account Settings', 'wp-twitter') ?></h3>
<div class="inside">
<!-- ############################################################################################################### -->
<div class="fdx-left-content">
<p><?php _e('Long URLs will automatically be shortened using the specified URL shortener.', 'wp-twitter' ); ?></p>
</div><!-- left content -->
<div class="fdx-right-content">
<select name="fdx1-url-type" class="long select" id="url_shortener">
<option value="post_id"<?php if ( $settings['url_type'] == 'post_id' ) echo " selected"; ?>><?php _e( "Post ID", "fdx1" ); ?> (<?php echo fdx1_post_id_url_base() . '10'; ?>)</option>
<option value="tinyurl"<?php if ( $settings['url_type'] == 'tinyurl' ) echo " selected"; ?>>Tinyurl</option>
<option value="isgd"<?php if ( $settings['url_type'] == 'isgd' ) echo " selected"; ?>>Is.gd</option>
<option value="bitly"<?php if ( $settings['url_type'] == 'bitly' ) echo " selected"; ?>>Bit.ly</option>
<option value="yourls"<?php if ( $settings['url_type'] == 'yourls' ) echo " selected"; ?>>YOURLS</option>
</select>


     			   <div id="select2">
     				<ul>
                    <li>
		     		<input type="text" name="bitly-user-name" id="bitly-user-name" value="<?php if ( isset( $settings['bitly-user-name'] ) ) echo $settings['bitly-user-name']; ?>" />
		     		<label for="bitly-user-name"><?php _e( 'User Name', 'wp-twitter' ); ?></label>
	     			</li>
	     			<li>
		     		<input type="text" name="bitly-api-key" id="bitly-api-key" value="<?php if ( isset( $settings['bitly-api-key'] ) ) echo $settings['bitly-api-key']; ?>" />
		     		<label for="bitly-api-key">API key</label>
	     			</li>
                    </ul>
	     			</div>
<div id="select1">
<ul>
<li>
		     		<input type="text" name="yourls-user-name" id="yourls-user-name" value="<?php if ( isset( $settings['yourls-user-name'] ) ) echo $settings['yourls-user-name']; ?>" />
		     		<label for="yourls-user-name">Signature Token</label>
	     			</li>
	     			<li>
		     		<input type="text" name="yourls-api-key" id="yourls-api-key" value="<?php if ( isset( $settings['yourls-api-key'] ) ) echo $settings['yourls-api-key']; ?>" />
		     		<label for="yourls-api-key"><?php _e( 'Full URL path to', 'wp-twitter' ); ?> yourls-api.php</label>
	     			</li>
                    </ul>
</div>

				</div><!-- right content -->

                  <div class="fdx-clear"></div>

<!-- ############################################################################################################### -->
</div>
</div>


<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'wp-twitter') ?>"><br /></div><h3 class='hndle'><span class="icon4">&nbsp;</span><?php _e('Limit Updating', 'wp-twitter') ?></h3>
<div class="inside">
<!-- ############################################################################################################### -->
   <div class="fdx-left-content">
						<p><?php _e( 'The default behaviour is to publish all new posts as Tweets to your Twitter stream', 'wp-twitter' ); ?>.</p>
						<p><?php _e( 'Can also be configured to include/exclude entries that have a specific tag, category or Associated Tag/Categorie', 'wp-twitter' ); ?>.</p>
				</div><!-- left content -->

				<div class="fdx-right-content">
                   <p><strong><?php _e('Tags, Categories, Tag/Categorie', 'wp-twitter' ); ?> </strong><small><?php _e('(comma separated)', 'wp-twitter' ); ?></small> </p>

							<input type="text" id="fdx1-tags" name="fdx1-tags" value="<?php echo implode( $settings['tags'], ', '); ?>" class="long"/>


						<p><input type="checkbox" class="check" id="fdx1-reverse" name="fdx1-reverse"<?php if ( $settings['reverse'] ) echo ' checked'; ?> />
						<label for="fdx1-reverse"><?php _e( 'Reverses default behavior', 'wp-twitter' ); ?> <small><?php _e( '(exclude tags/categories listed above)', 'wp-twitter' ); ?></small></label>
</p>
				</div><!-- right content -->
			<div class="fdx-clear"></div>


<!-- ############################################################################################################### -->
</div>
</div>
<div style="text-align: center"><input name="fdx1_update_settings" class="button-primary" type="submit" value="<?php _e('Save All Options', 'wp-twitter') ?>" /></div>
</form>

<div style="float: left">
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<input type="submit" onclick="return confirm('<?php _e('Restore Default Settings?', 'wp-twitter' ); ?>');" name="reset" value="<?php _e('Restore Defaults', 'wp-twitter' ); ?>" class="button" />
</form>
</div>
</div>
</div>



</div>
</div>


</div><!-- /wrap -->
<div class="clear"></div>
