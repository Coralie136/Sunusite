<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_flexslider
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<div class="flex-nav-container">
	<div id="flexslider-<?php echo $module->id; ?>" class="flexslider">
		<ul class="slides">
		<?php
	  		foreach($list as $item){
	  			if (isset($item->image) && $item->image !='') {?>
	  			<li class="slide" data-thumb="">
	  				<?php if ($params->get('title_link', 1) == 1) {?>
	  				<a target="<?php echo $params->get('target');?>" href="<?php echo $item->link;?>" title="<?php echo $item->image_alt;?>">
	  				<?php }?>
	  					<img src="<?php echo $item->image;?>" alt="<?php echo $item->image_alt;?>"/>
	  				<?php if ($params->get('title_link', 1) == 1) {?>
	  				</a>
	  				<?php }?>
	  				
	  				<?php if ($params->get('caption', 1) == 1) { ?>
	  				<div class="flex-caption">
	  					<div class="flexCaptionInner">
	  						<h3><?php echo $item->image_caption;?></h3>
	  						<div class="clr"></div>
	  						<div class="clr"></div>
	  					</div>
	  				</div>
	  				<?php }?>
	  			</li>
	  			
	  			<?php 
	  			}
	  		}
	  	?> 
		</ul>
	  
	  <?php if ( $slide_theme == 'true' ) : ?>
	  <span class="slide-theme">
	  	<span class="slide-theme-side slide-top-left"></span>
	  	<span class="slide-theme-side slide-top-right"></span>
	  	<span class="slide-theme-side slide-bottom-left"></span>
	  	<span class="slide-theme-side slide-bottom-right"></span>
	  </span>
	  <?php endif; ?>
	  
	</div>
	
	<script type="text/javascript">
	  jQuery(window).load(function() {
	    jQuery('#flexslider-<?php echo $module->id; ?>').flexslider({
	        animation: "<?php echo $transition; ?>",
	        easing:"linear",								// I disable this option because there was a bug with Jquery easing and Joomla 3.2.3
	 		direction: "<?php echo $direction; ?>",        //String: Select the sliding direction, "horizontal" or "vertical"
			slideshowSpeed: <?php echo $pauseTime; ?>, 			// How long each slide will show
			animationSpeed: <?php echo $animSpeed; ?>, 			// Slide transition speed
	    	directionNav: <?php if ($directionNav == 'false') { echo "false" ;} else { echo "true" ;} ?>,             
	    	controlNav: <?php echo $controlNav ; ?>,    
	    	pauseOnHover: <?php echo $pauseOnHover; ?>,
	    	initDelay: <?php echo $initDelay; ?>,
	    	randomize: <?php echo $randomize; ?>,
	    	smoothHeight: false,
	    	touch: false,
	    	keyboardNav: true
	    	
	    });
	  });
	</script>
</div>