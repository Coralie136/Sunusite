<?php
/*
* @version $Id: admin.jotloader.php,v 1.19 2008/12/08 13:51:02 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helper.php');
$helper = new JotloaderHelper();
$helper->cron();
$task = JRequest::getCmd('task');
if ($task == "cpanel"){
$controller = 'panel';
}else{
$controller = JRequest::getVar('section', 'panel');
}require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.$controller.'.php');
$classname = $controller.'Controller';
$controller = new $classname(&$helper->config);
$controller->execute(JRequest::getVar('task'));
$controller->redirect();
?>