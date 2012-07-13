<?php

     if (isset($_POST['reset']))
    {  add_option('wp_twitter_fdx_widget_search_query', 'omg'); }

// ------------------------------------------------------------------------------Some default options
add_option('wp_twitter_fdx_widget_title', 'Twitter fdx');
add_option('wp_twitter_fdx_username', 'wordpress');
add_option('wp_twitter_fdx_height', '300');
add_option('wp_twitter_fdx_width', '370');
add_option('wp_twitter_fdx_scrollbar', '-1');
add_option('wp_twitter_fdx_shell_bg', '333333');
add_option('wp_twitter_fdx_shell_text', 'ffffff');
add_option('wp_twitter_fdx_tweet_bg', '000000');
add_option('wp_twitter_fdx_tweet_text', 'ffffff');
add_option('wp_twitter_fdx_links', '4aed05');
add_option('wp_twitter_fdx_behavior', '-1');

add_option('wp_twitter_fdx_widget_search_query', 'omg');
add_option('wp_twitter_fdx_widget_search_title', 'Excitement is in the air...');
add_option('wp_twitter_fdx_widget_search_caption', 'OMG!!');
add_option('wp_twitter_fdx_search_height', '300');
add_option('wp_twitter_fdx_search_width', '370');
add_option('wp_twitter_fdx_search_scrollbar', '-1');
add_option('wp_twitter_fdx_search_shell_bg', '333333');
add_option('wp_twitter_fdx_search_shell_text', 'ffffff');
add_option('wp_twitter_fdx_search_tweet_bg', '000000');
add_option('wp_twitter_fdx_search_tweet_text', 'ffffff');
add_option('wp_twitter_fdx_search_links', '4aed05');
add_option('wp_twitter_fdx_search_widget_sidebar_title', 'Twitter fdx');

add_option('wp_twitter_fdx_allow_tweet_button', '-1');
add_option('wp_twitter_fdx_tweet_button_display_page', '-1');
add_option('wp_twitter_fdx_tweet_button_display_home', '-1');
add_option('wp_twitter_fdx_tweet_button_display_rss', '-1');
add_option('wp_twitter_fdx_tweet_button_place', 'after');
add_option('wp_twitter_fdx_tweet_button_style', 'horizontal');
add_option('wp_twitter_fdx_tweet_button_container', 'float: right; margin-left: 10px;');
add_option('wp_twitter_fdx_tweet_button_twitter_username', '');
add_option('wp_twitter_fdx_tweet_button_reco_username', '');
add_option('wp_twitter_fdx_tweet_button_langcode', 'en');
add_option('wp_twitter_fdx_tweet_button_reco_desc', '');

function filter_wp_twitter_fdx_profile($content)
{
    if (strpos($content, "<!--wp_twitter_fdx-->") !== FALSE)
    {
        $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
        $content = str_replace('<!--wp_twitter_fdx-->', wp_twitter_fdx_profile(), $content);
    }
    return $content;
}

function filter_wp_twitter_fdx_search($content)
{
    if (strpos($content, "<!--wp_twitter_fdx_search-->") !== FALSE)
    {
        $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
        $content = str_replace('<!--wp_twitter_fdx_search-->', wp_twitter_fdx_search(), $content);
    }
    return $content;
}


function wp_twitter_fdx_profile()
{
	$account = get_option('wp_twitter_fdx_username');
	$height = get_option('wp_twitter_fdx_height');
	$width = get_option('wp_twitter_fdx_width');

	if (get_option('wp_twitter_fdx_scrollbar') == 1){
		$scrollbar = "true";
	}else
	{
		$scrollbar = "false";
	}

	if (get_option('wp_twitter_fdx_behavior') == 1){
		$loop1 = "false";
		$behavior1 = "all";
	}else
	{
		$loop1 = "true";
		$behavior1 = "default";
	}

	$shell_bg = get_option('wp_twitter_fdx_shell_bg');
	$shell_text = get_option('wp_twitter_fdx_shell_text');
	$tweet_bg = get_option('wp_twitter_fdx_tweet_bg');
	$tweet_text = get_option('wp_twitter_fdx_tweet_text');
	$links = get_option('wp_twitter_fdx_links');

		$T1 = "new TWTR.Widget({  version: 2,  type: 'profile',  rpp: 4,  interval: 5000,  width: ";
			$v1 = $width;
		$T2 = ",  height: ";
			$v2 = $height;
		$T3 = ",  theme: {    shell: {      background: '#";
			$v3 = $shell_bg;
		$T4 = "',      color: '#";
			$v4 = $shell_text;
		$T5 = "'    },    tweets: {      background: '#";
			$v5 = $tweet_bg;
		$T6 = "',      color: '#";
			$v6 = $tweet_text;
		$T7 = "',      links: '#";
			$v7 = $links;
		$T8 = "'    }  },  features: {    scrollbar: ";
		    $v8 = $scrollbar;
		$T9 = ",    loop: ";
			$v9 = $loop1;
		$T10 = ",    live: true, behavior: '";
			$v10 = $behavior1;
		$T11 = "'  }}).render().setUser('";
			$v11 = $account;
		$T12 = "').start();";

	$output = '<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script><script>' . $T1 . $v1 . $T2 . $v2 . $T3 . $v3 . $T4 . $v4 . $T5 . $v5 . $T6 . $v6 . $T7 . $v7 . $T8 . $v8 . $T9 . $v9 . $T10 . $v10 . $T11 . $v11 . $T12 . '</script>';

	$output_profile = $output;

	return $output_profile;
}


