<?php
/*
* @version $Id: default_category.php,v 1.11 2008/12/07 16:56:50 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'toolbar.php');
JHTML::_('behavior.tooltip');
JotloaderToolbar::title($this->row->cat_id?JText::_('JOTLOADER_BACKEND_CATSEDIT_EDIT'):JText::_('JOTLOADER_BACKEND_CATSEDIT_ADD'));
JToolBarHelper::save('save');
JToolBarHelper::spacer();
JToolBarHelper::apply('apply');
JToolBarHelper::spacer();
JToolBarHelper::cancel('cancel');
JToolBarHelper::spacer();
JToolBarHelper::help('admin.jotloader', true);
jimport('joomla.html.editor');
$editor = &JFactory::getEditor();
?>
<script language="javascript" type="text/javascript">
 function submitbutton(pressbutton) {
  var form = document.adminForm;
  if (pressbutton == 'cancel') {
   submitform( pressbutton );
   return;
  }
  if (form.cat_title.value == ""){
   alert( "<?php echo JText::_('JOTLOADER_BACKEND_CATSEDIT_ERROR_TITLE');?>" );
  } else {
   submitform( pressbutton );
  }
 }
</script>
<form action="index2.php" method="post" name="adminForm" id="adminForm">
 <table width="100%" border="0">
  <tr>
   <td width="100%" valign="top">
    <table cellpadding="4" cellspacing="1" border="0" class="adminform">
     <tr>
      <td valign="top" align="left" width="100%">
       <table>
        <tr>
         <td><strong><?php echo JText::_('JOTLOADER_BACKEND_CATSEDIT_CAT_TITLE') . " "; ?></strong><br/>
          <input name="cat_title" value="<?php echo $this->row->cat_title; ?>" size="70" maxlength="50"/>
          <input type="hidden" name="ordering" value="<?php echo $this->row->ordering;  ?>"/>
          <input type="hidden" name="published" value="<?php echo $this->row->published; ?>"/>
         </td>
        </tr>
        <tr>
         <td><strong><?php echo JText::_('JOTLOADER_BACKEND_CATSEDIT_CAT_DESCRIPTION') . " "; ?></strong><br/>
          <?php echo $editor->display('cat_description', &$this->row->cat_description , '100%', '300', '75', '20') ;
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
 <input type="hidden" name="boxchecked" value="0" />
 <input type="hidden" name="hidemainmenu" value="1" />
 <input type="hidden" name="option" value="<?php echo $option; ?>" />
 <input type="hidden" name="cat_id" value="<?php echo $this->row->cat_id; ?>" />
 <input type="hidden" name="section" value="cats" />
 <input type="hidden" name="task" value="" />
</form>
