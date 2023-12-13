/**
 * @package		Mb2 Content
 * @version		1.3.1
 * @author		Mariusz Boloz (http://marbol2.com)
 * @copyright	Copyright (C) 2013 Mariusz Boloz (http://marbol2.com). All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
**/







(function($){$(window).load(function(){	

	/*-----------------------------------------------------------------------------------*/
	/*	Carousel
	/*-----------------------------------------------------------------------------------*/
	$('.mb2-content-carousel').each(function(){		
		
		
		var $carouselobj = $(this);
		var maxItems = $carouselobj.data('itemmax');
		var scrollItems = $carouselobj.data('scroll');
		var pauseTime = $carouselobj.data('duration');
		var touch = $carouselobj.data('touch');
		var is_play = $carouselobj.data('play');
		var id = $carouselobj.data('id');
		var item_margin_lr = $carouselobj.data('margin');
		
		
		// Add touch param
		if(touch == 1){
			var is_touch = true
			var is_mouse = true
		}
		else{
			var is_touch = false
			var is_mouse = false
		}
		
		
		// Add autoplay param
		if (is_play == 1)
		{
			is_newplay = true
		}
		else
		{
			is_newplay = false	
		}
		
			
		
		$(this).carouFredSel({
			responsive:true,
			auto:{
				play: is_newplay,
				timeoutDuration: pauseTime
			},
			scroll:scrollItems,
			prev: '#mb2-content-prev-'+id,
			next: '#mb2-content-next-'+id,
			pagination: '#mb2-content-pager-'+id,
			items:{width:300,height:'auto',visible:{min:1,max:maxItems}},
			swipe: {
	        	onTouch: is_touch,
	        	onMouse: is_mouse
	    	}		
		});	
		
		
		
		
	});
	
	
	
	



})})(jQuery);//end










jQuery(document).ready(function($){
	
	
	
	
	
	
	//nivo lightbox init
	$('.mb2-content-nivo-link').nivoLightbox();
	
	
	
	
	
	
	//image hover effect
	$('.mb2-content div.content-img').hover(function(){		
		$(this).children('.mark').css('opacity', 0);
		$(this).children('.mark').stop().fadeTo(250, 1);
	},
	function(){
		$(this).children('.mark').stop().fadeTo(250, 0);		
	});
	
	
	
	
	
	
	
	
});