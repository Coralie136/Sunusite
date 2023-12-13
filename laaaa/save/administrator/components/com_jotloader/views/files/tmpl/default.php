<?php
/*
* @version $Id: default.php,v 1.15 2008/12/13 14:42:01 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'toolbar.php');
JHTML::_('behavior.tooltip');
$task = "list";
$site_url = JURI::root();
$file_save = $site_url."/administrator/images/filesave.png";
JotloaderToolbar::title(JText::_('JOTLOADER_BACKEND_FILESLIST_TITLE'));
JToolBarHelper::addNew('add');
JToolBarHelper::spacer();
JToolBarHelper::publish('publish');
JToolBarHelper::unpublish('unpublish');
JToolBarHelper::customX( 'move', 'move.png', 'move_f2.png', 'Move' );
if ($this->lists['order']!='c.cat_title' or $this->lists['order_Dir']!='asc') {
JToolBarHelper::custom('showorder', 'download.png', 'download.png',JText::_('JOTLOADER_BACKEND_FILESLIST_ORDER') , false);
}JToolBarHelper::deleteList(JText::_('JOTLOADER_BACKEND_FILESLIST_DEL'), 'delete');
JToolBarHelper::spacer();
JToolBarHelper::custom('cpanel', 'preview.png', 'preview_f2.png', JText::_('JOTLOADER_BACKEND_TOOLBAR_MAIN'), false);
JToolBarHelper::spacer();
JToolBarHelper::help('files.jotloader', true);
?>
<style type="text/css" media="screen">
   .icon-32-download {
      background-image:url(<?php
   echo $site_url."/administrator/components/com_jotloader/images/icon-32-download.png";?>);
}
</style>
<script language="javascript" type="text/javascript">
   function submitorder() {
      document.adminForm.task.value = "pushorder";
      document.adminForm.submit();
   }
</script>
<form action="index2.php" method="post" name="adminForm">
   <table cellpadding="4" cellspacing="1" border="0" width="100%">
      <tr>
         <td align="left" width="100%">
            <?php echo JText::_('JOTLOADER_BACKEND_FILESLIST_SEARCH') . " "; ?>
            <input type="text" name="search" id="search" value="<?php echo $this->lists['search']; ?>" class="text_area" onChange="document.adminForm.submit();" />
            <?php echo $this->lists['reset']; ?>
            <button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
         </td>
         <td  align="right">
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
            <th width="5" align="left"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php
                                                 echo count($this->rows);
?>);" /></th>
            <th class="title"><?php echo JHTML::_('grid.sort','JOTLOADER_BACKEND_FILESLIST_FILE', 'f.file_title', @$this->lists['order_Dir'], @$this->lists['order']); ?>
               <?php if ($this->lists['order']=='f.file_title') { ?>
               <img src="<?php echo $file_save;?>" onclick="submitorder();" style="cursor:pointer;" />
               <?php } ?>
            </th>
            <th class="title"><?php echo JHTML::_('grid.sort','JOTLOADER_BACKEND_FILESLIST_DOWNLOADS', 'f.downloads', @$this->lists['order_Dir'], @$this->lists['order']); ?>
               <?php if ($this->lists['order']=='f.downloads') {?>
               <img src="<?php echo $file_save;?>" onclick="submitorder();" style="cursor:pointer;" />
               <?php } ?>
            </th>
            <th class="title"><?php echo JHTML::_('grid.sort','JOTLOADER_BACKEND_FILESLIST_CAT', 'c.cat_title', @$this->lists['order_Dir'], @$this->lists['order']); ?></th>
            <th class="title"><?php echo JText::_('JOTLOADER_BACKEND_FILESLIST_VERSION') . " "; ?></th>
            <th class="title"><?php echo JText::_('JOTLOADER_BACKEND_FILESLIST_LICENSE') . " "; ?></th>
            <th class="title"><?php echo JHTML::_('grid.sort','JOTLOADER_BACKEND_FILESLIST_DADDED', 'f.date_added2', @$this->lists['order_Dir'], @$this->lists['order']); ?>
               <?php if ($this->lists['order']=='f.date_added2') {?>
               <img src="<?php echo $file_save;?>" onclick="submitorder();" style="cursor:pointer;" />
               <?php } ?>
            </th>
            <th class="title"><?php echo JHTML::_('grid.sort','JOTLOADER_BACKEND_FILESLIST_URL_DOWNLOAD', 'f.url_download', @$this->lists['order_Dir'], @$this->lists['order']); ?></th>
            <th class="title"><?php echo JText::_('JOTLOADER_BACKEND_FILESLIST_AUTHOR') . " "; ?></th>
            <th class="title" align="center"><?php echo JHTML::_('grid.sort','JOTLOADER_BACKEND_FILESLIST_PUBLISHED', 'f.published', @$this->lists['order_Dir'], @$this->lists['order']); ?></th>
            <th class="title" colspan="3" align="center"><?php echo JHTML::_('grid.sort','JOTLOADER_BACKEND_FILESLIST_ORDERING', 'c.cat_title', @$this->lists['order_Dir'], @$this->lists['order']);
echo JHTML::_('grid.order',  &$this->rows ); ?></th>
         </tr>
      </thead>
      <?php
      $k = 0;
for($i = 0, $n = count(&$this->rows); $i < $n; $i++){
$row = &$this->rows[$i];
$row->id = $row->file_id;
$link = 'index2.php?option=com_jotloader&section=files&task=edit&hidemainmenu=1&cid=' . $row->file_id;
$checked = JHTML::_('grid.checkedout', $row, $i);
$published 	= JHTML::_('grid.published', $row, $i );
$ordering = ($this->lists['order'] == 'f.ordering');
$valid = ($row->not_valid)?'<div title="'.$row->file_path.'"><font color=red>'.$row->url_download.'</font></div>':$row->url_download;
?>
      <tbody>
         <tr class="<?php echo "row$k"; ?>">
            <td><?php echo $checked; ?></td>
            <td><a href="<?php echo $link; ?>" ><?php echo $row->file_title; ?></a></td>
            <td><?php echo $row->downloads; ?>&nbsp;</td>
            <td><?php echo $row->cat_title; ?>&nbsp;</td>
            <td><?php echo $row->version; ?>&nbsp;</td>
            <td><?php echo $row->license_type; ?>&nbsp;</td>
            <td><?php echo $row->date_added; ?>&nbsp;</td>
            <td><?php echo $valid; ?>&nbsp;</td>
            <td><a href="<?php echo $row->url_author; ?>" target="_blank">
            <?php echo $row->author; ?></a>&nbsp;</td>
            <td align="center"><?php echo $published;?></td>
            <td class="order">
               <span><?php echo $this->pagination->orderUpIcon( $i, ($row->cat_id == @$this->rows[$i-1]->cat_id),'orderup', 'Move Up', 1 ); ?></span>
               <span><?php echo $this->pagination->orderDownIcon( $i, $n, ($row->cat_id == @$this->rows[$i+1]->cat_id), 'orderdown', 'Move Down', 1 ); ?></span>
            </td>
            <td  class="order"><input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" class="text_area" style="text-align: center" /></td>
            <?php $k = 1 - $k;
}?>
         </tr>
      </tbody>
      <tfoot>
         <tr>
            <td colspan="13"><?php echo $this->pagination->getListFooter(); ?></td>
         </tr>
      </tfoot>
   </table>
   <input type="hidden" name="boxchecked" value="0" />
   <input type="hidden" name="option" value="<?php echo $option;?>" />
   <input type="hidden" name="section" value="files" />
   <input type="hidden" name="task" value="" />
   <input type="hidden" name="hidemainmenu" value="0" />
   <input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
   <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
   <?php echo JHTML::_('form.token'); ?>
</form>
