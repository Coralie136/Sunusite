<?php
/*
* @version $Id: files.php,v 1.19 2008/12/14 10:20:46 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
jimport('joomla.application.component.controller');
class FilesController extends JotloaderController{
function __construct($config = array()){
parent::__construct($config);
$this->registerTask('unpublish', 'publish');
$this->registerTask('orderdown', 'orderup');
$this->registerTask('edit', 'add');
$this->registerTask('apply', 'save');
}function display(){
$this->assignViewModel('files');
$this->catComboData(11);
parent::display();
}function showorder(){
$this->setRedirect('index2.php?option=com_jotloader&section=files&task=list&filter_order=c.cat_title&filter_order_Dir=asc');
}function delete(){
JRequest::checkToken() or jexit('Invalid Token');
$database = &JFactory::getDBO();
$cid = JRequest::getVar('cid', array(0), '', 'array');
JArrayHelper::toInteger($cid, array(0));
$total = count($cid);
$files = join(",", $cid);
$database->SetQuery("SELECT file_path,url_download FROM #__jotloader_files WHERE file_id IN ($files)");
$rows = $database->loadObjectList();
foreach ($rows as $row) {
unlink($row->file_path.DS.$row->url_download);
}$database->SetQuery("DELETE FROM #__jotloader_files WHERE file_id IN ($files)");
if (!$database->query()) $this->dberror($database->getErrorMsg());
$msg = $total . JText::_('JOTLOADER_BACKEND_FILESLIST_DEL2') . " ";
$this->setRedirect('index2.php?option=com_jotloader&section=files&task=list', $msg);
}function publish(){
global $mainframe;
$database = &JFactory::getDBO();
$cid = JRequest::getVar('cid', array(0), '', 'array');
JArrayHelper::toInteger($cid, array(0));
$row = &JTable::getInstance('jotloader', 'FilesTable');
$publish = ($this->getTask() == 'publish')?1:0;
$row->publish($cid, $publish);
$this->setRedirect('index2.php?option=com_jotloader&section=files&task=list');
}function orderup(){
global $mainframe;
$database = &JFactory::getDBO();
$cid = JRequest::getVar('cid', array(0), '', 'array');
JArrayHelper::toInteger($cid, array(0));
$id = intval($cid[0]);
$order = ($this->getTask() == 'orderup')?-1:1;
$row = &JTable::getInstance('jotloader', 'FilesTable');
$row->load((int)$id);
$row->move($order);
$this->setRedirect('index2.php?option=com_jotloader&section=files&task=list');
}function saveorder(){
JRequest::checkToken() or jexit('Invalid Token');
$cid = JRequest::getVar('cid', array(), 'post', 'array');
$order = JRequest::getVar('order', array(), 'post', 'array');
JArrayHelper::toInteger($cid);
JArrayHelper::toInteger($order);
$model = $this->getModel('files');
$model->saveorder($order, $cid);
$msg = 'New ordering saved';
$this->setRedirect('index2.php?option=com_jotloader&section=files&task=list',$msg);
}function pushorder() {
$model = $this->getModel('files');
$model->pushorder();
$msg = 'New ordering saved';
$this->setRedirect('index2.php?option=com_jotloader&section=files&task=list',$msg);
}function add(){
JRequest::setVar('hidemainmenu', 1);
$id = JRequest::getInt('cid');
$this->assignViewModel('files');
$this->catComboData(10);
$this->model->setState('file_id', $id);
$this->view->show('file');
}function save(){
$post = JRequest::get('post');
$cid = JRequest::getVar('cid', array(0), 'post', 'array');
$post['id'] = (int) $cid[0];
$post['description'] = JRequest::getVar('description', '', 'post', 'string', 2);
$this->assignViewModel('files');
if ($post['file_id']==0 or $this->model->check($post['file_id'])) {
$post['mark'] = MD5(time());
}if ($this->model->store($post)){
$msg = JText::_('JOTLOADER_BACKEND_FILESEDIT_SAVE');
}else{
$errmsg = $this->model->getError();
$this->dberror($errmsg);
$msg = JText::_('JOTLOADER_BACKEND_FILESEDIT_SAVE_ERR');
}if ($this->getTask() == 'save'){
$this->setRedirect('index2.php?option=com_jotloader&section=files&task=list', $msg);
}else{
$this->setRedirect('index2.php?option=com_jotloader&section=files&task=edit&cid=' . $this->model->getState('file_id'), $msg);
}}function cancel(){
$this->setRedirect('index2.php?option=com_jotloader&section=files&task=list');
}function getDir(){
$cid = JRequest::getInt('cat_id', 0);
if ($cid==-2) {
$cid = $this->config['cat.default'];
}$this->assignViewModel('files','cats');
$this->model->setState('cat_id', $cid);
$dir_util = $this->utility;
$dir_util->setCatContext($this->model->getItem());
echo $dir_util->getDirObj();
}function move() {
$cid = JRequest::getVar('cid', array(), 'post', 'array');
JArrayHelper::toInteger($cid);
$this->assignViewModel('files');
$this->catComboData(10);
$this->model->setState('cid', $cid);
$this->view->showMove($cid,'move');
}function savemove() {
JRequest::checkToken() or jexit( 'Invalid Token' );
$cat_id = JRequest::getInt('cat_id', 0);
if ($cat_id==-2) {
$cat_id = $this->config['cat.default'];
}$cid = JRequest::getVar('cid', array(), 'post', 'array');
JArrayHelper::toInteger($cid);
$this->assignViewModel('files');
$this->model->savemove($cid,$cat_id);
$msg = JText::_('JOTLOADER_BACKEND_CATSEDIT_SAVE');
$this->setRedirect('index2.php?option=com_jotloader&section=files&task=list', $msg);
}}?>