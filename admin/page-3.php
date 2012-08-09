<?php
/* DEFAULT OPTIONS
*------------------------------------------------------------*/
add_option('wp_twitter_fdx_tweet_button_display_single', '1');
add_option('wp_twitter_fdx_tweet_button_display_page', '1');
add_option('wp_twitter_fdx_tweet_button_display_home', '-1');
add_option('wp_twitter_fdx_tweet_button_display_arquive', '-1');
add_option('wp_twitter_fdx_tweet_button_place', 'after');
add_option('wp_twitter_fdx_tweet_button_style', 'large_buton');
add_option('wp_twitter_fdx_tweet_button_choose', 'direct_post');
add_option('wp_twitter_fdx_tweet_button_container', 'text-align: center');
add_option('wp_twitter_fdx_tweet_button_twitter_username', '');

function filter_wp_twitter_fdx_tweet_button_show($related_content)
{

    $tweet_btn_display_single = get_option('wp_twitter_fdx_tweet_button_display_single');
	$tweet_btn_display_page = get_option('wp_twitter_fdx_tweet_button_display_page');
	$tweet_btn_display_home = get_option('wp_twitter_fdx_tweet_button_display_home');
	$tweet_btn_display_arquive = get_option('wp_twitter_fdx_tweet_button_display_arquive');
	$tweet_btn_place = get_option('wp_twitter_fdx_tweet_button_place');
	$tweet_btn_style = get_option('wp_twitter_fdx_tweet_button_style');
	$tweet_btn_float = get_option('wp_twitter_fdx_tweet_button_container');
	$tweet_btn_twt_username = get_option('wp_twitter_fdx_tweet_button_twitter_username');


//	global $post;
//	$p = $post;
//	$title1 = $p->post_title ;
//	$link1 = get_permalink($p);
//	$blog_url = get_bloginfo('wpurl');
//	$blog_title = get_bloginfo('wp_title');

if ($tweet_btn_style == "large_buton")
    {
//	$final_url2 = '<a href="http://twitter.com/share?url='.$link1.'&via='.$tweet_btn_twt_username.'&text='.$title1.'&count='.$tweet_btn_style.'" class="twitter-share-button">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
 	$final_url2 = '<span class="st_twitter_large" displayText="Tweet"></span><span class="st_facebook_large" displayText="Facebook"></span><span class="st_googleplus_large" displayText="Google +"></span><span class="st_email_large" displayText="Email"></span><span class="st_sharethis_large" displayText="ShareThis"></span> ';
    $final_url2 = '<div style="'.$tweet_btn_float.'">' . $final_url2 . '</div>';
 }

if ($tweet_btn_style == "small_buton")
    {
    $final_url2 = '<span class="st_twitter"></span><span class="st_facebook"></span><span class="st_googleplus" ></span><span class="st_email"></span><span class="st_sharethis"></span>';
    $final_url2 = '<div style="'.$tweet_btn_float.'">' . $final_url2 . '</div>';
    }

if ($tweet_btn_style == "h_count_buton")
    {
  	$final_url2 = '<span class="st_twitter_hcount" displayText="Tweet"></span><span class="st_fblike_hcount" displayText="Facebook Like"></span><span class="st_plusone_hcount" displayText="Google +1"></span><span class="st_email_hcount" displayText="Email"></span><span class="st_sharethis_hcount" displayText="ShareThis"></span>';
    $final_url2 = '<div style="'.$tweet_btn_float.'">' . $final_url2 . '</div>';
   }

if ($tweet_btn_style == "v_count_buton")
    {
  	$final_url2 = '<span class="st_twitter_vcount" displayText="Tweet"></span><span class="st_fblike_vcount" displayText="Facebook Like"></span><span class="st_plusone_vcount" displayText="Google +1"></span><span class="st_email_vcount" displayText="Email"></span><span class="st_sharethis_vcount" displayText="ShareThis"></span>';
    $final_url2 = '<div style="'.$tweet_btn_float.'">' . $final_url2 . '</div>';
    }

if (is_single() && $tweet_btn_display_single == 1)
{
			if ($tweet_btn_place == "before")
			{
				$related_content =  $final_url2 . $related_content;
			}
			if ($tweet_btn_place == "after")
			{
				$related_content =  $related_content . $final_url2;
			}
			if ($tweet_btn_place == "manual")
			{
				fdx_admin_add_page();  //reset
			}
		}

if (is_page() && $tweet_btn_display_page == 1)
		{
			if ($tweet_btn_place == "before")
			{
				$related_content =  $final_url2 . $related_content;
			}
			if ($tweet_btn_place == "after")
			{
				$related_content =  $related_content . $final_url2;
			}
			if ($tweet_btn_place == "manual")
			{
				fdx_admin_add_page(); //reset
			}
		}

if (is_home() && $tweet_btn_display_home == 1)
		{
			if ($tweet_btn_place == "before")
			{
				$related_content =  $final_url2 . $related_content;
			}
			if ($tweet_btn_place == "after")
			{
				$related_content =  $related_content . $final_url2;
			}
			if ($tweet_btn_place == "manual")
			{
				fdx_admin_add_page();   //reset
			}
		}

if (is_archive() && $tweet_btn_display_arquive == 1)
		{
			if ($tweet_btn_place == "before")
			{
				$related_content =  $final_url2 . $related_content;
			}
			if ($tweet_btn_place == "after")
			{
				$related_content =  $related_content . $final_url2;
			}
			if ($tweet_btn_place == "manual")
			{
				fdx_admin_add_page();  //reset
			}
		}

// $post = $p;
return $related_content;

}//end add content

