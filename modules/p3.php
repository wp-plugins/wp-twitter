<?php
/* DEFAULT OPTIONS
*------------------------------------------------------------*/
add_option('wp_twitter_fdx_tweet_button_display_single', '1');
add_option('wp_twitter_fdx_tweet_button_display_page', '1');
add_option('wp_twitter_fdx_tweet_button_display_home', '-1');
add_option('wp_twitter_fdx_tweet_button_display_arquive', '-1');

add_option('wp_twitter_copynshare', '-1');

add_option('wp_twitter_fdx_tweet_button_place', 'after');
add_option('wp_twitter_fdx_tweet_button_style', 'large_buton');
add_option('wp_twitter_fdx_tweet_button_style2', 'floatside_left');
add_option('wp_twitter_fdx_tweet_button_style3', '3');
add_option('wp_twitter_fdx_tweet_button_choose', 'direct_post');
add_option('wp_twitter_fdx_tweet_button_container', 'text-align: center');
add_option('wp_twitter_fdx_tweet_button_twitter_username', '');

add_option('wp_twitter_fdx_services', 'facebook,twitter,linkedin,email,sharethis');    //New


add_option('wp_twitter_fdx_logo_top', FDX1_PLUGIN_URL .'/_inc/images/logo300x40.png');

function filter_wp_twitter_fdx_tweet_button_show($related_content)
{

    $tweet_btn_display_single = get_option('wp_twitter_fdx_tweet_button_display_single');
	$tweet_btn_display_page = get_option('wp_twitter_fdx_tweet_button_display_page');
	$tweet_btn_display_home = get_option('wp_twitter_fdx_tweet_button_display_home');
	$tweet_btn_display_arquive = get_option('wp_twitter_fdx_tweet_button_display_arquive');

    $tweet_btn_display_copynshare = get_option('wp_twitter_copynshare');

	$tweet_btn_place = get_option('wp_twitter_fdx_tweet_button_place');
	$tweet_btn_style = get_option('wp_twitter_fdx_tweet_button_style');
    $tweet_btn_style2 = get_option('wp_twitter_fdx_tweet_button_style2');
    $tweet_btn_style3 = get_option('wp_twitter_fdx_tweet_button_style3');
	$tweet_btn_float = get_option('wp_twitter_fdx_tweet_button_container');
	$tweet_btn_twt_username = get_option('wp_twitter_fdx_tweet_button_twitter_username');

    $tweet_btn_services = get_option('wp_twitter_fdx_services');


if ($tweet_btn_style == "large_buton")
    {
       $sh_services = explode(',' , $tweet_btn_services);
       foreach($sh_services as $key) {
       $key = preg_replace("/\s/", "", $key);
       @$final_url.='<span class="st_'.$key.'_large" displayText="'.$key.'"></span>';
    }
    $final_url = '<div style="'.$tweet_btn_float.'">' . $final_url . '</div>';
}

if ($tweet_btn_style == "small_buton")
      {
       $sh_services = explode(',' , $tweet_btn_services);
       foreach($sh_services as $key) {
       $key = preg_replace("/\s/", "", $key);
       @$final_url.='<span class="st_'.$key.'"></span>';
       }
    $final_url = '<div style="'.$tweet_btn_float.'">' . $final_url . '</div>';
    }

if ($tweet_btn_style == "h_count_buton")
      {
       $sh_services = explode(',' , $tweet_btn_services);
       foreach($sh_services as $key) {
       $key = preg_replace("/\s/", "", $key);
       @$final_url.='<span class="st_'.$key.'_hcount" displayText="'.$key.'"></span>';
      }
      $final_url = '<div style="'.$tweet_btn_float.'">' . $final_url . '</div>';
   }

if ($tweet_btn_style == "v_count_buton")
       {
       $sh_services = explode(',' , $tweet_btn_services);
       foreach($sh_services as $key) {
       $key = preg_replace("/\s/", "", $key);
       @$final_url.='<span class="st_'.$key.'_vcount" displayText="'.$key.'"></span>';
      }
    $final_url = '<div style="'.$tweet_btn_float.'">' . $final_url . '</div>';
    }
/************************** SHAREEGG *********************************/
if ($tweet_btn_place == "shareegg")
    {
     if (is_single() || is_page() ){
       $sh_services = explode(',' , $tweet_btn_services);
       foreach($sh_services as $key) {
       $key = preg_replace("/\s/", "", $key);
       @$allopt.= '"'.$key.'",';
       }
    $final_url = '<script type="text/javascript">stlib.shareEgg.createEgg("shareThisShareEgg", ['.$allopt.'], {title:"ShareThis Rocks!!!",url:"http://www.sharethis.com",theme:"shareegg"});</script>';
    $final_url = '<div id="shareThisShareEgg" class="shareEgg">' . $final_url . '</div>';
     }else {
      $final_url = '';
     }

   }

//copynshare
if ($tweet_btn_display_copynshare == 1) {
$display_copynshare = ", doNotHash: false, doNotCopy: false, hashAddressBar: true";
} else {
$display_copynshare = "";
}


// ***********************************************************************************
if (is_single() && $tweet_btn_display_single == 1 || is_page() && $tweet_btn_display_page == 1 || is_home() && $tweet_btn_display_home == 1 || is_archive() && $tweet_btn_display_arquive == 1 )
{
//------------------------------------------------------------
if ($tweet_btn_place == "before")
{
$related_content =  $final_url . $related_content;
}
//------------------------------------------------------------
if ($tweet_btn_place == "after")
{
$related_content =  $related_content . $final_url;
}
//------------------------------------------------------------
if ($tweet_btn_place == "manual")
{
$related_content = $related_content;
}
//------------------------------------------------------------
if ($tweet_btn_place == "floatside")
{
      $sh_services = explode(',' , $tweet_btn_services);
       foreach($sh_services as $key) {
       $key = preg_replace("/\s/", "", $key);
       @$allopt.= '"'.$key.'",';
       }
    if ($tweet_btn_style2 == "floatside_left")
       {
       echo '<script type="text/javascript">stLight.options({publisher: "'.$tweet_btn_twt_username.'"'.$display_copynshare.'});</script><script>var options={ "publisher": "'.$tweet_btn_twt_username.'", "position": "left", "ad": { "visible": false, "openDelay": 5, "closeDelay": 0}, "chicklets": { "items": ['.$allopt.']}}; var st_hover_widget = new sharethis.widgets.hoverbuttons(options);</script>';
       }
    if ($tweet_btn_style2 == "floatside_right")
       {
       echo '<script type="text/javascript">stLight.options({publisher: "'.$tweet_btn_twt_username.'"'.$display_copynshare.'});</script><script>var options={ "publisher": "'.$tweet_btn_twt_username.'", "position": "right", "ad": { "visible": false, "openDelay": 5, "closeDelay": 0}, "chicklets": { "items": ['.$allopt.']}}; var st_hover_widget = new sharethis.widgets.hoverbuttons(options);</script>';
       }
}
//------------------------------------------------------------
if ($tweet_btn_place == "fixedtop"){
       $sh_services = explode(',' , $tweet_btn_services);
       foreach($sh_services as $key) {
       $key = preg_replace("/\s/", "", $key);
       @$allopt.= '"'.$key.'",';
       }
echo '<script type="text/javascript">stLight.options({publisher: "'.$tweet_btn_twt_username.'"'.$display_copynshare.'});</script><script>var options={ "publisher": "'.$tweet_btn_twt_username.'", "scrollpx": 10, "ad": { "visible": false}, "chicklets": { "items": ['.$allopt.']}}; var st_pulldown_widget = new sharethis.widgets.pulldownbar(options);</script>';
}
//------------------------------------------------------------
if ($tweet_btn_place == "fixedbottom")
{
       $sh_services = explode(',' , $tweet_btn_services);
       foreach($sh_services as $key) {
       $key = preg_replace("/\s/", "", $key);
       @$allopt.= '"'.$key.'",';
       }
echo '<script type="text/javascript">stLight.options({publisher: "'.$tweet_btn_twt_username.'"'.$display_copynshare.'});</script>';
echo '<script>var options={ "publisher": "'.$tweet_btn_twt_username.'", "logo": { "visible": false, "url": "", "img": "http://sd.sharethis.com/disc/_inc/images/demo_logo.png", "height": 45}, "ad": { "visible": false, "openDelay": "5", "closeDelay": "0"}, "livestream": { "domain": "", "type": "sharethis", "customColors": { "widgetBackgroundColor": "#FFFFFF", "articleLinkColor": "#006fbb"}}, "ticker": { "visible": false, "domain": "", "title": "", "type": "sharethis", "customColors": { "widgetBackgroundColor": "#a0adc7", "articleLinkColor": "#00487f"}}, "facebook": { "visible": false, "profile": "sharethis"}, "fblike": { "visible": false, "url": ""}, "twitter": { "visible": false, "user": "sharethis"}, "twfollow": { "visible": false, "url": "http://www.twitter.com/sharethis"}, "custom": [{ "visible": false, "title": "Custom 1", "url": "", "img": "", "popup": false, "popupCustom": { "width": 300, "height": 250}}, { "visible": false, "title": "Custom 2", "url": "", "img": "", "popup": false, "popupCustom": { "width": 300, "height": 250}}, { "visible": false, "title": "Custom 3", "url": "", "img": "", "popup": false, "popupCustom": { "width": 300, "height": 250}}], "shadow": "gloss", "background": "#c2c2c2", "color": "#555555", "arrowStyle": "light", "chicklets": { "items": ['.$allopt.']}};';
echo 'var st_bar_widget = new sharethis.widgets.sharebar(options);</script>';
}
//------------------------------------------------------------
if ($tweet_btn_place == "sharenow")
{
echo '<script type="text/javascript">stLight.options({publisher: "'.$tweet_btn_twt_username.'"'.$display_copynshare.'});</script><script>var options={ "service": "facebook", "timer": { "countdown": 30, "interval": 10, "enable": false}, "frictionlessShare": true, "style": "'.$tweet_btn_style3.'", "publisher": "'.$tweet_btn_twt_username.'"};var st_service_widget = new sharethis.widgets.serviceWidget(options);</script>';
}
//------------------------------------------------------------
if ($tweet_btn_place == "shareegg")
{
$related_content =  $related_content . $final_url;
}
//------------------------------------------------------------
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

    $tweet_btn_services = get_option('wp_twitter_fdx_services');   //New

if ($tweet_btn_style == "large_buton")
    {
       $sh_services = explode(',' , $tweet_btn_services);
       foreach($sh_services as $key) {
       $key = preg_replace("/\s/", "", $key);
       @$final_url.='<span class="st_'.$key.'_large" displayText="'.$key.'"></span>';
    }
    $final_url = '<div style="'.$tweet_btn_float.'">' . $final_url . '</div>';
}

if ($tweet_btn_style == "small_buton")
      {
       $sh_services = explode(',' , $tweet_btn_services);
       foreach($sh_services as $key) {
       $key = preg_replace("/\s/", "", $key);
       @$final_url.='<span class="st_'.$key.'"></span>';
       }
    $final_url = '<div style="'.$tweet_btn_float.'">' . $final_url . '</div>';
    }

if ($tweet_btn_style == "h_count_buton")
      {
       $sh_services = explode(',' , $tweet_btn_services);
       foreach($sh_services as $key) {
       $key = preg_replace("/\s/", "", $key);
       @$final_url.='<span class="st_'.$key.'_hcount" displayText="'.$key.'"></span>';
      }
      $final_url = '<div style="'.$tweet_btn_float.'">' . $final_url . '</div>';
   }

if ($tweet_btn_style == "v_count_buton")
       {
       $sh_services = explode(',' , $tweet_btn_services);
       foreach($sh_services as $key) {
       $key = preg_replace("/\s/", "", $key);
       @$final_url.='<span class="st_'.$key.'_vcount" displayText="'.$key.'"></span>';
      }
    $final_url = '<div style="'.$tweet_btn_float.'">' . $final_url . '</div>';
    }

echo $final_url;

}


//---------------------------------------------------(wp_head)
function fdx_sharethis_script() {
    $tweet_btn_twt_username = get_option('wp_twitter_fdx_tweet_button_twitter_username');
    $tweet_btn_display_single = get_option('wp_twitter_fdx_tweet_button_display_single');
	$tweet_btn_display_page = get_option('wp_twitter_fdx_tweet_button_display_page');
	$tweet_btn_display_home = get_option('wp_twitter_fdx_tweet_button_display_home');

    $tweet_btn_services = get_option('wp_twitter_fdx_services');   //New

     $tweet_btn_display_copynshare = get_option('wp_twitter_copynshare');

	$tweet_btn_display_arquive = get_option('wp_twitter_fdx_tweet_button_display_arquive');
    $tweet_btn_choose = get_option('wp_twitter_fdx_tweet_button_choose');
    $tweet_btn_place = get_option('wp_twitter_fdx_tweet_button_place');
    $tweet_btn_logotop = get_option('wp_twitter_fdx_logo_top');


  if ($tweet_btn_choose == "multi_post")
    {
     $widget_style = 'true';
    }

 if ($tweet_btn_choose == "direct_post")
    {
     $widget_style = 'false';
    }



//adiciona se ativado
  if (is_single() && $tweet_btn_display_single == 1 || is_page() && $tweet_btn_display_page == 1 || is_home() && $tweet_btn_display_home == 1 || is_archive() && $tweet_btn_display_arquive == 1 || is_attachment() && $tweet_btn_display_arquive == 1 ) {

     if ($tweet_btn_place == "before" || $tweet_btn_place == "after" || $tweet_btn_place == "manual" )
    {
       echo "<!-- WP Twitter - http://fabrix.net/wp-twitter/  -->\n";
       echo "<script type='text/javascript'>var switchTo5x=". $widget_style .";</script>\n";
       echo "<script type='text/javascript' src='http://w.sharethis.com/button/buttons.js'></script>\n";

       if ($tweet_btn_display_copynshare == 1) {
       echo "<script type='text/javascript'>stLight.options({publisher: '" . $tweet_btn_twt_username . "', doNotHash: false, doNotCopy: false, hashAddressBar: true}); </script>\n";
       } else {
       echo "<script type='text/javascript'>stLight.options({publisher: '" . $tweet_btn_twt_username . "'}); </script>\n";
       }

     } elseif ($tweet_btn_place == "floatside" || $tweet_btn_place == "fixedbottom"){
        echo "<!-- WP Twitter - http://fabrix.net/wp-twitter/  -->\n";
        echo "<script type='text/javascript'>var switchTo5x=". $widget_style .";</script>\n";
        echo "<script type='text/javascript' src='http://w.sharethis.com/button/buttons.js'></script>\n";
        echo "<script type='text/javascript' src='http://s.sharethis.com/loader.js'></script>\n";

     } elseif ($tweet_btn_place == "fixedtop"){
        echo "<!-- WP Twitter - http://fabrix.net/wp-twitter/  -->\n";
        echo "<style type='text/css'>.stpulldown-gradient{background: #E1E1E1;background: -moz-linear-gradient(top, #E1E1E1 0%, #A7A7A7 100%);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#E1E1E1), color-stop(100%,#A7A7A7)); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#E1E1E1', endColorstr='#A7A7A7',GradientType=0 ); background: -o-linear-gradient(top, #E1E1E1 0%,#A7A7A7 100%); color: #636363;}#stpulldown .stpulldown-logo {height: 40px;width: 300px;margin-left: 20px;margin-top: 5px;background:url('".$tweet_btn_logotop."') no-repeat;}</style>\n";
        echo "<script type='text/javascript'>var switchTo5x=". $widget_style .";</script>\n";
        echo "<script type='text/javascript' src='http://w.sharethis.com/button/buttons.js'></script>\n";
        echo "<script type='text/javascript' src='http://s.sharethis.com/loader.js'></script>\n";

     } elseif ($tweet_btn_place == "sharenow") {
        echo "<!-- WP Twitter - http://fabrix.net/wp-twitter/  -->\n";
        echo "<script type='text/javascript' src='http://w.sharethis.com/button/buttons.js'></script>\n";
        echo "<script type='text/javascript' src='http://s.sharethis.com/loader.js'></script>\n";

     } elseif ($tweet_btn_place == "shareegg") {
       echo "<!-- WP Twitter - http://fabrix.net/wp-twitter/  -->\n";
       echo "<script type='text/javascript' src='http://w.sharethis.com/gallery/shareegg/shareegg.js'></script>\n";
       echo "<script type='text/javascript' src='http://w.sharethis.com/button/buttons.js'></script>\n";

    if ($tweet_btn_display_copynshare == 1) {
    echo "<script type='text/javascript'>stLight.options({publisher: '" . $tweet_btn_twt_username . "', doNotHash: false, doNotCopy: false, hashAddressBar: true, onhover:false});</script>\n";
    } else {
      echo "<script type='text/javascript'>stLight.options({publisher: '" . $tweet_btn_twt_username . "', onhover:false}); </script>\n";
      }
       echo "<link media='screen' type='text/css' rel='stylesheet' href='http://w.sharethis.com/gallery/shareegg/shareegg.css'></link>\n";
     }


      }
}

//---------------------------------------------------

function wp_twitter_fdx_social() {
   	$wp_twitter_fdx_tweet_button_place = @$_POST['wp_twitter_fdx_tweet_button_place'];
	$wp_twitter_fdx_tweet_button_style = @$_POST['wp_twitter_fdx_tweet_button_style'];
    $wp_twitter_fdx_tweet_button_style2 = @$_POST['wp_twitter_fdx_tweet_button_style2'];
    $wp_twitter_fdx_tweet_button_style3 = @$_POST['wp_twitter_fdx_tweet_button_style3'];
    $wp_twitter_fdx_tweet_button_choose  = @$_POST['wp_twitter_fdx_tweet_button_choose'];

    if (isset($_POST['info_update2']))
    {
        update_option('wp_twitter_fdx_tweet_button_display_single', (@$_POST['wp_twitter_fdx_tweet_button_display_single']=='1') ? '1':'-1' );
		update_option('wp_twitter_fdx_tweet_button_display_page', (@$_POST['wp_twitter_fdx_tweet_button_display_page']=='1') ? '1':'-1' );
		update_option('wp_twitter_fdx_tweet_button_display_home', (@$_POST['wp_twitter_fdx_tweet_button_display_home']=='1') ? '1':'-1' );
		update_option('wp_twitter_fdx_tweet_button_display_arquive', (@$_POST['wp_twitter_fdx_tweet_button_display_arquive']=='1') ? '1':'-1' );

        update_option('wp_twitter_copynshare', (@$_POST['wp_twitter_copynshare']=='1') ? '1':'-1' );

		update_option('wp_twitter_fdx_tweet_button_container', stripslashes_deep((string)$_POST['wp_twitter_fdx_tweet_button_container']));
		update_option('wp_twitter_fdx_tweet_button_twitter_username', stripslashes_deep((string)$_POST['wp_twitter_fdx_tweet_button_twitter_username']));

   		update_option('wp_twitter_fdx_services', stripslashes_deep((string)$_POST['wp_twitter_fdx_services']));   //New


		update_option('wp_twitter_fdx_logo_top', stripslashes_deep((string)$_POST['wp_twitter_fdx_logo_top']));
    	update_option('wp_twitter_fdx_tweet_button_place', stripslashes_deep((string)@$_POST['wp_twitter_fdx_tweet_button_place']));
		update_option('wp_twitter_fdx_tweet_button_style', stripslashes_deep((string)@$_POST['wp_twitter_fdx_tweet_button_style']));
        update_option('wp_twitter_fdx_tweet_button_style2', stripslashes_deep((string)@$_POST['wp_twitter_fdx_tweet_button_style2']));
        update_option('wp_twitter_fdx_tweet_button_style3', stripslashes_deep((string)@$_POST['wp_twitter_fdx_tweet_button_style3']));
 		update_option('wp_twitter_fdx_tweet_button_choose', stripslashes_deep((string)@$_POST['wp_twitter_fdx_tweet_button_choose']));
       echo '<div class="updated fade"><p><strong>' . __( 'Settings updated', 'wp-twitter' ) . '.</strong></p></div>';
        } else {
	$wp_twitter_fdx_tweet_button_place = get_option('wp_twitter_fdx_tweet_button_place');
	$wp_twitter_fdx_tweet_button_style = get_option('wp_twitter_fdx_tweet_button_style');
    $wp_twitter_fdx_tweet_button_style2 = get_option('wp_twitter_fdx_tweet_button_style2');
    $wp_twitter_fdx_tweet_button_style3 = get_option('wp_twitter_fdx_tweet_button_style3');
    $wp_twitter_fdx_tweet_button_choose  = get_option('wp_twitter_fdx_tweet_button_choose');
}
?>

<div class="wrap">
<?php echo get_screen_icon('fdx-lock');?>
<h2><?php echo FDX1_PLUGIN_NAME;?>: <?php _e('Sharethis Button Integration', 'wp-twitter') ?></h2>
<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">

<?php include('_sidebar.php'); ?>

<div class="postbox-container">
<div class="meta-box-sortables">

<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<input type="hidden" name="info_update2" id="info_update" value="true" />

<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'wp-twitter') ?>"><br /></div><h3 class='hndle'><span><?php _e('Allow integration in:', 'wp-twitter') ?></span></h3>
<div class="inside">
<ul>
<li><input name="wp_twitter_fdx_tweet_button_display_single" type="checkbox"<?php if(get_option('wp_twitter_fdx_tweet_button_display_single')!='-1') echo 'checked="checked"'; ?> value="1" /> <?php _e('Post', 'wp-twitter') ?> </li>
<li><input name="wp_twitter_fdx_tweet_button_display_page" type="checkbox"<?php if(get_option('wp_twitter_fdx_tweet_button_display_page')!='-1') echo 'checked="checked"'; ?> value="1" /> <?php _e('Pages', 'wp-twitter') ?> </li>
<li><input name="wp_twitter_fdx_tweet_button_display_home" type="checkbox"<?php if(get_option('wp_twitter_fdx_tweet_button_display_home')!='-1') echo 'checked="checked"'; ?> value="1" /> <?php _e('Front Page (Home)', 'wp-twitter') ?> </li>
<li><input name="wp_twitter_fdx_tweet_button_display_arquive" type="checkbox"<?php if(get_option('wp_twitter_fdx_tweet_button_display_arquive')!='-1') echo 'checked="checked"'; ?> value="1" /> <?php _e('Archive', 'wp-twitter') ?> <span class="description">  (<?php _e('category, tags, author, date, attachment', 'wp-twitter') ?>)</span> </li>
</ul>
</div></div>

<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'wp-twitter') ?>"><br /></div><h3 class='hndle'><span><?php _e('Sharethis Style', 'wp-twitter') ?></span></h3>
<div class="inside">

