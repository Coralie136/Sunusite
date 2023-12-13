<?php
/*
* @version $Id: stats.php,v 1.4 2008/12/08 12:25:46 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
class StatsModelStats extends JModel{
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
global $mainframe, $option;
if (empty($this->_data)){
$query = $this->_buildQuery();
$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
if ($this->getState('group')==1) {
$search = $mainframe->getUserStateFromRequest($option . 'search', 'search', '', 'string');
if (count($this->_data) == 0 and strlen($search) > 0){
$this->_data = $this->_getList($query, 0, $this->getState('limit'));
}}}return $this->_data;
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
$cat = JRequest::getInt('cat', -1);
$file = JRequest::getInt('file', 0);
$date = trim(JRequest::getVar('date'));
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/',$date)) {
$date ='0000-00-00';
}$filter = "c.cat_id=" . $cat . " AND f.file_id=" . $file . " AND DATE_FORMAT( s.stat_dadded, '%Y-%m-%d')='" . $date . "'";
$query = "SELECT s.*,f.file_title,c.cat_title"
. " FROM `#__jotloader_stats` AS s, `#__jotloader_files` AS f, `#__jotloader_cats` AS c"
. " WHERE s.file_id=f.file_id AND f.cat_id=c.cat_id AND " . $filter
. " ORDER BY s.stat_dadded DESC";
$this->_item = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
return $this->_item;
}function _buildQuery(){
if ($this->getState('group')==1) {
$where = $this->_buildContentWhere();
$query = "SELECT COUNT( s.file_id ) AS hits,"
. "DATE_FORMAT( s.stat_dadded, '%Y-%m-%d' ) AS dload, f.file_title AS ftitle,"
. "c.cat_title AS ctitle,c.cat_id AS cat,f.file_id AS file"
. " FROM `#__jotloader_stats` AS s, `#__jotloader_files` AS f, `#__jotloader_cats` AS c"
. $where
. " GROUP BY dload, ftitle, ctitle"
. " ORDER BY dload DESC , ctitle, ftitle";
} else {
$cat = JRequest::getInt('cat', -1);
$file = JRequest::getInt('file', 0);
$date = trim(JRequest::getVar('date'));
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/',$date)) {
$date ='0000-00-00';
}$filter = "c.cat_id=" . $cat . " AND f.file_id=" . $file . " AND DATE_FORMAT( s.stat_dadded, '%Y-%m-%d')='" . $date . "'";
$query = "SELECT s.*,f.file_title,c.cat_title"
. " FROM `#__jotloader_stats` AS s, `#__jotloader_files` AS f, `#__jotloader_cats` AS c"
. " WHERE s.file_id=f.file_id AND f.cat_id=c.cat_id AND " . $filter
. " ORDER BY s.stat_dadded DESC";
}return $query;
}function _buildContentWhere(){
global $mainframe, $option;
$db = &JFactory::getDBO();
$filter_catid = $mainframe->getUserStateFromRequest($option . 'cat_id', 'cat_id', -1, 'int');
$search = $mainframe->getUserStateFromRequest($option . 'search', 'search', '', 'string');
$search = JString::strtolower($search);
$where = array("s.file_id = f.file_id", "f.cat_id = c.cat_id");
if ($filter_catid >= 0){
$where[] = 'f.cat_id = ' . (int) $filter_catid;
}if ($search){
$where[] = 'LOWER(f.file_title) LIKE ' . $db->Quote('%' . $db->getEscaped($search, true) . '%', false);
}$where = (count($where) ? ' WHERE ' . implode(' AND ', $where) : '');
return $where;
}}