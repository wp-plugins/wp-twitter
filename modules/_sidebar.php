<?php
define('FDX1_WPPAGE', 'http://wordpress.org/extend/plugins/wp-twitter');
define('FDX1_PLUGINPAGE', 'http://fabrix.net/wp-twitter');
define('FDX1_GLOTPRESS', 'http://translate.fabrix.net/projects/wp-twitter');
define('FDX1_SUPFORUM', 'http://wordpress.org/support/plugin/wp-twitter');
define('FDX1_PAYPAL', 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Z9SRNRLLDAFZJ');
?>
<div id="postbox-container-1" class="postbox-container">
<div id="side-sortables" class="meta-box-sortables">
<!-- <div class="postbox closed"> -->
<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'wp-twitter') ?>"><br /></div><h3 class='hndle'><span><?php echo WP_Twitter::PLUGIN_NAME;?> <small style="float: right">v<?php echo WP_Twitter::PLUGIN_VERSION;?></small></span></h3>
<div class="inside" style="padding-bottom: 5px">
<div style="float: right;"><a href="<?php echo FDX1_PLUGINPAGE;?>" target="_blank"><img src="<?php echo plugins_url( 'images/logo.png', dirname(__FILE__));?>" width="91" height="106" border="0" alt="*" /></a></div>
<a class="sm_button sm_autor" href="<?php echo FDX1_PLUGINPAGE;?>" target="_blank"><?php _e('Plugin Homepage', 'wp-twitter') ?></a>
<a class="sm_button sm_code" href="<?php echo FDX1_SUPFORUM;?>" target="_blank"><?php _e('Suggest a Feature', 'wp-twitter') ?></a>
<a class="sm_button sm_bug" href="<?php echo FDX1_SUPFORUM;?>" target="_blank"><?php _e('Report a Bug', 'wp-twitter') ?></a>
<a class="sm_button sm_lang" href="<?php echo FDX1_GLOTPRESS;?>" target="_blank"><?php _e('Help translating it', 'wp-twitter') ?></a>
</div>
</div>

<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'wp-twitter') ?>"><br /></div><h3 class='hndle'><span><?php _e('Do you like this Plugin?', 'wp-twitter') ?></span></h3>
<div class="inside">
<?php _e('Please help to support continued development of this plugin!', 'wp-twitter') ?>
<div align="center">
<strong style="font-size: 15px"><?php _e('DONATE', 'wp-twitter') ?></strong><br />
<a href="<?php echo FDX1_PAYPAL ;?>" target="_blank"><img src="<?php echo plugins_url( 'images/paypal.png', dirname(__FILE__));?>" width="101" height="64" border="0"  alt=""/></a>
<a href="http://www.neteller.com/personal/send-money/" id="cl" target="_blank" title="fabrix@fabrix.net"><img src="<?php echo plugins_url( 'images/neteller.png', dirname(__FILE__));?>" width="102" height="64" border="0" alt=""  style="margin-left: 25px" /></a>
</div>
<ul>
<li><a class="sm_button sm_star" href="http://wordpress.org/extend/plugins/wp-twitter" target="_blank"><?php _e('Rate the plugin 5 star on WordPress.org', 'wp-twitter') ?>.</a></li>
<li><a class="sm_button sm_link" href="<?php echo FDX1_PLUGINPAGE ;?>" target="_blank"><?php _e('Blog about it and link to the plugin page', 'wp-twitter') ?>.</a></li>
</ul>

<div align="center">
<a href="javascript:void(0);" onclick="PopupCenter('http://www.facebook.com/sharer.php?u=<?php echo FDX1_PLUGINPAGE;?>&t=<?php echo WP_Twitter::PLUGIN_NAME;?>:', 'facebook',800,550,'no');" title="<?php _e('Share on', 'wp-twitter') ?> Facebook" rel="nofollow"><img src="<?php echo plugins_url( 'images/facebook.png', dirname(__FILE__));?>" width="24" height="24" border="0"  alt="*" style="margin-right: 10px" /></a>
<a href="javascript:void(0);" onclick="PopupCenter('http://twitter.com/share?text=Plugin <?php echo WP_Twitter::PLUGIN_NAME;?>:&amp;url=<?php echo FDX1_PLUGINPAGE;?>', 'twitter',600,450,'no');" title="<?php _e('Share on', 'wp-twitter') ?> Twitter" rel="nofollow"><img src="<?php echo plugins_url( 'images/twitter.png', dirname(__FILE__));?>" width="24" height="24" border="0" alt="*" style="margin-right: 10px" /></a>
<a href="javascript:void(0);" onclick="PopupCenter('https://plus.google.com/share?url=<?php echo FDX1_PLUGINPAGE;?>', 'googleplus',800,550,'no');" title="<?php _e('Share on', 'wp-twitter') ?> Google Plus" rel="nofollow"><img src="<?php echo plugins_url( 'images/googleplus.png', dirname(__FILE__));?>" width="24" height="24" border="0" alt="*" /></a>
</div>
</div>
</div>

<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'wp-twitter') ?>"><br /></div><h3 class='hndle'><span><?php _e('Translation', 'wp-twitter') ?></span></h3>
<div class="inside">

<?php if (WPLANG == '' || WPLANG == 'en' || WPLANG == 'en_US'  ){ ?>

<strong>Would you like to help translating this plugin?</strong> Contribute a translation using the GlotPress web interface - no technical knowledge required (<strong><a href="<?php echo FDX1_GLOTPRESS;?>" target="_blank">how to</a></strong>)

<?php } else { ?>

<span class="ico_button ico_button_<?php echo WPLANG;?>"><?php _e('Translated by: <a href="http://YOUR-LINK.COM"><strong>Your Name</strong></a>', 'wp-twitter') ?></span>

<p><?php _e('If you find any spelling error in this translation or would like to contribute', 'wp-twitter') ?>, <a href="<?php echo FDX1_GLOTPRESS;?>" target="_blank"><?php _e('click here', 'wp-twitter') ?>.</a></p>

<?php } ?>
</div>
</div>

<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'wp-twitter') ?>"><br /></div><h3 class='hndle'><span><?php _e('Notices', 'wp-twitter') ?></span></h3>
<div class="inside">
 <?php
    $rss = @fetch_feed( 'http://feeds.feedburner.com/fdxplugins/' );

    if ( is_object($rss) ) {

        if ( is_wp_error($rss) ) {
            echo 'Newsfeed could not be loaded.';
    		return;
        }

        echo '<ul>';
		foreach ( $rss->get_items(0, 5) as $item ) {
    		$link = $item->get_link();
    		while ( stristr($link, 'http') != $link )
    			$link = substr($link, 1);
    		$link = esc_url(strip_tags($link));
    		$title = esc_attr(strip_tags($item->get_title()));
    		if ( empty($title) )
    			$title = __('Untitled');

			$date = $item->get_date();
            $diff = '';

			if ( $date ) {

                $diff = human_time_diff( strtotime($date, time()) );

				if ( $date_stamp = strtotime( $date ) )
					$date =  date_i18n( get_option( 'date_format' ), $date_stamp );
				else
					$date = '';
			}
        ?>
          <li style=" margin-top: -2px; margin-bottom: -2px"><a class="sm_button sm_bullet" title="<?php echo $date; ?>" target="_blank" href="<?php echo $link; ?>"><?php echo $title; ?> <em class="none"><?php echo $diff; ?></em></a>
		  </li>
        <?php
        }
        echo '</ul>';
      }
    ?>

</div>
</div>

</div>
</div>