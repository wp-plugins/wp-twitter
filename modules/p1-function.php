<?php
/* (F1)
*------------------------------------------------------------*/
function fdx1_update_post_settings() {
	if ( is_admin() ) {
		$settings = fdx1_get_settings();

	  	if ( isset($_POST['fdx1_update_settings']) ) {
			if ( isset($_POST['message']) ) {
				$message = $_POST['message'];
			} else {
				$message = '';
			}

			if ( isset( $_POST['fdx1-url-type'] ) ) {
				$settings['url_type'] = $_POST['fdx1-url-type'];
			}

			if ( isset( $_POST['bitly-api-key'] ) ) {
				$settings['bitly-api-key'] = $_POST['bitly-api-key'];
			} else {
				$settings['bitly-api-key'] = '';
			}
			if ( isset( $_POST['bitly-user-name'] ) ) {
				$settings['bitly-user-name'] = $_POST['bitly-user-name'];
			} else {
				$settings['bitly-user-name'] = '';
			}
            if ( isset( $_POST['yourls-api-key'] ) ) {
				$settings['yourls-api-key'] = $_POST['yourls-api-key'];
			} else {
				$settings['yourls-api-key'] = '';
			}
			if ( isset( $_POST['yourls-user-name'] ) ) {
				$settings['yourls-user-name'] = $_POST['yourls-user-name'];
			} else {
				$settings['yourls-user-name'] = '';
			}
			if ( isset( $_POST['fdx1-reverse'] ) ) {
				$reverse = true;
			} else {
				$reverse = false;
			}
			$wt_tags = explode( ",", stripslashes( $_POST['fdx1-tags'] ) );
     		$new_tags = array();
			foreach ( $wt_tags as $tags ) {
				$clean_tag = strtolower( rtrim( ltrim( $tags ) ) );
				if ( strlen( $clean_tag ) ) {
					$new_tags[] = $clean_tag;
				}
			}

			$settings['tags'] = $new_tags;
			$settings['message'] = stripslashes( $message );
			$settings['reverse'] = $reverse;

			fdx1_save_settings( $settings );
			update_option( 'fdx1_last_fetch_time', 0 );
		}

		// The Master Kill Switch
	 	elseif ( isset( $_POST['reset'] ) ) {
			update_option( 'fdx1_last_fetch_time', 0 );
			update_option( 'fdx1_settings', false );
	    }
	}
}

/* (F2)
*------------------------------------------------------------*/
function fdx1_get_auth_url() {
	global $fdx1_oauth;
	$settings = fdx1_get_settings();

	$token = $fdx1_oauth->get_request_token();
	if ( $token ) {
		$settings['oauth_request_token'] = $token['oauth_token'];
		$settings['oauth_request_token_secret'] = $token['oauth_token_secret'];

		fdx1_save_settings( $settings );

		return $fdx1_oauth->get_auth_url( $token['oauth_token'] );
	}
}

$fdx1_defaults = array(
	'tags' => array(),
	'reverse' => false,
	'activation_time' => 0,
	'message' => 'New blog posting, [title] - [link]',
	'url_type' => 'tinyurl',
	'oauth_request_token' => false,
	'oauth_request_token_secret' => false,
	'oauth_access_token' => false,
	'oauth_access_token_secret' => false,
	'last_tweet_time' => 0,
	'user_id' => 0,
	'profile_image_url' => '',
	'screen_name' => '',
	'location' => false,
);

/* (F3)
*------------------------------------------------------------*/
function fdx1_get_settings() {
	global $fdx1_defaults;

	$settings = $fdx1_defaults;

	$wordpress_settings = get_option( 'fdx1_settings' );
	if ( $wordpress_settings ) {
		foreach( $wordpress_settings as $key => $value ) {
			$settings[ $key ] = $value;
		}
	}

	return $settings;
}


/* (F4)
*------------------------------------------------------------*/
function fdx1_do_tweet( $post_id ) {
	$settings = fdx1_get_settings();
  	$message = fdx1_get_message( $post_id );
	// If we have a valid message, Tweet it
	// this will fail if the Tiny URL service is done
	if ( $message ) {
		// If we successfully posted this to Twitter, then we can remove it from the queue eventually
		$result_of_tweet = fdx1_twit_update_status( $message );
		if ( $result_of_tweet ) {
			return true;
		}
	}
	return false;
}

