<?php
/*
* @version $Id: jotloader.php,v 1.6 2008/12/13 14:42:28 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helper.php');
$helper = new JotloaderHelper();
if ($helper->config['advanced.on'] and $helper->config['files.autopublish'] and intval($helper->config['scan.frontend'])) {
$stamp = $helper->config['scan.frontend'];
list($delay,$last) = split("_",$stamp,2);
$curtime = time();
if ($curtime>$last) {
$helper->cron();
$helper->next_time(intval($delay),$curtime);
}}$task = JRequest::getWord('task','display');
$controller = JRequest::getWord('section', 'files');
require_once(JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
$classname = $controller.'Controller';
$controller = new $classname(&$helper->config);
$controller->execute($task);
$controller->redirect();
?>