//---------------------------------------------------add manual
function fdx_add_sharethis()
{
    $tweet_btn_display_single = get_option('wp_twitter_fdx_tweet_button_display_single');
	$tweet_btn_display_page = get_option('wp_twitter_fdx_tweet_button_display_page');
	$tweet_btn_display_home = get_option('wp_twitter_fdx_tweet_button_display_home');
	$tweet_btn_display_arquive = get_option('wp_twitter_fdx_tweet_button_display_arquive');
	$tweet_btn_place = get_option('wp_twitter_fdx_tweet_button_place');
	$tweet_btn_style = get_option('wp_twitter_fdx_tweet_button_style');
	$tweet_btn_float = get_option('wp_twitter_fdx_tweet_button_container');
	$tweet_btn_twt_username = get_option('wp_twitter_fdx_tweet_button_twitter_username');

if ($tweet_btn_style == "large_buton")
    {
//	$final_url2 = '<a href="http://twitter.com/share?url='.$link1.'&via='.$tweet_btn_twt_username.'&text='.$title1.'&count='.$tweet_btn_style.'" class="twitter-share-button">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
 	$final_url2 = '<span class="st_twitter_large" displayText="Tweet"></span><span class="st_facebook_large" displayText="Facebook"></span><span class="st_googleplus_large" displayText="Google +"></span><span class="st_email_large" displayText="Email"></span><span class="st_sharethis_large" displayText="ShareThis"></span> ';
    $final_url2 = '<div style="'.$tweet_btn_float.'">' . $final_url2 . '</div>';
 }

if ($tweet_btn_style == "small_buton")
    {
    $final_url2 = '<span class="st_twitter"></span><span class="st_facebook"></span><span class="st_googleplus" ></span><span class="st_email"></span><span class="st_sharethis"></span>';
    $final_url2 = '<div style="'.$tweet_btn_float.'">' . $final_url2 . '</div>';
    }

if ($tweet_btn_style == "h_count_buton")
    {
  	$final_url2 = '<span class="st_twitter_hcount" displayText="Tweet"></span><span class="st_fblike_hcount" displayText="Facebook Like"></span><span class="st_plusone_hcount" displayText="Google +1"></span><span class="st_email_hcount" displayText="Email"></span><span class="st_sharethis_hcount" displayText="ShareThis"></span>';
    $final_url2 = '<div style="'.$tweet_btn_float.'">' . $final_url2 . '</div>';
   }

if ($tweet_btn_style == "v_count_buton")
    {
  	$final_url2 = '<span class="st_twitter_vcount" displayText="Tweet"></span><span class="st_fblike_vcount" displayText="Facebook Like"></span><span class="st_plusone_vcount" displayText="Google +1"></span><span class="st_email_vcount" displayText="Email"></span><span class="st_sharethis_vcount" displayText="ShareThis"></span>';
    $final_url2 = '<div style="'.$tweet_btn_float.'">' . $final_url2 . '</div>';
    }

echo $final_url2;

}


