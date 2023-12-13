<?php
/*
* @version $Id: default_bug.php,v 1.3 2008/12/08 12:26:10 Vlado Exp $
* @package JotLoader
* @copyright (C) 2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
global $Itemid;
?>
<script>
    function markEdit(pos) {
        document.getElementById("chng" + pos).value="1";
    }
</script>		<H3>Bug informations edit</H3>
<form action="<?php echo $this->sefRelToAbsX('index.php?option=' . $option . '&section=bugs&task=save&cid=' . $this->file->file_id . '&Itemid=' . $Itemid);
?>" method="POST">
    <table width="100%" border="0" cellpadding="10"><tr>
            <td>Download file</td>
            <td width="80%"><?php echo $this->file->file_title;
?></td>
        </tr><tr>
            <td colspan="2">&nbsp;</td>
        </tr><tr>
            <td>Bug title</td>
            <td><input type="text" name="bug_title" value="<?php echo $this->bug->bug_title;
?>" size="80" onChange="document.getElementById('title_chng').value=1;"></td>
        </tr><tr>
            <td>Bug description</td>
            <td><textarea cols="60" rows="5" name="bug_desc" id="bug_desc" onChange="document.getElementById('desc_chng').value=1;"><?php echo $this->bug->bug_desc;
?></textarea></td></tr>
        <?php
        $cnt = 0;
foreach($this->comments as $comment){
$cnt++;
echo '<tr><td>Comment#' . $cnt . '</td><td><textarea cols="60" rows="5" onChange="markEdit(' . $comment->comment_id . ');" name="comment_' . $comment->comment_id . '">' . $comment->comment_desc . '</textarea><input type="hidden" id="chng' . $comment->comment_id . '" name="chng' . $comment->comment_id . '" value=""></td></tr>';
}?>
    </table>
    <input type="submit" name="save" value="Save">
    <input type="reset" name="reset" value="Reset">
    <input type="hidden" name="title_chng" id="title_chng" value=""/>
    <input type="hidden" name="desc_chng" id="desc_chng" value=""/>
    <input type="hidden" name="task" value="save"/>
    <input type="hidden" name="section" value="bugs"/>
    <input type="hidden" name="option" value="<?php echo $option; ?>"/>
    <input type="hidden" name="bid" value="<?php echo $this->bug->bug_id;
?>"/>
    <input type="hidden" name="cid" value="<?php echo $this->file->file_id;
?>"/>
</form><br/><br/>
