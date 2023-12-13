<?php
/*
* @version $Id: default_detail.php,v 1.6 2008/12/08 12:25:47 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'toolbar.php');
JHTML::_('behavior.tooltip');
JotloaderToolbar::title(JText::_('JOTLOADER_BACKEND_STATS_TITLE_HEAD'));
JToolBarHelper::spacer();
JToolBarHelper::custom('group', 'back.png', 'back_f2.png', JText::_('JOTLOADER_BACKEND_TOOLBAR_BACK'), false);
JToolBarHelper::spacer();
JToolBarHelper::custom('cpanel', 'preview.png', 'preview_f2.png', JText::_('JOTLOADER_BACKEND_TOOLBAR_MAIN'), false);
JToolBarHelper::spacer();
JToolBarHelper::help('usage.jotloader', true);
?>
<form action="index2.php" method="post" name="adminForm">
    <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
        <thead>
            <tr>
                <th class="title"><?php echo JText::_('JOTLOADER_BACKEND_STATS_ID') . " "; ?></th>
                <th class="title"><?php echo JText::_('JOTLOADER_BACKEND_STATS_FILE') . " "; ?></th>
                <th class="title"><?php echo JText::_('JOTLOADER_BACKEND_STATS_CAT') . " "; ?></th>
                <th class="title"><?php echo JText::_('JOTLOADER_BACKEND_STATS_IP') . " "; ?></th>
                <th class="title"><?php echo JText::_('JOTLOADER_BACKEND_STATS_HOST') . " "; ?></th>
                <th class="title" width="250"><?php echo JText::_('JOTLOADER_BACKEND_STATS_DATE') . " "; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $k = 0;
for($i = 0, $n = count($this->rows); $i < $n; $i++){
$row = &$this->rows[$i];
$id = $this->pagination->limitstart + $i + 1;
?>

            <tr class="<?php echo "row$k"; ?>">
                <td><?php echo $id; ?></td>
                <td><?php echo $row->file_title; ?></td>
                <td><?php echo $row->cat_title; ?></td>
                <td><?php echo $row->stat_address; ?></td>
                <td><?php echo $row->stat_host; ?></td>
                <td><?php echo $row->stat_dadded; ?></td>
                <?php $k = 1 - $k;
}?>
            </tr>
        </tbody>
        <tfoot>
            <tr class="<?php echo "row$k"; ?>">
                <td align="center" colspan="6"><?php
                    echo $this->pagination->getListFooter();
?>
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="option" value="<?php echo $option; ?>" />
    <input type="hidden" name="section" value="stats" />
    <input type="hidden" name="task" value="detail" />
    <input type="hidden" name="hidemainmenu" value="0">
    <?php echo JHTML::_('form.token'); ?>
</form>