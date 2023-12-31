<?php

/**
* @copyright	Copyright (C) 2012 JoomSpirit. All rights reserved.
* Slideshow based on the JQuery script Flexslider
* @license		GNU General Public License version 2 or later
*/

defined('_JEXEC') or die;
jimport('joomla.filesystem.folder');

$target	= $params->get('target');

class ModFlexsliderHelper{
	
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
		
		// Filter by language
		$model->setState('filter.language', $app->getLanguageFilter());
		
		//  Featured switch
		switch ($params->get('show_featured')) {
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
			//$item->image_caption = json_decode($item->images)->image_intro_caption;
			$caption = explode(" ", json_decode($item->images)->image_intro_caption);
			$premier = array_shift($caption);
			while ($premier == '') {
				$premier = array_shift($caption);
			}
			$item->image_caption = '<span>'.$premier.'</span> ' . implode(" ", $caption);
	
			// Get category link
			$item->categoryLink = JRoute::_(ContentHelperRoute::getCategoryRoute($item->catslug));
		}
		
		return $items;

	}
	
	
	
}