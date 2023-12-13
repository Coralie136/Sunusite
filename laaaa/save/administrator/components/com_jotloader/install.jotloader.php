<?php
/*
* @version $Id: install.jotloader.php,v 1.7 2008/12/13 14:42:01 Vlado Exp $
* @package JotLoader
* @copyright (C) 2007-2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Based on doQment 1.0.0beta (www.pimpmyjoomla.com) - fully reworked the front-end
* pages to allow commenting bugs and suggestions for authorized users.
* package doQment 1.0.0beta
* version 1.0.0beta
* copyright (C) 2007 www.pimpmyjoomla.com
* license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
function migrate($table,$column,$type) {
$database = &JFactory::getDBO();
$sql = "DESCRIBE `#__jotloader_".$table."` `".$column."`";
$database->setQuery($sql);
if (!$database->loadResult()){
$sql = "ALTER TABLE `#__jotloader_".$table."` ADD `".$column."` ".$type.";";
$database->setQuery($sql);
$database->query();
}}function copy_lang($language,$path) {
$jotloader_path = JPATH_SITE.'/administrator/components/com_jotloader/';
$path1 =  "/".$path."/".$language."/";
if (!file_exists(JPATH_SITE . $path1)){
mkdir(JPATH_SITE . $path1);
}$dir1 = ($path=='language')? 'client':'admin';
$extension = ($path=='language')?array("ini"):array("ini","menu.ini");
foreach ($extension as $ext) {
$file1 = $jotloader_path.$dir1.'/'.$language.'.com_jotloader.'.$ext;
$file2 = JPATH_SITE .$path1.$language.'.com_jotloader.'.$ext;
if (!copy($file1,$file2 )){
echo "failed to copy ".$file1."...\n";
}chmod($file2, 0640);
}}function com_install() {
$mosConfig_absolute_path = JPATH_SITE;
$database = &JFactory::getDBO();
$items = array("files,file_path,VARCHAR(255)",
"files,date_added2,DATETIME",
"files,mark,VARCHAR(50) default NULL",
"files,not_valid,TINYINT(1)",
"cats,mark,VARCHAR(50) default NULL",
"cats,cat_subdir,VARCHAR(255)",
"cats,cat_subdir_default,TINYINT(1)");
foreach ($items as $item) {
$table="";$column="";$type="";
list($table,$column,$type) = split(",", $item, 3);
migrate($table,$column,$type);
}$database->setQuery("SELECT setting_value FROM #__jotloader_config WHERE setting_name='files.uploaddir'");
$uploadpath = JPATH_SITE.DS.$database->loadResult();
$uploadpath = str_replace('\\', '\\\\', $uploadpath);
$database->setQuery("SELECT setting_value FROM #__jotloader_config WHERE setting_name='files.uploadpath'");
$res = $database->loadResult();
if (!strlen($res)>0) {
$database->SetQuery("UPDATE #__jotloader_config SET setting_value='".$uploadpath."' WHERE setting_name='files.uploadpath'");
$database->Query();
}$database->setQuery("SELECT * FROM #__jotloader_files");
$rows = $database->loadObjectList();
foreach ($rows as $row) {
if (is_null($row->date_added2)) {
$conv = strtotime($row->date_added);
$conv = date('Y-m-d H:i:s', $conv);
$database->SetQuery("UPDATE #__jotloader_files SET date_added2='$conv' WHERE file_id='$row->file_id'");
$database->Query();
}if (!strlen($row->file_path)>0) {
$database->SetQuery("UPDATE #__jotloader_files SET file_path='$uploadpath' WHERE file_id='$row->file_id'");
$database->Query();
}if (is_null($row->mark)) {
$database->SetQuery("UPDATE #__jotloader_files SET mark='".MD5(time())."' WHERE file_id='$row->file_id'");
$database->Query();
}}$add_languages = array('de-DE','fr-FR');
foreach($add_languages as $add_language){
copy_lang($add_language,'language');
copy_lang($add_language,'administrator/language');
}$lang = &JFactory::getLanguage();
$lang->load('com_jotloader');
?>
<table width="100%" border="0">
   <tr>
      <td>
         <strong>
         <?php echo JText::_('JOTLOADER_BACKEND_INSTALL_TOP'); ?></strong><br />
         <br/>
      </td>
   </tr>
   <tr>
      <td background="E0E0E0" style="border:1px solid #999;" colspan="2">
         <code><?php echo JText::_('JOTLOADER_BACKEND_INSTALL_PROC'); ?><br />
   <?php
   if ($makedir = @mkdir("$mosConfig_absolute_path/download/", 0777)) {
echo "<font color='green'>".JText::_('JOTLOADER_BACKEND_INSTALL_FINISHED')."</font> ".JText::_('JOTLOADER_BACKEND_INSTALL_SET')."<br />";
} else {
echo "<font color='red'><strong>".JText::_('JOTLOADER_BACKEND_INSTALL_ATT')."</strong></font><br />";
}?>
   <br><br>
   <font color="green"><b><?php echo JText::_('JOTLOADER_BACKEND_INSTALL_SUCCESS'); ?></b></font><br />
   <?php echo JText::_('JOTLOADER_BACKEND_INSTALL_ENSURE'); ?><br />
         </code>
      </td>
   </tr>
</table>
<?php
$tag =  $lang->getTag();
if ($tag=="de-DE") {
$infoPath = 'components' .DS.'com_jotloader'.DS. 'help'.DS.$tag.DS.'info.jotloader.html';
} else {
$infoPath = 'components' .DS.'com_jotloader'.DS. 'help'.DS.'en-GB'.DS.'info.jotloader.html';
}include(JPATH_BASE.DS.$infoPath);
}?>