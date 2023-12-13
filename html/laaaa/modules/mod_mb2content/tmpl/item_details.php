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
	
?>
	<div class="moduleItemIntrotext">
                
		<?php 
			if($params->get('title', 1) == 1){
				$pieces = explode(" ", $item->title);
				$dernier = array_pop($pieces);
				$reste = implode(" ", $pieces);
				
				if($params->get('title_link', 1) == 1){?>						
					<h3 class="moduleItemTitle">
                        <a href="<?php echo $item->link; ?>">
                            <?php echo JHtml::_('item.word_limit', $item->title, $params->get('title_limit', 999), '...'); ?>
                        </a>
                    </h3>
				<?php 
				}
				else{?>                        
					<h3 class="moduleItemTitle">
						<?php //echo JHtml::_('item.word_limit', $item->title, $params->get('title_limit', 999), '...'); ?>
						<?php echo $reste;?>
						<span><?php echo $dernier;?></span>
                    </h3>
				<?php						
				}				
			}
			
			if($params->get('meta_category', 1) == 1 || $params->get('meta_date', 1) == 1){?>
				<div class="mb2-content-item-meta clearfix">
                	<ul>
                    	<?php
						if($params->get('meta_date', 1) == 1){?>
							<li class="mb2-content-item-meta-date">
                                <i class="mb2content-fa mb2content-fa-calendar"></i> <?php echo JText::sprintf(JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_' . $params->get('meta_date_format', 'LC3')))); ?>
                            </li>							
						<?php
						}
						if($params->get('meta_category', 1) == 1){?>                        
                        	<li class="mb2-content-item-meta-category">
                            <?php 
							if($params->get('meta_category_link', 1) == 1)
							{?>
                            	<a href="<?php echo $item->categoryLink; ?>">
                                	<i class="mb2content-fa mb2content-fa-folder-open"></i> <?php echo $item->categoryname; ?>
                                </a>	
                             <?php
							}
							else
							{ ?>
								<i class="mb2content-fa mb2content-fa-folder-open"></i> <?php echo $item->categoryname; ?>
                            <?php }	?>                                
                            </li>
                        <?php
                        }						
						?>
                    </ul>
                </div><!-- end .mb2-content-item-meta -->					
			<?php
            }	
				
			
			if($params->get('introtext', 1) == 1){?>
				<p>
					<!--?php echo JHtml::_('item.word_limit', $item->introtext, $params->get('introtext_limit', 999), '...'); ?-->
					<?php echo $item->introtext; ?>
				</p>
                <?php	
			}
		?>		
	</div>
	<div class="clr"></div>
	<div class="clr"></div>	
		<?php 			
			if($params->get('readmore', 1) == 1){ ?>
				<a class="moduleItemReadMore" href="<?php echo $item->link; ?>"><?php echo $params->get('readmore_text', 'Read More'); ?> <i class="mb2content-fa mb2content-fa-angle-double-right"></i></a>
			<?php
			}			
		?>
	<div class="clr"></div>
