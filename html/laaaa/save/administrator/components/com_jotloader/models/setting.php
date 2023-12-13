<?php
/*
* @version $Id: setting.php,v 1.4 2008/12/07 16:56:50 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
class SettingModelSetting extends JModel{
var $_data = null;
var $_total = null;
var $_pagination = null;
var $_item = null;
function __construct(){
parent::__construct();
}function writeConfig($value){
$txt = "<?xml version=\"1.0\" encoding=\"utf-8\"?><config><params>\n";
$txt .= "<param name=\"header_format\" type=\"textarea\" default=\"";
$txt .= htmlspecialchars($value[0], ENT_COMPAT, "UTF-8");
$txt .= "\" label=\"JOTLOADER_BACKEND_SETTINGS_TEMPLATES_HEADER\" rows=\"10\" cols=\"40\" description=\"JOTLOADER_BACKEND_SETTINGS_TEMPLATES_HEADER_DESC\" />\n";
$txt .= "<param name=\"files_format\" type=\"textarea\" default=\"";
$txt .= htmlspecialchars($value[1], ENT_COMPAT, "UTF-8");
$txt .= "\" label=\"JOTLOADER_BACKEND_SETTINGS_TEMPLATES_FILES\" rows=\"10\" cols=\"40\" description=\"JOTLOADER_BACKEND_SETTINGS_TEMPLATES_FILES_DESC\" />\n";
$txt .= "</params></config>";
file_put_contents(JPATH_COMPONENT_ADMINISTRATOR . "/config.xml", $txt);
chmod(JPATH_COMPONENT_ADMINISTRATOR . "/config.xml", 0640);
}}