<ul>
<li><input name="wp_twitter_fdx_tweet_button_place" type="radio" value="before" <?php checked('before', $wp_twitter_fdx_tweet_button_place); ?> /> <?php _e('Before Content', 'wp-twitter') ?></li>
<li><input name="wp_twitter_fdx_tweet_button_place" type="radio" value="after" <?php checked('after', $wp_twitter_fdx_tweet_button_place); ?> /> <?php _e('After Content', 'wp-twitter') ?> <span class="description">(<?php _e('default', 'wp-twitter') ?>)</span></li>
<li><input name="wp_twitter_fdx_tweet_button_place" type="radio" value="manual" <?php checked('manual', $wp_twitter_fdx_tweet_button_place); ?> /> <?php _e('Manual add', 'wp-twitter') ?>: <code><span style="color: #000000; font-weight: bold;">&lt;?php</span> <span style="color: #b1b100;">if</span><span style="color: #009900;">&#40;</span><span style="color: #990000;">function_exists</span><span style="color: #009900;">&#40;</span><span style="color: #0000ff;">'fdx_add_sharethis'</span><span style="color: #009900;">&#41;</span><span style="color: #009900;">&#41;</span> <span style="color: #009900;">&#123;</span> <span style="color: #0000ff;">fdx_add_sharethis&#40;&#41;</span><span style="color: #339933;">;</span><span style="color: #009900;">&#125;</span> <span style="color: #000000; font-weight: bold;">?&gt;</span></code></li>
</ul>
<h3 style="margin: 0; padding: 0"></h3>

