<?php
/**
 * @package		Mb2 Content
 * @version		1.3.1
 * @author		Mariusz Boloz (http://marbol2.com)
 * @copyright	Copyright (C) 2013 Mariusz Boloz (http://marbol2.com). All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
**/



defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_content/helpers/route.php';
JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

abstract class modMb2contentHelper{
	
	/**
	 * 
	 * Method to get article list
	 * 
	 */
	public static function getList(&$params, $format = 'html') {

		// Get the dbo
		$db = JFactory::getDbo();
		
		// Get an instance of the generic articles model
		$model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
		
		// Set application parameters in model
		$app = JFactory::getApplication();
		$appParams = $app->getParams();
		$model->setState('params', $appParams);
		
		// Set the filters based on the module params
		$model->setState('list.start', 0);
		$model->setState('list.limit', (int) $params->get('count', 5));
		$model->setState('filter.published', 1);
		
		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);
		
		// Category filter
		$model->setState('filter.category_id', $params->get('catid', array()));
		
		// User filter
		$userId = JFactory::getUser()->get('id');
		switch ($params->get('user_id'))
		{
			case 'by_me':
				$model->setState('filter.author_id', (int) $userId);
				break;
			case 'not_me':
				$model->setState('filter.author_id', $userId);
				$model->setState('filter.author_id.include', false);
				break;
		
			case '0':
				break;
		
			default:
				$model->setState('filter.author_id', (int) $params->get('user_id'));
				break;
		}
		
		// Filter by language
		$model->setState('filter.language', $app->getLanguageFilter());
		
		//  Featured switch
		switch ($params->get('show_featured'))
		{
			case '1':
				$model->setState('filter.featured', 'only');
				break;
			case '0':
				$model->setState('filter.featured', 'hide');
				break;
			default:
				$model->setState('filter.featured', 'show');
				break;
		}
		
		// Set ordering
		$order_map = array(
			'm_dsc' => 'a.modified DESC, a.created',
			'mc_dsc' => 'CASE WHEN (a.modified = '.$db->quote($db->getNullDate()).') THEN a.created ELSE a.modified END',
			'c_dsc' => 'a.created',
			'p_dsc' => 'a.publish_up',
			'most_popular' => 'a.hits',
		);
		$ordering = JArrayHelper::getValue($order_map, $params->get('ordering'), 'a.publish_up');
		$dir = 'DESC';
		
		$model->setState('list.ordering', $ordering);
		$model->setState('list.direction', $dir);
		
		$items = $model->getItems();
		
		foreach ($items as &$item) {
			$item->slug = $item->id.':'.$item->alias;
			$item->catslug = $item->catid.':'.$item->category_alias;
		
			if ($access || in_array($item->access, $authorised)) {
				// We know that user has the privilege to view the article
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
			} else {
				$item->link = JRoute::_('index.php?option=com_users&view=login');
			}
			
			// Change category title to categoyt name
			$item->categoryname = $item->category_title; 	
			
			// Define intro image, alt and caption text
			$item->image = json_decode($item->images)->image_intro;
			$item->image_alt = json_decode($item->images)->image_intro_alt;
			$item->image_caption = json_decode($item->images)->image_intro_caption;
			
			// Get category link
			$item->categoryLink = JRoute::_(ContentHelperRoute::getCategoryRoute($item->catslug));
			
		}
		