//---------------------------------------------------add footer
//add script sharethis
function fdx_sharethis_script() {
    $tweet_btn_twt_username = get_option('wp_twitter_fdx_tweet_button_twitter_username');
    $tweet_btn_display_single = get_option('wp_twitter_fdx_tweet_button_display_single');
	$tweet_btn_display_page = get_option('wp_twitter_fdx_tweet_button_display_page');
	$tweet_btn_display_home = get_option('wp_twitter_fdx_tweet_button_display_home');
	$tweet_btn_display_arquive = get_option('wp_twitter_fdx_tweet_button_display_arquive');
    $tweet_btn_choose = get_option('wp_twitter_fdx_tweet_button_choose');

  if ($tweet_btn_choose == "multi_post")
    {
     $widget_style = 'true';
    }

 if ($tweet_btn_choose == "direct_post")
    {
     $widget_style = 'false';
    }



//adiciona se ativado
  if (is_single() && $tweet_btn_display_single == 1 || is_page() && $tweet_btn_display_page == 1 || is_archive() && $tweet_btn_display_arquive == 1 || is_home() && $tweet_btn_display_home == 1) {
       echo "<!-- WP Twitter - http://wp.webmais.com/wp-twitter  -->\n";
       echo "<script type='text/javascript'>var switchTo5x=". $widget_style .";</script>\n";
       echo "<script type='text/javascript' src='http://w.sharethis.com/button/buttons.js'></script>\n";
       echo "<script type='text/javascript'>stLight.options({publisher: '" . $tweet_btn_twt_username . "'}); </script>\n";
      }
}
add_action( 'wp_head', 'fdx_sharethis_script' );
//---------------------------------------------------

