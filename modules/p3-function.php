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


add_option('wp_twitter_fdx_logo_top', plugins_url( '/images/logo300x40.png', dirname(__FILE__)));

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
