	<a class="logo" href="<?php echo home_url()?>"><span class="none">Parkii</span><?php //echo file_get_contents("_images/logo.svg", true); ?></a>
	
	<?php 
	
		if($detect->isMobile()) {
			echo "<div id='navTrigger'><i></i><i></i><i></i></div>";
			
			$args = array( 
				'theme_location'  => 'p_menu',
				'menu'            => 'parkii-menu', 
				'container'       => 'nav', 
				'container_class' => 'main-nav', 
				'container_id'    => 'menu',
				'echo'            => true		
			);
			
		}else{
			$args = array( 
				'theme_location'  => 'p_menu',
				'menu'            => 'parkii-menu', 
				'container'       => 'nav', 
				'container_class' => 'main-nav desktop', 
				'container_id'    => 'menu',
				'echo'            => true		
			);
		}
			
		wp_nav_menu( $args );
	?>