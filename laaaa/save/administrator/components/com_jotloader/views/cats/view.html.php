<?php
/*
* @version $Id: view.html.php,v 1.10 2008/12/07 16:56:50 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');
class CatsViewCats extends JView{
function display($tpl = null){
global $mainframe, $option;
$filter_order = $mainframe->getUserStateFromRequest($option . 'filter_order', 'filter_order', 'ordering', 'cmd');
$search = $mainframe->getUserStateFromRequest($option . 'search', 'search', '', 'string');
$search = JString::strtolower($search);
$rows = &$this->get('Data');
$total = &$this->get('Total');
$pagination = &$this->get('Pagination');
$javascript = 'onchange="document.adminForm.submit();"';
$lists['order'] = $filter_order;
$lists['search'] = $search;
if ($search){
$lists['reset'] = "<button onclick=\"document.getElementById('search').value='';this.form.submit();\">" . JText::_('Reset') . "</button>";
}else{
$lists['reset'] = "";
}$this->assignRef('lists', $lists);
$this->assignRef('rows', $rows);
$this->assignRef('pagination', $pagination);
parent::display($tpl);
}function show($tpl = null){
$row = &$this->get('Item');
$this->assignRef('row', $row);
parent::display($tpl);
}}