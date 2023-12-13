<?php
/*
* @version $Id: view.html.php,v 1.12 2008/12/07 16:56:50 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');
class FilesViewFiles extends JView{
function display($tpl = null){
global $mainframe, $option;
$session	=& JFactory::getSession();
$registry	=& $session->get('registry');
$search = $mainframe->getUserStateFromRequest($option . 'search', 'search', '', 'string');
$search = JString::strtolower($search);
$model = &$this->getModel();
$rows = &$this->get('Data');
$total = &$this->get('Total');
$pagination = &$this->get('Pagination');
$javascript = 'onchange="document.adminForm.submit();"';
$lists['catid'] = $this->categories;
$lists['search'] = $search;
if ($search){
$lists['reset'] ="<button onclick=\"document.getElementById('search').value='';this.form.submit();\">".JText::_( 'Reset' )."</button>";
} else {
$lists['reset'] ="";
}$lists['order_Dir']	= $model->file_order_Dir;
$lists['order']		= $model->file_order;
$this->assignRef('lists', $lists);
$this->assignRef('rows', $rows);
$this->assignRef('pagination', $pagination);
$this->assignRef('cat_id', $model->filter_catid);
parent::display($tpl);
}function show($tpl = null){
$row = &$this->get('Item');
$this->utility->setFileContext($row);
$this->utility->getDirObj();
$lists['download_dir'] = $this->utility->_dir_string;
$lists['catid'] = $this->categories;
$this->assignRef('row', $row);
$this->assignRef('lists', $lists);
parent::display($tpl);
}function showMove($cid,$tpl = null) {
$rows = &$this->get('Moved');
$lists['catid'] = $this->categories;
$lists['cid'] = $cid;
$this->assignRef('rows', $rows);
$this->assignRef('lists', $lists);
parent::display($tpl);
}}