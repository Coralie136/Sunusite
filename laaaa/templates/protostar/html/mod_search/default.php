<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_search
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>




                                <!--form action="/joomla_45490/index.php/blog" method="post">
	<div class="mod_search ">
		<label for="mod-search-searchword"> </label>
		
		<input name="searchword" id="mod-search-searchword" maxlength="20"  class="inputbox" type="text" size="20" value=" "  onblur="if (this.value=='') this.value=' ';" onfocus="if (this.value==' ') this.value='';" />
		
		<input type="submit" value="Search" class="button" onclick="this.form.searchword.focus();"/>	
		<input type="hidden" name="task" value="search" />
		<input type="hidden" name="option" value="com_search" />
		<input type="hidden" name="Itemid" value="117" />
	</div>
</form-->


            
            
            

	<form action="<?php echo JRoute::_('index.php');?>" method="post" class="form-inline">
		<div class="mod_search ">
			<?php
				//$output = '<label for="mod-search-searchword" class="element-invisible"></label> '; //' . $label . '
				$output .= '<input name="searchword" id="mod-search-searchword" maxlength="' . $maxlength . '"  class="inputbox search-query" type="text" size="' . $width . '" value="' . $text . '"  onblur="if (this.value==\'\') this.value=\'' . $text . '\';" onfocus="if (this.value==\'' . $text . '\') this.value=\'\';" />';
	
				if ($button) :
					if ($imagebutton) :
						$btn_output = ' <input type="image" value="' . $button_text . '" class="button" src="' . $img . '" onclick="this.form.searchword.focus();"/>';
					else :
						$btn_output = ' <button class="button btn btn-primary" onclick="this.form.searchword.focus();">' . $button_text . '</button>';
					endif;
	
					switch ($button_pos) :
						case 'top' :
							$output = $btn_output . '<br />' . $output;
							break;
	
						case 'bottom' :
							$output .= '<br />' . $btn_output;
							break;
	
						case 'right' :
							$output .= $btn_output;
							break;
	
						case 'left' :
						default :
							$output = $btn_output . $output;
							break;
					endswitch;
	
				endif;
	
				echo $output;
			?>
			<input type="hidden" name="task" value="search" />
			<input type="hidden" name="option" value="com_search" />
			<input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
		</div>
	</form>
