function parallaxFx(){
	//define store some initial variables
	var	halfWindowH = $j(window).height()*0.5,
		halfWindowW = $j(window).width()*0.5,
		//define a max rotation value (X and Y axises)
		maxRotationY = 5,
		maxRotationX = 3,
		aspectRatio;
		
	var container = $j('.cd-floating-background'),
		wrapper = $j('.cd-background-wrapper'),
		layers = container.find('.parallax'),
		totalL = layers.length;
		

		
	//detect mouse movement
		
		$j("#intro").on('mousemove', function(event){
			var wrapperOffsetTop = $j(wrapper).offset().top;
			if( $j('html').hasClass('preserve-3d') ) {
				window.requestAnimationFrame(function(){
					moveBackground(event, wrapperOffsetTop);
				});
			}
		});

			
	// Hero parallax
	function heroFx(){
		var topDistance = $j(window).scrollTop(),
			bgMov = -(topDistance * 0.4);
			posM = (-185.2)+(topDistance * 0.04);
			posB = (-277.8)+(topDistance * 0.04);
			posV = (-100)+(topDistance * 0.05);
			
			if(window.matchMedia("(max-height: 800px)").matches){
				posA = (-150.8) +(topDistance * 0.04);
			}else{
				posA = (-277.8) +(topDistance * 0.04);
			}
					
		window.requestAnimationFrame(function(){
			// For every image
			$j(layers).each(function (i, value) {
				var depth = $j(this).attr('data-depth'),
					z = parseInt($j(this).attr('data-z')),
					movement = -(topDistance * depth),
					rotateX = (movement*maxRotationX) / 50,
					zoomout = z+(movement / 5)
					opacity = 0.9+(movement/200);
						
				$j(this).css({
					'transform': 'translateY(' + movement + 'px) translateZ(' + zoomout + 'px) rotateX(' + rotateX + 'deg' + ')'
					//'transform': 'translateY(' + movement + 'px) translateZ(' + z + ') rotateX(0)'
				});
			});
			
			$j(wrapper).css({'transform': 'translateY(' + bgMov + 'px)'});
			$j("p.intro").css({'opacity': opacity});
			
			$j("#home-mobile.second-image").css('background-position', '0px ' + posB + 'px, ' + '0px 0px, ' + '0px ' + posM + 'px');
			$j("#what-app.second-image").css('background-position', '0px 0px, ' + '0px ' + posA + 'px');
			$j("#who-volunteers img").css({'transform': 'translateY(' + posV + 'px)'});
			$j("#inv-dom article figure, #inv-int article figure").css('top', posV + 'px');
			
			
			if( topDistance >= $j(window).height()){
				$j("a.logo").css({'opacity': 1});
				$j("header").addClass("sticky");
			} else {
				$j("a.logo").css({'opacity': opacity});
				$j("header").removeClass("sticky");
			}
			
		});
	}
	
	function initBackground() {
		var wrapperHeight = Math.ceil(halfWindowW*2/aspectRatio), 
			proportions = ( maxRotationY > maxRotationX ) ? 1.1/(Math.sin(Math.PI / 2 - maxRotationY*Math.PI/180)) : 1.1/(Math.sin(Math.PI / 2 - maxRotationX*Math.PI/180)),
			newImageWidth = Math.ceil(halfWindowW*2*proportions),
			newImageHeight = Math.ceil(newImageWidth/aspectRatio),
			newLeft = halfWindowW - newImageWidth/2,
			newTop = (wrapperHeight - newImageHeight)/2,
			layers = $j('.cd-floating-background').find('.parallax');
		
		//set dimentions and position of the .cd-background-wrapper		
		container.css({
			'left' : newLeft,
			'top' : newTop,
			'width' : newImageWidth,
		});
	}

	function moveBackground(event, topOffset) {
		var rotateY = ((-event.pageX+halfWindowW)/halfWindowW)*maxRotationY,
			yPosition = event.pageY - topOffset,
			rotateX = ((yPosition-halfWindowH)/halfWindowH)*maxRotationX;

		if( rotateY > maxRotationY) rotateY = maxRotationY;
		if( rotateY < -maxRotationY ) rotateY = -maxRotationY;
		if( rotateX > maxRotationX) rotateX = maxRotationX;
		if( rotateX < -maxRotationX ) rotateX = -maxRotationX;

		$j('.cd-floating-background').css({
			'transform': 'rotateX(' + rotateX + 'deg' + ') rotateY(' + rotateY + 'deg' + ') translateZ(0)',
		});
	}
	
	//on resize - adjust .cd-background-wrapper and .cd-floating-background dimentions and position
	$j(window).on('resize', function(){
		if( $j('html').hasClass('preserve-3d') ) {
			window.requestAnimationFrame(function(){
				halfWindowH = $j(window).height()*0.5,
				halfWindowW = $j(window).width()*0.5;
				initBackground();
			});
		} else {
			$j('.cd-background-wrapper').attr('style', '');
			$j('.cd-floating-background').attr('style', '');
		}
	});
	
	$j(window).on('scroll', heroFx);


	/* 	Detect "transform-style: preserve-3d" support, or update csstransforms3d for IE10 ? #762
		https://github.com/Modernizr/Modernizr/issues/762 */
	(function getPerspective(){
	  var element = document.createElement('p'),
	      html = document.getElementsByTagName('html')[0],
	      body = document.getElementsByTagName('body')[0],
	      propertys = {
	        'webkitTransformStyle':'-webkit-transform-style',
	        'MozTransformStyle':'-moz-transform-style',
	        'msTransformStyle':'-ms-transform-style',
	        'transformStyle':'transform-style'
	      };
	
	    body.insertBefore(element, null);
	
	    for (var i in propertys) {
	        if (element.style[i] !== undefined) {
	            element.style[i] = "preserve-3d";
	        }
	    }
	
	    var st = window.getComputedStyle(element, null),
	        transform = st.getPropertyValue("-webkit-transform-style") ||
	                    st.getPropertyValue("-moz-transform-style") ||
	                    st.getPropertyValue("-ms-transform-style") ||
	                    st.getPropertyValue("transform-style");
	
	    if(transform!=='preserve-3d'){
	      html.className += ' no-preserve-3d';
	    } else {
	    	html.className += ' preserve-3d';
	    }
	    document.body.removeChild(element);
	
	})();
	
	//detect if hero <img> has been loaded and evaluate its aspect-ratio
	$j('.cd-floating-background').find('img.parallax').load(function() {
		aspectRatio = $j(this).width()/$j(this).height();
		var z = parseInt($j(this).attr('data-z'));
			$j(this).css({
				'transform': 'translateY(0) translateZ(' + z + 'px) rotateX(0)'
			});
  		if( $j('html').hasClass('preserve-3d') ) { 
	  			initBackground()
	  		};
	}).each(function() {
		//check if image was previously load - if yes, trigger load event
  		if(this.complete) $j(this).load();
	});

}