function filter_wp_twitter_fdx_tweet_button_show($related_content)
{

	$tweet_btn_allow = get_option('wp_twitter_fdx_allow_tweet_button');
	$tweet_btn_display_page = get_option('wp_twitter_fdx_tweet_button_display_page');
	$tweet_btn_display_home = get_option('wp_twitter_fdx_tweet_button_display_home');
	$tweet_btn_display_rss = get_option('wp_twitter_fdx_tweet_button_display_rss');
	$tweet_btn_place = get_option('wp_twitter_fdx_tweet_button_place');
	$tweet_btn_style = get_option('wp_twitter_fdx_tweet_button_style');
	$tweet_btn_float = get_option('wp_twitter_fdx_tweet_button_container');
	$tweet_btn_twt_username = get_option('wp_twitter_fdx_tweet_button_twitter_username');
	$tweet_btn_reco_username = get_option('wp_twitter_fdx_tweet_button_reco_username');
    $tweet_btn_reco_langcode = get_option('wp_twitter_fdx_tweet_button_langcode');
	$tweet_btn_reco_desc = get_option('wp_twitter_fdx_tweet_button_reco_desc');
    $language_code = get_option('wp_twitter_fdx_tweet_button_langcode');

	global $post;
	$p = $post;
	$title1 = $p->post_title ;
	$link1 = get_permalink($p);
	$blog_url = get_bloginfo('wpurl');
	$blog_title = get_bloginfo('wp_title');


	$final_url2 = '<a href="http://twitter.com/share?url='.$link1.'&via='.$tweet_btn_twt_username.'&text='.$title1.'&related='.$tweet_btn_reco_username.':'.$tweet_btn_reco_desc.'&lang='.$language_code.'&count='.$tweet_btn_style.'" class="twitter-share-button">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';

	$final_url2 = '<div style="'.$tweet_btn_float.'">' . $final_url2 . '</div>';

	if($tweet_btn_allow == 1)
	{
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
				wp_twitter_fdx_add_option_page();
			}
		}

		if (is_single() || is_search() || is_archive())
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
				wp_twitter_fdx_add_option_page();
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
				wp_twitter_fdx_add_option_page();
			}
		}

		if (is_feed() && $tweet_btn_display_rss == 1)
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
				wp_twitter_fdx_add_option_page();
			}
		}
 	}
	$post = $p;
	return $related_content;
}

