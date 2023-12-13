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

// no direct access
defined('_JEXEC') or die;
$document = JFactory::getDocument();
require(JModuleHelper::getLayoutPath('mod_smartcarousel', $params->get('layout', 'default')));
*/
?>

<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_smartcarousel
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$item = modhdArticleHelper::getTheArticle($params);

require JModuleHelper::getLayoutPath('mod_smartcarousel', $params->get('layout', 'default'));
