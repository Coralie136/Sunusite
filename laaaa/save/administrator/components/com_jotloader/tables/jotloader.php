<?php
/*
* @version $Id: jotloader.php,v 1.11 2008/12/07 16:56:50 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
class BugsTableJotLoader extends JTable{
var $bug_id = null;
var $bug_title = null;
var $bug_desc = null;
var $bug_status = null;
var $bug_dadded = null;
function BugsTableJotLoader(&$db){
parent::__construct('#__jotloader_bugs', 'bug_id', $db);
}}class SuggsTableJotLoader extends JTable{
var $sugg_id = null;
var $sugg_title = null;
var $sugg_desc = null;
var $sugg_status = null;
var $sugg_dadded = null;
function SuggsTableJotLoader(&$db){
parent::__construct('#__jotloader_suggs', 'sugg_id', $db);
}}class CommentsTableJotLoader extends JTable{
var $comment_id = null;
var $comment_title = null;
var $comment_desc = null;
var $comment_type = null;
var $comment_dadded = null;
function CommentsTableJotLoader(&$db){
parent::__construct('#__jotloader_comments', 'comment_id', $db);
}}class ConfigTableJotLoader extends JTable{
var $id = null;
var $setting_name = null;
var $setting_value = null;
function ConfigTableJotLoader(&$db){
parent::__construct('#__jotloader_config', 'id', $db);
}}class CatsTableJotLoader extends JTable{
var $cat_id = null;
var $parent_id = null;
var $cat_title = null;
var $cat_description = null;
var $ordering = null;
var $published = null;
var $checked_out = null;
var $checked_out_time = null;
var $mark = null;
var $cat_subdir = null;
var $cat_subdir_default = null;
function CatsTableJotLoader(&$db){
parent::__construct('#__jotloader_cats', 'cat_id', $db);
}}class FilesTableJotLoader extends JTable{
var $file_id = null;
var $file_title = null;
var $file_path = null;
var $version = null;
var $license_type = null;
var $cat_id = null;
var $cat = null;
var $size = null;
var $date_added = null;
var $date_added2 = null;
var $url_download = null;
var $url_home = null;
var $author = null;
var $url_author = null;
var $downloads = null;
var $ordering = null;
var $published = null;
var $checked_out = null;
var $checked_out_time = null;
var $description = null;
var $mark = null;
var $not_valid = null;
function FilesTableJotLoader(&$db){
parent::__construct('#__jotloader_files', 'file_id', $db);
}}