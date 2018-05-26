<?php

// Include LESS Support
	require_once($_SERVER['DOCUMENT_ROOT'] . "/_php/lessphp/lessc.inc.php");
	require_once( '_php/wp-less/wp-less.php' );

/**
* Parkii functions and definitions
**/

	/* check if user using smaller mobile device */
	function my_wp_is_mobile() {
		require_once($_SERVER['DOCUMENT_ROOT'] . '/_php/detect.mobile.php');
		$detect = new Mobile_Detect;
		if( $detect->isMobile() && !$detect->isTablet() ) {
			return true;
		} else {
			return false;
		}
	}
	
	/* check if user using tablet device */
	function my_wp_is_tablet() {
		require_once($_SERVER['DOCUMENT_ROOT'] . '/_php/detect.mobile.php');
		$detect = new Mobile_Detect;
		if( $detect->isTablet() ) {
			return true;
		} else {
			return false;
		}
	}
		
	// Loading CSS and Scripts
	function p_scripts() {
				
		// Load main scripts
		wp_enqueue_script( 'tweenmax', '//cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js', array ( 'jquery' ), null, true);
		wp_enqueue_script( 'tweenmax-cssplugin', '//cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/plugins/CSSRulePlugin.min.js', array ( 'jquery' ), null, true);
		//wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/_js/off/modernizr.js', array ( 'jquery' ), null, true);
		
		
		// Load REST specific scripts
		if ( wp_is_mobile() ) {
			if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
				wp_enqueue_script( 'mobile', get_template_directory_uri() . '/_js/mobile.min.js', array ( 'jquery' ), null, true);
			} else {
				wp_enqueue_script( 'mobile', get_template_directory_uri() . '/_js/mobile.js', array ( 'jquery' ), null, true);
			}		
		} else {	
			if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
				wp_enqueue_script( 'scripts', get_template_directory_uri() . '/_js/desktop.min.js', array ( 'jquery' ), null, true);
			} else {
				wp_enqueue_script( 'scripts', get_template_directory_uri() . '/_js/scripts.js', array ( 'jquery' ), null, true);
			}	
		}
		
		// Load our main stylesheet
		if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
			wp_enqueue_style( 'parkii-style', get_template_directory_uri() . '/_css/styles.min.css' );
		} else {
			wp_enqueue_style( 'reset', get_template_directory_uri() . '/_css/reset.css' );
			wp_enqueue_style( 'styles', get_template_directory_uri() . '/_css/styles.less' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'p_scripts' );
			
	// Register meta tags
	function p_metatags() {
		
		// Meta Data variables
		$title = 'Parkii Shop';
		$url = 'https://www.parkiishop.com';
		$short_url = '';
		$summary = '';
		$image = 'favicon.png';
		$bigimage = '';
		$keywords = '';
		$author = 'Gilbert Consulting Group';
		$expires = '';
		$summary_fb = '';
		$summary_twitter = '';
		
	?>
		<meta name="description" content="<?php echo $summary; ?>">
		<meta name="abstract" content="<?php echo $summary; ?>">
		<meta name="keywords" content="<?php echo $keywords; ?>">
		<meta name="author" content="<?php echo $author; ?>">
		<meta http-equiv="expires" content="<?php echo $expires; ?>">
		<meta name="revisit-after" content="15 days">
		<meta name="robots" content="follow,index">
	
	<?php 
		
		if( my_wp_is_mobile() ) {
				// To only address iPhones
				echo '<meta name = "viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui, viewport-fit=cover">
					  <meta name = "apple-mobile-web-app-capable" content="yes">
					  <meta name = "format-detection" content="telephone=no">';
			} else {
				echo '<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">';
			}
	?>
		<meta charset="utf-8">
		<title><?php echo $title ?></title>
		<link rel="icon" type="image/jpeg" href="<?php echo $image; ?>">
		
		<!-- Facebook -->
		<meta name="medium" content="mult" />
		<meta property="og:title" content="<?php echo $title; ?>" />
		<meta property="og:description" content="<?php echo $summary_fb; ?>" />
		<meta property="og:image" content="<?php echo $bigimage; ?>" />
		<link rel="image_src" type="image/jpeg" href="<?php echo $bigimage; ?>" />

		<!-- Google -->
		<meta itemprop="name" content="<?php echo $title; ?>">
		<meta itemprop="description" content="<?php echo $summary_fb; ?>">
		<meta itemprop="image" content="<?php echo $bigimage; ?>">

		<!-- Favicon -->
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="194x194" href="/favicon-194x194.png">
		<link rel="icon" type="image/png" sizes="192x192" href="/android-chrome-192x192.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
		<link rel="manifest" href="/manifest.json">
		<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#e31c79">
		<meta name="theme-color" content="#f2f1f0">
		
	<?php }
	
	add_action('wp_head', 'p_metatags');
	
	// Page redirected to Coming Soon to visitor but not to admin
	function temp_page_redirect() {
    if (!current_user_can('administrator')) {
	        wp_safe_redirect('comingsoon.html',307);
	    }
	}
	add_action('template_redirect','temp_page_redirect');
		
	// Registering Custom menu
	function p_menu() {
		register_nav_menu('p_menu',__( 'Parkii - Menu' ));
	}
	add_action( 'init', 'p_menu' );
	
	// Cleaning the markup of the default menu
	function wp_nav_menu_attributes_filter($var) {
		return is_array($var) ? array_intersect($var, array('current-menu-item')) : '';
	}
	
	add_filter('nav_menu_css_class', 'wp_nav_menu_attributes_filter', 100, 1);
	add_filter('nav_menu_itep_id', 'wp_nav_menu_attributes_filter', 100, 1);
	add_filter('page_css_class', 'wp_nav_menu_attributes_filter', 100, 1);
	
	
	// Disable editors
	add_action('admin_init', 'my_remove_menu_elements', 102);

	function my_remove_menu_elements() {
		remove_submenu_page( 'themes.php', 'theme-editor.php' );
		remove_submenu_page( 'plugins.php','plugin-editor.php' );
	}
	
	// Remove the deactivate and edit link from the plugins
	add_filter( 'plugin_action_links', 'disable_plugin_deactivation', 10, 4 );
	
	function disable_plugin_deactivation( $actions, $plugin_file, $plugin_data, $context ) {
	    // Remove edit link for all
	    if ( array_key_exists( 'edit', $actions ) )
	        unset( $actions['edit'] );
	    
	    // Remove deactivate link for crucial plugins
	    if ( array_key_exists( 'deactivate', $actions ) && in_array( $plugin_file, array(
	        'customizer-remove-all-parts/wp-crap.php'
	    )))
	        unset( $actions['deactivate'] );
	    return $actions;
	}
	
	// Hide some plugins from the list
	add_filter( 'all_plugins', 'hide_plugins');
	
	function hide_plugins($plugins)	{
		
		if(is_plugin_active('customizer-remove-all-parts/wp-crap.php')) {
				//unset( $plugins['customizer-remove-all-parts/wp-crap.php'] );
		}		
		return $plugins;
	}
	
	// Remove <p> tags from images
	function img_unautop($pee) {
    	$pee = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $pee);
		return $pee;
	}
	add_filter( 'the_content', 'img_unautop', 30 );
	
	
	// Add thumbnail function
	add_theme_support( 'post-thumbnails' );
	
	
	// Allow SVG upload
	function cc_mime_types($mimes) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
	add_filter('upload_mimes', 'cc_mime_types');
		
	/**
	 * Custom WP gallery
	 */
	add_shortcode('gallery', 'my_gallery_shortcode');    
	function my_gallery_shortcode($attr) {
	   $post = get_post();
	
		static $instance = 0;
		$instance++;
	
		if ( ! empty( $attr['ids'] ) ) {
		    // 'ids' is explicitly ordered, unless you specify otherwise.
		    if ( empty( $attr['orderby'] ) )
		        $attr['orderby'] = 'post__in';
		    $attr['include'] = $attr['ids'];
		}
	
		// Allow plugins/themes to override the default gallery template.
		$output = apply_filters('post_gallery', '', $attr);
		if ( $output != '' )
		    return $output;
	
		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
		    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		    if ( !$attr['orderby'] )
		        unset( $attr['orderby'] );
		}
	
		extract(shortcode_atts(array(
		    'order'      => 'ASC',
		    'orderby'    => 'menu_order ID',
		    'id'         => $post->ID,
		    'itemtag'    => 'li',
		    'icontag'    => 'figure',
		    'captiontag' => 'figcaption',
		    'columns'    => 3,
		    'size'       => 'thumbnail',
		    'include'    => '',
		    'exclude'    => ''
		), $attr));
	
		$id = intval($id);
		if ( 'RAND' == $order )
		    $orderby = 'none';
	
		if ( !empty($include) ) {
		    $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	
		    $attachments = array();
		    foreach ( $_attachments as $key => $val ) {
		        $attachments[$val->ID] = $_attachments[$key];
		    }
		} elseif ( !empty($exclude) ) {
		    $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		} else {
		    $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		}
	
		if ( empty($attachments) )
		    return '';
	
		if ( is_feed() ) {
		    $output = "\n";
		    foreach ( $attachments as $att_id => $attachment )
		        $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		    return $output;
		}
	
		$itemtag = tag_escape($itemtag);
		$captiontag = tag_escape($captiontag);
		$icontag = tag_escape($icontag);
		$valid_tags = wp_kses_allowed_html( 'post' );
		if ( ! isset( $valid_tags[ $itemtag ] ) )
		    $itemtag = 'li';
		if ( ! isset( $valid_tags[ $captiontag ] ) )
		    $captiontag = 'figcaption';
		if ( ! isset( $valid_tags[ $icontag ] ) )
		    $icontag = 'figure';
	
		$columns = intval($columns);
		$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
		$float = is_rtl() ? 'right' : 'left';
	
		$selector = "gallery-{$instance}";
	
		$gallery_style = $gallery_div = '';
		if ( apply_filters( 'use_default_gallery_style', true ) )
		    $gallery_style = "
		    <style type='text/css'>
		        #{$selector} {
		            margin: auto;
		        }
		        #{$selector} .gallery-item {
		            float: {$float};
		            margin-top: 10px;
		            text-align: center;
		            width: {$itemwidth}%;
		        }
		        #{$selector} img {
		            
		        }
		        #{$selector} .gallery-caption {
		            margin-left: 0;
		        }
		    </style>
		    <!-- see gallery_shortcode() in wp-includes/media.php -->";
		$size_class = sanitize_html_class( $size );
		$gallery_div = "<ul id='$selector' class='flex gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
		$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
	
		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
		    $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
	
		    $output .= "<{$itemtag} class='gallery-item'>";
		    $output .= "
		        <{$icontag} class='gallery-icon'>
		            $link
		        </{$icontag}>";
		    if ( $captiontag && trim($attachment->post_excerpt) ) {
		        $output .= "
		            <{$captiontag} class='wp-caption-text gallery-caption'>
		            " . wptexturize($attachment->post_excerpt) . "
		            </{$captiontag}>";
		    }
		    $output .= "</{$itemtag}>";
		    if ( $columns > 0 && ++$i % $columns == 0 )
		        $output .= '<br style="clear: both" />';
		}
	
		$output .= "
		        <br style='clear: both;' />
		    </ul>\n";
	
		return $output;
	}
	
	// Get rid off Howdy, User
	add_filter('gettext', 'change_howdy', 10, 3);

	function change_howdy($translated, $text, $domain) {
	
	    if (!is_admin() || 'default' != $domain)
	        return $translated;
	
	    if (false !== strpos($translated, 'Howdy'))
	        return str_replace('Howdy', 'Welcome', $translated);
	
	    return $translated;
	}
	
	/*
	 * Load the theme options page.
	 */
	//require_once( __DIR__ . '/theme-options/theme-options.php');
?>