<?php
/*
* @version $Id: default_move.php,v 1.6 2008/12/09 14:02:28 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'toolbar.php');
JHTML::_('behavior.tooltip');
JotloaderToolbar::title(JText::_('JOTLOADER_BACKEND_CATSEDIT_CAT_DIR'));
JToolBarHelper::save('savemove');
JToolBarHelper::spacer();
JToolBarHelper::cancel('cancel');
JToolBarHelper::spacer();
JToolBarHelper::help('files.jotloader', true);
$cat_size = count($this->categories);
if ($cat_size>30) $cat_size = 30;
$site = JURI::root();
?>
<form action="index2.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <table width="100%" border="0">
        <tr>
            <td width="100%" valign="top">
                <table cellpadding="4" cellspacing="1" border="0" class="adminform">
                    <tr>
                        <td valign="top" align="left" width="100%">
                            <table border="0" cellspacing="25">
                                <tr>
                                    <td valign="top"><strong><?php echo JText::_('JOTLOADER_BACKEND_FILESEDIT_FILE_TITLE2') . " "; ?></strong><br/>
                                        <table class="adminlist" id="content-box" >
                                            <?php
                                            for($i = 0, $n = count(&$this->rows); $i < $n; $i++){
$row = &$this->rows[$i];
?>
                                            <tr>
                                                <td><?php echo $row->file_title; ?></td>
                                                <td><?php echo $row->url_download; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                    </td>
                                    <td>
                                        <strong><?php echo JText::_('JOTLOADER_BACKEND_FILESEDIT_FILE_CAT2') . " "; ?></strong><br/>
                                        <?php $html = JHTML::_('select.genericlist', $this->lists['catid'], 'cat_id', 'size="'.$cat_size.'" class="inputbox"', 'value', 'text', $this->lists['cid']);
echo $html;
?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br/><br/>
    <?php
    foreach ($this->lists['cid'] as $id) {
echo "\n<input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
}?>
    <?php echo JHTML::_( 'form.token' ); ?>
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="hidemainmenu" value="1" />
    <input type="hidden" name="option" value="<?php echo $option; ?>" />
    <input type="hidden" name="section" value="files" />
    <input type="hidden" name="task" value="" />
</form>