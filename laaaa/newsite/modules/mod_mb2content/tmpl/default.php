<?php
/**
 * @package		Mb2 Content
 * @version		1.3.1
 * @author		Mariusz Boloz (http://marbol2.com)
 * @copyright	Copyright (C) 2013 Mariusz Boloz (http://marbol2.com). All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
**/



// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_SITE . '/modules/mod_mb2content/helpers');

if(count($list)>0)
{
?>
<div class="carousel">
<div id="list_carousel_carousel" class="list_carousel">
	<?php echo modMb2contentHelper::carousel_nav($list, $params, array('uniqid'=>$uniqid)); ?>
	<ul id="caroufredsel_carousel">
		<?php 
		$i=0;
		foreach($list as $item)
		{			
		$i++;
        ?>
        <li class="even">
            	<?php
				if ((isset($item->image)&& $item->image !='') && $params->get('item_layout', 'media-above') !='only-desc' )
				{
					require JModuleHelper::getLayoutPath('mod_mb2content', 'item_media');
				}
				if ($params->get('item_layout', 'media-above') !='only-image')
				{
					require JModuleHelper::getLayoutPath('mod_mb2content', 'item_details');	
				}													
				?>            
			</li>       
        <?php		
		if($params->get('cols', 4) == $i && !$carousel){		
			echo '<div class="mb2-content-item-separator clearfix"></div>';	
			$i=0;	
		}		
	}//endforech 
	?>
	</ul>
</div>

<div id="carousel__prev" class="caroufredsel_prev"><span>&lt;</span></div>
<div id="carousel__next" class="caroufredsel_next"><span>&gt;</span></div>
<div id="carousel_carousel_pag" class="caroufredsel_pagination"></div>

<script type="text/javascript">
  jQuery(window).load(function() {
    var carouselConteiner = jQuery("#caroufredsel_carousel");
    carouselConteiner.carouFredSel({
      responsive  : true,
      width: '100%',
      items   : {
        width : 300,
        height: 'variable',
        visible   : {
          min     : 1,
          max     : 5        },
        minimum: 1
      },
      scroll: {
        items: 1,
        fx: "scroll",
        easing: "swing",
        duration: 500,
        queue: true
      },
      auto: false,
      next: "#carousel__next",
      prev: "#carousel__prev",
      swipe:{
        onTouch: true
      }
    });
  });
</script>
</div>
<?php
}