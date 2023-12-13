<?php 
/**
 * @package		Mb2 Content
 * @version		1.3.1
 * @author		Mariusz Boloz (http://marbol2.com)
 * @copyright	Copyright (C) 2013 Mariusz Boloz (http://marbol2.com). All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
**/



// no direct access
defined('_JEXEC') or die();
require_once __DIR__ . '/helper.php';


// Get articles
$list = modMb2contentHelper::getList($params);


$uniqid = uniqid();
$carousel = modMb2contentHelper::items_carousel($list, $params);
$is_k2 = ($params->get('source', '') == 'k2' && (file_exists(JPATH_SITE . '/components/com_k2/k2.php') && JComponentHelper::isEnabled('com_k2', true)));


// Get style s and scripts
modMb2contentHelper::before_head($params, array('mod_id'=>$module->id, 'carousel'=>$carousel));


// Check if items are display within carousel
$carousel_cls = modMb2contentHelper::carousel_cls($list, $params, array('mode'=>'module', 'pos'=>' mb2-content-carousel', 'neg'=>''));
$mod_carousel_cls = modMb2contentHelper::carousel_cls($list, $params, array('mode'=>'module', 'pos'=>' is-carousel', 'neg'=>' no-carousel'));
$carousel_data = modMb2contentHelper::carousel_data($list, $params, array('uniqid'=>$uniqid));


// Gt module layout
require JModuleHelper::getLayoutPath('mod_mb2content', $params->get('layout', 'default'));