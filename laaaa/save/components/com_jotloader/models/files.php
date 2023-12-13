<?php
/*
* @version $Id: files.php,v 1.9 2008/12/08 12:26:10 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
class FilesModelFiles extends JModel{
var $_database = null;
var $_cats = null;
var $_files = null;
var $_cid = null;
function __construct(){
$this->_database = &JFactory::getDBO();
$word = JRequest::getCmd('cid','');
$mark = ""; $cid = 0;
if (strpos($word,'_')){
list($cid, $mark) = split("_", $word, 2);
}$cid=intval($cid);
if ($cid==0 and count($mark)>0){
$this->_cid  = 0;
parent::__construct();
return;
}$query = "SELECT mark FROM #__jotloader_cats where cat_id='$cid'";
$this->_database ->setQuery($query);
$value = $this->_database->loadResult();
if (isset($mark) and $mark==$value) {
$this->_cid  = $cid;
} else {
$this->_cid  = -1;
}parent::__construct();
}function getCats(){
$where = '';
if ($this->_cid){
$where = ' AND cat_id=' . $this->_cid;
}$this->_database->setQuery("SELECT * FROM #__jotloader_cats WHERE published = 1" . $where . "\n ORDER BY ordering");
$this->_cats = $this->_database->loadObjectList();
if (empty($this->_cats)){
$this->_cats[0] = &JTable::getInstance('jotloader', 'FilesTable');
$this->_cats[0]->cat_id = -1;
$this->_cats[0]->cat_title = JText::_('JOTLOADER_FRONTEND_NOCAT');
}return $this->_cats;
}function getFiles(){
$this->_files = array();
foreach($this->_cats as $cat){
$this->_database->setQuery("SELECT * FROM #__jotloader_files WHERE cat_id = '{$cat->cat_id}' AND published = 1" . "\n ORDER BY ordering");
$files = $this->_database->loadObjectList();
$update = 0;
foreach ($files as $file) {
if ($file->mark=="" or !is_string($file->mark)) {
$query2 = "UPDATE #__jotloader_files SET mark=MD5(now())"
." WHERE file_id = '" . (int)$file->file_id . "'";
$this->_database->setQuery($query2);
$this->_database->query();
$update = 1;
}}if ($update) {
$this->_database->setQuery($query);
$files = $this->_database->loadObjectList();
}$this->_files[$cat->cat_id] = $files;
}return $this->_files;
}function updateHits($config){
$cid = JRequest::getCmd('cid');
list($cid,$mark) = split("_", $cid, 2);
$this->_database->setQuery("SELECT mark FROM #__jotloader_files WHERE file_id = '$cid' AND published = 1" . "\n ORDER BY ordering");
$mark_db = $this->_database->loadResult();
if ($mark_db==$mark) {
$this->_database->setQuery("UPDATE #__jotloader_files SET downloads=downloads+1 WHERE file_id = '" . (int)$cid . "'");
$this->_database->query();
$addr = $_SERVER['REMOTE_ADDR'];
$host = gethostbyaddr($addr);
if ($config['statistics.on']){
$this->_database->setQuery("INSERT INTO #__jotloader_stats (file_id, stat_address, stat_host, stat_dadded) VALUES ('$cid','$addr','$host',now());");
$this->_database->query();
}$this->_database->setQuery("SELECT url_download FROM #__jotloader_files WHERE file_id = '" . (int)$cid . "'");
$file_uri = $this->_database->loadResult();
return $file_uri ;
} else {
return false;
}}function getFile(){
$file = &JTable::getInstance('jotloader', 'FilesTable');
$word = JRequest::getCmd('cid');
$cid = (int) $word;
$file->load($cid);
$this->_database->setQuery("SELECT c.* FROM #__jotloader_cats c, #__jotloader_files f WHERE f.cat_id = c.cat_id AND f.file_id = '$cid'");
$file->cat = $this->_database->loadObject();
return $file;
}function getBugs(){
$word = JRequest::getCmd('cid');
$cid = (int) $word;
$this->_database->setQuery("SELECT * FROM #__jotloader_bugs WHERE file_id = '$cid' ORDER BY bug_dadded DESC");
$bugs = $this->_database->loadObjectList();
foreach($bugs as $i => $bug){
$this->_database->setQuery("SELECT * FROM #__jotloader_comments WHERE rel_id = '$bug->bug_id' AND comment_type = 'bugs'");
$bugs[$i]->comments = $this->_database->loadObjectList();
}return $bugs;
}}