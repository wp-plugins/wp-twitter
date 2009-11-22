<?php
// Date function (this could be included in a seperate script to keep it clean)
function datediff0($d1, $d2){
	$d1 = (is_string($d1) ? strtotime($d1) : $d1);
	$d2 = (is_string($d2) ? strtotime($d2) : $d2);

	$diff_secs = abs($d1 - $d2);
	$base_year = min(date("Y", $d1), date("Y", $d2));

	$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	$diffArray = array(
		"years" => date("Y", $diff) - $base_year,
		"months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
		"months" => date("n", $diff) - 1,
		"days_total" => floor($diff_secs / (3600 * 24)),
		"days" => date("j", $diff) - 1,
		"hours_total" => floor($diff_secs / 3600),
		"hours" => date("G", $diff),
		"minutes_total" => floor($diff_secs / 60),
		"minutes" => (int) date("i", $diff),
		"seconds_total" => $diff_secs,
		"seconds" => (int) date("s", $diff)
	);
	if($diffArray['days'] > 0){
		if($diffArray['days'] == 1){
			$days = '1 day';
		}else{
			$days = $diffArray['days'] . __(' days ', 'wp-twitter');
		}
		return $days ." ". __('and', 'wp-twitter') ." ". $diffArray['hours'] . __('hours ago', 'wp-twitter'); 
	}else if($diffArray['hours'] > 0){
		if($diffArray['hours'] == 1){
			$hours = '1 hour';
		}else{
			$hours = $diffArray['hours'] . __(' hours ', 'wp-twitter');;
		}
		return $hours ." ". __('and', 'wp-twitter') ." ". $diffArray['minutes'] . __('minutes ago ', 'wp-twitter');
	}else if($diffArray['minutes'] > 0){
		if($diffArray['minutes'] == 1){
			$minutes = '1 minute';
		}else{
			$minutes = $diffArray['minutes'] . __(' minutes ', 'wp-twitter');
		}
		return $minutes ." ". __('and', 'wp-twitter') ." ". $diffArray['seconds'] .  __('seconds ago ', 'wp-twitter');
	}else{
		return __('Less than a minute ago', 'wp-twitter'); 
	}
}

// Work out the Date plus 8 hours
// get the current timestamp into an array
$timestamp = time();
$date_time_array = getdate($timestamp);

$hours = $date_time_array['hours'];
$minutes = $date_time_array['minutes'];
$seconds = $date_time_array['seconds'];
$month = $date_time_array['mon'];
$day = $date_time_array['mday'];
$year = $date_time_array['year'];

// use mktime to recreate the unix timestamp
// adding 19 hours to $hours
$timestamp = mktime($hours + 0,$minutes,$seconds,$month,$day,$year);
$theDate = strftime('%Y-%m-%d %H:%M:%S',$timestamp);	

// END DATE FUNCTION
?>