<ul>
<li><input name="wp_twitter_fdx_tweet_button_place" type="radio" value="floatside" <?php checked('floatside', $wp_twitter_fdx_tweet_button_place); ?> /> <?php _e('Fixed on the sides', 'wp-twitter') ?></li>
<li><input name="wp_twitter_fdx_tweet_button_place" type="radio" value="fixedtop" <?php checked('fixedtop', $wp_twitter_fdx_tweet_button_place); ?> /> <?php _e('Top of Page', 'wp-twitter') ?></li>
<li><input name="wp_twitter_fdx_tweet_button_place" type="radio" value="fixedbottom" <?php checked('fixedbottom', $wp_twitter_fdx_tweet_button_place); ?> /> <?php _e('Fixed on Bottom', 'wp-twitter') ?></li>
</ul>


<h3 style="margin: 0; padding: 0"></h3>

<ul>
 <li><input name="wp_twitter_fdx_tweet_button_place" type="radio" value="sharenow" <?php checked('sharenow', $wp_twitter_fdx_tweet_button_place); ?> /> <?php _e('ShareNow', 'wp-twitter') ?></li>
<li><input name="wp_twitter_fdx_tweet_button_place" type="radio" value="shareegg" <?php checked('shareegg', $wp_twitter_fdx_tweet_button_place); ?> /> <?php _e('Share Egg', 'wp-twitter') ?></li>
</ul>

