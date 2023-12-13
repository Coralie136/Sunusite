<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_documents
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('DocumentsHelper', JPATH_ADMINISTRATOR . '/components/com_documents/helpers/documents.php');
JLoader::register('CategoryHelperAssociation', JPATH_ADMINISTRATOR . '/components/com_categories/helpers/association.php');

/**
 * Documents Component Association Helper
 *
 * @package     Joomla.Site
 * @subpackage  com_documents
 * @since       3.0
 */
abstract class DocumentsHelperAssociation extends CategoryHelperAssociation
{
	/**
	 * Method to get the associations for a given item
	 *
	 * @param   integer  $id    Id of the item
	 * @param   string   $view  Name of the view
	 *
	 * @return  array   Array of associations for the item
	 *
	 * @since  3.0
	 */

	public static function getAssociations($id = 0, $view = null)
	{
		jimport('helper.route', JPATH_COMPONENT_SITE);

		$app = JFactory::getApplication();
		$jinput = $app->input;
		$view = is_null($view) ? $jinput->get('view') : $view;
		$id = empty($id) ? $jinput->getInt('id') : $id;

		if ($view == 'category' || $view == 'categories')
		{
			return self::getCategoryAssociations($id, 'com_documents');
		}

		return array();

	}
}
