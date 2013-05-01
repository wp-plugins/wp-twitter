<?php
function filter_wp_twitter_fdx_profile($content)
{
    if (strpos($content, "[--wp_twitter--]") !== FALSE)
    {
        $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
        $content = str_replace('[--wp_twitter--]', wp_twitter_fdx_profile(), $content);
    }
    return $content;
}

function filter_wp_twitter_fdx_search($content)
{
    if (strpos($content, "[--wp_twitter_search--]") !== FALSE)
    {
        $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
        $content = str_replace('[--wp_twitter_search--]', wp_twitter_fdx_search(), $content);
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
		$T3 = ",  theme: {    shell: {      background: '";
			$v3 = $shell_bg;
		$T4 = "',      color: '";
			$v4 = $shell_text;
		$T5 = "'    },    tweets: {      background: '";
			$v5 = $tweet_bg;
		$T6 = "',      color: '";
			$v6 = $tweet_text;
		$T7 = "',      links: '";
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
		$T3 = ",  theme: {    shell: {      background: '";
			$v3 = $search_shell_bg;
		$T4 = "',      color: '";
			$v4 = $search_shell_text;
		$T5 = "'    },    tweets: {      background: '";
			$v5 = $search_tweet_bg;
		$T6 = "',      color: '";
			$v6 = $search_tweet_text;
		$T7 = "',      links: '";
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

