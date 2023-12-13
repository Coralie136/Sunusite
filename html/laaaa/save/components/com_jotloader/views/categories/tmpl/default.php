<?php
/*
* @version $Id: default.php,v 1.7 2008/12/08 13:51:27 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
global $Itemid;
$params = &JComponentHelper::getParams('com_jotloader');
$basicParams = $params->_registry['_default']['data'];
if (!empty($this->cats)){
foreach($this->cats as $cat){
$html_cat = str_replace('{cat_title}', $cat->cat_title, $this->config['templates.cats.cat']);
$html_cat = str_replace('{cat_description}', $cat->cat_description, $html_cat);
$html_files = '';
if (isset($this->files[$cat->cat_id])){
if ($basicParams->header_flag) {
$html_file = $basicParams->header_format;
} else {
$html_file = $this->config['templates.files.header'];
}$html_files .= $html_file;
foreach($this->files[$cat->cat_id] as $file){
if ($basicParams->files_flag) {
$html_file = str_replace('{file_id}', $file->file_id, $basicParams->files_format);
} else {
$html_file = str_replace('{file_id}', $file->file_id, $this->config['templates.files.file']);
}$html_file = str_replace('{file_title}', $file->file_title, $html_file);
$html_file = str_replace('{file_description}', $file->description, $html_file);
$html_file = str_replace('{version}', $file->version, $html_file);
$html_file = str_replace('{license_type}', $file->license_type, $html_file);
$html_file = str_replace('{cat_id}', $file->cat_id, $html_file);
$html_file = str_replace('{size}', $file->size, $html_file);
$html_file = str_replace('{date_added}', $file->date_added, $html_file);
$html_file = str_replace('{url_download}', $this->sefRelToAbsX('index.php?option=' . $option . '&section=files&task=download&cid='.$file->file_id."_".$file->mark. '&Itemid=' . $Itemid), $html_file);
$html_file = str_replace('{url_home}', $file->url_home, $html_file);
$html_file = str_replace('{author}', $file->author, $html_file);
$html_file = str_replace('{url_author}', $file->url_author, $html_file);
$html_file = str_replace('{url_bugs}', $this->sefRelToAbsX('index.php?option=com_jotloader&section=files&task=bugs&cid=' . $file->file_id."_".$file->mark . '&Itemid=' . $Itemid), $html_file);
$html_file = str_replace('{url_suggs}', $this->sefRelToAbsX('index.php?option=com_jotloader&task=files.suggs&cid=' . $file->file_id . '&Itemid=' . $Itemid), $html_file);
$html_file = str_replace('{downloads}', $file->downloads, $html_file);
$html_file = str_replace('{ordering}', $file->ordering, $html_file);
$html_file = str_replace('{published}', $file->published, $html_file);
$html_files .= $html_file;
}}$html_cat = str_replace('{files}', $html_files, $html_cat);
echo $html_cat;
}}?>