<!-- ***************************************************************************************** -->

 </div></div>

 <div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'wp-twitter') ?>"><br /></div><h3 class='hndle'><span><?php _e('Customization', 'wp-twitter') ?></span></h3>
<div class="inside">
<br />
<div class="tabsCell">

<table style="width:100%;" class="widefat">
<thead><tr><th>

<ul class="tabs">
<li><a href="#tabid1" title=""><span><?php _e('Buttons', 'wp-twitter') ?></span></a></li>
<li><a href="#tabid2" title=""><span><?php _e('Fixed on the sides', 'wp-twitter') ?></span></a></li>
<li><a href="#tabid3" title=""><span><?php _e('Top of Page', 'wp-twitter') ?></span></a></li>
<li><a href="#tabid4" title=""><span><?php _e('Fixed on Bottom', 'wp-twitter') ?></span></a></li>
<li><a href="#tabid5" title=""><span><?php _e('ShareNow', 'wp-twitter') ?></span></a></li>
</ul>

</th></tr></thead>
<tbody><tr class="alternate"><td>
<div class="tab_container">

<div id="tabid1" class="tab_content">
<!-- ******************************************tab1****************************************** -->
<p><strong><?php _e('Type of the Button', 'wp-twitter') ?>   </strong> </p>
  <table style="width: 100%; text-align: center">
     <tr>
       <td valign="top"><input name="wp_twitter_fdx_tweet_button_style" type="radio" value="small_buton" <?php checked('small_buton', $wp_twitter_fdx_tweet_button_style); ?> /> <?php _e('Small Butons (16x16)', 'wp-twitter') ?><br /><img src="<?php echo FDX1_PLUGIN_URL;?>/_inc/images/but1.png" width="140" height="54" border="0" alt="" /></td>
       <td valign="top"><input name="wp_twitter_fdx_tweet_button_style" type="radio" value="large_buton" <?php checked('large_buton', $wp_twitter_fdx_tweet_button_style); ?> /> <?php _e('Large Buttons (32x32)', 'wp-twitter') ?><br /><img src="<?php echo FDX1_PLUGIN_URL;?>/_inc/images/but2.png" width="140" height="54" border="0" alt="" /></td>
      <td valign="top"><input name="wp_twitter_fdx_tweet_button_style" type="radio" value="h_count_buton" <?php checked('h_count_buton', $wp_twitter_fdx_tweet_button_style); ?> /> <?php _e('Horizontal Count', 'wp-twitter') ?><br /><img src="<?php echo FDX1_PLUGIN_URL;?>/_inc/images/but3.png" width="140" height="54" border="0" alt="" /></td>
       <td valign="top"><input name="wp_twitter_fdx_tweet_button_style" type="radio" value="v_count_buton" <?php checked('v_count_buton', $wp_twitter_fdx_tweet_button_style); ?> /> <?php _e('Vertical Count', 'wp-twitter') ?><br /><img src="<?php echo FDX1_PLUGIN_URL;?>/_inc/images/but4.png" width="140" height="54" border="0" alt="" /></td>
     </tr>
   </table>
