<?php
/*
*
* @version $Id: default_file.php,v 1.12 2008/12/14 10:20:46 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'toolbar.php');
global $jotloaderConfig;
jimport( 'joomla.html.editor' );
$editor =& JFactory::getEditor();
JHTML::_('behavior.tooltip');
JotloaderToolbar::title($this->row->file_id ? JText::_('JOTLOADER_BACKEND_FILESEDIT_EDIT') : JText::_('JOTLOADER_BACKEND_FILESEDIT_ADD'));
JToolBarHelper::save('save');
JToolBarHelper::spacer();
JToolBarHelper::apply('apply');
JToolBarHelper::spacer();
JToolBarHelper::cancel('cancel');
JToolBarHelper::spacer();
JToolBarHelper::help('files.jotloader', true);
?>
<script language="javascript" type="text/javascript">
   function submitbutton(pressbutton) {
      var form = document.adminForm;
      if (pressbutton == 'cancel') {
         submitform( pressbutton );
         return;
      }
      if (form.file_title.value == ""){
         alert( "<?php echo JText::_('JOTLOADER_BACKEND_FILESEDIT_ERROR_TITLE');?>" );
      } else {
         submitform( pressbutton );
      }
   }
</script>
<form action="index2.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
   <table width="100%" border="0">
      <tr>
         <td width="100%" valign="top">
            <table cellpadding="4" cellspacing="1" border="0" class="adminform">
               <tr>
                  <td valign="top" align="left" width="100%">
                     <table>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_FILESEDIT_FILE_TITLE') . " "; ?></strong><br/>
                              <input name="file_title" value="<?php echo $this->row->file_title; ?>" size="70">
                              <input type="hidden" name="ordering" value="<?php echo $this->row->ordering; ?>"/>
                              <input type="hidden" name="published" value="<?php echo $this->row->published; ?>"/>
                           </td>
                        </tr>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_FILESEDIT_FILE_CAT') . " "; ?></strong><br/>
                              <?php $html = JHTML::_('select.genericlist', $this->lists['catid'], 'cat_id', 'size="1" class="inputbox"', 'value', 'text', $this->row->cat_id);
echo $html;
?>
                           </td>
                        </tr>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_FILESEDIT_VERSION') . " "; ?></strong><br/>
                              <input name="version" value="<?php echo $this->row->version; ?>" size="70"/>
                           </td>
                        </tr>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_FILESEDIT_DESC')." "; ?></strong><br/><?php
                              echo $editor->display('description',  $this->row->description , '100%', '300', '75', '20' ) ;	?>
                           </td>
                        </tr>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_FILESEDIT_LICENSE') . " "; ?></strong><br/>
                              <input name="license_type" value="<?php echo $this->row->license_type; ?>" size="70"/>
                           </td>
                        </tr>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_FILESEDIT_SIZE') . " "; ?></strong><br/>
                              <input name="size" value="<?php echo $this->row->size; ?>" size="70"/>
                           </td>
                        </tr>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_FILESEDIT_DADDED') . " "; ?></strong><br/>
                              <input name="date_added" value="<?php echo $this->row->date_added; ?>" size="70"/>
                           </td>
                        </tr>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_FILESEDIT_URL_DOWNLOAD') . " "; ?></strong><br/>
                              <?php echo $this->lists['download_dir']; ?>
                           </td>
                        </tr>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_FILESEDIT_FILE') . " "; ?></strong><br/>
                              <input name="file_upload" type="file"/><br/>
                              <?php
                              if ($this->row->url_download != ''){
echo $this->utility->download_dir.$this->row->url_download;
} ?>
                           </td>
                        </tr>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_FILESEDIT_URL_HOME') . " ";
?></strong><br/>
                              <input name="url_home" value="<?php echo $this->row->url_home; ?>" size="70"/>
                           </td>
                        </tr>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_FILESEDIT_AUTHOR') . " "; ?></strong><br/>
                              <input name="author" value="<?php echo $this->row->author; ?>" size="70"/>
                           </td>
                        </tr>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_FILESEDIT_AUTHOR_URL') . " "; ?></strong><br/>
                              <input name="url_author" value="<?php echo $this->row->url_author; ?>" size="70"/>
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
   <input type="hidden" name="boxchecked" value="0" />
   <input type="hidden" name="hidemainmenu" value="1" />
   <input type="hidden" name="option" value="<?php echo $option; ?>" />
   <input type="hidden" name="file_id" value="<?php echo $this->row->file_id; ?>" />
   <input type="hidden" name="section" value="files" />
   <input type="hidden" name="task" value="" />
</form>