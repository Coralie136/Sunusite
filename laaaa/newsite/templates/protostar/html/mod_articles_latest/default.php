<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<!--ul class="latestnews<?php echo $moduleclass_sfx; ?>">
<?php foreach ($list as $item) :  ?>
	<li itemscope itemtype="http://schema.org/Article">
		<a href="<?php echo $item->link; ?>" itemprop="url">
			<span itemprop="name">
				<?php echo $item->title; ?>
			</span>
		</a>
	</li>
<?php endforeach; ?>
</ul-->

<div id="" class="k2ItemsBlock post img-left">
	<ul>
		<?php foreach ($list as $item) : ?>

			<li class="even lastItem firstItem">
				<div class="moduleItemIntrotext">
				
					<h3>
						<a class="moduleItemTitle <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
							<?php echo $item->title; ?>
						</a>
					</h3>
	
					<?php $images = json_decode($item->images); ?>
					<div class="catItemImageBlock">
						<?php if (isset($images->image_intro) && !empty($images->image_intro)) : ?>
							<?php $imgfloat = (empty($images->float_intro)) ? $item->params->get('float_intro') : $images->float_intro; ?>
							<span class="catItemImage"> <img width="150"
							<?php if ($images->image_intro_caption):
								echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_intro_caption) . '"';
							endif; ?>
							src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>" itemprop="thumbnailUrl"/> 
							<?php echo $item->introtext; ?></span>
						<?php endif; ?>
						<div class="clr"></div>
					</div>

					<p class="mod-articles-category-introtext">
						<?php //echo $item->introtext; ?>
					</p>
	
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
	</ul>
</div>