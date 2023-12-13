<?php
/*
* @version $Id: utility.php,v 1.7 2008/12/08 12:25:46 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
class DirUtility {
var $_config =null;
var $data =null;
var	$download_root=null;
var	$download_dir=null;
var	$_subdir="";
var $_dir_string="";
function __construct($config){
$this->_config = $config;
if ($this->_config['advanced.on']) {
$this->download_root = $this->_config['files.uploadpath'];
} else {
$this->download_root = JPATH_SITE. DS . $this->_config['files.uploaddir'];
}$this->download_dir = $this->download_root;
}function setFileContext($row) {
$this->data = $row;
}function setCatContext($row) {
$this->data = $row;
}function setDirContext($subdir) {
$this->_subdir = $subdir;
$this->download_dir = $this->download_root.DS.$subdir;
}function getDirObj(){
$subdir= "";
$sep ="";
if($subdir!=""){
$sep =DS;
if (DS!='/') $sep ='\\\\';
}$this->download_dir = $this->download_root.DS.$subdir;
$this->_dir_string = $this->clean($this->download_root).$sep.'<strong>'
.$this->clean($subdir.$sep).'</strong>'.' - '.$this->getWritable();
$result = "obj.innerHTML='".$this->_dir_string."'";
$this->_dir_string = str_replace('\\\\', '\\', $this->_dir_string);
return $result;
}function clean($path){
$path = trim($path);
if (DS=='/') {
$path = preg_replace('#[/\\\\]+#', '/', $path);
} else {
$path = preg_replace('#[/\\\\]+#', '\\\\\\\\', $path);
}return $path;
}function getWritable() {
clearstatcache();
$result = is_writeable($this->download_dir) ? JText::_('JOTLOADER_BACKEND_FILESEDIT_URL_DOWNLOAD_WRITABLE') : JText::_('JOTLOADER_BACKEND_FILESEDIT_URL_DOWNLOAD_NOTWRITABLE');
return $result;
}function findDirs($from,$delete=false){
if(! is_dir($from))
return false;
$files = array();
$subdirs = array();
$subdir_level = array();
$dirs = array( $from);
$pos = strlen($from)+1;
while( NULL !== ($dir = array_pop( $dirs))) {
if( $dh = opendir($dir)) {
while( false !== ($file = readdir($dh))) {
if( $file == '.' || $file == '..') continue;
$path = $dir . '/' . $file;
if( is_dir($path)){
$subdir = substr($path,$pos);
$subdirs[] = $subdir;
$dirs[]  = $path;
if ($delete) {
$subdir_level[$subdir] = substr_count($subdir,'/')+1;
}} else {
$files[] = $path;
if ($delete) {
if (!unlink ($path)) unlink ($path);
}}}closedir($dh);
}}unset($files);
unset($dirs);
natcasesort($subdirs);
if ($delete) {
arsort($subdir_level);
foreach ($subdir_level as $dir2 => $level) {
rmdir($from."/".$dir2);
}}return $subdirs;
}}?>