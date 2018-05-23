/* Scripts
==============================================================
@name scripts.js
@author Christophe Drayton Zlobinski-Furmaniak (christophe.zf@gmail.com or @t1wk)
@version 0.1 - Prototype version
@date 12/20/2017
@category Animation scripts
==============================================================
*/

// jQuery No Conflit mode
var $j = jQuery.noConflict();

//=============================================================
//	Scope Functions
//=============================================================//

	var forEach = Array.prototype.forEach;
	
	function multiplyNode(node, count, deep) {
		for (var i = 0, copy; i < count - 1; i++) {
			copy = node.cloneNode(deep);
			node.parentNode.insertBefore(copy, node);
		}
	}
	
	function randomNumber(min, max){
			return Math.floor(Math.random() * (1 + max - min) + min);
		}

	function rangeToPercent(number, min, max){
		return ((number - min) / (max - min));
	}
	
	
	// http://upshots.org/javascript/jquery-mootools-wrapped-text-to-lines
	$j.fn.linify = function(tag){  // type of element to serve as 'rows'
		tag = tag || 'div';  // element type defaults to div
		var text = this.text();  // get the original text
		this.html('&nbsp;');  // add a space to measure line height
		var height = this.height();  // save line height
		this.text('');  // zero it out
		var words = text.split(/\s+/g);  // break it into words
		var row = $j('<' + tag + '>');  // create the initial 'row'
		this.append(row);  // append it
		while(words.length) {
			var word = words.shift();  // get the next word
			var saved = row.text(); // save the text in case we need to replace it
			row.append(' ' + word);  // add it to the row
			var h = this.height();  // get the new height
			if(h > height) {  // if the new height is greater than the last saved height
				row.text(saved);  // replace the last saved text
				row = $j('<' + tag + '>');  // create a new row and reset the reference
				this.append(row);  // add it to the dom
				row.append(word);  // write the word to it, omitting the space
				height = this.height();  // update the last saved height
			};
		};
	};
	
	
	function load(target, url) {
	  var r = new XMLHttpRequest();
	  r.open("GET", url, true);
	  r.onreadystatechange = function () {
		if (r.readyState != 4 || r.status != 200) return;
		target.innerHTML = r.responseText;
	  };
	  r.send();
	}
	//load(document.getElementById('anyDiv'), 'anyPage.htm');
	
	// Returns a function, that, as long as it continues to be invoked, will not
	// be triggered. The function will be called after it stops being called for
	// N milliseconds. If `immediate` is passed, trigger the function on the
	// leading edge, instead of the trailing.
	function debounce(func, wait, immediate) {
		var timeout;
		return function() {
			var context = this, args = arguments;
			var later = function() {
				timeout = null;
				if (!immediate) func.apply(context, args);
			};
			var callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if (callNow) func.apply(context, args);
		};
	};
	
	// Determine if an element is in the visible viewport
	$j.fn.isOnScreen = function(){
	    
	    var win = $j(window);
	    
	    var viewport = {
	        top : win.scrollTop(),
	        left : win.scrollLeft()
	    };
	    viewport.right = viewport.left + win.width();
	    viewport.bottom = viewport.top + win.height();
	    
	    var bounds = this.offset();
	    bounds.right = bounds.left + this.outerWidth();
	    bounds.bottom = bounds.top + this.outerHeight();
	    
	    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
	    
	};
	
	// Wait for an CSS Transition to finish
	wte = 'transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd';
	/* $j(".yourclass").on(wte, function() {
        // Do Something
    }); */
 
//=============================================================
//	Cancel AnimationFrame
//	Based on: http://notes.jetienne.com/2011/05/18/cancelRequestAnimFrame-for-paul-irish-requestAnimFrame.html
//=============================================================//
	window.requestAnimFrame = (function(){
		return  window.requestAnimationFrame       || 
			window.webkitRequestAnimationFrame || 
			window.mozRequestAnimationFrame    || 
			window.oRequestAnimationFrame      || 
			window.msRequestAnimationFrame     || 
			function(/* function */ callback, /* DOMElement */ element){
				return window.setTimeout(callback, 1000 / 60);
			};
	})();
	
	window.cancelRequestAnimFrame = ( function() {
		return window.cancelAnimationFrame          ||
			window.webkitCancelRequestAnimationFrame    ||
			window.mozCancelRequestAnimationFrame       ||
			window.oCancelRequestAnimationFrame     ||
			window.msCancelRequestAnimationFrame        ||
			clearTimeout
	} )();
	
	// to store the request
	var request;
	
	// Localization of the theme directory for Ajax requests
	//var templateUrl = theme_dir.templateUrl;
	
	
//=============================================================
//	Variables
//=============================================================//

	var page = document.URL,
		body = document.body,
		html = document.documentElement;
	
	var header, footer;
	
	// Definition - Global
	var header = $j("header"),
		footer = $j("footer"),
		sections = $j("section"),
		pos = [];
	
	// Determine what is the current url
	// and what is the size of the window
	var arrUrl = page.split("/");
	//var CurrentUrl = arrUrl[arrUrl.length-1],
		hdr = window.innerHeight;
		
	var CurrentUrl = arrUrl[arrUrl.length - 2],
		hdr = window.innerHeight;
	
	// Definition of Current Url if empty
	if(CurrentUrl == "" || CurrentUrl == "parkii" || CurrentUrl == "www.parkiishop.com"){
		CurrentUrl = 'index';
	}	
	
//=============================================================
//	Function randomize order
//=============================================================//
	var uniqueRandoms = [];
	var numRandoms;
	
	function makeUniqueRandom(numRandoms) {
	    // refill the array if needed
	    if (!uniqueRandoms.length) {
	        for (var i = 0; i < numRandoms; i++) {
	            uniqueRandoms.push(i);
	        }
	    }
	    var index = Math.floor(Math.random() * uniqueRandoms.length);
	    var val = uniqueRandoms[index];
	
	    // now remove that value from the array
	    uniqueRandoms.splice(index, 1);
	
	    return val;
	
	}
	
	function randomOrder(){
		var members = $j("section.members li"),
		numRandoms = members.length;
		
		$j(members).each(function (i, value) {
			$j(this).css('order', parseInt(makeUniqueRandom(numRandoms) + 1));
		});
		
	}
	randomOrder();

//=============================================================
//	Animations
//=============================================================//		
	
		
//=============================================================
//	When the document is ready
//=============================================================//
 document.addEventListener("DOMContentLoaded", function(event) { 	

	// Give the active page the right menu
	$j(function() {
	  $j('nav a[href^="' + CurrentUrl + '"]').parent().addClass('current');
	  $j('#footer a[href^="' + CurrentUrl + '"]').parent().addClass('current');
	});	
	
		
	// Scroll actions
	var scrollFn = debounce(function() {
		var scrollTop = $j(window).scrollTop();
		
		// For every section
		$j(sections).each(function (i, value) {
			
			// Add an active class to each active sections
			if ( $j(this).isOnScreen() ) {
				$j('section.active').removeClass('active');
				$j(sections[i]).addClass('active').trigger('classChange');
			}			
		});
		
	}, 150);
	
	$j(window).on('scroll', scrollFn);
		
}, false);