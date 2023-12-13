<?php
/*
* @version $Id: panel.php,v 1.4 2008/12/07 16:56:49 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
jimport('joomla.application.component.controller');
class PanelController extends JotloaderController{
function display(){
$this->assignViewModel('panel');
parent::display();
}function info(){
$view = &$this->getView('panel','html');
$view->info();
}}?>