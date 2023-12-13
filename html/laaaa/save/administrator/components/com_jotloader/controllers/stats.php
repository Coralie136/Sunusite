<?php
/*
* @version $Id: stats.php,v 1.9 2008/12/07 16:56:49 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
jimport('joomla.application.component.controller');
class StatsController extends JotloaderController{
function display(){
$this->assignViewModel('stats');
$this->catComboData(13);
$this->model->setState('group',1);
parent::display();
}function detail(){
$this->assignViewModel('stats');
$this->model->setState('group',0);
parent::show('detail');
}}?>