<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_superfish_menu
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
//require_once __DIR__ . '/helper.php';
require_once JPATH_SITE.'/modules/mod_menu/helper.php'; 

$list			= ModMenuHelper::getList($params);
$base			= ModMenuHelper::getBase($params);
$active			= ModMenuHelper::getActive($params);
$active_id 		= $active->id;
$path			= $base->tree;

$showAll		= $params->get('showAllChildren');
$class_sfx		= htmlspecialchars($params->get('class_sfx'));


$ext_style_menu	= $params->get('stylemenu');
$ext_menu		= (int)$params->get('ext_menu');
$ext_load_jquery= (int)$params->get('ext_load_jquery', 1);
$ext_jquery_ver	= $params->get('ext_jquery_ver', '1.9.1');
$ext_load_base	= (int)$params->get('ext_load_base', 1);
$animation		= $params->get('animation');
$delay			= $params->get('delay');
$speed			= $params->get('speed');
$cssArrows		= $params->get('autoarrows');

$document 		= JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_superfish_menu/assets/css/superfish.css');
$class_style 	= '';
if ($ext_style_menu == 1) {
	$document->addStyleSheet(JURI::base() . 'modules/mod_superfish_menu/assets/css/superfish-vertical.css'); 
	$class_style='sf-vertical'; 
}
if ($ext_style_menu == 2) { 
	$document->addStyleSheet(JURI::base() . 'modules/mod_superfish_menu/assets/css/superfish-navbar.css');
	$class_style='sf-navbar';
}	

	
if ($ext_menu == 1) 
{
$ext_script = <<<SCRIPT


var jQ = false;
function initJQ() {
	if (typeof(jQuery) == 'undefined') {
		if (!jQ) {
			jQ = true;
			document.write('<scr' + 'ipt type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/$ext_jquery_ver/jquery.min.js"></scr' + 'ipt>');
		}
		setTimeout('initJQ()', 50);
	}
}
initJQ(); 


SCRIPT;

if ($ext_load_jquery  > 0) {
	$document->addScriptDeclaration($ext_script);		
}
	if ($ext_load_base > 0) {
		$document->addCustomTag('<script type = "text/javascript" src = "'.JURI::root().'modules/mod_superfish_menu/assets/js/hoverIntent.js"></script>');	
		$document->addCustomTag('<script type = "text/javascript" src = "'.JURI::root().'modules/mod_superfish_menu/assets/js/superfish.js"></script>');
		$document->addCustomTag('<script type = "text/javascript">if (jQuery) jQuery.noConflict();</script>');
	}
}


if(count($list)) {
	require JModuleHelper::getLayoutPath('mod_superfish_menu', $params->get('layout', 'default'));
	echo JText::_(COP_JOOMLA);
}
