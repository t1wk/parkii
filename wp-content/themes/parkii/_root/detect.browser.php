<?php
	/* Copyright 2012 Magsty, Inc. */
	
	/* INCLUDES */
	require_once($_SERVER['DOCUMENT_ROOT'] . '/test/php/definitions.php');
	
	// Function gets the time difference between two dates
	function time_difference($time1, $time2) {
		$time_difference = abs(strtotime($time1) - strtotime($time2)); 
		$years = floor($time_difference / TIME_IN_YEARS);//(365*60*60*24)); 
		$months = floor(($time_difference - $years * TIME_IN_YEARS) / TIME_IN_MONTHS);//(30*60*60*24)); 
		$days = floor(($time_difference - $years * TIME_IN_YEARS - $months * TIME_IN_MONTHS)/ TIME_IN_DAYS);//(60*60*24));
		return $days;	
	}

	// Function finds the user's browser
	function detect_user_browser() { 
	    $user_agent = $_SERVER['HTTP_USER_AGENT']; 
	    $user_browser_name = 'Unknown';
	    $user_operating_system = 'Unknown';
	    $user_version = '';
	
	    // First get the platform?
	    if(preg_match('/linux/i', $user_agent)) {
	        $user_operating_system = 'linux';
	    } else if(preg_match('/macintosh|mac os x/i', $user_agent)) {
	        $user_operating_system = 'mac';
	    } else if(preg_match('/windows|win32/i', $user_agent)) {
	        $user_operating_system = 'windows';
	    }
	    
	    // Next get the name of the useragent yes seperately and for good reason
	    if(preg_match('/MSIE/i', $user_agent) && !preg_match('/Opera/i', $user_agent)) { 
	        $user_browser_name = 'Internet Explorer'; 
	        $user_browser = 'MSIE'; 
	    } else if(preg_match('/Firefox/i', $user_agent)) { 
	        $user_browser_name = 'Mozilla Firefox'; 
	        $user_browser = 'Firefox'; 
	    } else if(preg_match('/Chrome/i', $user_agent)) { 
	        $user_browser_name = 'Google Chrome'; 
	        $user_browser = 'Chrome'; 
	    } else if(preg_match('/Safari/i', $user_agent)) { 
	        $user_browser_name = 'Apple Safari'; 
	        $user_browser = 'Safari'; 
	    } else if(preg_match('/Opera/i', $user_agent)) { 
	        $user_browser_name = 'Opera'; 
	        $user_browser = 'Opera'; 
	    } else if(preg_match('/Netscape/i', $user_agent)) { 
	        $user_browser_name = 'Netscape'; 
	        $user_browser = 'Netscape'; 
	    } 
	    
	    // Finally get the correct version number
	    $known = array('Version', $user_browser, 'other');
	    $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	    
	    if(!preg_match_all($pattern, $user_agent, $matches)) {
	        // We have no matching number just continue
	    }
	    
	    // See how many we have
	    $i = count($matches['browser']);
	    if($i != 1) {
	        // We will have two since we are not using 'other' argument yet
	        // See if version is before or after the name
	        if(strripos($user_agent, 'Version') < strripos($user_agent, $user_browser)) {
	            $user_version = $matches['version'][0];
	        } else {
	            $user_version = $matches['version'][1];
	        }
	    } else {
	        $user_version = $matches['version'][0];
	    }
	    
	    // Check if we have a number
	    if($user_version == null || $user_version == "") {
	    	$user_version ='?';
		}
	    
	    return array(
	        'user_agent' => $user_agent,
	        'browser_name' => $user_browser_name,
	        'version' => $user_version,
	        'platform' => $user_operating_system,
	        'pattern' => $pattern
	    );
	}
?>