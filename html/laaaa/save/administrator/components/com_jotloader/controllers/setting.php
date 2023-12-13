<?php
/*
* @version $Id: setting.php,v 1.13 2008/12/13 14:42:01 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
jimport('joomla.application.component.controller');
class SettingController extends JotloaderController{
function __construct($config = array()){
parent::__construct($config);
$this->registerTask('apply', 'save');
}function display(){
$this->assignViewModel('setting');
$this->catComboData(10);
parent::display();
}function save(){
$database = &JFactory::getDBO();
$jotloaderConfig = JRequest::getVar('config', null, 'post', 'ARRAY');
if(!$jotloaderConfig['advanced.on']) $jotloaderConfig['advanced.on']=0;
$delay = abs(intval($jotloaderConfig['scan.frontend']));
if ($delay>10000) $delay=10000;
$jotloaderConfig['scan.frontend']=$delay."_".time();
$txt = array();
foreach($jotloaderConfig as $setting_name => $setting_value){
if ($setting_name == "files.uploadpath") {
$setting_value = JPath::clean($setting_value);
}$setting_value = str_replace("\\","\\\\",$setting_value);
$database->setQuery("UPDATE #__jotloader_config SET setting_value = '$setting_value' WHERE setting_name = '$setting_name'");
if (!$database->query()) $this->dberror($database->getErrorMsg());
if ($setting_name == "templates.files.header"){
$txt[0] = $setting_value;
}if ($setting_name == "templates.files.file"){
$txt[1] = $setting_value;
}}$model= $this->getModel();
$model->writeConfig($txt);
if ($this->getTask() == 'save'){
$this->setRedirect('index2.php?option=com_jotloader&task=cpanel', 'Settings saved');
}else{
$this->setRedirect('index2.php?option=com_jotloader&section=setting&task=list','Settings saved');
}}}?>