/* (F5)
*------------------------------------------------------------*/
function fdx1_init() {
	fdx1_update_post_settings();

	if ( isset( $_GET['fdx1_oauth'] ) ) {
		global $fdx1_oauth;

		$settings = fdx1_get_settings();
		$result = $fdx1_oauth->get_access_token( $settings['oauth_request_token'], $settings['oauth_request_token_secret'], $_GET['oauth_verifier'] );
		if ( $result ) {
			$settings['oauth_access_token'] = $result['oauth_token'];
			$settings['oauth_access_token_secret'] = $result['oauth_token_secret'];
			$settings['user_id'] = $result['user_id'];

			$result = $fdx1_oauth->get_user_info( $result['user_id'] );
			if ( $result ) {
				$settings['profile_image_url'] = $result['user']['profile_image_url'];
				$settings['screen_name'] = $result['user']['screen_name'];
				if ( isset( $result['user']['location'] ) ) {
					$settings['location'] = $result['user']['location'];
				} else {
					$settings['location'] = false;
				}
			}

			fdx1_save_settings( $settings );

			header( 'Location: ' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page='.FDX1_PLUGIN_P1);
			die;
		}
	} else if ( isset( $_GET['fdx1'] ) && $_GET['fdx1'] == 'deauthorize' ) {
		$settings = fdx1_get_settings();
		$settings['oauth_access_token'] = '';
		$settings['oauth_access_token_secret'] = '';
		$settings['user_id'] = '';
		fdx1_save_settings( $settings );

		header( 'Location: ' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page='.FDX1_PLUGIN_P1);
		die;
	}

}

/* (F6)
*------------------------------------------------------------*/
function fdx1_get_profile_url() {
	$settings = fdx1_get_settings();

	return $settings['profile_image_url'];
}

/*
*------------------------------------------------------------*/
function fdx1_twit_update_status( $new_status ) {
	global $fdx1_oauth;
	$settings = fdx1_get_settings();
	if ( isset( $settings['oauth_access_token'] ) && isset( $settings['oauth_access_token_secret'] ) ) {
		return $fdx1_oauth->update_status( $settings['oauth_access_token'], $settings['oauth_access_token_secret'], $new_status );
	}
	return false;
}

/*
*------------------------------------------------------------*/
function fdx1_twit_has_tokens() {
	$settings = fdx1_get_settings();

	return ( $settings[ 'oauth_access_token' ] && $settings['oauth_access_token_secret'] );
}

/*
*------------------------------------------------------------*/
function fdx1_is_valid() {
	return fdx1_twit_has_tokens();
}


/*
*------------------------------------------------------------*/
function fdx1_make_tinyurl( $link, $update = true, $post_id ) {
	if ( strpos( $link, 'http://' ) === false ) {
		return $link;
	}

	$settings = fdx1_get_settings();

	$short_link = false;

if ( $settings['url_type'] == 'tinyurl' ) {  //ok
require_once(dirname(__FILE__) . '/p1/tinyurl.php' );
$tinyurl = new FDX1TinyUrlShortener;
$short_link = $tinyurl->shorten( $link );
//yourls
} else if ( $settings['url_type'] == 'yourls' ) {
require_once(dirname(__FILE__) . '/p1/yourls.php' );
$settings = fdx1_get_settings();
$yourls_link = new FDX1YourlsShortener($settings['yourls-api-key'], $settings['yourls-user-name'] );
$short_link = $yourls_link->shorten( $link );
//bitly
} else if ( $settings['url_type'] == 'bitly' ) {
if ( isset( $settings['bitly-user-name'] ) && strlen( $settings['bitly-user-name'] ) ) {
require_once(dirname(__FILE__) . '/p1/bitly.php' );
$settings = fdx1_get_settings();
$tinyurl = new FDX1BitlyShortener( $settings['bitly-user-name'], $settings['bitly-api-key'] );
$short_link = $tinyurl->shorten( $link );
} else {  // if ERRO = tinyurl
require_once(dirname(__FILE__) . '/p1/tinyurl.php' );
$tinyurl = new FDX1TinyUrlShortener;
$short_link = $tinyurl->shorten( $link );
}
//isgd
} else if ( $settings['url_type'] == 'isgd' ) {
require_once(dirname(__FILE__) . '/p1/isgd.php' );
$isgd_link = new FDX1IsgdShortener;
$short_link = $isgd_link->shorten( $link );
//post_id
} else if ( $settings['url_type'] == 'post_id' ) {
$short_link = fdx1_post_id_url_base() . $post_id;
}
return $short_link;
}

/*
*------------------------------------------------------------*/
function fdx1_post_id_url_base() {
	$settings = fdx1_get_settings();

	$url = get_bloginfo( 'home' ) . '/?p=';
	$url = str_replace( 'www.', '', $url );
	return $url;
}


/*
*------------------------------------------------------------*/
function fdx_hash_tags2( $post_id ) {
	$hashtags = '';
	$max_tags = '3'; //Maximum number of tags to include
	$max_characters = '15'; //Maximum length in characters for included tags
	$max_characters = ( $max_characters == 0 || $max_characters == "" )?100:$max_characters + 1;
	if ($max_tags == 0 || $max_tags == "") { $max_tags = 100; }
		$tags = get_the_tags( $post_id );
		if ( $tags > 0 ) {
		$i = 1;
			foreach ( $tags as $value ) {
			$tag = $value->name;
			$replace = '_'; //Spaces in tags replaced with
			$strip = '0'; //Strip nonalphanumeric characters from tags no=0 | yes=1
			$search = "/[^\p{L}\p{N}\s]/u";
			if ($replace == "[ ]") { $replace = ""; }
			$tag = str_ireplace( " ",$replace,trim( $tag ) );
			if ($strip == '1') { $tag = preg_replace( $search, $replace, $tag ); }
			if ($replace == "" || !$replace) { $replace = "_"; }
				$newtag = "#$tag";
					if ( mb_strlen( $newtag ) > 2 && (mb_strlen( $newtag ) <= $max_characters) && ($i <= $max_tags) ) {
					$hashtags .= "$newtag ";
					$i++;
					}
			}
		}
	$hashtags = trim( $hashtags );
	if ( mb_strlen( $hashtags ) <= 1 ) { $hashtags = ""; }
	return $hashtags;
}

/*
*------------------------------------------------------------*/
function fdx1_get_message( $post_id ) {
	$my_post = get_post( $post_id );
	if ( $my_post ) {
		$settings = fdx1_get_settings();

		$message = $settings['message'];
		$message = str_replace( '[title]', $my_post->post_title, $message );
//--------------------------
        $message = str_replace( '[author]', get_the_author_meta( 'display_name',$my_post->post_author ), $message );
        $message = str_replace( '[tags]', fdx_hash_tags2( $post_id ), $message );
        $categorys = get_the_category($post_id);
        $message = str_replace( '[cat]', $categorys[0]->name, $message );
//--------------------------
		$tinyurl = fdx1_make_tinyurl( get_permalink( $post_id ), true, $my_post->ID );

		if ( $tinyurl ) {
			$message = str_replace( '[link]', $tinyurl, $message );
			return $message;
		}
	}

	return false;
}

/*
*------------------------------------------------------------*/
function fdx1_post_now_published( $post_id) {

	$settings = fdx1_get_settings();

	$wt_tags = $settings['tags'];
	$wt_reverse = $settings['reverse'];


		$can_tweet = true;

		// check tags
		if ( count( $wt_tags ) ) {

			// we have a tag or a category
			$new_taxonomy = array();

			$post_tags = get_the_tags();
			if ( $post_tags ) {
				foreach ( $post_tags as $some_tag ) {
					$new_taxonomy[] = strtolower( $some_tag->name );
				}
			}

			$post_categories = get_the_category();
			if ( $post_categories ) {
				foreach ( $post_categories as $some_category ) {
					$new_taxonomy[] = strtolower( $some_category->name );
				}
			}

			$category_hits = array_intersect( $wt_tags, $new_taxonomy );

			if ( $wt_reverse ) {
				$can_tweet = ( count( $category_hits ) == 0);
			} else {
				$can_tweet = ( count( $category_hits ) > 0);
			}
		}

		if ($can_tweet ) {
 			$result = fdx1_do_tweet( $post_id );
		}

}

/* Atention
*------------------------------------------------------------*/
function fdx1_save_settings( $settings ) {
	update_option( 'fdx1_settings', $settings );
}
?>