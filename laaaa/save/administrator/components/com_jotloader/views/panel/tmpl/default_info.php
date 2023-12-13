<?php
/*
* @version $Id: default_info.php,v 1.5 2008/12/07 16:56:51 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
JToolBarHelper::title('JotLoader');
JToolBarHelper::spacer();
JToolBarHelper::custom('cpanel', 'preview.png', 'preview_f2.png', JText::_('JOTLOADER_BACKEND_TOOLBAR_MAIN'), false);
JToolBarHelper::spacer();
JToolBarHelper::help('usage.jotloader', true);
global $mainframe;
$site_url = $mainframe->getSiteURL();
?>
<form action="index2.php" method="post" name="adminForm">
    <?php
    $lang = &JFactory::getLanguage();
$tag = $lang->getTag();
if ($tag == "de-DE"){
$infoPath = 'components' . DS . 'com_jotloader' . DS . 'help' . DS . $tag . DS . 'info.jotloader.html';
}else{
$infoPath = 'components' . DS . 'com_jotloader' . DS . 'help' . DS . 'en-GB' . DS . 'info.jotloader.html';
}include(JPATH_BASE . DS . $infoPath);
?>
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="option" value="<?php echo $option; ?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="hidemainmenu" value="0">
</form>