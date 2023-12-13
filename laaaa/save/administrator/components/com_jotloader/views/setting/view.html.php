<?php
/*
* @version $Id: view.html.php,v 1.11 2008/12/07 16:56:51 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
class SettingViewSetting extends JView {
function display($tpl = null) {
$lists['catid'] = $this->categories;
$this->assignRef('lists', $lists);
parent::display($tpl);
}function show($tpl = null) {
$lists['catid'] = $this->categories;
$this->assignRef('lists', $lists);
$this->setLayout($tpl);
parent::display();
}}