function fdx_tweet_button()
{

	$tweet_btn_allow = get_option('wp_twitter_fdx_allow_tweet_button');
	$tweet_btn_display_page = get_option('wp_twitter_fdx_tweet_button_display_page');
	$tweet_btn_display_home = get_option('wp_twitter_fdx_tweet_button_display_home');
	$tweet_btn_display_rss = get_option('wp_twitter_fdx_tweet_button_display_rss');
	$tweet_btn_place = get_option('wp_twitter_fdx_tweet_button_place');
	$tweet_btn_style = get_option('wp_twitter_fdx_tweet_button_style');
	$tweet_btn_float = get_option('wp_twitter_fdx_tweet_button_container');
	$tweet_btn_twt_username = get_option('wp_twitter_fdx_tweet_button_twitter_username');
	$tweet_btn_reco_username = get_option('wp_twitter_fdx_tweet_button_reco_username');
    $tweet_btn_reco_langcode = get_option('wp_twitter_fdx_tweet_button_langcode');
	$tweet_btn_reco_desc = get_option('wp_twitter_fdx_tweet_button_reco_desc');
    $language_code = get_option('wp_twitter_fdx_tweet_button_langcode');

	global $post;
	$p = $post;
	$title1 = $p->post_title ;
	$link1 = get_permalink($p);
	$final_url2 = '<a href="http://twitter.com/share?url='.$link1.'&via='.$tweet_btn_twt_username.'&text='.$title1.'&related='.$tweet_btn_reco_username.':'.$tweet_btn_reco_desc.'&lang='.$language_code.'&count='.$tweet_btn_style.'" class="twitter-share-button">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';

	echo $final_url2;
}
//fdx adiciona um botão teste
function fdx_tweet_button_test()
{
	$tweet_btn_allow = get_option('wp_twitter_fdx_allow_tweet_button');
	$tweet_btn_display_page = get_option('wp_twitter_fdx_tweet_button_display_page');
	$tweet_btn_display_home = get_option('wp_twitter_fdx_tweet_button_display_home');
	$tweet_btn_display_rss = get_option('wp_twitter_fdx_tweet_button_display_rss');
	$tweet_btn_place = get_option('wp_twitter_fdx_tweet_button_place');
	$tweet_btn_style = get_option('wp_twitter_fdx_tweet_button_style');
	$tweet_btn_float = get_option('wp_twitter_fdx_tweet_button_container');
	$tweet_btn_twt_username = get_option('wp_twitter_fdx_tweet_button_twitter_username');
	$tweet_btn_reco_username = get_option('wp_twitter_fdx_tweet_button_reco_username');
    $tweet_btn_reco_langcode = get_option('wp_twitter_fdx_tweet_button_langcode');
	$tweet_btn_reco_desc = get_option('wp_twitter_fdx_tweet_button_reco_desc');
    $language_code = get_option('wp_twitter_fdx_tweet_button_langcode');

	$final_url2 = '<a href="http://twitter.com/share?url=http://wp.webmais.com/wp-twitter/&via='.$tweet_btn_twt_username.'&text=Plugin WP Twitter&related='.$tweet_btn_reco_username.':'.$tweet_btn_reco_desc.'&lang='.$language_code.'&count='.$tweet_btn_style.'" class="twitter-share-button">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
	echo $final_url2;
}




function wp_twitter_fdx_search()
{
	$search_query = get_option('wp_twitter_fdx_widget_search_query');
	$search_title = get_option('wp_twitter_fdx_widget_search_title');
	$search_caption = get_option('wp_twitter_fdx_widget_search_caption');
	$account = get_option('wp_twitter_fdx_username');

	$search_sidebar_title = get_option('wp_twitter_fdx_search_widget_sidebar_title');



	$search_height = get_option('wp_twitter_fdx_search_height');
	$search_width = get_option('wp_twitter_fdx_search_width');


		if (get_option('wp_twitter_fdx_search_scrollbar') == 1){
			$search_scrollbar = "true";
		}else
		{
			$search_scrollbar = "false";
		}

		$search_shell_bg = get_option('wp_twitter_fdx_search_shell_bg');
		$search_shell_text = get_option('wp_twitter_fdx_search_shell_text');
		$search_tweet_bg = get_option('wp_twitter_fdx_search_tweet_bg');
		$search_tweet_text = get_option('wp_twitter_fdx_search_tweet_text');
		$search_links = get_option('wp_twitter_fdx_search_links');

		$T11 = "new TWTR.Widget({  version: 2,  type: 'search', search: '";
			$S1 = $search_query;
		$T12 = "', interval:6000, title: '";
			$S2 = $search_title;
		$T13 = "', subject: '";
			$S3 = $search_caption;
		$T14 = "', width: ";
			$v1 = $search_width;
		$T2 = ",  height: ";
			$v2 = $search_height;
		$T3 = ",  theme: {    shell: {      background: '#";
			$v3 = $search_shell_bg;
		$T4 = "',      color: '#";
			$v4 = $search_shell_text;
		$T5 = "'    },    tweets: {      background: '#";
			$v5 = $search_tweet_bg;
		$T6 = "',      color: '#";
			$v6 = $search_tweet_text;
		$T7 = "',      links: '#";
			$v7 = $search_links;
		$T8 = "'    }  },  features: {    scrollbar: ";
			$v8 = $search_scrollbar;
		$T9 = ",    loop: ";
			$v9 = "true";
		$T10 = ",    live: true, behavior: 'default'  }}).render().start();";

		$output1 = '<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script><script>' . $T11 .$S1 . $T12 . $S2 . $T13 . $S3 . $T14 . $v1 . $T2 . $v2 . $T3 . $v3 . $T4 . $v4 . $T5 . $v5 . $T6 . $v6 . $T7 . $v7 . $T8 . $v8 . $T9 . $v9 . $T10 . '</script>';

		$output_search = $output1;

	return $output_search;
}

