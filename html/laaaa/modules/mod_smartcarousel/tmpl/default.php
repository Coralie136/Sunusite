<?php
/*------------------------------------------------------------------------
# mod_smartcarousel.php(module)
# ------------------------------------------------------------------------
# version		1.0.0
# author    	Implantes en tu ciudad
# copyright 	Copyright (c) 2011 Top Position All rights reserved.
# @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website		http://mastermarketingdigital.org/open-source-joomla-extensions
-------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die;

?>

	<div id="" class="k2ItemsBlock img-left">
		<ul>
	        <li class="even lastItem">
	            <div class="moduleItemIntrotext">
	            <?php $images = json_decode($item[0]->images); ?>
	            <?php  if (isset($images->image_intro) and !empty($images->image_intro)) : ?>
		    		<div class="catItemImageBlock">
		    			<?php $imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro; ?>
						<span class="catItemImage">
				      		<!--a class="moduleItemImage" href="<?php echo $item[0]->link;?>" title="<?php echo htmlspecialchars($images->image_intro_alt); ?>"-->
				      			<img width="460" 
				      				<?php if ($images->image_intro_caption):
										echo 'class="caption"'.' title="' .htmlspecialchars($images->image_intro_caption) .'"';
									endif; ?>
									src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"/><!--/a-->
			      		</span>
		    		</div>
		    	<?php endif; ?>
		    	
		    	<?php if ($params->get('item_title')) : ?>
		      		<h3>
		      		<?php if ($params->get('link_titles') && $item[0]->link != '') : ?>
		      			<a class="moduleItemTitle" href="<?php echo $item[0]->link;?>">
		      				<?php echo $item[0]->title; ?>
		      			</a>
		      		<?php else : ?>
						<?php echo $item[0]->title; ?>
					<?php endif; ?>
		      		</h3>
				<?php endif; ?>
	      	      	<?php echo $item[0]->introtext; ?>
	      		</div>
	      		<div class="clr"></div>
	    	</li>
		</ul>
	</div>
