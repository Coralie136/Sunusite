<?php
/*
* @version $Id: uninstall.jotloader.php,v 1.4 2008/12/13 14:42:01 Vlado Exp $
* @package JotLoader
* @copyright (C) 2007-2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Based on doQment 1.0.0beta (www.pimpmyjoomla.com) - fully reworked the front-end
* pages to allow commenting bugs and suggestions for authorized users.
* package doQment 1.0.0beta
* version 1.0.0beta
* copyright (C) 2007 www.pimpmyjoomla.com
* license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
function com_uninstall() {
$lang = &JFactory::getLanguage();
$lang->load('com_jotloader');
echo JText::_('JOTLOADER_BACKEND_UNINSTALL1')."2.0.1 ".JText::_('JOTLOADER_BACKEND_UNINSTALL2');}
$add_languages = array('de-DE','fr-FR');
foreach($add_languages as $add_language){
$add_language_ini = $add_language.'.com_jotloader.ini';
$path1 = '/language/' . $add_language . '/';
unlink(JPATH_SITE .$path1. $add_language_ini);
$path2 = '/administrator/language/' . $add_language . '/';
unlink(JPATH_SITE .$path2. $add_language_ini);
unlink(JPATH_SITE .$path2. $add_language.'.com_jotloader.menu.ini');
}?>