// Displays Wordpress Blog Twitter fdx Options menu
function wp_twitter_fdx_options_page() {

 	$wp_twitter_fdx_tweet_button_place = @$_POST['wp_twitter_fdx_tweet_button_place'];
	$wp_twitter_fdx_tweet_button_style = @$_POST['wp_twitter_fdx_tweet_button_style'];


    if (isset($_POST['info_update']))
    {
		update_option('wp_twitter_fdx_widget_title', stripslashes_deep((string)$_POST["wp_twitter_fdx_widget_title"]));
        update_option('wp_twitter_fdx_username', (string)$_POST["wp_twitter_fdx_username"]);
        update_option('wp_twitter_fdx_height', (string)$_POST['wp_twitter_fdx_height']);
		update_option('wp_twitter_fdx_width', (string)$_POST['wp_twitter_fdx_width']);
		update_option('wp_twitter_fdx_scrollbar', (@$_POST['wp_twitter_fdx_scrollbar']=='1') ? '1':'-1' );
		update_option('wp_twitter_fdx_behavior', (@$_POST['wp_twitter_fdx_behavior']=='1') ? '1':'-1' );
		update_option('wp_twitter_fdx_shell_bg', (string)$_POST['wp_twitter_fdx_shell_bg']);
		update_option('wp_twitter_fdx_shell_text', (string)$_POST['wp_twitter_fdx_shell_text']);
		update_option('wp_twitter_fdx_tweet_bg', (string)$_POST['wp_twitter_fdx_tweet_bg']);
		update_option('wp_twitter_fdx_tweet_text', (string)$_POST['wp_twitter_fdx_tweet_text']);
		update_option('wp_twitter_fdx_links', (string)$_POST['wp_twitter_fdx_links']);
		update_option('wp_twitter_fdx_widget_search_query', stripslashes_deep((string)$_POST['wp_twitter_fdx_widget_search_query']));
		update_option('wp_twitter_fdx_widget_search_title', stripslashes_deep((string)$_POST['wp_twitter_fdx_widget_search_title']));
		update_option('wp_twitter_fdx_widget_search_caption', stripslashes_deep((string)$_POST['wp_twitter_fdx_widget_search_caption']));
        update_option('wp_twitter_fdx_search_height', (string)$_POST['wp_twitter_fdx_search_height']);
		update_option('wp_twitter_fdx_search_width', (string)$_POST['wp_twitter_fdx_search_width']);
		update_option('wp_twitter_fdx_search_scrollbar', (@$_POST['wp_twitter_fdx_search_scrollbar']=='1') ? '1':'-1' );
		update_option('wp_twitter_fdx_search_shell_bg', (string)$_POST['wp_twitter_fdx_search_shell_bg']);
		update_option('wp_twitter_fdx_search_shell_text', (string)$_POST['wp_twitter_fdx_search_shell_text']);
		update_option('wp_twitter_fdx_search_tweet_bg', (string)$_POST['wp_twitter_fdx_search_tweet_bg']);
		update_option('wp_twitter_fdx_search_tweet_text', (string)$_POST['wp_twitter_fdx_search_tweet_text']);
		update_option('wp_twitter_fdx_search_links', (string)$_POST['wp_twitter_fdx_search_links']);
		update_option('wp_twitter_fdx_search_widget_sidebar_title', (string)$_POST['wp_twitter_fdx_search_widget_sidebar_title']);
		update_option('wp_twitter_fdx_allow_tweet_button', (@$_POST['wp_twitter_fdx_allow_tweet_button']=='1') ? '1':'-1' );
		update_option('wp_twitter_fdx_tweet_button_display_page', (@$_POST['wp_twitter_fdx_tweet_button_display_page']=='1') ? '1':'-1' );
		update_option('wp_twitter_fdx_tweet_button_display_home', (@$_POST['wp_twitter_fdx_tweet_button_display_home']=='1') ? '1':'-1' );
		update_option('wp_twitter_fdx_tweet_button_display_rss', (@$_POST['wp_twitter_fdx_tweet_button_display_rss']=='1') ? '1':'-1' );
		update_option('wp_twitter_fdx_tweet_button_container', stripslashes_deep((string)$_POST['wp_twitter_fdx_tweet_button_container']));
		update_option('wp_twitter_fdx_tweet_button_twitter_username', stripslashes_deep((string)$_POST['wp_twitter_fdx_tweet_button_twitter_username']));
		update_option('wp_twitter_fdx_tweet_button_reco_username', stripslashes_deep((string)$_POST['wp_twitter_fdx_tweet_button_reco_username']));
		update_option('wp_twitter_fdx_tweet_button_langcode', stripslashes_deep((string)$_POST['wp_twitter_fdx_tweet_button_langcode']));
        update_option('wp_twitter_fdx_tweet_button_reco_desc', stripslashes_deep((string)$_POST['wp_twitter_fdx_tweet_button_reco_desc']));
		update_option('wp_twitter_fdx_tweet_button_place', stripslashes_deep((string)@$_POST['wp_twitter_fdx_tweet_button_place']));
		update_option('wp_twitter_fdx_tweet_button_style', stripslashes_deep((string)@$_POST['wp_twitter_fdx_tweet_button_style']));
        echo '<div class="updated fade"><p><strong>' . __( 'Settings updated', 'fdx-lang' ) . '.</strong></p></div>';
        } else {
	$wp_twitter_fdx_tweet_button_place = get_option('wp_twitter_fdx_tweet_button_place');
	$wp_twitter_fdx_tweet_button_style = get_option('wp_twitter_fdx_tweet_button_style');
	}
//adicionar icones e lang patch

?>
<div class="wrap">
<div id="icon-edit" class="icon32 icon32-posts-post"><br /></div><h2><?php echo FDX_PLUGIN_N1;?>: <?php _e('Integration and Widget', 'fdx-lang') ?></h2>
<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">

<?php include('inc/sidebar.php'); ?>

<div class="postbox-container">
<div class="meta-box-sortables">

<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<input type="hidden" name="info_update" id="info_update" value="true" />

<div class="postbox">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Twitter Button integration', 'fdx-lang') ?></span></h3>
<div class="inside">
<!-- ############################################################################################################### -->
<table class="form-table">
           					<tr valign="top">
					<th scope="row" style="width:29%;"><label>Allow Tweet Button Integration?</label></th>
						<td>
						 <input name="wp_twitter_fdx_allow_tweet_button" type="checkbox"<?php if(get_option('wp_twitter_fdx_allow_tweet_button')!='-1') echo 'checked="checked"'; ?> value="1" /> <code>Check</code> to allow Tweet Button Integration
						</td>
					</tr>


					<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label>Display</label></th>
						<td>
						 <input name="wp_twitter_fdx_tweet_button_display_page" type="checkbox"<?php if(get_option('wp_twitter_fdx_tweet_button_display_page')!='-1') echo 'checked="checked"'; ?> value="1" />Pages

						 <input name="wp_twitter_fdx_tweet_button_display_home" type="checkbox"<?php if(get_option('wp_twitter_fdx_tweet_button_display_home')!='-1') echo 'checked="checked"'; ?> value="1" />Front Page (Home)

						 <input name="wp_twitter_fdx_tweet_button_display_rss" type="checkbox"<?php if(get_option('wp_twitter_fdx_tweet_button_display_rss')!='-1') echo 'checked="checked"'; ?> value="1" />RSS Feed
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><label>Placing Option</label></th>
						<td>
							<input name="wp_twitter_fdx_tweet_button_place" type="radio" value="before" <?php checked('before', $wp_twitter_fdx_tweet_button_place); ?> />
						&nbsp;Before Content

							<input name="wp_twitter_fdx_tweet_button_place" type="radio" value="after" <?php checked('after', $wp_twitter_fdx_tweet_button_place); ?> />
						&nbsp;After Content (default)

							<input name="wp_twitter_fdx_tweet_button_place" type="radio" value="manual" <?php checked('manual', $wp_twitter_fdx_tweet_button_place); ?> />
						&nbsp;Manual<br>
						Manual Insertion Code: <br /><code>&lt;?php if(function_exists('fdx_tweet_button'))<br /> { fdx_tweet_button();} ?&gt;</code>
						</td>
					</tr>

					<tr valign="top" class="alternate">
						<th scope="row"><label>Button Style option</label></th>
						<td>
							<input name="wp_twitter_fdx_tweet_button_style" type="radio" value="vertical" <?php checked('vertical', $wp_twitter_fdx_tweet_button_style); ?> />
						&nbsp;Vertical

					<input name="wp_twitter_fdx_tweet_button_style" type="radio" value="horizontal" <?php checked('horizontal', $wp_twitter_fdx_tweet_button_style); ?> />
						&nbsp;Horizonal

					<input name="wp_twitter_fdx_tweet_button_style" type="radio" value="none" <?php checked('none', $wp_twitter_fdx_tweet_button_style); ?> />
						&nbsp;No Count

                         <div style="float: right; margin-right: 100px"> <?php fdx_tweet_button_test(); ?> </div>
                        </td>
					</tr>

                    	<tr valign="top" class="alternate">
						<th scope="row"><label>Language code of button</label></th>
						<td>

                         <input name="wp_twitter_fdx_tweet_button_langcode" type="text" size="2" maxlength="2" value="<?php echo get_option('wp_twitter_fdx_tweet_button_langcode'); ?>" /> (2 digits <a href="http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes" target="_blank">ISO 639-1</a> codes)  Ex: Portuguese (pt)


                        </td>
					</tr>



					<tr valign="top" class="alternate">
							<th scope="row" style="width:29%;"><label>Float Left/Right?</label></th>
						<td>
						<input name="wp_twitter_fdx_tweet_button_container" type="text" size="25" value="<?php echo get_option('wp_twitter_fdx_tweet_button_container'); ?>" /> i.e. float: left; margin-right: 10px;
						</td>
					</tr>

					<tr valign="top">
							<th scope="row" style="width:29%;"><label>Twitter Username</label></th>
						<td>
						@<input name="wp_twitter_fdx_tweet_button_twitter_username" type="text" size="25" value="<?php echo get_option('wp_twitter_fdx_tweet_button_twitter_username'); ?>" />
						</td>
					</tr>

					<tr valign="top" class="alternate">
							<th scope="row" style="width:29%;"><label>Recommended Twitter user</label></th>
						<td>
						Name<input name="wp_twitter_fdx_tweet_button_reco_username" type="text" size="25" value="<?php echo get_option('wp_twitter_fdx_tweet_button_reco_username'); ?>" /><br />
						Description<input name="wp_twitter_fdx_tweet_button_reco_desc" type="text" size="25" value="<?php echo get_option('wp_twitter_fdx_tweet_button_reco_desc'); ?>" />
						</td>
					</tr>

 					</table>
<!-- ############################################################################################################### -->  
</div>
</div>


<div class="postbox closed">
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Twitter Profile Widget Options', 'fdx-lang') ?></span></h3>
<div class="inside">
<!-- ############################################################################################################### -->
 <table class="form-table">

				<tr valign="top" class="alternate">
          			<th scope="row" style="width:29%;"><label>Widget Title</label></th>
                      <td><input name="wp_twitter_fdx_widget_title" type="text" size="35" value="<?php echo get_option('wp_twitter_fdx_widget_title'); ?>"></td>
				</tr>
				<tr valign="top">
						<th scope="row" style="width:29%;"><label>Twitter Username</label></th>
					<td>
					 <input name="wp_twitter_fdx_username" type="text" size="25" value="<?php echo get_option('wp_twitter_fdx_username'); ?>" /> (for Twitter Widget)
					</td>
				</tr>

				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label>Widget Height</label></th>
					<td>
					<input name="wp_twitter_fdx_height" type="text" size="15" value="<?php echo get_option('wp_twitter_fdx_height'); ?>" />
					</td>
				</tr>
				<tr valign="top">
						<th scope="row" style="width:29%;"><label>Widget Width</label></th>
					<td>
					 <input name="wp_twitter_fdx_width" type="text" size="15" value="<?php echo get_option('wp_twitter_fdx_width'); ?>" />
					</td>
				</tr>

				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label>Include Scrollbar?</label></th>
					<td>
					<input name="wp_twitter_fdx_scrollbar" type="checkbox"<?php if(get_option('wp_twitter_fdx_scrollbar')!='-1') echo 'checked="checked"'; ?> value="1" /> <code>Check</code> to include Scrollbar
					</td>
				</tr>
				<tr valign="top">
						<th scope="row" style="width:29%;"><label>Load all Tweets? / Time Interval?</label></th>
					<td>
					<input name="wp_twitter_fdx_behavior" type="checkbox"<?php if(get_option('wp_twitter_fdx_behavior')!='-1') echo 'checked="checked"'; ?> value="1" /> <code>Check</code> to Load all Tweets (total 30)
					</td>
				</tr>

				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label>Widget Shell Background Color</label></th>
					<td>
					 <input class="color" name="wp_twitter_fdx_shell_bg" type="text" size="15" value="<?php echo get_option('wp_twitter_fdx_shell_bg'); ?>" />

					</td>
				</tr>
				<tr valign="top">
						<th scope="row" style="width:29%;"><label>Widget Shell Text Color</label></th>
					<td>
					<input class="color" name="wp_twitter_fdx_shell_text" type="text" size="15" value="<?php echo get_option('wp_twitter_fdx_shell_text'); ?>" />
					</td>
				</tr>

				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label>Widget Tweet Background Color</label></th>
					<td>
					 <input class="color" name="wp_twitter_fdx_tweet_bg" type="text" size="15" value="<?php echo get_option('wp_twitter_fdx_tweet_bg'); ?>" />

					</td>
				</tr>
				<tr valign="top">
						<th scope="row" style="width:29%;"><label>Widget Tweet Text Color</label></th>
					<td>
					<input class="color" name="wp_twitter_fdx_tweet_text" type="text" size="15" value="<?php echo get_option('wp_twitter_fdx_tweet_text'); ?>" />
					</td>
				</tr>
				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label>Link Color</label></th>
					<td>
					<input class="color" name="wp_twitter_fdx_links" type="text" size="15" value="<?php echo get_option('wp_twitter_fdx_links'); ?>" />
					</td>
				</tr>

				</table>
<!-- ############################################################################################################### -->
</div>
</div>

<div class="postbox closed" >
<div class="handlediv" title="<?php _e('Click to toggle', 'fdx-lang') ?>"><br /></div><h3 class='hndle'><span><?php _e('Twitter Search Widget Options', 'fdx-lang') ?></span></h3>
<div class="inside">
<!-- ############################################################################################################### -->
	<table class="form-table">
					<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label>Search Query</label></th>
                        <td><input name="wp_twitter_fdx_widget_search_query" type="text" size="35" value="<?php echo get_option('wp_twitter_fdx_widget_search_query'); ?>">HELP:
                        <a href="https://twitter.com/#!/search-home" target="_blank">https://twitter.com/#!/search-home</a></td>
					</tr>
					<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label>Search Title</label></th>
                        <td><input name="wp_twitter_fdx_widget_search_title" type="text" size="35" value="<?php echo get_option('wp_twitter_fdx_widget_search_title'); ?>"></td>
					</tr>
					<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label>Search Caption</label></th>
                        <td><input name="wp_twitter_fdx_widget_search_caption" type="text" size="35" value="<?php echo get_option('wp_twitter_fdx_widget_search_caption'); ?>"></td>
					</tr>

				<tr valign="top">
          			<th scope="row" style="width:29%;"><label>Widget Title</label></th>
                      <td><input name="wp_twitter_fdx_search_widget_sidebar_title" type="text" size="35" value="<?php echo get_option('wp_twitter_fdx_search_widget_sidebar_title'); ?>"></td>
				</tr>

				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label>Widget Height</label></th>
					<td>
					<input name="wp_twitter_fdx_search_height" type="text" size="15" value="<?php echo get_option('wp_twitter_fdx_search_height'); ?>" />
					</td>
				</tr>
				<tr valign="top">
						<th scope="row" style="width:29%;"><label>Widget Width</label></th>
					<td>
					 <input name="wp_twitter_fdx_search_width" type="text" size="15" value="<?php echo get_option('wp_twitter_fdx_search_width'); ?>" />
					</td>
				</tr>

				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label>Include Scrollbar?</label></th>
					<td>
					<input name="wp_twitter_fdx_search_scrollbar" type="checkbox"<?php if(get_option('wp_twitter_fdx_search_scrollbar')!='-1') echo 'checked="checked"'; ?> value="1" /> <code>Check</code> to include Scrollbar
					</td>
				</tr>

				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label>Widget Shell Background Color</label></th>
					<td>
					 <input class="color" name="wp_twitter_fdx_search_shell_bg" type="text" size="15" value="<?php echo get_option('wp_twitter_fdx_search_shell_bg'); ?>" />

					</td>
				</tr>
				<tr valign="top">
						<th scope="row" style="width:29%;"><label>Widget Shell Text Color</label></th>
					<td>
					<input class="color" name="wp_twitter_fdx_search_shell_text" type="text" size="15" value="<?php echo get_option('wp_twitter_fdx_search_shell_text'); ?>" />
					</td>
				</tr>

				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label>Widget Tweet Background Color</label></th>
					<td>
					 <input class="color" name="wp_twitter_fdx_search_tweet_bg" type="text" size="15" value="<?php echo get_option('wp_twitter_fdx_search_tweet_bg'); ?>" />

					</td>
				</tr>
				<tr valign="top">
						<th scope="row" style="width:29%;"><label>Widget Tweet Text Color</label></th>
					<td>
					<input class="color" name="wp_twitter_fdx_search_tweet_text" type="text" size="15" value="<?php echo get_option('wp_twitter_fdx_search_tweet_text'); ?>" />
					</td>
				</tr>
				<tr valign="top" class="alternate">
						<th scope="row" style="width:29%;"><label>Link Color</label></th>
					<td>
					<input class="color" name="wp_twitter_fdx_search_links" type="text" size="15" value="<?php echo get_option('wp_twitter_fdx_search_links'); ?>" />
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
<?php } //fim da pagina de opções

