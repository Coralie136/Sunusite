<?php
/*
* @version $Id: files.php,v 1.7 2008/12/13 14:42:29 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
jimport('joomla.application.component.controller');
class FilesController extends JotloaderController{
function __construct($config){
parent::__construct($config);
$this->assignViewModel('categories','files');
}function display(){
parent::display();
}function bugs(){
$access = $this->checkAccess();
$this->view->show($access,'bugs');
}function download(){
$site_url = JURI::root();
$file_uri = $this->model->updateHits($this->config);
if ($file_uri) {
$file_path = $this->config['files.uploadpath'].DS.$file_uri;
if ($this->config['advanced.on'] and file_exists ($file_path)) {
$this->transferFile($file_path);
} else {
$file_uri = $site_url.$this->config['files.uploaddir'] . '/' . $file_uri;
$this->setRedirect($file_uri);
}} else {
$this->setRedirect($site_url .'index.php');
}}function transferFile($file_path){
$fsize = filesize($file_path);
if ($allowed_ext[$fext] == '') {
$mtype = '';
if (function_exists('mime_content_type')) {
$mtype = mime_content_type($file_path);
}else if (function_exists('finfo_file')) {
$finfo = finfo_open(FILEINFO_MIME); 
$mtype = finfo_file($finfo, $file_path);
finfo_close($finfo);
}if ($mtype == '') {
$mtype = "application/force-download";
}}$asfname = basename($file_path);
ob_end_clean();
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: $mtype");
header("Content-Disposition: attachment; filename=\"$asfname\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . $fsize);
@readfile($file_path);
exit;
}}?>