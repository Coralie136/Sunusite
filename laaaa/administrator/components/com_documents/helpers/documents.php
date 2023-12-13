<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_documents
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Documents helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_documents
 * @since       1.6
 */
class DocumentsHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public static function addSubmenu($vName = 'documents')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_DOCUMENTS_SUBMENU_DOCUMENTS'),
			'index.php?option=com_documents&view=documents',
			$vName == 'documents'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_DOCUMENTS_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_documents',
			$vName == 'categories'
		);
	}
}