function show_wp_twitter_fdx_profile_widget($args)
{
	extract($args);
	$wp_twitter_fdx_widget_title1 = get_option('wp_twitter_fdx_widget_title');
	echo $before_widget;
	echo $before_title . $wp_twitter_fdx_widget_title1 . $after_title;
    echo wp_twitter_fdx_profile();
    echo $after_widget;
}

function show_wp_twitter_fdx_search_widget($args)
{
	extract($args);
	$wp_twitter_fdx_widget_title1 = get_option('wp_twitter_fdx_search_widget_sidebar_title');
	echo $before_widget;
	echo $before_title . $wp_twitter_fdx_widget_title1 . $after_title;

    echo wp_twitter_fdx_search();
    echo $after_widget;
}


function wp_twitter_fdx_profile_widget_control()
{
    ?>
    <p>
    <? _e("Please go to <b>Settings -> Twitter fdx</b> for options. <br><br> Available options: <br> 1) Widget Title <br> 2) Twitter Username <br> 3) Widget Height <br> 4) Widget Width <br> 5) 5 different Shell and Tweet background and text color options"); ?>
    </p>
    <?php
}


function wp_twitter_fdx_search_widget_control()
{
    ?>
    <p>
    <? _e("Please go to <b>Settings -> Twitter fdx</b> for options. <br><br> Available options: <br> 1) Search Query <br> 2) Search Title <br> 3) Search Caption"); ?>
    </p>
    <?php
}

