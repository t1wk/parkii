<?php
	
	/*
		Template Name: Contact
	*/
	
	/* INCLUDES */
	require_once($_SERVER['DOCUMENT_ROOT'] . '/_php/detect.mobile.php');
	define('DESKTOP_CLIENT', 0);
	define('MOBILE_CLIENT', 1 << 1);
	define('TABLET_CLIENT', 1 << 2);

	$detect = new Mobile_Detect;
	$client_device = DESKTOP_CLIENT;
	
	if($detect->isMobile()) {
		$client_device |= MOBILE_CLIENT;
		}
	else if($detect->isTablet()) {
		$client_device |= TABLET_CLIENT;
	}
		
	// Head and meta
	wp_head();

?>
</head>
<body>
	<?php if($detect->isMobile()) {
		// Lock rotation
		require_once('lockrotation.php');
		
		echo "<header class='sticky'>";
	} else {
		echo "<header>";
	}	 
			// Navigation
			require_once('nav.php');
	?>
	<?php 
		// Footer
		wp_footer();
		get_footer();
	?>
	