<p><strong><?php _e('CSS Style Align', 'wp-twitter') ?>:</strong> <input name="wp_twitter_fdx_tweet_button_container" type="text" size="50" value="<?php echo get_option('wp_twitter_fdx_tweet_button_container'); ?>" /></p>
<code>text-align: center</code>&nbsp;&nbsp;&nbsp;<code>float: left; margin-right: 10px;</code>&nbsp;&nbsp;&nbsp;<code>float: right</code>
 <!-- ******************************************tab1****************************************** -->
</div>

<div id="tabid2" class="tab_content">
<!-- ******************************************tab2****************************************** -->
<p><strong><?php _e('Docking Position', 'wp-twitter') ?> </strong>  </p>

<table style="width: 100%">
  <tr>
    <td style="width: 50%; vertical-align: top">
<p><img src="<?php echo FDX1_PLUGIN_URL;?>/_inc/images/button_sidebar.png" width="232" height="100" border="0" alt="" style="vertical-align: middle"  /> <input name="wp_twitter_fdx_tweet_button_style2" type="radio" value="floatside_left" <?php checked('floatside_left', $wp_twitter_fdx_tweet_button_style2); ?> /> <?php _e('Left', 'wp-twitter') ?></p>
 </td>
 <td style="width: 50%; vertical-align: top">
