<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_superfish_menu
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$doc = JFactory::getDocument();
$document =& $doc;
$document->addStyleSheet('modules/mod_superfish_menu/css/superfish.css');
$document->addStyleSheet('modules/mod_superfish_menu/css/superfish-navbar.css');
$document->addStyleSheet('modules/mod_superfish_menu/css/superfish-vertical.css');

$document->addScript('modules/mod_superfish_menu/js/superfish.min.js');
$document->addScript('modules/mod_superfish_menu/js/jquery.mobilemenu.js');
$document->addScript('modules/mod_superfish_menu/js/hoverIntent.js');
$document->addScript('modules/mod_superfish_menu/js/supersubs.js');
$document->addScript('modules/mod_superfish_menu/js/sftouchscreen.js');

$list	= modSfMenuHelper::getList($params);
$app	= JFactory::getApplication();
$menu	= $app->getMenu();
$active	= $menu->getActive();
$active_id = isset($active) ? $active->id : $menu->getDefault()->id;
$path	= isset($active) ? $active->tree : array();
$showAll	= $params->get('showAllChildren');
$class_sfx	= htmlspecialchars($params->get('class_sfx'));

if($active){
  $pagetitle = $document->getTitle();
  if(strpos($pagetitle, '||')){
    $pagetitle = explode('||', $pagetitle);
    $pagetitle = $pagetitle[0];
  }
  $document->setTitle($pagetitle);
}

if(count($list)) {
	require JModuleHelper::getLayoutPath('mod_superfish_menu', $params->get('layout', 'default'));
}
