<?php
/*
* @version $Id: helper.php,v 1.18 2008/12/13 14:42:01 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'utility.php');
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
class JotloaderHelper {
var $config = array();
function __construct(){
$database = &JFactory::getDBO();
$database->setQuery("SELECT setting_name, setting_value FROM #__jotloader_config");
$jotloaderConfigObj = $database->loadObjectList();
if (!empty($jotloaderConfigObj)){
foreach ($jotloaderConfigObj as $jotloaderConfigRow){
$this->config[$jotloaderConfigRow->setting_name] = $jotloaderConfigRow->setting_value;
}}return $this->config;
}function getConfig(){
return $this->config;
}function cron(){
$database = &JFactory::getDBO();
$dir_util = new DirUtility($this->config);
$dir_root = $dir_util->download_root;
if ($this->config['files.autodetect']){
if (file_exists($dir_root)){
if ($handle = opendir($dir_root)){
while (false !== ($file = readdir($handle))){
if (is_file($dir_root .DS. $file)){
$database->setQuery("SELECT file_id FROM #__jotloader_files WHERE url_download = '$file'");
$file_id = $database->loadResult();
if (!$file_id){
$file_obj = &JTable::getInstance('jotloader', 'FilesTable');
$file_obj->url_download = $file;
$file_obj->file_title = $file;
$file_obj->file_path = $dir_root;
$file_obj->size = $this->fsize($dir_root.DS. $file);
$file_obj->date_added = date($this->config['global.datetime']);
$file_obj->date_added2 = date('Y-m-d H:i:s');
$file_obj->mark = MD5(time());
$file_obj->not_valid = 0;
if ($this->config['advanced.on']) {
$file_obj->cat_id = $this->config['cat.default'];
if ($this->config['files.autopublish']) $file_obj->published = 1;
}$file_obj->store();
$file_obj->reorder(' cat_id = 0');
} else {
$file_obj = &JTable::getInstance('jotloader', 'FilesTable');
$file_obj->file_id = $file_id;
$file_obj->not_valid = 0;
$file_obj->store();
}}}closedir($handle);
}}$database->setQuery("SELECT * FROM #__jotloader_files"); 
$filesDb = $database->loadObjectList();
foreach($filesDb as $fileDb){
if (!is_file($dir_root.DS. $fileDb->url_download)){
$database->setQuery("UPDATE #__jotloader_files SET published=0,not_valid=1 WHERE file_id = '$fileDb->file_id'");
$database->query();
}}}}function fsize($file){
$a = array("B", "KB", "MB", "GB", "TB", "PB");
$pos = 0;
$size = filesize($file);
while ($size >= 1024){
$size /= 1024;
$pos++;
}return round($size, 2) . " " . $a[$pos];
}function next_time($delay, $curtime) {
$database = &JFactory::getDBO();
$setting_value = $delay."_".($curtime+$delay);
$database->setQuery("UPDATE #__jotloader_config SET setting_value = '$setting_value' WHERE setting_name = 'scan.frontend'");
$database->query();
}}class JotloaderController extends JController{
var $config = null;
var $view = null;
var $model = null;
var $utility = null;
function __construct($config = array()){
$this->config = &$config;
parent::__construct();
}function getConfig(){
return $this->config;
}function dberror($msg) {
echo '<script> alert("'.$msg.'"); window.history.go(-1); </script>\n';
exit();
}function assignViewModel($viewName,$modelName='',$modelPrefix=''){
$this->view = &$this->getView($viewName, 'html');
if ($modelName=='') {
$modelName= ucfirst($viewName);
}if ($modelPrefix=='') {
$modelPrefix= ucfirst($modelName).'Model';
}if ($this->model = &$this->getModel($modelName,$modelPrefix)){
$this->view->setModel($this->model, true);
}$this->utility = new DirUtility($this->config);
$this->view->assignRef('utility', $this->utility);
$this->view->assignRef('config', $this->config);
if (is_object($this->model)) {
$this->model->setState('config', $this->config);
$this->model->setState('utility', $this->utility);
}}function display(){
$this->view->display();
}function show($tpl = null){
$this->view->show($tpl);
}function catComboData($switch=15){
$database = &JFactory::getDBO();
$database->setQuery("SELECT cat_id as value, cat_title as text FROM #__jotloader_cats");
$cats = array();
if ($switch&1) {
$cats[] = JHTML::_('select.option', '-1','-'.JText::_('JOTLOADER_BACKEND_FILESLIST_CATS').'-');
}if ($switch&2) {
$cats[] = JHTML::_('select.option', '0', '-'.JText::_('JOTLOADER_BACKEND_FILESLIST_NOCATS').'-');
}if ($switch&4) {
$cats[] = JHTML::_('select.option', '-2', '-'.JText::_('JOTLOADER_BACKEND_FILESLIST_DEF').'-');
}$this->view->assignRef('categories', array_merge($cats, $database->loadObjectList()));
}function checkAccess(){
$check = 0;
$acl = &JFactory::getACL();
$my = &JFactory::getUser();
$utype = $my->usertype;
if ($utype == "Registered") $utype = "Author";
if ($acl->acl_check('com_content', 'add', 'users', $utype, 'content', 'all')){
$check = 1;
}if ($acl->acl_check('com_content', 'edit', 'users', $utype, 'content', 'all')){
$check += 2;
}return $check;
}}?>