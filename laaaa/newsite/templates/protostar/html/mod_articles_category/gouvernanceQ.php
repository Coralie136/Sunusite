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

<div id="" class="k2ItemsBlock">
	<ul>
	<?php foreach ($list as $item) :  ?>
		<li class="even firstItem">
			<div class="moduleItemIntrotext">
				<h3>
					<a href="<?php echo $item->link; ?>" class="moduleItemTitle"><?php echo $item->title; ?></a>
				</h3>
				<p><?php echo $item->introtext; ?></p>
				<a class="moduleItemReadMore" href="<?php echo $item->link; ?>"><?php echo JText::_('COM_CONTENT_READ_MORE_TITLE'); ?></a>
			</div>
			<div class="clr"></div>
		</li>
						<!--a href="<?php echo $item->link; ?>" itemprop="url"-->

						<!--/a-->

	<?php endforeach; ?>
	</ul>
</div>
