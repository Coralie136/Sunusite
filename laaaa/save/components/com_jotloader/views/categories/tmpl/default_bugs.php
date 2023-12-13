<?php
/*
* @version $Id: default_bugs.php,v 1.4 2008/12/08 12:26:10 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
global $Itemid;
JHTML::stylesheet( 'jotloader.css', 'components/com_jotloader/' );
?>
<h3><a href="<?php
           echo JRoute::_('index.php?option=' . $option .'&section=files&cid='.$this->file->cat->cat_id
.'_'.$this->file->cat->mark.'&Itemid='. $Itemid);?>">
           <?php echo $this->file->cat->cat_title;?>
    &raquo; <?php echo $this->file->file_title ;?></a>
</h3>
<script>
    var bugid = -1;
    function openEdit(pos) {
        if (bugid>-1){document.getElementById("head" + bugid).innerHTML="";}
        var head1 = document.getElementById("head" + pos);
        bugid = pos;
        head1.innerHTML='<textarea cols="70" rows="6" name="txt_comment" id="txt_comment"></textarea> <input type="submit" value="Send"><input type="hidden" name="append" value="1"/>';
    }
</script>
<table><tr><td><em><?php echo JText::_('JOTLOADER_FRONTEND_BUGS_TITLE'); ?></em></td></tr><tr><td>&nbsp;</td></tr></table>
<?php
if ($this->access2 > 0){
?>
<form action="<?php echo $this->sefRelToAbsX('index.php?option=' . $option . '&section=bugs&task=add&cid=' . $this->file->file_id . '&Itemid=' . $Itemid);
?>" method="POST">
    <table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
            <td class="bugTitle" width="70%"><input type="text" size="80" name="bug_title" /></td>
            <td align="center" class="bugTitle" width="10%">
                <input type="submit" name="submit" value="<?php echo JText::_('JOTLOADER_FRONTEND_BUGS_BUTTON_ADD');
?>"/>
            </td>
            <td align="center" class="bugTitle" width="20%">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">
                <textarea name="bug_desc" cols="70" rows="3"></textarea>
            </td>
        </tr>
    </table>
    <input type="hidden" name="task" value="add"/>
    <input type="hidden" name="section" value="bugs"/>
    <input type="hidden" name="option" value="<?php echo $option;
?>"/>
    <input type="hidden" name="cid" value="<?php echo $this->file->file_id;
?>"/>
</form><br>
<?php
}
foreach($this->bugs as $bug){
if ($this->access2 > 0){ ?>
<form action="<?php echo $this->sefRelToAbsX('index.php?option=' . $option . '&section=bugs&task=change&cid=' . $this->file->file_id . '&Itemid=' . $Itemid);
?>" method="POST"><?php
  }
?>
    <table width="100%" class="bugNote">
        <tr><td>
                <table width="100%" border="0" cellpadding="3" cellspacing="0" class="<?php echo ($bug->bug_status) ? 'bugOk' : 'bugNotOk';
?>">
                    <tr><td colspan="3">
                            <?php
                            if ($this->access2 > 1){
echo ("<input type=\"button\" name=\"remove\" value=\"" . JText::_('JOTLOADER_FRONTEND_BUGS_REMOVE') . "\" onClick=\"location.href='" . $this->sefRelToAbsX('index.php?option=' . $option . '&section=bugs&task=remove&bid='.$bug->bug_id.'&Itemid='.$Itemid)."';\">");
echo '<input type="submit" name="bug_status" value="' . JText::_('JOTLOADER_FRONTEND_BUGS_BUTTON') . '"/>';
echo ("<input type=\"button\" name=\"edit\" value=\"" . JText::_('JOTLOADER_FRONTEND_BUGS_EDIT') . "\" onClick=\"location.href='" . $this->sefRelToAbsX('index.php?option=' . $option . '&section=bugs&task=edit&bid=' . $bug->bug_id . '&Itemid=' . $Itemid) . "';\">");
}?>
                    </td></tr>
                    <tr>
                        <td class="bugTitle" width="70%">
                            <?php echo $bug->bug_title;
?>
                        </td>
                        <td align="center" class="bugTitle" width="10%">
                            <?php if ($this->access2 > 1)
echo '<div style="cursor: pointer; color: #CC0000;" onClick="openEdit(' . $bug->bug_id . ');">'.JText::_('JOTLOADER_FRONTEND_BUGS_BUTTON_APPEND').'</div>';
else
echo JText::_('JOTLOADER_FRONTEND_BUGS_BUG_STATUS_'. $bug->bug_status);
?>
                        </td>
                        <td align="center" class="bugTitle" width="20%"><?php echo date($this->config['global.datetime'], strtotime($bug->bug_dadded));
?></td>
                    </tr>
                    <tr>
                        <td colspan="3"><?php echo preg_replace("/\n/", "<br/>", $bug->bug_desc);
?></td>
                    </tr>
                </table>
        </td></tr>
        <tr><td><span ID="head<?php echo $bug->bug_id; ?>"> </span>
        </td></tr>
        <tr><td>
                <?php
                for ($i = 0; $i < count($bug->comments); $i++){
if ($i > 0) echo "<br>";
echo substr($bug->comments[$i]->comment_dadded, 0, 10) . " " . $bug->comments[$i]->comment_desc . "<br>";
} ?>
        </td></tr>
    </table>
    <?php
    if ($this->access2 > 0){
?>
    <input type="hidden" name="task" value="change"/>
    <input type="hidden" name="section" value="bugs"/>
    <input type="hidden" name="option" value="<?php echo $option; ?>"/>
    <input type="hidden" name="bid" value="<?php echo $bug->bug_id; ?>"/>
    <input type="hidden" name="cid" value="<?php echo $this->file->file_id; ?>"/>
</form>
<?php
}
}?>