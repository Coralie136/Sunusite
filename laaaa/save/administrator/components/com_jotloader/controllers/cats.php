<?php
/*
*
* @version $Id: cats.php,v 1.9 2008/12/07 16:56:49 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
jimport('joomla.application.component.controller');
class CatsController extends JotloaderController{
function __construct($config = array()){
parent::__construct($config);
$this->registerTask('unpublish', 'publish');
$this->registerTask('orderdown', 'orderup');
$this->registerTask('edit', 'add');
$this->registerTask('apply', 'save');
}function display(){
$this->assignViewModel('cats');
parent::display();
}function delete(){
JRequest::checkToken() or jexit('Invalid Token');
$database = &JFactory::getDBO();
$cid = JRequest::getVar('cid', array(0), '', 'array');
JArrayHelper::toInteger($cid, array(0));
$total = count($cid);
$cats = join(",", $cid);
$database->SetQuery("DELETE FROM #__jotloader_cats WHERE cat_id IN ($cats)");
if (!$database->query()) $this->dberror($database->getErrorMsg());
$msg = $total . JText::_('JOTLOADER_BACKEND_FILESLIST_DEL2') . " ";
$this->setRedirect('index2.php?option=com_jotloader&section=cats&task=list', $msg);
}function publish(){
$database = &JFactory::getDBO();
$cid = JRequest::getVar('cid', array(0), '', 'array');
JArrayHelper::toInteger($cid, array(0));
$row = &JTable::getInstance('jotloader', 'CatsTable');
$publish = ($this->getTask() == 'publish')?1:0;
$row->publish($cid, $publish);
$this->setRedirect('index2.php?option=com_jotloader&section=cats&task=list');
}function orderup(){
$database = &JFactory::getDBO();
$cid = JRequest::getVar('cid', array(0), '', 'array');
JArrayHelper::toInteger($cid, array(0));
$id = intval($cid[0]);
$order = ($this->getTask() == 'orderup')?-1:1;
$row = &JTable::getInstance('jotloader', 'CatsTable');
$row->load((int)$id);
$row->move($order);
$this->setRedirect('index2.php?option=com_jotloader&section=cats&task=list');
}function saveorder(){
JRequest::checkToken() or jexit('Invalid Token');
$cid = JRequest::getVar('cid', array(), 'post', 'array');
$order = JRequest::getVar('order', array(), 'post', 'array');
JArrayHelper::toInteger($cid);
JArrayHelper::toInteger($order);
$model = $this->getModel('cats');
$model->saveorder($order, $cid);
$msg = 'New ordering saved';
$this->setRedirect('index2.php?option=com_jotloader&section=cats&task=list', $msg);
}function add(){
JRequest::setVar('hidemainmenu', 1);
$cid = JRequest::getVar('cid', array(0), '', 'array');
JArrayHelper::toInteger($cid, array(0));
$id = intval($cid[0]);
$this->assignViewModel('cats');
$this->model->setState('cat_id', $id);
$this->view->show('category');
}function save(){
$post = JRequest::get('post',2);
$view = &$this->getView('cats', 'html');
if ($model = &$this->getModel('cats')){
$view->setModel($model, true);
}if ($post['cat_id']==0 or $model->check($post['cat_id'])) {
$post['mark'] = MD5(time());
}if ($model->store($post)){
$msg = JText::_('JOTLOADER_BACKEND_CATSEDIT_SAVE');
}else{
$msg = JText::_('JOTLOADER_BACKEND_CATSEDIT_SAVE_ERR');
}if ($this->getTask() == 'save'){
$this->setRedirect('index2.php?option=com_jotloader&section=cats&task=list', $msg);
}else{
$this->setRedirect('index2.php?option=com_jotloader&section=cats&task=edit&cid=' . $model->getState('cat_id'), $msg);
}}function cancel(){
$this->setRedirect('index2.php?option=com_jotloader&section=cats&task=list');
}}?>