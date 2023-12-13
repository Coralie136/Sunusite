<?php
/*
* @version $Id: view.php,v 1.2 2008/12/07 17:09:34 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
jimport( 'joomla.application.component.view');
class JotloaderView extends JView
{function __construct($config = array())	{
parent::__construct($config);
}function sefRelToAbsX($value){
$url = str_replace('&amp;', '&', $value);
if (substr(strtolower($url), 0, 9) != "index.php") return $url;
$uri = JURI::getInstance();
$prefix = $uri->toString(array('scheme', 'host', 'port'));
return $prefix . JRoute::_($url);
}}?>