function widget_wp_twitter_fdx_profile_init()
{
    $widget_options = array('classname' => 'widget_wp_twitter_fdx_profile', 'description' => __( "Display Twitter fdx Profile Widget") );
    wp_register_sidebar_widget('wp_twitter_fdx_profile_widgets', FDX_PLUGIN_N1 . __(' - Profile Widget', 'fdx-lang'), 'show_wp_twitter_fdx_profile_widget', $widget_options);
    wp_register_widget_control('wp_twitter_fdx_profile_widgets', FDX_PLUGIN_N1 . __(' - Profile Widget', 'fdx-lang'), 'wp_twitter_fdx_profile_widget_control' );
}

function widget_wp_twitter_fdx_search_init()
{
    $widget_options = array('classname' => 'widget_wp_twitter_fdx_search', 'description' => __( "Display Twitter fdx Search Widget") );
    wp_register_sidebar_widget('wp_twitter_fdx_search_widgets', FDX_PLUGIN_N1. __(' - Search Widget', 'fdx-lang'), 'show_wp_twitter_fdx_search_widget', $widget_options);
    wp_register_widget_control('wp_twitter_fdx_search_widgets', FDX_PLUGIN_N1. __(' - Search Widget', 'fdx-lang'), 'wp_twitter_fdx_search_widget_control' );
}

add_filter('the_content', 'filter_wp_twitter_fdx_profile');
add_filter('the_content', 'filter_wp_twitter_fdx_search');

add_filter('the_content', 'filter_wp_twitter_fdx_tweet_button_show');


add_action('init', 'widget_wp_twitter_fdx_profile_init');
add_action('init', 'widget_wp_twitter_fdx_search_init');

?>