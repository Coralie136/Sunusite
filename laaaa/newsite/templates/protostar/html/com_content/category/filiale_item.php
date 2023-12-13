<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Create a shortcut for params.
$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);
?>


	<div class="catItemView groupLeading filiales">
		<div class="catItemBody">
			<?php $images = json_decode($this->item->images); ?>
			<div class="catItemImageBlock">
				<?php if (isset($images->image_intro) && !empty($images->image_intro)) : ?>
					<?php $imgfloat = (empty($images->float_intro)) ? $this->item->params->get('float_intro') : $images->float_intro; ?>
					<span class="catItemImage"> 
						<a href=<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));?>" class="link"><img width="140" border="0"
							<?php if ($images->image_intro_caption):
								echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_intro_caption) . '"';
							endif; ?>
							src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>" itemprop="thumbnailUrl"/></a> 
					</span>
				<?php endif; ?>
				<div class="clr"></div>
				<p class="text" align="center"><a href=<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));?>" class="link">
					<?php echo $this->item->title; ?></a></p>
			</div>
		
			<!--div class="catItemIntroText">
				
				<a href=<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));?>" class="link">
					<?php echo $this->item->title; ?></a>

				
			</div-->
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
	</div>

