<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<div id="" class="k2ItemsBlock post">
<ul>
	<?php if ($grouped) : ?>

	<?php else : ?>
		<?php foreach ($list as $item) : ?>

			<li class="even lastItem firstItem">
				<div class="moduleItemIntrotext">
				 
					<?php if ($item->displayDate) : ?>
					<span class="moduleItemDateCreated">
						<?php echo $item->displayDate; ?>
					</span>
					<?php endif; ?>
				
					<h3>
					<?php if ($params->get('link_titles') == 1) : ?>
						<a class="moduleItemTitle <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
							<?php echo $item->title; ?>
						</a>
					<?php else : ?>
						<?php echo $item->title; ?>
					<?php endif; ?>
					</h3>
	
				<?php if ($item->displayHits) : ?>
					<span class="mod-articles-category-hits">
						(<?php echo $item->displayHits; ?>)
					</span>
				<?php endif; ?>
	
				<?php if ($params->get('show_author')) : ?>
					<span class="mod-articles-category-writtenby">
						<?php echo $item->displayAuthorName; ?>
					</span>
				<?php endif;?>
	
				<?php if ($item->displayCategoryTitle) : ?>
					<span class="mod-articles-category-category">
						(<?php echo $item->displayCategoryTitle; ?>)
					</span>
				<?php endif; ?>
	
				<?php if ($params->get('show_introtext')) : ?>
					<p class="mod-articles-category-introtext">
						<?php echo $item->displayIntrotext; ?>
					</p>
				<?php endif; ?>
	
				<?php if ($params->get('show_readmore')) : ?>
					
						<a class="moduleItemReadMore <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
							<?php if ($item->params->get('access-view') == false) : ?>
								<?php echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
							<?php elseif ($readmore = $item->alternative_readmore) : ?>
								<?php echo $readmore; ?>
								<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
							<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
								<?php echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
							<?php else : ?>
								<?php echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
								<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
							<?php endif; ?>
						</a>
					
				<?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>
</div>