<p><img src="<?php echo FDX1_PLUGIN_URL;?>/_inc/images/button_sidebar2.png" width="232" height="100" border="0" alt="" style="vertical-align: middle" /> <input name="wp_twitter_fdx_tweet_button_style2" type="radio" value="floatside_right" <?php checked('floatside_right', $wp_twitter_fdx_tweet_button_style2); ?> /> <?php _e('Right', 'wp-twitter') ?></p>
</td>
  </tr>
</table>
<!-- ******************************************tab2****************************************** -->
</div>

<div id="tabid3" class="tab_content">
<!-- ******************************************tab3****************************************** -->
<p><strong><?php _e('Logo Area', 'wp-twitter') ?></strong> <span class="description"> (300x40 pix)</span>  </p>
<p><img src="<?php echo FDX1_PLUGIN_URL;?>/_inc/images/button_top.png" width="234" height="101" border="0" alt="" /><br /><strong>Logo Url:</strong> <input name="wp_twitter_fdx_logo_top" type="text" size="75" value="<?php echo get_option('wp_twitter_fdx_logo_top'); ?>" /></p>
<!-- ******************************************tab3****************************************** -->
</div>

<div id="tabid4" class="tab_content">
<!-- ******************************************tab4****************************************** -->
<p><strong>options of customization: coming soon  </strong>  </p>
<p><img src="<?php echo FDX1_PLUGIN_URL;?>/_inc/images/sahre_bar.png" width="233" height="86" border="0" alt="" />   </p>
<!-- ******************************************tab4****************************************** -->
</div>

