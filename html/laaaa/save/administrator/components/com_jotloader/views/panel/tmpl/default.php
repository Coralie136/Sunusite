<?php
/*
* @version $Id: default.php,v 1.10 2008/12/07 16:56:51 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
JToolBarHelper::title('JotLoader');
JToolBarHelper::spacer();
JToolBarHelper::help('usage.jotloader', true);
global $mainframe;
$site_url = $mainframe->getSiteURL();
$site_path = JPATH_SITE;
$mainframe->addCustomHeadTag("<link href=\"" . $site_url . "administrator/components/com_jotloader/style.css\" rel=\"stylesheet\" type=\"text/css\"/>");
?>
<table class="thisform" cellpadding="20" cellspacing="50">
 <tr class="thisform">
  <td width="50%" valign="top" class="thisform">
   <table width="100%" class="thisform2" border="1">
    <tr class="thisform2">
     <td align="center" height="100px" width="33%" class="thisform2">
      <div align="center">
       <a href="index2.php?option=com_jotloader&task=list&section=files" style="text-decoration:none;" title="<?php echo JText::_('JOTLOADER_BACKEND_CPANEL_FILES'); ?>">
        <img src="components/com_jotloader/images/files.png" width="48px" height="48px" align="middle" border="0"/>
        <br />
        <?php echo JText::_('JOTLOADER_BACKEND_CPANEL_FILES'); ?>
       </a>
      </div>
     </td>
     <td align="center" height="100px" width="34%" class="thisform2">
      <a href="index2.php?option=com_jotloader&task=list&section=cats" style="text-decoration:none;" title="<?php echo JText::_('JOTLOADER_BACKEND_CPANEL_CATEGORIES'); ?>">
       <img src="components/com_jotloader/images/categories.png" width="48px" height="48px" align="middle" border="0"/>
       <br />
       <?php echo JText::_('JOTLOADER_BACKEND_CPANEL_CATEGORIES'); ?>
      </a>
     </td>
    </tr>
    <tr class="thisform2">
     <td align="center" height="100px" width="33%" class="thisform2">
      <a href="index2.php?option=com_jotloader&section=setting" style="text-decoration:none;" title="<?php echo JText::_('JOTLOADER_BACKEND_CPANEL_SETTINGS'); ?>">
       <img src="components/com_jotloader/images/config.png" width="48px" height="48px" align="middle" border="0"/>
       <br />
       <?php echo JText::_('JOTLOADER_BACKEND_CPANEL_SETTINGS'); ?>
      </a>
     </td>
     <td align="center" height="100px" class="thisform2">
      <a href="index2.php?option=com_jotloader&section=panel&task=info" style="text-decoration:none;" title="<?php echo JText::_('JOTLOADER_BACKEND_CPANEL_INFORMATION'); ?>">
       <img src="components/com_jotloader/images/systeminfo.png" width="48px" height="48px" align="middle" border="0"/>
       <br />
       <?php echo JText::_('JOTLOADER_BACKEND_CPANEL_INFORMATION'); ?>
      </a>
     </td>
    </tr>
    <?php if ($this->config['statistics.on']){ ?>
    <tr class="thisform2">
     <td align="center" height="100px" width="33%" class="thisform2">
      <a href="index2.php?option=com_jotloader&section=stats" style="text-decoration:none;" title="<?php echo JText::_('JOTLOADER_BACKEND_CPANEL_STATISTICS'); ?>">
       <img src="components/com_jotloader/images/download.png" width="48px" height="48px" align="middle" border="0"/>
       <br />
       <?php echo JText::_('JOTLOADER_BACKEND_CPANEL_STATISTICS'); ?>
      </a>
     </td>
     <td align="center" height="100px" class="thisform2">&nbsp;
      <?php if (false){ ?>
      <a href="index2.php?option=com_jotloader&task=notes" style="text-decoration:none;" title="<?php echo JText::_('JOTLOADER_BACKEND_CPANEL_NOTES'); ?>">
       <img src="components/com_jotloader/images/notes.png" width="48px" height="48px" align="middle" border="0"/>
       <br />
       <?php echo JText::_('JOTLOADER_BACKEND_CPANEL_NOTES'); ?>
      </a>
      <?php } ?>
     </td>
    </tr>
    <?php } ?>
   </table>
  </td>
  <td width="50%" valign="top" align="center">
   <table border="1" width="100%" class="thisform">
    <tr class="thisform">
    <th class="cpanel" colspan="2"><?php echo JText::_('JOTLOADER_PRODUCT') . ' ' . '2.0.1 (December 2008)'; ?></th></tr>
    <tr class="thisform"><td bgcolor="#FFFFFF" colspan="2"><br />
      <div style="width:100%" align="center">
       <img src="components/com_jotloader/images/jotloaderlogo.gif" align="middle" alt="JotLoader logo"/>
      <br /><br /></div>
    </td></tr>
    <tr class="thisform">
     <td width="120" bgcolor="#FFFFFF">Installed version:</td>
     <td bgcolor="#FFFFFF"><?php echo '2.0.1'; ?></td>
    </tr>
    <tr class="thisform">
     <td bgcolor="#FFFFFF">Copyright:</td>
     <td bgcolor="#FFFFFF"><?php echo "&copy; V. Kanich 2007-2008"; ?></td>
    </tr>
    <tr class="thisform">
     <td bgcolor="#FFFFFF">License:</td>
     <td bgcolor="#FFFFFF"><?php echo '<a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">http://www.gnu.org/copyleft/gpl.html</a> GNU/GPL'; ?></td>
    </tr>
    <tr class="thisform">
     <td valign="top" bgcolor="#FFFFFF">Author:</td>
     <td bgcolor="#FFFFFF">
      <?php echo '<a href="http://www.kanich.net/radio/site/" target="_blank">Visit the home site</a>'; ?>
     </td>
    </tr>
    <tr class="thisform">
     <td valign="top" bgcolor="#FFFFFF">German text:</td>
     <td bgcolor="#FFFFFF">Frank Braun</td>
    </tr>
    <tr class="thisform">
     <td valign="top" bgcolor="#FFFFFF">French text:</td>
     <td bgcolor="#FFFFFF">Vibby</td>
    </tr>
   </table>
  </td>
 </tr>
</table>
