<?php
/*
* @version $Id: view.html.php,v 1.5 2008/12/07 16:56:51 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
class PanelViewPanel extends JView {
function display($tpl = null){
parent::display($tpl);
}function info(){
parent::display('info');
}}