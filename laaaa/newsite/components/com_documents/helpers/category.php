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
 * Documents Component Category Tree
 *
 * @static
 * @package     Joomla.Site
 * @subpackage  com_documents
 * @since       1.6
 */
class DocumentsCategories extends JCategories
{
	public function __construct($options = array())
	{
		$options['table'] = '#__documents';
		$options['extension'] = 'com_documents';
		parent::__construct($options);
	}
}
