<?php
/*
* @version $Id: bugs.php,v 1.4 2008/12/07 17:09:34 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
function callback($var){
return substr($var, 0, 7) == "comment";
}class BugsModelBugs extends JModel{
var $_database = null;
var $_cid = null;
var $_file = null;
var $_bug = null;
var $_comments = null;
function __construct(){
$this->_database = &JFactory::getDBO();
$cid = JRequest::getInt('cid');
if (is_array($cid)) $cid = 0;
else $cid = (int)$cid;
$this->_cid = $cid;
parent::__construct();
}function getCid(){
return $this->_cid;
}function getFile(){
return $this->_file;
}function getBug(){
return $this->_bug;
}function getComments(){
return $this->_comments;
}function addBug($access){
$my = &JFactory::getUser();
if ($this->_cid){
if ($access > 0){
$bug_title = $this->_database->Quote("[" . $my->name . "] ".JRequest::getVar('bug_title', '', 'post'));
$bug_desc = $this->_database->Quote(JRequest::getVar('bug_desc', '', 'post'));
$this->_database->setQuery("INSERT INTO #__jotloader_bugs (bug_title, bug_desc, bug_status, file_id, bug_dadded) VALUES ($bug_title,$bug_desc, 0,'$this->_cid',now());");
$this->_database->query();
}}}function removeBug($access){
$bid = JRequest::getInt('bid', 0);
if ($bid){
if ($access > 1){
$this->_database->setQuery("SELECT file_id FROM #__jotloader_bugs WHERE bug_id = '$bid'");
$cid = $this->_database->loadResult();
$this->_database->setQuery("DELETE FROM #__jotloader_bugs WHERE bug_id = '$bid'");
$this->_database->query();
}}return $cid;
}function editBug($bid){
$this->_database->setQuery("SELECT * FROM #__jotloader_bugs WHERE bug_id = '$bid'");
$bugs = $this->_database->loadObjectList();
$this->_database->setQuery("SELECT * FROM #__jotloader_comments WHERE rel_id = '$bid' AND comment_type='bugs'");
$this->_comments = $this->_database->loadObjectList();
$this->_database->setQuery("SELECT f.* FROM #__jotloader_files f,#__jotloader_bugs b WHERE b.bug_id = '$bid' AND b.file_id=f.file_id");
$files = $this->_database->loadObjectList();
if (array_key_exists(0, $bugs)){
$this->_bug = $bugs[0];
}if (array_key_exists(0, $files)){
$this->_file = $files[0];
}}function saveBug(){
$bid = JRequest::getInt('bid', 0);
$bug_title = $this->_database->Quote(JRequest::getVar('bug_title', ""));
$bug_desc = $this->_database->Quote(JRequest::getVar('bug_desc', ""));
$bug_title_changed = JRequest::getInt('title_chng', 0);
$bug_desc_changed = JRequest::getInt('desc_chng', 0);
if ($bug_title_changed){
$this->_database->setQuery("UPDATE #__jotloader_bugs SET bug_title = $bug_title WHERE bug_id = '$bid'");
$this->_database->query();
}if ($bug_desc_changed){
$this->_database->setQuery("UPDATE #__jotloader_bugs SET bug_desc = $bug_desc WHERE bug_id = '$bid'");
$this->_database->query();
}$cid = JRequest::getInt('cid', 0);
$comment_keys = array_filter (array_keys($_REQUEST), 'callback');
foreach($comment_keys as $comment_key){
$comment_id = substr($comment_key, 8);
$comment_changed = JRequest::getInt("chng" . $comment_id, 0);
if ($comment_changed){
$comment_desc = JRequest::getVar($comment_key, "");
if (trim($comment_desc) == ""){
$this->_database->setQuery("DELETE FROM #__jotloader_comments WHERE comment_id = '$comment_id'");
}else{
$comment_desc = $this->_database->Quote($comment_desc);
$this->_database->setQuery("UPDATE #__jotloader_comments SET comment_desc = $comment_desc WHERE comment_id = '$comment_id'");
}$this->_database->query();
}}return $cid;
}function appendNote($access){
$my = &JFactory::getUser();
if ($this->_cid){
if ($access > 0){
$bug_id = $this->_database->Quote(JRequest::getInt('bid', '', 'post'));
$txt_comment = $this->_database->Quote(" [" . $my->name . "] " . JRequest::getVar('txt_comment', '', 'post'));
$this->_database->setQuery("INSERT INTO #__jotloader_comments (rel_id, comment_desc, comment_type, comment_dadded) VALUES ($bug_id,$txt_comment,'bugs',now());");
$this->_database->query();
}}return $this->_cid;
}function changeStatus($access){
$bid = JRequest::getInt('bid', 0);
if ($bid){
$bid = $this->_database->Quote($bid);
if ($access > 1){
$this->_database->setQuery("SELECT bug_status FROM #__jotloader_bugs WHERE bug_id = $bid");
$bug_status = $this->_database->loadResult();
$bug_status = ($bug_status) ? 0:1;
$this->_database->setQuery("UPDATE #__jotloader_bugs SET bug_status = '$bug_status' WHERE bug_id = $bid");
$this->_database->query();
}}$this->_database->setQuery("SELECT file_id FROM #__jotloader_bugs WHERE bug_id = $bid");
$cid = $this->_database->loadResult();
return $cid;
}}