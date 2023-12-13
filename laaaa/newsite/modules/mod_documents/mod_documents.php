<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_documents
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the documents functions only once
require_once __DIR__ . '/helper.php';

$list = ModDocumentsHelper::getList($params);

if (!count($list))
{
	return;
}

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_documents', $params->get('layout', 'default'));
