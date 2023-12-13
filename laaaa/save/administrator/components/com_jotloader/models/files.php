<?php
/*
* @version $Id: files.php,v 1.17 2008/12/14 10:20:46 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'utility.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helper.php');
class FilesModelFiles extends JModel{
var $_data = null;
var $_total = null;
var $_pagination = null;
var $_item = null;
var $search = null;
var $filter_catid = null;
var $file_order = null;
var $file_order_Dir = null;
function __construct(){
parent::__construct();
global $mainframe, $option;
$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
$limitstart = $mainframe->getUserStateFromRequest($option . '.limitstart', 'limitstart', 0, 'int');
$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
$this->setState('limit', $limit);
$this->setState('limitstart', $limitstart);
}function getData(){
if (empty($this->_data)){
$query = $this->_buildQuery();
$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
}return $this->_data;
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
$query = 'SELECT * FROM #__jotloader_files WHERE file_id='
. $this->getState('file_id');
$rows = $this->_getList($query);
if (count($rows)>0){
$this->_item = $rows[0];
} else {
$empty = &new stdclass;
$empty->file_id = null;
$empty->file_title = null;
$empty->ordering = null;
$empty->published = null;
$empty->cat_id = null;
$empty->version = null;
$empty->description = null;
$empty->license_type = null;
$empty->size = null;
$empty->date_added = null;
$empty->url_download = null;
$empty->url_home = null;
$empty->author = null;
$empty->url_author = null;
$this->_item = $empty;
}return $this->_item;
}function _buildQuery(){
$where = $this->_buildContentWhere();
$orderby = $this->_buildContentOrderBy();
$query = 'SELECT f.*,c.cat_title FROM #__jotloader_files f LEFT JOIN #__jotloader_cats c ON f.cat_id=c.cat_id'
. $where
. $orderby ;
return $query;
}function _buildContentOrderBy(){
global $mainframe, $option;
$this->file_order = $mainframe->getUserStateFromRequest($option . 'file_order', 'filter_order', 'c.cat_title', 'cmd');
$this->file_order_Dir = $mainframe->getUserStateFromRequest($option . 'file_order_Dir', 'filter_order_Dir', 'asc', 'word');
$basic_order = ' ORDER BY '.$this->file_order.' '.$this->file_order_Dir;
if ($this->file_order == 'c.cat_title') {
$orderby = $basic_order.",f.ordering";
} else {
$orderby = ' ORDER BY '.$this->file_order.' '.$this->file_order_Dir.",f.date_added2 desc";
}return $orderby;
}function _buildContentWhere(){
global $mainframe, $option;
$db = &JFactory::getDBO();
$this->filter_catid = $mainframe->getUserStateFromRequest($option .'cat_id','cat_id',-1,'int');
$this->search = $mainframe->getUserStateFromRequest($option .'search','search','','string');
$this->search = JString::strtolower($this->search);
$where = array();
if ($this->filter_catid >= 0){
$where[] = 'f.cat_id = '.$this->filter_catid;
}if (count($this->search)>0){
$where[] = 'LOWER(f.file_title) LIKE '.$db->Quote('%'.$db->getEscaped($this->search, true).'%',false);
}$where = (count($where)?' WHERE '.implode(' AND ', $where):'');
return $where;
}function saveorder($order,$cid = array()){
$row = &JTable::getInstance('jotloader', 'FilesTable');
$groupings = array();
for($i = 0; $i < count($cid); $i++){
$row->load((int) $cid[$i]);
$groupings[] = $row->cat_id;
if ($row->ordering != $order[$i]){
$row->ordering = $order[$i];
if (!$row->store()){
$this->setError($this->_db->getErrorMsg());
return false;
}}}$groupings = array_unique($groupings);
foreach ($groupings as $group){
$row->reorder('cat_id = ' . (int) $group);
}return true;
}function pushorder() {
$query = 'SELECT * FROM #__jotloader_files f '.$this->_buildContentOrderBy();
$rows = $this->_getList($query);
$row = &JTable::getInstance('jotloader', 'FilesTable');
$groupings = array();
for($i = 0; $i < count($rows); $i++){
$row->load((int) $rows[$i]->file_id);
$groupings[] = $row->cat_id;
if ($row->ordering != $i){
$row->ordering = $i;
if (!$row->store()){
$this->setError($this->_db->getErrorMsg());
return false;
}}}$groupings = array_unique($groupings);
foreach ($groupings as $group){
$row->reorder('cat_id = ' . (int) $group);
}return true;
}function store($data){
$row = &$this->getTable('JotLoader', 'FilesTable');
if (!$row->bind($data)){
$this->setError($this->_db->getErrorMsg());
return false;
}$row->checked_out_time = date('Y-m-d H:i:s');
$date = JRequest::getVar('date_added','','post');
$row->date_added2 = date('Y-m-d H:i:s',strtotime($date));
if (!$row->file_id){
$where = 'cat_id = '.(int) $row->cat_id ;
$row->ordering = $row->getNextOrder( $where );
}if (!$row->check()){
$this->setError($this->_db->getErrorMsg());
return false;
}if (!$row->store()){
$this->setError($this->_db->getErrorMsg());
return false;
}else{
if (!$row->file_id) $row->file_id = mysql_insert_id();
$file = JRequest::getVar('file_upload', array('tmp_name' => ''), 'files');
if ($file['tmp_name'] != ''){
$config = $this->getState('config');
$dir_util = new DirUtility($config);
$root_path = $dir_util->download_root;
if ($config['advanced.on']) {
$autopublish = $config['files.autopublish'];
} else {
$autopublish = 0;
}$date_added = date($config['global.datetime']);
$date_added2 = date('Y-m-d H:i:s');
$target_path = $root_path.DS.$file['name'];
if (move_uploaded_file($file['tmp_name'], $target_path)){
chmod($target_path,0644);
$file_size = JotloaderHelper::fsize($target_path);
$root_path = str_replace('\\', '\\\\', $root_path);
$this->_db->setQuery("UPDATE #__jotloader_files SET url_download = '{$file['name']}',date_added='$date_added',date_added2='$date_added2',file_path='$root_path',published='$autopublish',size='$file_size' WHERE file_id = '$row->file_id'");
if (!$this->_db->query()) {
$this->setError($this->_db->getErrorMsg());
return false;
}}else{
$mainframe->redirect("index2.php?option=$option&task=files.edit&cid=" . $row->file_id, JText::_('JOTLOADER_BACKEND_FILESEDIT_CHECK_PERMISSIONS') . " " . $target_path);
}}}$this->setState('file_id', $row->file_id);
return true;
}function check($id){
$db = &JFactory::getDBO();
$query = 'SELECT mark FROM #__jotloader_files WHERE file_id='.$id;
$db->setQuery($query);
$result = $db->loadResult();
if (is_string($result)) {
if ($result=="") return true;
else return false;
}else{
return true;
}}function getMoved() {
$db     = JFactory::getDBO();
$cid = $this->getState('cid');
$cid = implode(",", $cid);
$query = 'SELECT file_title, url_download FROM #__jotloader_files WHERE file_id IN('.$cid.')';
$rows = $this->_getList($query);
return $rows;
}function savemove($cid,$cat_id) {
$row = & JTable::getInstance('JotLoader', 'FilesTable');
foreach ($cid as $id)
{$row->load(intval($id));
if (is_file($row->file_path.DS.$row->url_download)) {
$dir_util = $this->getState('utility');
rename($row->file_path.DS.$row->url_download,$dir_util->download_root.DS.$row->url_download);
$row->file_path = $dir_util->download_root;
}$config = $this->getState('config');
if ($config['advanced.on']) $row->published = $config['files.autopublish'];
$row->ordering = 0;
$row->cat_id = $cat_id;
$row->store();
$row->reorder('cat_id = '.(int) $row->cat_id);
}}}