<div id="tabid5" class="tab_content">
<!-- ******************************************tab5****************************************** -->
<p><strong><?php _e('Choose a theme', 'wp-twitter') ?>  </strong> </p>

<table style="width: 100%">
  <tr>
    <td style="width: 33%; vertical-align: top"><p><img src="<?php echo FDX1_PLUGIN_URL;?>/_inc/images/fbtheme_3.png" width="140" height="112" border="0" alt="" style="vertical-align: middle" /> <input name="wp_twitter_fdx_tweet_button_style3" type="radio" value="3" <?php checked('3', $wp_twitter_fdx_tweet_button_style3); ?> /></p>
<p><img src="<?php echo FDX1_PLUGIN_URL;?>/_inc/images/fbtheme_4.png" width="140" height="112" border="0" alt="" style="vertical-align: middle" /> <input name="wp_twitter_fdx_tweet_button_style3" type="radio" value="4" <?php checked('4', $wp_twitter_fdx_tweet_button_style3); ?> /></p>
</td>
    <td style="width: 33%; vertical-align: top"><p><img src="<?php echo FDX1_PLUGIN_URL;?>/_inc/images/fbtheme_5.png" width="140" height="112" border="0" alt="" style="vertical-align: middle" /> <input name="wp_twitter_fdx_tweet_button_style3" type="radio" value="5" <?php checked('5', $wp_twitter_fdx_tweet_button_style3); ?> /></p>
<p><img src="<?php echo FDX1_PLUGIN_URL;?>/_inc/images/fbtheme_6.png" width="140" height="112" border="0" alt="" style="vertical-align: middle" /> <input name="wp_twitter_fdx_tweet_button_style3" type="radio" value="6" <?php checked('6', $wp_twitter_fdx_tweet_button_style3); ?> /></p>
</td>
    <td style="width: 33%; vertical-align: top"><p><img src="<?php echo FDX1_PLUGIN_URL;?>/_inc/images/fbtheme_7.png" width="140" height="112" border="0" alt="" style="vertical-align: middle" /> <input name="wp_twitter_fdx_tweet_button_style3" type="radio" value="7" <?php checked('7', $wp_twitter_fdx_tweet_button_style3); ?> /></p>
</td>
  </tr>
</table>



<!-- ******************************************tab5****************************************** -->
</div>


</div><!-- tab_container -->


</td>
 </tr>
 </tbody>
 </table>

</div><!-- tabsCell -->




<table style="width:100%;" class="widefat">
 <thead><tr><th><?php _e('Change order or modify list of buttons.', 'wp-twitter') ?></th> </tr></thead>
