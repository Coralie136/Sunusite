<?php
/*
* @version $Id: bugs.php,v 1.6 2008/12/08 12:26:10 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
jimport('joomla.application.component.controller');
class BugsController extends JotloaderController{
var $_access = null;
var $_Itemid = 0;
function __construct($config){
parent::__construct($config);
$this->assignViewModel('categories','bugs');
$this->_access = $this->checkAccess();
$this->_Itemid = JRequest::getInt('Itemid',0);
}function display(){
}function add(){
$this->model->addBug($this->_access);
$cid = $this->model->getCid();
$this->setRedirect('index.php?option=com_jotloader&section=files&task=bugs&cid='.$cid.'&Itemid='.$this->_Itemid);
}function remove(){
$cid = $this->model->removeBug($this->_access);
$this->setRedirect('index.php?option=com_jotloader&section=files&task=bugs&cid='.$cid.'&Itemid='.$this->_Itemid);
}function change(){
$append = JRequest::getInt('append', 0, 'post');
if ($append == 1){
$cid = $this->model->appendNote($this->_access);
$this->setRedirect('index.php?option=com_jotloader&section=files&task=bugs&cid='.$cid.'&Itemid='.$this->_Itemid);
}else{
$cid = $this->model->changeStatus($this->_access);
$this->setRedirect('index.php?option=com_jotloader&section=files&task=bugs&cid='.$cid.'&Itemid='.$this->_Itemid);
}}function edit(){
$bid = JRequest::getInt('bid', 0);
if ($bid and $this->_access > 1){
$this->model->editBug($bid);
$this->view->show();
} else {
$this->setRedirect('index.php?option=com_jotloader&Itemid='.$this->_Itemid);
}}function save(){
$cid = $this->model->saveBug();
$this->setRedirect('index.php?option=com_jotloader&section=files&task=bugs&cid='.$cid.'&Itemid='.$this->_Itemid);
}}?>