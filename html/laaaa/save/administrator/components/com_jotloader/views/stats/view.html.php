<?php
/*
* @version $Id: view.html.php,v 1.6 2008/12/07 16:56:51 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
class StatsViewStats extends JView {
function display($tpl = null){
global $mainframe, $option;
$filter_order = $mainframe->getUserStateFromRequest($option . 'filter_order', 'filter_order', 'f.ordering', 'cmd');
$filter_catid		= $mainframe->getUserStateFromRequest( $option.'filter_catid',		'cat_id',-1,'int' );
$search = $mainframe->getUserStateFromRequest($option . 'search', 'search', '', 'string');
$search = JString::strtolower($search);
$rows = &$this->get('Data');
$total = &$this->get('Total');
$pagination = &$this->get('Pagination');
$javascript = 'onchange="document.adminForm.submit();"';
$lists['catid'] = $this->categories;
$lists['order'] = $filter_order;
$lists['search'] = $search;
if ($search){
$lists['reset'] = "<button onclick=\"document.getElementById('search').value='';this.form.submit();\">" . JText::_('Reset') . "</button>";
}else{
$lists['reset'] = "";
}$this->assignRef('lists', $lists);
$this->assignRef('rows', $rows);
$this->assignRef('pagination', $pagination);
$this->assignRef('cat_id', $filter_catid);
parent::display($tpl);
}function show($tpl = null){
$rows = &$this->get('Data');
$total = &$this->get('Total');
$pagination = &$this->get('Pagination');
$this->assignRef('rows', $rows);
$this->assignRef('pagination', $pagination);
parent::display($tpl);
}}