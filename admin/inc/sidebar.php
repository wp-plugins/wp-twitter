<div id="postbox-container-1" class="postbox-container">
<div id="side-sortables" class="meta-box-sortables">
<!-- <div class="postbox closed"> -->
<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php echo FDX_PLUGIN_N1;?> <small style="float: right">v<?php echo FDX_PLUGIN_V1;?></small></span></h3>
<div class="inside">
<div style="float: right; margin: 0 0 0 0"><a href="http://wp.webmais.com/wp-twitter/"><img src="<?php echo FDX_PLUGIN_U1;?>/images/logo.png" width="109" height="109" border="0" alt="" /></a></div>
<a class="sm_button sm_autor" href="http://fabrix.net"><?php _e('Author Homepage', 'fdx-lang') ?></a>
<a class="sm_button sm_wp" href="http://wordpress.org/extend/plugins/wp-twitter/"><?php _e('Plugin Homepage', 'fdx-lang') ?></a>
<a class="sm_button sm_code" href="#"><?php _e('Suggest a Feature', 'fdx-lang') ?></a>
<a class="sm_button sm_pay" href="#"><?php _e('Donate with PayPal', 'fdx-lang') ?></a>
<a class="sm_button sm_bug" href="#"><?php _e('Report a Bug', 'fdx-lang') ?></a>
</div>
</div>

<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Notices', 'fdx-lang') ?></span></h3>
<div class="inside">
<?php // Do a WP version check
global $wp_version;
if (version_compare($wp_version, FDX1_MINIMUM_WP_VER, '>=')) { ?>
<span class="ico_button ico_button_ok"><?php _e('Your WordPress version', 'fdx-lang') ?>: <strong><a href="http://wordpress.org" target="_blank"><?php global $wp_version; echo $wp_version; ?></a></strong></span>
<?php } else {
	echo '<span class="ico_button ico_button_error">';
	printf(__('Your WordPress version (<strong><a href="http://wordpress.org" target="_blank">%s</a></strong>) is old, please upgrade to a newer version.', 'fdx-lang'), FDX1_MINIMUM_WP_VER);
	echo "</span>\n";
   }
?>

<?php // Do a PHP version check
if (version_compare(PHP_VERSION, FDX1_MINIMUM_PHP_VER, '>=') ) { ?>
<span class="ico_button ico_button_ok"><?php _e('Your PHP version', 'fdx-lang') ?>: <strong><a href="http://www.php.net/" target="_blank"><?php echo phpversion();?></a></strong></span>
<?php } else {
	echo '<span class="ico_button ico_button_error">';
    echo (sprintf(__('Your PHP version (<strong><a href="http://www.php.net/" target="_blank">%s</a></strong>) is old, please upgrade to a newer version.', 'fdx-lang'), phpversion()));
	echo "</epan>\n";
  }
?>

</div>
</div>


<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Need premium support?', 'fdx-lang') ?></span></h3>
<div class="inside">
<p>coming soon</p>
</div>
</div>

<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Assess and contribute!', 'fdx-lang') ?></span></h3>
<div class="inside">
<?php _e('Want to help make this plugin even better? All donations are used to improve this plugin, so donate now!', 'fdx-lang') ?>
<div align="center"><img src="<?php echo FDX_PLUGIN_U1;?>/images/btn_donateCC_LG.gif" width="147" height="47" border="0" alt="" /></div>
<p><?php _e('Or you could:', 'fdx-lang') ?> </p>
<ul>
<li><a href="http://wordpress.webmais.com/wp-twitter/"><?php _e('Rate the plugin 5 star on WordPress.org', 'fdx-lang') ?></a></li>
<li><a href="http://wp.webmais.com/wp-twitter/"><?php _e('Blog about it & link to the plugin page', 'fdx-lang') ?></a></li>
</ul>

</div>
</div>

</div>
</div>