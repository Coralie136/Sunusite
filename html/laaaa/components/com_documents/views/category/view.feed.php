<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_documents
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * HTML View class for the WebLinks component
 *
 * @package     Joomla.Site
 * @subpackage  com_documents
 * @since       1.0
 */
class DocumentsViewCategory extends JViewCategoryfeed
{
	/**
	 * @var    string  The name of the view to link individual items to
	 * @since  3.2
	 */
	protected $viewName = 'document';
}
