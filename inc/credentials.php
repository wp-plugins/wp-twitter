<?php
if ( ABSPATH ) {
   require_once( ABSPATH . 'wp-config.php' );
   require_once( ABSPATH . 'wp-includes/class-snoopy.php' );
} else {
   require_once( '../../../wp-config.php' );
   require_once( '../../../wp-includes/class-snoopy.php' );
}
// xml
function wptwitter_xml( $xml, $get_attributes = 1, $priority = 'tag' )
{
    $parser = xml_parser_create('');
    xml_parser_set_option( $parser, XML_OPTION_TARGET_ENCODING, "UTF-8" );
    xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 );
    xml_parser_set_option( $parser, XML_OPTION_SKIP_WHITE, 1 );
    xml_parse_into_struct( $parser, trim($xml), $xml_values );
    xml_parser_free($parser);
    
    if (!$xml_values)
        return; 
        
    $xml_array = array ();
    $parents = array ();
    $opened_tags = array ();
    $arr = array ();
    $current = & $xml_array;
    $repeated_tag_index = array (); 
    
    foreach ($xml_values as $data) {
        unset ($attributes, $value);
        extract($data);
        $result = array ();
        $attributes_data = array ();
        if (isset ($value))
        {
            if ($priority == 'tag')
                $result = $value;
            else
                $result['value'] = $value;
        }
        if (isset ($attributes) and $get_attributes)
        {
            foreach ($attributes as $attr => $val)
            {
                if ($priority == 'tag')
                    $attributes_data[$attr] = $val;
                else
                    $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
            }
        }
        if ($type == "open")
        { 
            $parent[$level -1] = & $current;
            if (!is_array($current) or (!in_array($tag, array_keys($current))))
            {
                $current[$tag] = $result;
                if ($attributes_data)
                    $current[$tag . '_attr'] = $attributes_data;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                $current = & $current[$tag];
            }
            else
            {
                if (isset ($current[$tag][0]))
                {
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    $repeated_tag_index[$tag . '_' . $level]++;
                }
                else
                { 
                    $current[$tag] = array (
                        $current[$tag],
                        $result
                    ); 
                    $repeated_tag_index[$tag . '_' . $level] = 2;
                    if (isset ($current[$tag . '_attr']))
                    {
                        $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                        unset ($current[$tag . '_attr']);
                    }
                }
                $last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
                $current = & $current[$tag][$last_item_index];
            }
        }
        elseif ($type == "complete")
        {
            if (!isset ($current[$tag]))
            {
                $current[$tag] = $result;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                if ($priority == 'tag' and $attributes_data)
                    $current[$tag . '_attr'] = $attributes_data;
            }
            else
            {
                if (isset ($current[$tag][0]) and is_array($current[$tag]))
                {
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    if ($priority == 'tag' and $get_attributes and $attributes_data)
                    {
                        $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag . '_' . $level]++;
                }
                else
                {
                    $current[$tag] = array (
                        $current[$tag],
                        $result
                    ); 
                    $repeated_tag_index[$tag . '_' . $level] = 1;
                    if ($priority == 'tag' and $get_attributes)
                    {
                        if (isset ($current[$tag . '_attr']))
                        { 
                            $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                            unset ($current[$tag . '_attr']);
                        }
                        if ($attributes_data)
                        {
                            $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag . '_' . $level]++; //0 and 1 index is already taken
                }
            }
        }
        elseif ($type == 'close')
        {
            $current = & $parent[$level -1];
        }
    }
    return $xml_array;
}
// xml end
$username = get_option('wp_twitter_username');
$password = get_option('wp_twitter_pw');

$settings['username'] = $username;
$settings['password'] = $password;


function wptwitter_hit_server( $location, $username, $password, &$output, $post = false, $post_fields = '' ) {
   global $wptwitter_version;
   $output = '';
   $snoopy = new Snoopy;
   $snoopy->agent = 'WP-Twitter ' . $wptwitter_version;

   if ( $username ) {
      $snoopy->user = $username;
      if ( $password ) {
         $snoopy->pass = $password;      
      }
   }
   
   if ( $post ) {
      // need to do the actual post
      $result = $snoopy->submit( $location, $post_fields );
      if ( $result ) {
         return $true;  
      }
   } else {
      $result = $snoopy->fetch( $location );
      if ( $result ) {
         $output = $snoopy->results;  
      }
      
      $code = explode( ' ', $snoopy->response_code );
      if ( $code[1] == 200) {
         return true;
      } else {
         return false;
      }
   }
}


function wptwitter_verify_credentials( $username, $password, &$credent ) {
  $output = '';
  $result = wptwitter_hit_server( 'http://twitter.com/account/verify_credentials.xml', $username, $password, $output );  
   if ( $result ) {
        $credent= wptwitter_xml( $output );
   } 
   return $result;
}?>
