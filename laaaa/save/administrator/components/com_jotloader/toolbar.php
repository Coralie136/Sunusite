<?php
/*
* @version $Id: toolbar.php,v 1.2 2008/12/07 16:56:49 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
class JotloaderToolbar extends JToolBarHelper{
function title($title) {
global $mainframe;
$site = $mainframe->getSiteURL();
$html  = '<img border="0" src="'.$site
.'administrator/components/com_jotloader/images/jotloaderlogo.gif" height="49" width="166" alt="JotLoader Logo" align="left">';
$html .= '<div class="header">&nbsp;'.$title;
$html .= "</div>\n";
$mainframe->set('JComponentTitle', $html);
}}?>