		return $items;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * 
	 * Method to get module styles and scripts
	 * 
	 */
	public static function before_head(&$params, $attribs)
	{
		
		
		// Basic variables
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
		
				
		
		// Load javascript framework
		if (version_compare(JVERSION,'3.0','>'))
		{			
			JHtml::_('jquery.framework', false);			
		}
		else
		{
			
			// Load jquery and jquery noConflict for Joomla 2.5
			$params->get('jquery', 1) == 1 ? 
			$doc->addScript('https://ajax.googleapis.com/ajax/libs/jquery/' . $params->get('jquery_version', '1.8.3') . '/jquery.min.js') : '';
						
			$params->get('no_conflict', 1) == 1 ? $doc->addScript(JURI::base(true) . '/modules/mod_mb2content/js/jquery.noConflict.js') : '';
			
		}		
		
						
		
		// Nivo lightbox style and script are loaded when: 
		// 1. Style and script are not loading from other extenson or template
		// 2. Image lightbox parameters is set as true
		// 3. Image link is set as link to big image or link to big image and post
		if (!modMb2contentHelper::is_script('nivo-lightbox.min.js') && $params->get('lightbox_image', 1) == 1 && ($params->get('thumb_link', 0) == 1) || $params->get('thumb_link', 0) == 3)
		{
			
			// Style
			$doc->addStyleSheet(JURI::base(true) . '/modules/mod_mb2content/css/nivo-lightbox/nivo-lightbox.css');
			$doc->addStyleSheet(JURI::base(true) . '/modules/mod_mb2content/css/nivo-lightbox/themes/default/default.css');
			
			// Script
			$doc->addScript(JURI::base(true) . '/modules/mod_mb2content/js/nivo-lightbox.min.js');
			
		}		
		
		
		
		
		
		// Get carousel script will load if:
		// 1. Module carousel is enabled
		// 2. Items count is bigger than item columns
		// 3. Scripts are not load by other extensons	
		$carousel = ($params->get('carousel_on', 0) == 1 && $attribs['carousel']);		
		
		if ($carousel)
		{			
			
			// Check if carousel script is not loaded by other extension
			if (!modMb2contentHelper::is_script('jquery.carouFredSel-packed.js'))
			{
				$doc->addScript(JURI::base(true) . '/modules/mod_mb2content/js/jquery.carouFredSel-packed.js');
			}			
			
			if ($params->get('carousel_touch', 1) == 1)
			{				
				
				// Check if touchSwipe script is not loaded by other extension
				if (!modMb2contentHelper::is_script('jquery.touchSwipe.min.js'))
				{
					$doc->addScript(JURI::base(true). '/modules/mod_mb2content/js/jquery.touchSwipe.min.js');
				}
				
			}		
			
		}
		
				
		
		
		
		// Get module style		
		$doc->addStyleSheet(JURI::base() . 'templates/protostar/css/caroufredsel.css');
		
		
		// Get module script
		$doc->addScript(JURI::base() . '/modules/mod_mb2content/js/mb2content.js');
		
		
		
		
		// Inline styles		
		$inl_style = modMb2contentHelper::layout($params, $attribs);
		$inl_style .= modMb2contentHelper::inline_style($params, $attribs);
		
		$doc->addStyleDeclaration($inl_style);
		
			 
		 
		 
		 
	}
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * 
	 * Method to get module styles and scripts
	 * 
	 */
	public static function inline_style(&$params, $attribs)
	{
		
		
		// Basic variables
		$output = '';		
		$pref = '.mb2-content-' . $attribs['mod_id'];
		
		
		
		
		// Active color
		if ($params->get('active_color', '') !='')
		{
			
			$output .= $pref . ' .content-img:hover .mark a,'; 
			$output .= $pref . ' .mb2-content-nav .prev:hover,'; 
			$output .= $pref . ' .mb2-content-nav .prev:focus,'; 
			$output .= $pref . ' .mb2-content-nav .next:hover,'; 
			$output .= $pref . ' .mb2-content-nav .next:focus,';
			$output .= $pref . ' .mb2-content-nav .pager a.selected,'; 
			$output .= $pref . ' .content-img:hover .img-border,'; 
			$output .= $pref . ' .mb2-content-img-caption'; 
			
			// style
			$output .= '{background-color:' . $params->get('active_color', '') . ';}';
			
		}
		
		
		
		
		// Text color
		if ($params->get('color', '') !='')
		{			
			$output .= $pref . '{color:' . $params->get('color', '') . ';}'; 			
		}
		
		
		
		
		// Links color
		if ($params->get('link_color', '') !='' || $params->get('link_hover_color', '') !='')
		{
			
			// Normal liks
			$params->get('link_color', '') !='' ? $output .= $pref . ' a{color:' . $params->get('link_color', '') . ';}' : ''; 
			
			// Hover links
			$params->get('link_hover_color', '') !='' ? 
			$output .= $pref . ' a:hover{color:' . $params->get('link_hover_color', '') . ';}' .
			$pref . ' a:active{color:' . $params->get('link_hover_color', '') . ';}' .
			$pref . ' a:focus{color:' . $params->get('link_hover_color', '') . ';}' : 
			'';
						
		}
		
		
		
		
		// Title color
		if ($params->get('title_color', '') !='')
		{
			
			$output .= $pref . ' .mb2-content-item-title,'; 
			$output .= $pref . ' .mb2-content-item-title a'; 
			
			// Style
			$output .= '{color: ' . $params->get('title_color', '') . ';}'; 			
			
		}		
		
		
		
		
		// Meta color
		if ($params->get('meta_color', '') !='')
		{			
			$output .= $pref . ' .mb2-content-item-meta{color:' . $params->get('meta_color', '') . ';}';
		}
		
		
		
		// Custom css
		if ($params->get('custom_css', '') !='')
		{
			
			$output .= $params->get('custom_css', '');
		}
		
		
		
		
		return $output; 	
		
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * 
	 * Method to check if items are display within carousel
	 * 
	 */
	public static function items_carousel($items, $params)
	{
				
		
		// Basic variables
		$i=0;
		$caron = $params->get('carousel_on', 0);
		$cols = $params->get('cols', 4);	
		
		
		$carousel = ($caron == 1 && count($items)>$cols);
		
		
		if($carousel)
		{
			return true;			
		}
		else		
		{			
			return false;	
		}
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * 
	 * Method to get carousel class
	 * 
	 */
	public static function carousel_cls($items, $params, $attribs)
	{
				
			
		$carousel = modMb2contentHelper::items_carousel($items, $params, $attribs);
				
		return $carousel ? $attribs['pos'] : $attribs['neg'];		
		
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * 
	 * Method to get carousel data attribute
	 * 
	 */
	public static function carousel_data($items, $params, $attribs)
	{
				
		
		// Basic variables
		$output = '';	
		$carousel = modMb2contentHelper::items_carousel($items, $params, $attribs);		
		$cols = $params->get('cols', 4);
		
		
		
		if ($carousel)
		{			
			$data_itemmax = ' data-itemmax="' . $cols . '"';
			$data_duration = ' data-duration="' . $params->get('carousel_pause_time', 7000) . '"';
			$data_scroll = ' data-scroll="' . $params->get('carousel_scroll', 1) . '"';
			$data_touch = ' data-touch="' . $params->get('carousel_touch', 1) . '"';
			$data_play = ' data-play="' . $params->get('carousel_auto', 1) . '"';
			$data_id = ' data-id="' . $attribs['uniqid'] . '"';
			$output .= $data_itemmax . $data_duration . $data_scroll . $data_touch . $data_play . $data_id;			
		}
		
		
		return $output;
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * 
	 * Method to get carousel navigation
	 * 
	 */
	public static function carousel_nav($items, $params, $attribs)
	{
				
		
		// Basic variables	
		$carousel = modMb2contentHelper::items_carousel($items, $params, $attribs);
		$output = '';
		$prev = '';
		$next = '';
		
		
		if ($carousel)
		{
			
			
			// Carousel direct nav
			if ($params->get('carousel_direct_nav', 1) == 1)
			{
				$prev = 'prev: \'#mb2-content-prev-' . $attribs['uniqid'] . '\',';
				$next = 'next: \'#mb2-content-next-' . $attribs['uniqid'] . '\',';				
			}			
			
			
			// Carousel control nav
			$params->get('carousel_control_nav', 0) == 1 ? $pager = 'pagination: \'#mb2-content-pager-' . $attribs['uniqid'] . '\',' : $pager = '';	
			
			
			// Create carousel navigation
			if ($params->get('carousel_direct_nav', 1) == 1 || $params->get('carousel_control_nav', 0) == 1)
			{				
				
				$output .= '<div class="mb2-content-nav"><div class="mb2-content-nav-inner">';				
				
				if ($params->get('carousel_control_nav', 0) == 1)
				{					
					$output .= '<div id="mb2-content-pager-' . $attribs['uniqid'] . '" class="pager"></div><!-- end .mb2-content-pager -->';
				}
								
				
				if ($params->get('carousel_direct_nav', 1) == 1)
				{
					$output .= '<a id="mb2-content-prev-' . $attribs['uniqid'] . '" class="prev" href="#"><i class="mb2content-fa mb2content-fa-angle-double-left"></i></i></a>';
					$output .= '<a id="mb2-content-next-' . $attribs['uniqid'] . '" class="next" href="#"><i class="mb2content-fa mb2content-fa-angle-double-right"></i></a>';					
				}			
				
				$output .= '</div><!-- end .mb2-portfolio-content-nav-inner --></div><!-- end .mb2-content-carousel-nav -->';				
			}			
		}
		
		return $output;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * 
	 * Method to get module layout
	 * 
	 */
	public static function layout($params, $attribs)
	{
		
		
		// Basic variables
		$output = '';
		$module_container = '.mb2-content-' . $attribs['mod_id']; 
	
	
		// Module container style
		$container_width = (100 + (2*$params->get('margin_lr', 1)));
		$container_margin_left = -$params->get('margin_lr', 1);	
		
		$output .= $module_container . '{width:' . $container_width . '%;margin-left:' . $container_margin_left . '%;}';
				
		
		
		//content item core style
		$item_width = ((100/$params->get('cols', 4))-((2*$params->get('margin_lr', 1))+0.05));
		
		$output .= $module_container . ' .mb2-content-item';
		$output .= '{width:' . $item_width . '%;margin-left:' . $params->get('margin_lr', 1) . '%;margin-right:' . $params->get('margin_lr', 1) . '%;margin-bottom:' . $params->get('margin_b', 30) . 'px;}';
			
		
		
		
		//carousel layout-----------------
		$module_container_c = $module_container . '.is-carousel';
		
			
		//calculate margin left and right for carousel items
		if($params->get('margin_lr', 1) == 0){
			$c_item_margin_lr = 0;	
		}
		elseif($params->get('margin_lr', 1) > 0 && $params->get('margin_lr', 1) < 1.1){
			$c_item_margin_lr = 10;		
		}
		elseif($params->get('margin_lr', 1) > 1.1 && $params->get('margin_lr', 1) < 1.9){
			$c_item_margin_lr = 15;
		}
		elseif($params->get('margin_lr', 1) > 1.9){
			$c_item_margin_lr = 23;
		}	
		
		
		
		$c_item_width = (100/$params->get('cols', 4));
		
		$output .= $module_container_c .'{margin-left:-' . $c_item_margin_lr . 'px;}';
		
		$output .= $module_container_c .' .mb2-content-item';
		$output .= '{width:' . $c_item_width . '%;margin-left:0;margin-right:0;}';
		
		$output .= $module_container_c .' .mb2-content-item-inner';
		$output .= '{margin-left:' . $c_item_margin_lr . 'px;margin-right:' . $c_item_margin_lr . 'px;}';
		
		$output .= $module_container_c .' .mb2-content-nav';
		$output .= '{right:' . $c_item_margin_lr . 'px;}';
		
		$output .= $module_container_c .' .mb2-content-nav .pager';
		$output .= '{right:' . ($c_item_margin_lr + 42) . 'px;}';	
		//--------------------------------
		
		
		
		
		//style for module item elements (media and description)		
		$params->get('item_layout', 'media-above') == 'media-right' ? $item_parts_float = 'right' : $item_parts_float = 'left';
		
			
		if($params->get('item_layout', 'media-above') == 'media-left' || $params->get('item_layout', 'media-above') == 'media-right'){		
			$item_media_width = $params->get('media_width', 50);		
			$item_desc_width = 100 - $item_media_width;			
		}
		else{		
			$item_media_width = 100;
			$item_desc_width = 100;		
		}	
			
		
		
		$output .= $module_container .' .mb2-content-item-media';
		$output .= '{width:' . $item_media_width . '%;float:' . $item_parts_float . ';}';
		
		$output .= $module_container .' .mb2-content-item-deatils';
		$output .= '{width:' . $item_desc_width . '%;float:' . $item_parts_float . ';}';	
		
		
		
		
		
		
		
		
		return $output;	
		
		
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 *
	 * Method to check loading script
	 *
	 */	
	public static function is_script($script)
	{
		
		
		// Core Joomla variables
		$doc = JFactory::getDocument();
		$scriptsarr = $doc->_scripts;
		
		
		foreach ($scriptsarr as $key=>$s)
		{			
			
			if (preg_match('@' . $script . '@', $key))
			{				
				return true;				
			}
			else
			{				
				return false;	
			}		
		}	
		
		
		
	}
	
	
	
	
	
	
	
	 
	
	
	
	
	
	
	
	
	
	
	
	
}