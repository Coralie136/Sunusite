<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_flexslider
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::base() . 'templates/protostar/css/flexslider.css');

$doc->addScript(JURI::base() . 'templates/protostar/js/jquery.flexslider-min.js');

// Get articles
$list = ModFlexsliderHelper::getList($params);

// Get basic parameters
$transition					= $params->get('transition');
$direction					= $params->get('direction');

$animSpeed					= intval($params->get('animSpeed'));
$pauseTime					= intval($params->get('pauseTime'));

$controlNav					= $params->get('controlNav');
$positionNav				= $params->get('positionNav');
$colorNav					= $params->get('colorNav');
$colorNavActive				= $params->get('colorNavActive');

$directionNav				= $params->get('directionNav');

$pauseOnHover				= $params->get('pauseOnHover');
$initDelay					= $params->get('initDelay');
$randomize					= $params->get('randomize');


require JModuleHelper::getLayoutPath('mod_flexslider', $params->get('layout', 'default'));
