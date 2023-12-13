<?php
/*
* @version $Id: view.html.php,v 1.2 2008/12/07 17:09:34 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die( 'Restricted access' );
require_once (JPATH_COMPONENT.DS.'view.php');
class FilesViewCategories extends JotloaderView {
function display($tpl = null){
$cats = &$this->get('Cats');
$files = &$this->get('Files');
$this->assignRef('cats', $cats);
$this->assignRef('files', $files);
parent::display($tpl);
}function show($access, $tpl = null){
$file = &$this->get('File');
$bugs = &$this->get('Bugs');
$this->assignRef('file', $file);
$this->assignRef('bugs', $bugs);
$this->assignRef('access2', $access);
parent::display($tpl);
}}class BugsViewCategories extends JotloaderView {
function show($tpl = null){
$file = &$this->get('File');
$bug = &$this->get('Bug');
$comments = &$this->get('Comments');
$this->assignRef('file', $file);
$this->assignRef('bug', $bug);
$this->assignRef('comments', $comments);
parent::display('bug');
}}