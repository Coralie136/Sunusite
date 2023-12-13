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
 * Document Component HTML Helper
 *
 * @static
 * @package     Joomla.Site
 * @subpackage  com_documents
 * @since       1.5
 */
class JHtmlIcon
{
	public static function create($document, $params)
	{
		JHtml::_('bootstrap.tooltip');

		$uri = JUri::getInstance();
		$url = JRoute::_(DocumentsHelperRoute::getFormRoute(0, base64_encode($uri)));
		$text = JHtml::_('image', 'system/new.png', JText::_('JNEW'), null, true);
		$button = JHtml::_('link', $url, $text);
		$output = '<span class="hasTooltip" title="' . JHtml::tooltipText('COM_DOCUMENTS_FORM_CREATE_DOCUMENT') . '">' . $button . '</span>';
		return $output;
	}

	public static function edit($document, $params, $attribs = array())
	{
		$uri = JUri::getInstance();

		if ($params && $params->get('popup'))
		{
			return;
		}

		if ($document->state < 0)
		{
			return;
		}

		JHtml::_('bootstrap.tooltip');

		$url	= DocumentsHelperRoute::getFormRoute($document->id, base64_encode($uri));
		$icon	= $document->state ? 'edit.png' : 'edit_unpublished.png';
		$text	= JHtml::_('image', 'system/'.$icon, JText::_('JGLOBAL_EDIT'), null, true);

		if ($document->state == 0)
		{
			$overlib = JText::_('JUNPUBLISHED');
		}
		else
		{
			$overlib = JText::_('JPUBLISHED');
		}

		$date = JHtml::_('date', $document->created);
		$author = $document->created_by_alias ? $document->created_by_alias : $document->author;

		$overlib .= '&lt;br /&gt;';
		$overlib .= $date;
		$overlib .= '&lt;br /&gt;';
		$overlib .= htmlspecialchars($author, ENT_COMPAT, 'UTF-8');

		$button = JHtml::_('link', JRoute::_($url), $text);

		$output = '<span class="hasTooltip" title="' . JHtml::tooltipText('COM_DOCUMENTS_EDIT') . ' :: ' . $overlib . '">' . $button . '</span>';

		return $output;
	}
}
