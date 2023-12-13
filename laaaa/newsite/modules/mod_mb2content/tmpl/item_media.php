<?php
/**
 * @package		Mb2 Content
 * @version		1.3.1
 * @author		Mariusz Boloz (http://marbol2.com)
 * @copyright	Copyright (C) 2013 Mariusz Boloz (http://marbol2.com). All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
**/

// no direct access
defined('_JEXEC') or die;

?>            
<div class="mb2-content-item-media">
	<div class="mb2-content-item-media-inner clearfix">
		<?php echo JHtml::_('itemedia.img_html', $item, $params, array('is_k2'=>$is_k2, 'uniqid'=>$uniqid));?>
	</div><!-- end .mb2-content-item-media-inner -->            
</div><!-- end .mb2-content-item-media -->