function wp_twitter_fdx_social() {
   	$wp_twitter_fdx_tweet_button_place = @$_POST['wp_twitter_fdx_tweet_button_place'];
	$wp_twitter_fdx_tweet_button_style = @$_POST['wp_twitter_fdx_tweet_button_style'];
    $wp_twitter_fdx_tweet_button_choose  = @$_POST['wp_twitter_fdx_tweet_button_choose'];

    if (isset($_POST['info_update2']))
    {
        update_option('wp_twitter_fdx_tweet_button_display_single', (@$_POST['wp_twitter_fdx_tweet_button_display_single']=='1') ? '1':'-1' );
		update_option('wp_twitter_fdx_tweet_button_display_page', (@$_POST['wp_twitter_fdx_tweet_button_display_page']=='1') ? '1':'-1' );
		update_option('wp_twitter_fdx_tweet_button_display_home', (@$_POST['wp_twitter_fdx_tweet_button_display_home']=='1') ? '1':'-1' );
		update_option('wp_twitter_fdx_tweet_button_display_arquive', (@$_POST['wp_twitter_fdx_tweet_button_display_arquive']=='1') ? '1':'-1' );
		update_option('wp_twitter_fdx_tweet_button_container', stripslashes_deep((string)$_POST['wp_twitter_fdx_tweet_button_container']));
		update_option('wp_twitter_fdx_tweet_button_twitter_username', stripslashes_deep((string)$_POST['wp_twitter_fdx_tweet_button_twitter_username']));
    	update_option('wp_twitter_fdx_tweet_button_place', stripslashes_deep((string)@$_POST['wp_twitter_fdx_tweet_button_place']));
		update_option('wp_twitter_fdx_tweet_button_style', stripslashes_deep((string)@$_POST['wp_twitter_fdx_tweet_button_style']));
 		update_option('wp_twitter_fdx_tweet_button_choose', stripslashes_deep((string)@$_POST['wp_twitter_fdx_tweet_button_choose']));
       echo '<div class="updated fade"><p><strong>' . __( 'Settings updated', 'fdx-lang' ) . '.</strong></p></div>';
        } else {
	$wp_twitter_fdx_tweet_button_place = get_option('wp_twitter_fdx_tweet_button_place');
	$wp_twitter_fdx_tweet_button_style = get_option('wp_twitter_fdx_tweet_button_style');
    $wp_twitter_fdx_tweet_button_choose  = get_option('wp_twitter_fdx_tweet_button_choose');
}
?>

<div class="wrap">
<div id="icon-edit" class="icon32 icon32-posts-post"><br /></div><h2><?php echo FDX1_PLUGIN_NAME;?>: <?php _e('Button Integration', 'fdx-lang') ?></h2>
<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">

<?php include('inc/sidebar.php'); ?>

<div class="postbox-container">
<div class="meta-box-sortables">

<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<input type="hidden" name="info_update2" id="info_update" value="true" />

<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Sharethis Button integration', 'fdx-lang') ?></span></h3>
<div class="inside">
<table style="width: 100%;">
<tr>
<td style="width: 150px; vertical-align: top"><p><strong><?php _e('Allow itegration in:', 'fdx-lang') ?></strong> </p></td>
<td style="width: auto; vertical-align: top" colspan="2">
<ul>
<li><input name="wp_twitter_fdx_tweet_button_display_single" type="checkbox"<?php if(get_option('wp_twitter_fdx_tweet_button_display_single')!='-1') echo 'checked="checked"'; ?> value="1" /> <?php _e('Single', 'fdx-lang') ?> </li>
<li><input name="wp_twitter_fdx_tweet_button_display_page" type="checkbox"<?php if(get_option('wp_twitter_fdx_tweet_button_display_page')!='-1') echo 'checked="checked"'; ?> value="1" /> <?php _e('Pages', 'fdx-lang') ?> </li>
<li><input name="wp_twitter_fdx_tweet_button_display_home" type="checkbox"<?php if(get_option('wp_twitter_fdx_tweet_button_display_home')!='-1') echo 'checked="checked"'; ?> value="1" /> <?php _e('Front Page (Home)', 'fdx-lang') ?> </li>
<li><input name="wp_twitter_fdx_tweet_button_display_arquive" type="checkbox"<?php if(get_option('wp_twitter_fdx_tweet_button_display_arquive')!='-1') echo 'checked="checked"'; ?> value="1" /> <?php _e('Archive (Category, Tags, ...)', 'fdx-lang') ?> </li>
</ul>
</td>
</tr>
<tr>
<td colspan="3"><h3 style="margin: 0; padding: 0">&nbsp;</h3></td>
</tr>
<tr>
<td style="width: 150px; vertical-align: top"><p><strong><?php _e('Placing Option:', 'fdx-lang') ?></strong></p></td>
<td style="width: auto; vertical-align: top" colspan="2">

<ul>
<li><input name="wp_twitter_fdx_tweet_button_place" type="radio" value="before" <?php checked('before', $wp_twitter_fdx_tweet_button_place); ?> /> <?php _e('Before Content', 'fdx-lang') ?></li>
<li><input name="wp_twitter_fdx_tweet_button_place" type="radio" value="after" <?php checked('after', $wp_twitter_fdx_tweet_button_place); ?> /> <?php _e('After Content (default)', 'fdx-lang') ?></li>
<li><input name="wp_twitter_fdx_tweet_button_place" type="radio" value="manual" <?php checked('manual', $wp_twitter_fdx_tweet_button_place); ?> /> <?php _e('Manual add', 'fdx-lang') ?> <code>&lt;?php if(function_exists('fdx_add_sharethis')) { fdx_add_sharethis();} ?&gt;</code></li>
</ul>
 </td>
 </tr>
<tr>
<td colspan="3"><h3 style="margin: 0; padding: 0">&nbsp;</h3></td>
</tr>
<tr>
<td style="width: 150px; vertical-align: top"><p><strong><?php _e('Style of share this', 'fdx-lang') ?>  </strong></p></td>
<td style="width: 200px; vertical-align: top">
<ul>
<li><input name="wp_twitter_fdx_tweet_button_style" type="radio" value="small_buton" <?php checked('small_buton', $wp_twitter_fdx_tweet_button_style); ?> /> <?php _e('Small Butons (16x16)', 'fdx-lang') ?></li>
<li><input name="wp_twitter_fdx_tweet_button_style" type="radio" value="large_buton" <?php checked('large_buton', $wp_twitter_fdx_tweet_button_style); ?> /> <?php _e('Large Buttons (32x32)', 'fdx-lang') ?></li>
<li><input name="wp_twitter_fdx_tweet_button_style" type="radio" value="h_count_buton" <?php checked('h_count_buton', $wp_twitter_fdx_tweet_button_style); ?> /> <?php _e('Horizontal Count', 'fdx-lang') ?></li>
<li><input name="wp_twitter_fdx_tweet_button_style" type="radio" value="v_count_buton" <?php checked('v_count_buton', $wp_twitter_fdx_tweet_button_style); ?> /> <?php _e('Vertical Count', 'fdx-lang') ?></li>
</ul>
</td>
<td>
<table>
<tr>
<td style="text-align: left; vertical-align: top">
<p><img src="<?php echo FDX1_PLUGIN_URL;?>/images/but1.png" width="120" height="16" border="0" alt="" /> </p>
<p><img src="<?php echo FDX1_PLUGIN_URL;?>/images/but2.png" width="166" height="30" border="0" alt="" />  </p>
<p><img src="<?php echo FDX1_PLUGIN_URL;?>/images/but3.png" width="201" height="22" border="0" alt="" />  </p>
</td>
<td style="text-align: left; vertical-align: top">
<img src="<?php echo FDX1_PLUGIN_URL;?>/images/but4.png" width="126" height="68" border="0" alt="" />
</td>
</tr>
</table>


</td>
</tr>
<tr>
<td colspan="3"><h3 style="margin: 0; padding: 0">&nbsp;</h3></td>
</tr>
<tr>
<td style="width: 150px; vertical-align: top"><p><strong><?php _e('CSS Style Align:', 'fdx-lang') ?>  </strong></p></td>
<td colspan="2">
 <input name="wp_twitter_fdx_tweet_button_container" type="text" size="50" value="<?php echo get_option('wp_twitter_fdx_tweet_button_container'); ?>" /> Ex: <code>text-align: center</code> <strong><?php _e('or', 'fdx-lang') ?></strong> <br /><code>float: left; margin-right: 10px;</code> <strong><?php _e('or', 'fdx-lang') ?></strong>  <code>float: right</code> <?php _e('or your css tags!', 'fdx-lang') ?>
</td>
 </tr>
 <tr>
<td colspan="3"><h3 style="margin: 0; padding: 0">&nbsp;</h3></td>
</tr>
<tr>
<td><p><strong><?php _e('Choose which version of the widget you would like to use: ', 'fdx-lang') ?></strong></p></td>
<td colspan="2">
<ul>
<li><p><input name="wp_twitter_fdx_tweet_button_choose" type="radio" value="multi_post" <?php checked('multi_post', $wp_twitter_fdx_tweet_button_choose); ?> /> <?php _e('Multi Post', 'fdx-lang') ?> <code><?php _e('Sharing takes place inside the widget, without taking users away from your site. Preferences are saved so your users can share to more than one service at the same time.', 'fdx-lang') ?></code> </p></li>
<li><p><input name="wp_twitter_fdx_tweet_button_choose" type="radio" value="direct_post" <?php checked('direct_post', $wp_twitter_fdx_tweet_button_choose); ?> /> <?php _e('Classic', 'fdx-lang') ?> <code><?php _e('Your users will be redirected to Facebook, Twitter, etc when clicking on the corresponding buttons. The widget is opened when users click on "Email" and "ShareThis".', 'fdx-lang') ?></code></p></li>
</ul>
</td>
</tr>
<tr>
<td colspan="3"><h3 style="margin: 0; padding: 0">&nbsp;</h3></td>
</tr>
<tr>
<td style="width: 150px; vertical-align: top"><strong><?php _e('Want Analytics?', 'fdx-lang') ?> <br /><a href="javascript:void(0);" onclick="PopupCenter('http://sharethis.com/external-login', 'page3_id1',562,342,'no');"><?php _e('Click here to Register.', 'fdx-lang') ?></a></strong>
</td>
<td colspan="2" style="vertical-align: top"><?php _e('At the end of the flow, you will be given a publisher key. Please paste it in the textbox below.', 'fdx-lang') ?><br />
<code>Publisher key:</code> <input name="wp_twitter_fdx_tweet_button_twitter_username" type="text" size="45" value="<?php echo get_option('wp_twitter_fdx_tweet_button_twitter_username'); ?>" />&nbsp;&nbsp;&nbsp;&nbsp;<span id="butpop"><a href="javascript:void(0);" onclick="PopupCenter('http://sharethis.com/publishers/metrics-dashboard', 'page2_id2',980,680,'yes');"><code class="red"><?php _e('see their stats', 'fdx-lang') ?></code></a></span>
</td>
</tr>
<tr>
<td colspan="3">
<p><?php _e('To get detailed sharing analytics, you need to register with ShareThis. You also get: Must-have live metrics: shares, clicks, social response, influencer reports & more. Monthly tips and tricks newsletter to improve your sites share-ability. Weekly sharing summary delivered via email (and available online).', 'fdx-lang') ?></p>

</td>
</tr>


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
<?php include('inc/footer_js.php'); ?>
<!-- carregar javascript especifico aqui -->
<div class="clear"></div>
<?php } //end page
add_filter('the_content', 'filter_wp_twitter_fdx_tweet_button_show');
?>