<tbody><tr class="alternate"><td>
<p><strong><?php _e('Selected Services', 'wp-twitter') ?>:</strong> <input name="wp_twitter_fdx_services" type="text" size="65" value="<?php echo get_option('wp_twitter_fdx_services'); ?>" /><small><em> (<?php _e('lowercase, separated by commas', 'wp-twitter') ?>)</em></small></p>
<p><a href="javascript:void(0);" onclick="PopupCenter('http://sharethis.com/publishers/services-directory', 'page2_id3',980,680,'yes');" title="<?php _e('Sharing Services Directory', 'wp-twitter') ?>"><?php _e('Service Codes', 'wp-twitter') ?></a>: <code>sharethis</code>, <code>email</code>, <code>facebook</code>, <code>twitter</code>, <code>linkedin</code>, <code>pinterest</code>, <code>tumblr</code>, <code>googleplus</code>, <code>blogger</code>, <code>delicious</code>, <code>wordpress</code>, <code>technorati</code>, <code>stumbleupon</code>, <code>reddit</code>, <code>digg</code>, <code>plusone</code><small><em>(Google +1)</em></small>, <code>fblike</code><small><em>(<?php _e('Facebook Like', 'wp-twitter') ?>)</em></small>, <code>fbrec</code><small><em>(<?php _e('Facebook Recommend', 'wp-twitter') ?>)</em></small>, <code>fbsend</code><small><em>(<?php _e('Facebook Send', 'wp-twitter') ?>)</em></small></p>
</td>
 </tr>
 </tbody>
 </table>



<!-- ***************************************************************************************** -->
 </div></div>

<div class="postbox closed">
<div class="handlediv" title="<?php _e('Click to toggle', 'wp-twitter') ?>"><br /></div><h3 class='hndle'><span><?php _e('Choose which version of the widget you would like to use: ', 'wp-twitter') ?></span></h3>
<div class="inside">
<p><input name="wp_twitter_fdx_tweet_button_choose" type="radio" value="multi_post" <?php checked('multi_post', $wp_twitter_fdx_tweet_button_choose); ?> /> <strong><?php _e('Multi Post', 'wp-twitter') ?></strong> <br /><span class="description"><?php _e('Sharing takes place inside the widget, without taking users away from your site. Preferences are saved so your users can share to more than one service at the same time.', 'wp-twitter') ?></span> </p>
<p><input name="wp_twitter_fdx_tweet_button_choose" type="radio" value="direct_post" <?php checked('direct_post', $wp_twitter_fdx_tweet_button_choose); ?> /> <strong><?php _e('Classic', 'wp-twitter') ?></strong> <br /> <span class="description"><?php _e('Your users will be redirected to Facebook, Twitter, etc when clicking on the corresponding buttons. The widget is opened when users click on "Email" and "ShareThis".', 'wp-twitter') ?></span></p>
 </div></div>

<!-- ***************************************************************************************** -->
<div class="postbox closed">
<div class="handlediv" title="<?php _e('Click to toggle', 'wp-twitter') ?>"><br /></div><h3 class='hndle'><span><?php _e('Want Analytics?', 'wp-twitter') ?></span></h3>
<div class="inside">


<p><a href="javascript:void(0);" onclick="PopupCenter('http://sharethis.com/external-login', 'page3_id1',562,342,'no');"><strong><?php _e('CLICK HERE TO REGISTER', 'wp-twitter') ?></strong></a> <span class="description">  <?php _e('At the end of the flow, you will be given a publisher key. Please paste it in the textbox below.', 'wp-twitter') ?> </span> </p>
<p><strong>Publisher key: </strong><input name="wp_twitter_fdx_tweet_button_twitter_username" type="text" size="45" value="<?php echo get_option('wp_twitter_fdx_tweet_button_twitter_username'); ?>" />&nbsp;&nbsp;&nbsp;&nbsp;<span id="butpop"><a href="javascript:void(0);" onclick="PopupCenter('http://sharethis.com/publishers/metrics-dashboard', 'page2_id2',980,680,'yes');"><code class="red"><?php _e('see their stats', 'wp-twitter') ?></code></a></span> </p>
<h3></h3>
<p><input name="wp_twitter_copynshare" type="checkbox"<?php if(get_option('wp_twitter_copynshare')!='-1') echo 'checked="checked"'; ?> value="1" /> <strong>CopyNShare</strong> <br /><span class="description"> <?php _e('If activated, start tracking your users copy and paste shares by adding to your widget (Publisher key is required).', 'wp-twitter') ?> <strong><a href="http://support.sharethis.com/customer/portal/articles/517332#copynshare" target="_blank">FAQs</a></strong></span></p>

<!-- ############################################################################################################### -->
</div>
</div>



<div align="center"><input name="Submit" class="button-primary"  type="submit" value="<?php _e('Save All Options', 'wp-twitter') ?>" /></div>
</form>
</div> <!-- /postbox-container -->
</div><!-- /meta-box-sortables -->



</div><!-- /post-body -->
</div><!-- /poststuff -->


</div><!-- /wrap -->
<div class="clear"></div>
<?php } //end page

?>