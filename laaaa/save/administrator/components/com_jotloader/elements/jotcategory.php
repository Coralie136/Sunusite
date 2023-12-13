<?php
/*
* @version $Id: jotcategory.php,v 1.1 2008/12/13 14:44:20 Vlado Exp $
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
defined('_JEXEC') or die();
class JElementJotcategory extends JElement
{var   $_name = 'Jotcategory';
function fetchElement($name, $value, &$node, $control_name){
$db = &JFactory::getDBO();
$query = "SELECT cat_id as catid,CONCAT(cat_id, '_', mark) as cid,cat_title as title, mark"
." FROM #__jotloader_cats ORDER BY cat_title";
$db->setQuery($query);
$options = $db->loadObjectList();
$update = 0;
foreach ($options as $option) {
if(!is_string($option->cid) or $option->mark==""){
$query2 = "UPDATE #__jotloader_cats SET mark=MD5(now())"
." WHERE cat_id = '" . (int)$option->catid . "'";
$db->setQuery($query2);
if (!$db->query()) {
echo '<script> alert("'.$msg.'"); window.history.go(-1); </script>\n';
exit();
}$update = 1;
}}if ($update) {
$db->setQuery($query);
$options = $db->loadObjectList();
}array_unshift($options, JHTML::_('select.option', '0_'.MD5(gettimeofday(true)), '- '.JText::_('All categories').' -', 'cid', 'title'));
return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'cid', 'title', $value, $control_name.$name );
}}?>