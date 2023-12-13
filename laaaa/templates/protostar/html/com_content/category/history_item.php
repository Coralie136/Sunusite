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


<div class="catItemView groupPrimary history">
	<?php if ($params->get('show_title')) : ?>
	<div class="catItemHeader">
		<h3 class="catItemTitle">
			<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
				<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>" itemprop="url">
				<?php echo $this->escape($this->item->title); ?></a>
			<?php else : ?>
				<?php echo $this->escape($this->item->title); ?>
			<?php endif; ?>
		</h3>
	</div>
	<?php endif; ?>
	<div class="catItemBody">
		<div class="catItemIntroText">
			<?php echo $this->item->introtext; ?>
			
			<?php if ($params->get('show_readmore') && $this->item->readmore) :
				if ($params->get('access-view')) :
					$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
				else :
					$menu = JFactory::getApplication()->getMenu();
					$active = $menu->getActive();
					$itemId = $active->id;
					$link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
					$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
					$link = new JUri($link1);
					$link->setVar('return', base64_encode($returnURL));
				endif; ?>
			
				<div class="catItemReadMore">
					<a class="k2ReadMore" href="<?php echo $link; ?>" itemprop="url">
						<span class="icon-chevron-right"></span>
						<?php if (!$params->get('access-view')) :
							echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
						elseif ($readmore = $item->alternative_readmore) :
							echo $readmore;
							if ($params->get('show_readmore_title', 0) != 0) :
								echo JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit'));
							endif;
						elseif ($params->get('show_readmore_title', 0) == 0) :
							echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
						else :
							echo JText::_('COM_CONTENT_READ_MORE');
							echo JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit'));
						endif; ?>
					</a>
				</div>
				<?php //echo JLayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>
			<?php endif; ?>
		</div>
		<div class="clr"></div>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>
	<div class="clr"></div>
</div>
