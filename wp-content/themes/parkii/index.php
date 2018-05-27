<?php	
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
	
	wp_head();
?>
</head>	
<body class="">
	<div class="wrapper">
		<?php if($detect->isMobile()) {
			// Specifics if mobile
			// Lock rotation
			//require_once('lockrotation.php');
			
			echo "<header class='sticky'>";
		} else {
			echo "<header>";
		}	 
				// Navigation
				require_once("nav.php");
		?>
		</header>
		
		<section id="intro">
			<h1>All Natural Shea butter from the ivory coast</h1>
			<p><strong>Parkii celebrates its authentic origin of the Ivory Coast by giving back to the community where the Shea Butter is made.</strong></p>
		</section>
			
		<section id="testimonials">
			<h2>Testimonials</h2>
			<ul>
				<li>
					<quote>I love this product. It has a nice, delicate scent and is whipped until it is fluffy. The shea butter is so light when you put it on that you may forget that you already did. It's great for moisturizing and keeps my skin supple.</quote>
					<cite>Juanita M.</cite>
				</li>
				<li>
					<quote>I use Parkii Refined Shea Butter because of its conditioning and moisturizing benefits. It leaves my hair hydrated with a brilliant shine and my skin smooth. Best of all it's all natural and yummy smelling with multiple uses.</quote>
					<cite>Alex G.</cite>
				</li>
				<li>
					<quote>I had been buying Shea butter on and off for a few years when I purchased The Parkii shea butter. I predominantly use it as a sealant for my skin and hair. What I absolutely love about this butter is its texture. It is by far the smoothest and creamiest shea butter I have found on the market. This makes application a pleasure as the butter virtually melts in your hands. You can actually feel the quality of this product.</quote>
					<cite>Lisa M.</cite>
				</li>
			</ul>
		</section>
			
		<section id="benefits">
			<h3>Benefits of Shea Butter</h3>
			<h4>Shea butter is a rich source of moisture, vitamins and fat for your skin and hair.</h4>
			<ul>
				<li>Moisturizer</li>
				<li>Anti-Inflammatory</li>
				<li>Skin smoothing</li>
			</ul>
			<a role="button" href="shop">Shop Now</a>
		</section>
		
		<section id="woocommerce">
		</section>
	
	<?php 
		// Footer
		wp_footer();
		get_footer();
	?>