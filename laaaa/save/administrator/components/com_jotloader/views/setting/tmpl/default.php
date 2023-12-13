<?php
/*
* @version $Id: default.php,v 1.11 2008/12/13 14:42:01 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'toolbar.php');
JHTML::_('behavior.tooltip');
JotloaderToolbar::title(JText::_('JOTLOADER_BACKEND_SETTINGS'));
JToolBarHelper::save('save');
JToolBarHelper::spacer();
JToolBarHelper::apply('apply');
JToolBarHelper::spacer();
JToolBarHelper::cancel('cpanel', JText::_('JOTLOADER_BACKEND_TOOLBAR_CLOSE'));
JToolBarHelper::spacer();
JToolBarHelper::custom('cpanel', 'preview.png', 'preview_f2.png', JText::_('JOTLOADER_BACKEND_TOOLBAR_MAIN'), false);
JToolBarHelper::spacer();
JToolBarHelper::help('settings.jotloader', true);
$site_path = JPATH_SITE;
$site_url = JURI::root();
JLoader::register('JPaneTabs', JPATH_LIBRARIES . DS . 'joomla' . DS . 'html' . DS . 'pane.php');
$tabs = new JPaneTabs(1);
?>
<script language="javascript" type="text/javascript">
   function submitbutton(pressbutton) {
      var advanced = document.getElementsByName('config[advanced.on]');
      if (pressbutton == 'cancel' || advanced[0].checked==false) {
         submitform( pressbutton );
         return;
      }
      var autopublish = document.getElementsByName('config[files.autopublish]');
      var catId = document.getElementsByName('config[cat.default]');
      if (autopublish.length>0&&autopublish[1].checked&&catId[0].selectedIndex==0){
         alert( "<?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_PAUTO_ALERT');?>" );
      } else {
         submitform( pressbutton );
      }
   }
</script>
<form action="index2.php" method="post" name="adminForm" id="adminForm">
   <table width="100%" border="0">
      <tr>
         <td width="40%" valign="top">
            <table cellpadding="4" cellspacing="1" border="0" class="adminform">
               <tr>
                  <th colspan="2"><?php
                     echo strtoupper(JText::_('JOTLOADER_BACKEND_SETTINGS_GLOBAL_HEAD'));
?></th>
               </tr>
               <tr>
                  <td valign="top" align="left" width="100%">
                     <table>
                        <tr>
                           <td><strong><?php
                                 echo JText::_('JOTLOADER_BACKEND_SETTINGS_DATETIME') . " ";
?></strong><br/>
                              <input name="config[global.datetime]" value="<?php echo $this->config['global.datetime'];
?>" size="100" maxlength="50"></td>
                           <td>
                              <?php
                              echo JText::_('JOTLOADER_BACKEND_SETTINGS_DATETIME_DESC');
?>
                           </td>
                        </tr>
                        <?php if(!$this->config['advanced.on']){?>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_UPLOADDIR') . " ";
?></strong><br/>
                              <?php echo $site_path.DS; ?>
                              <input name="config[files.uploaddir]" value="<?php
                                     echo $this->config['files.uploaddir'];
?>" size="50" /><?php echo DS; ?><br/>
                                     <?php
                                     echo (is_writable($site_path.DS.$this->config['files.uploaddir'])) ? JText::_('JOTLOADER_BACKEND_FILESEDIT_URL_DOWNLOAD_WRITABLE') : JText::_('JOTLOADER_BACKEND_FILESEDIT_URL_DOWNLOAD_NOTWRITABLE');
?></td>
                           <td>
                              <?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_UPLOADDIR_DESC'); ?>
                           </td>
                        </tr>
                        <?php } ?>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_FAUTO') . " "; ?></strong><br/>
                              <?php
                              echo JHTML::_('select.booleanlist', "config[files.autodetect]", "", ($this->config['files.autodetect']) ? 1:0);
?>
                           </td>
                           <td>
                              <?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_FAUTO_DESC'); ?>
                           </td>
                        </tr>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_STAT') . " "; ?></strong><br/>
                              <?php
                              echo JHTML::_('select.booleanlist', "config[statistics.on]", "", ($this->config['statistics.on']) ? 1:0);
?>
                           </td>
                           <td>
                              <?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_STAT_DESC'); ?>
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr>

            </table>
         </td>
      </tr>
      <tr>
         <td width="40%" valign="top">
            <table cellpadding="4" cellspacing="1" border="0" class="adminform">
               <tr>
                  <th colspan="2"><?php echo strtoupper(JText::_('JOTLOADER_BACKEND_SETTINGS_TEMPLATES_HEAD')); ?></th>
               </tr>
               <tr>
                  <td valign="top" align="left" width="100%">
                     <table>
                        <tr>
                           <td><strong><?php
                                 echo JText::_('JOTLOADER_BACKEND_SETTINGS_TEMPLATES_CATS') . " ";
?></strong><br/>
                              <textarea name="config[templates.cats.cat]" rows="8" cols="70"><?php
                           echo $this->config['templates.cats.cat']; ?></textarea></td>
                           <td>
                              <?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_TEMPLATES_CATS_DESC'); ?>
                           </td>
                        </tr>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_TEMPLATES_HEADER') . " "; ?></strong><br/>
                              <textarea name="config[templates.files.header]" rows="8" cols="70"><?php
echo $this->config['templates.files.header'];
?></textarea></td>
                           <td>
                              <?php
                              echo JText::_('JOTLOADER_BACKEND_SETTINGS_TEMPLATES_HEADER_DESC');
?>
                           </td>
                        </tr>
                        <tr>
                           <td><strong><?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_TEMPLATES_FILES') . " ";
?></strong><br/>
                              <textarea name="config[templates.files.file]" rows="8" cols="70"><?php echo $this->config['templates.files.file'];
?></textarea></td>
                           <td>
                              <?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_TEMPLATES_FILES_DESC'); ?>
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr>

            </table>
         </td>
      </tr>
      <tr>
         <td width="40%" valign="top">
            <table cellpadding="4" cellspacing="1" border="0" class="adminform">
               <tr>
                  <th colspan="2"><input type="checkbox" name="config[advanced.on]" value="1" <?php
                                            if($this->config['advanced.on']) echo "checked";
?>>&nbsp;
                                            <?php echo strtoupper(JText::_('JOTLOADER_BACKEND_SETTINGS_ADVANCED')); ?></th>
               </tr>
               <?php if($this->config['advanced.on']){ ?>
               <tr>
                  <td><table><tr><td colspan="2"><strong><?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_UPLOADPATH') . " ";
?></strong></td></tr>
                        <tr><td>
                              <input name="config[files.uploadpath]" value="<?php
                                     echo $this->config['files.uploadpath'];
?>" size="90" /></td>
                           <td><?php echo DS;?></td>
                        </tr><tr><td colspan="2">
                              <?php
                              echo (is_writable($this->config['files.uploadpath'])) ? JText::_('JOTLOADER_BACKEND_FILESEDIT_URL_DOWNLOAD_WRITABLE') : JText::_('JOTLOADER_BACKEND_FILESEDIT_URL_DOWNLOAD_NOTWRITABLE');
?></td>
                     </tr></table>
                  </td>
                  <td>
                     <?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_UPLOADPATH_DESC'); ?>
                  </td>
               </tr>
               <tr>
                  <td><strong><?php echo "&nbsp;".JText::_('JOTLOADER_BACKEND_SETTINGS_PAUTO')." "; ?></strong><br/>
                     <?php
                     echo JHTML::_('select.booleanlist', "config[files.autopublish]", "", ($this->config['files.autopublish']) ? 1:0);
?>
                  </td>
                  <td>
                     <?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_PAUTO_DESC'); ?>
                  </td>
               </tr>
               <tr>
                  <td><strong><?php echo "&nbsp;".JText::_('JOTLOADER_BACKEND_SETTINGS_DCAT')." "; ?></strong><br/>
                     <?php echo "&nbsp;".JHTML::_('select.genericlist', $this->lists['catid'], 'config[cat.default]', 'size="1" class="inputbox"', 'value', 'text', $this->config['cat.default']);
?>
                  </td>
                  <td>
                     <?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_DCAT_DESC'); ?>
                  </td>
               </tr>
               <tr>
                  <td><strong><?php echo "&nbsp;".JText::_('JOTLOADER_BACKEND_SETTINGS_SCAN')." "; ?></strong><br/>
                     &nbsp;<input name="config[scan.frontend]" value="<?php
                            echo intval($this->config['scan.frontend']);
?>" size="10" />

                  </td>
                  <td>
                     <?php echo JText::_('JOTLOADER_BACKEND_SETTINGS_SCAN_DESC'); ?>
                  </td>
               </tr>
               <?php } ?>
            </table>
         </td>
      </tr>
   </table>
   <input type="hidden" name="option" value="<?php echo $option; ?>" />
   <input type="hidden" name="section" value="setting" />
   <input type="hidden" name="task" value="" />
</form>