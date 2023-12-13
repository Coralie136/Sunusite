<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class modhdArticleHelper
{
	static function getTheArticle(&$params)
	{
		$app	= JFactory::getApplication();
		$db		= JFactory::getDbo();

		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));

		// Get an instance of the generic articles model
//		$model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
//		$db 	=& JFactory::getDBO();
		$artid 	= (int) $params->get('artid', 1);
		$query = 'SELECT a.* ' .
			' FROM #__content AS a' .
			' WHERE a.id = '. (int) $artid;
		
		$db->setQuery($query); 
		$items = $db->loadObjectList();
		
		if ($db->getErrorNum()) {JError::raiseWarning( 500, $db->stderr() );}
		
		foreach ($items as &$item) {
			$item->readmore = strlen(trim($item->fulltext));
			$item->slug = $item->id.':'.$item->alias;
			// $item->catslug = $item->catid.':'.$item->category_alias;

			if ($access || in_array($item->access, $authorised))
			{
				// We know that user has the privilege to view the article
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid));
				$item->linkText = JText::_('MOD_ARTICLES_NEWS_READMORE');
			}
			else {
				$item->link = JRoute::_('index.php?option=com_users&view=login');
				$item->linkText = JText::_('MOD_ARTICLES_NEWS_READMORE_REGISTER');
			}

			$item->introtext = JHtml::_('content.prepare', $item->introtext, '', 'mod_articles_news.content');
			$item->introtext = preg_replace('/<img[^>]*>/', '', $item->introtext);
				
		}
		return $items;
	}
}
