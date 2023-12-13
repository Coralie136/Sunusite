<?php
/*
* @version $Id: default.php,v 1.7 2008/12/08 12:25:47 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'toolbar.php');
JHTML::_('behavior.tooltip');
JotloaderToolbar::title(JText::_('JOTLOADER_BACKEND_STATS_TITLE_HEAD'));
JToolBarHelper::spacer();
JToolBarHelper::custom('cpanel', 'preview.png', 'preview_f2.png', JText::_('JOTLOADER_BACKEND_TOOLBAR_MAIN'), false);
JToolBarHelper::spacer();
JToolBarHelper::help('usage.jotloader', true);
$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
?>
<form action="index2.php" method="post" name="adminForm">
    <table cellpadding="4" cellspacing="1" border="0" width="100%">
        <tr>
            <td>
                <?php echo JText::_('JOTLOADER_BACKEND_FILESLIST_SEARCH') . " "; ?>
                <input type="text" name="search" id="search" value="<?php echo $this->lists['search']; ?>" class="text_area" onChange="document.adminForm.submit();" />
                <?php echo $this->lists['reset']; ?>
                <button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
            </td>
            <td align="right">
                <?php
                $html = JHTML::_('select.genericlist', $this->lists['catid'], 'cat_id', 'size="1" class="inputbox" onchange="document.adminForm.submit();"', 'value', 'text', $this->cat_id);
echo $html;
?>
            </td>
        </tr>
    </table>
    <table  class="adminlist">
        <thead>
            <tr>
                <th class="title"><?php echo JText::_('JOTLOADER_BACKEND_STATS_FILE') . " "; ?></th>
                <th class="title"><?php echo JText::_('JOTLOADER_BACKEND_STATS_CAT') . " "; ?></th>
                <th class="title"><?php echo JText::_('JOTLOADER_BACKEND_STATS_HITS') . " "; ?></th>
                <th class="title" width="250"><?php echo JText::_('JOTLOADER_BACKEND_STATS_DATE') . " "; ?></th>
            </tr>
        </thead>
        <?php
        $k = 0;
for($i = 0, $n = count(&$this->rows); $i < $n; $i++){
$row = &$this->rows[$i];
$id = $this->pagination->limitstart + $i + 1;
?>
        <tbody>
            <tr class="<?php echo "row$k"; ?>">
                <td><a href="index2.php?option=com_jotloader&section=stats&task=detail&date=<?php echo $row->dload;?>&cat=<?php echo $row->cat;?>&file=<?php echo $row->file;?>"><?php echo $row->ftitle;?></a></td>
                <td><?php echo $row->ctitle;?></td>
                <td><?php echo $row->hits;?></td>
                <td><?php echo $row->dload;?></td>
                <?php $k = 1 - $k;
}?>
            </tr>
        </tbody>
        <tfoot>
            <tr class="<?php echo "row$k";?>">
                <th align="center" colspan="4"><?php echo $this->pagination->getListFooter(); ?>
                </th>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="option" value="<?php echo $option; ?>" />
    <input type="hidden" name="section" value="stats" />
    <input type="hidden" name="task" value="list" />
    <input type="hidden" name="hidemainmenu" value="0" />
    <?php echo JHTML::_('form.token'); ?>
</form>