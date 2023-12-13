<?php
/*
* @version $Id: default.php,v 1.10 2008/12/08 12:25:47 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'toolbar.php');
JHTML::_('behavior.tooltip');
$site = JURI::root();
JotloaderToolbar::title(JText::_('JOTLOADER_BACKEND_CATSLIST_TITLE_HEAD'));
JToolBarHelper::addNew('add');
JToolBarHelper::spacer();
JToolBarHelper::publish('publish');
JToolBarHelper::unpublish('unpublish');
JToolBarHelper::deleteList(JText::_('JOTLOADER_BACKEND_CATSLIST_DEL'), 'delete');
JToolBarHelper::spacer();
JToolBarHelper::custom('cpanel', 'preview.png', 'preview_f2.png', JText::_('JOTLOADER_BACKEND_TOOLBAR_MAIN'), false);
JToolBarHelper::spacer();
JToolBarHelper::help('admin.jotloader', true);
?>
<form action="index2.php" method="post" name="adminForm">
    <table cellpadding="5" cellspacing="1" border="0" width="100%" class="adminlist">
        <tr>
            <td>
                <?php echo JText::_('JOTLOADER_BACKEND_CATSLIST_SEARCH') . " "; ?>
                <input type="text" name="search" id="search" value="<?php echo $this->lists['search']; ?>" class="text_area" onChange="document.adminForm.submit();" />
                <?php echo $this->lists['reset']; ?>
                <button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
            </td>
        </tr>
    </table>
    <table  class="adminlist">
        <thead>
            <tr>
                <th width="5" align="left"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($this->rows); ?>);" /></th>
                <th class="title"><?php echo JText::_('JOTLOADER_BACKEND_CATSLIST_TITLE') . " ";     ?></th>
                <th class="title"><?php echo JText::_('JOTLOADER_BACKEND_FILESLIST_DADDED') . " "; ?></th>
                <th class="title"><?php echo JText::_('JOTLOADER_BACKEND_CATSLIST_LINK') . " "; ?></th>
                <?php if($this->config['advanced.on']){ ?>
                <th class="title" align="center"><?php echo JText::_('JOTLOADER_BACKEND_DIRLIST_DEF') . " "; ?></th>
                <?php } ?>
                <th class="title" align="center"><?php echo JText::_('JOTLOADER_BACKEND_CATSLIST_PUBLISHED') . " "; ?></th>
                <th class="title" colspan="3" align="center"><?php echo JText::_('JOTLOADER_BACKEND_CATSLIST_ORDERING') . " "; ?><?php echo JHTML::_('grid.order',  &$this->rows ); ?></th>
            </tr>
        </thead>
        <?php
        $k = 0;
for($i = 0, $n = count(&$this->rows); $i < $n; $i++){
$row = &$this->rows[$i];
$row->id = $row->cat_id;
$link = 'index2.php?option=com_jotloader&task=edit&section=cats&hidemainmenu=1&cid='.$row->cat_id;
$checked = JHTML::_('grid.checkedout', $row, $i);
$def_subdir_id = $this->config['cat.default'];
$default = ($row->cat_id==$def_subdir_id) ? $site."administrator/images/publish_g.png":"";
$published 	= JHTML::_('grid.published', $row, $i );
$ordering = ($this->lists['order'] == 'ordering');
?>
        <tbody>
            <tr class="<?php echo "row$k"; ?>">
                <td><?php echo $checked; ?></td>
                <td><a href="<?php echo $link; ?>" title="<?php echo JText::_('JOTLOADER_BACKEND_CATSEDIT_TITLE'); ?>"><?php
                        echo $row->cat_title;
?></a></td>
                <td><?php echo $row->checked_out_time; ?>&nbsp;</td>
                <td width="30%"><a href="<?php echo $site.'index.php?option=com_jotloader&cid='.$row->id
.'_'.$row->mark;
?>" target="_blank"><?php echo 'index.php?option=com_jotloader&cid='.$row->id;
?></a></td>
                                       <?php if($this->config['advanced.on']){ ?>
                <td align="center"><img src="<?php echo $default;?>"/></td>
                <?php } ?>
                <td align="center"><?php echo $published;?></td>
                <td class="order" colspan="2">
                    <span><?php echo $this->pagination->orderUpIcon( $i, 1,'orderup', 'Move Up', 1 ); ?></span>
                    <span><?php echo $this->pagination->orderDownIcon( $i, $n, 1, 'orderdown', 'Move Down', 1 ); ?></span>
                </td>
                <td  class="order"><input type="text" name="order[]" size="5" value="<?php
                                              echo $row->ordering;?>" class="text_area" style="text-align: center" />
                </td>
                <?php $k = 1 - $k;
} ?>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td align="center" colspan="<?php echo($this->config['advanced.on']==1)?9:8; ?>"><?php echo $this->pagination->getListFooter(); ?></td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="option" value="<?php echo $option;?>" />
    <input type="hidden" name="section" value="cats" />
    <input type="hidden" name="task" value="list" />
    <input type="hidden" name="hidemainmenu" value="0">
    <?php echo JHTML::_('form.token'); ?>
</form>
