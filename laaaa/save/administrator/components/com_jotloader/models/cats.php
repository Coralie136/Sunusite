<?php
/*
* @version $Id: cats.php,v 1.8 2008/12/08 12:25:46 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
class CatsModelCats extends JModel{
var $_data = null;
var $_total = null;
var $_pagination = null;
var $_item = null;
function __construct(){
parent::__construct();
global $mainframe, $option;
$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
$limitstart = $mainframe->getUserStateFromRequest($option . '.limitstart', 'limitstart', 0, 'int');
$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
$this->setState('limit', $limit);
$this->setState('limitstart', $limitstart);
}function getData(){
global $mainframe,$option;
if (empty($this->_data)){
$query = $this->_buildQuery();
$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
$search = $mainframe->getUserStateFromRequest($option . 'search', 'search', '', 'string');
if (count($this->_data) == 0 and strlen($search) > 0){
$this->_data = $this->_getList($query, 0, $this->getState('limit'));
}}return $this->_data;
}function getTotal(){
if (empty($this->_total)){
$query = $this->_buildQuery();
$this->_total = $this->_getListCount($query);
}return $this->_total;
}function getPagination(){
if (empty($this->_pagination)){
jimport('joomla.html.pagination');
$this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit'));
}return $this->_pagination;
}function getItem(){
$query = 'SELECT * FROM #__jotloader_cats WHERE cat_id='
. $this->getState('cat_id');
$rows = $this->_getList($query);
if (count($rows)>0){
$this->_item = $rows[0];
} else {
$empty = &new stdclass;
$empty->cat_id = null;
$empty->cat_title = null;
$empty->ordering = null;
$empty->published = null;
$empty->cat_description = null;
$this->_item = $empty;
}return $this->_item;
}function _buildQuery(){
$where = $this->_buildContentWhere();
$orderby = $this->_buildContentOrderBy();
$query = 'SELECT * FROM #__jotloader_cats '
. $where
. $orderby ;
return $query;
}function _buildContentOrderBy(){
global $mainframe, $option;
$filter_order = $mainframe->getUserStateFromRequest($option . 'filter_order', 'filter_order', 'ordering', 'cmd');
$orderby = ' ORDER BY ordering';
return $orderby;
}function _buildContentWhere(){
global $mainframe, $option;
$db = &JFactory::getDBO();
$filter_order = $mainframe->getUserStateFromRequest($option . 'filter_order', 'filter_order', 'ordering', 'cmd');
$search = $mainframe->getUserStateFromRequest($option . 'search', 'search', '', 'string');
$search = JString::strtolower($search);
$where = array();
if ($search){
$where[] = 'LOWER(cat_title) LIKE ' . $db->Quote('%' . $db->getEscaped($search, true) . '%', false);
}$where = (count($where) ? ' WHERE ' . implode(' AND ', $where) : '');
return $where;
}function saveorder($order, $cid = array()){
$row = &JTable::getInstance('jotloader', 'CatsTable');
for($i = 0; $i < count($cid); $i++){
$row->load((int) $cid[$i]);
if ($row->ordering != $order[$i]){
$row->ordering = $order[$i];
if (!$row->store()){
$this->setError($this->_db->getErrorMsg());
return false;
}}}$row->reorder();
return true;
}function check($id){
$db = &JFactory::getDBO();
$query = 'SELECT mark FROM #__jotloader_cats WHERE cat_id='.$id;
$db->setQuery($query);
$result = $db->loadResult();
if (is_string($result)) {
if ($result=="") return true;
else return false;
}else{
return true;
}}function store($data){
$row = &$this->getTable('JotLoader', 'CatsTable');
if (!$row->bind($data)){
$this->setError($this->_db->getErrorMsg());
return false;
}$row->checked_out_time = date('Y-m-d H:i:s');
if (!$row->cat_id){
$row->ordering = $row->getNextOrder();
}if (!$row->check()){
$this->setError($this->_db->getErrorMsg());
return false;
}if (!$row->store()){
$this->setError($this->_db->getErrorMsg());
return false;
}else{
if (!$row->cat_id) $row->cat_id = mysql_insert_id();
}$this->setState('cat_id', $row->cat_id);
return true;
}}