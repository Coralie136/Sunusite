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
 * Document controller class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_documents
 * @since       1.6
 */
class DocumentsControllerDocument extends JControllerForm
{
	/**
	 * Method override to check if you can add a new record.
	 *
	 * @param   array  $data  An array of input data.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowAdd($data = array())
	{
		$user = JFactory::getUser();
		$categoryId = JArrayHelper::getValue($data, 'catid', $this->input->getInt('filter_category_id'), 'int');
		$allow = null;

		if ($categoryId)
		{
			// If the category has been passed in the URL check it.
			$allow = $user->authorise('core.create', $this->option . '.category.' . $categoryId);
		}

		if ($allow === null)
		{
			// In the absense of better information, revert to the component permissions.
			return parent::allowAdd($data);
		}
		else
		{
			return $allow;
		}
	}

	/**
	 * Method to check if you can add a new record.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		$recordId = (int) isset($data[$key]) ? $data[$key] : 0;
		$categoryId = 0;

		if ($recordId)
		{
			$categoryId = (int) $this->getModel()->getItem($recordId)->catid;
		}

		if ($categoryId)
		{
			// The category has been set. Check the category permissions.
			return JFactory::getUser()->authorise('core.edit', $this->option . '.category.' . $categoryId);
		}
		else
		{
			// Since there is no asset tracking, revert to the component permissions.
			return parent::allowEdit($data, $key);
		}
	}

	/**
	 * Method to run batch operations.
	 *
	 * @param   object  $model  The model.
	 *
	 * @return  boolean   True if successful, false otherwise and internal error is set.
	 *
	 * @since   1.7
	
	public function batch($model = null)
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Set the model
		$model = $this->getModel('Document', '', array());

		// Preset the redirect
		$this->setRedirect(JRoute::_('index.php?option=com_documents&view=documents' . $this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}
 	*/
	public function batch($model = null)
	{
	
		// Lire le fichier
	
	
		if (!$fp = fopen("/home/amoise/Bureau/Decret2014.csv","r")) {
			echo "Echec de l'ouverture du fichier";
	
			exit;
		}
	
		else {
			$file = new SplFileObject('/home/amoise/Bureau/Decret2014.csv', 'r'); //lecture du fichier
			$file->setFlags(SplFileObject::READ_CSV);
			$file->setCsvControl(";", "", "\\");
	
			foreach($file as $ligne)
			{
				$model = $this->getModel('document', '', array());
				$data = JFactory::getApplication()->getUserState('com_documents.edit.document.data', array());
	
				if (empty($data))
				{
					// Prime some default values.
					$data['title'] = $ligne[0];
					//$data['description'] = $ligne[1];
					//$data['created'] = $ligne[2];//substr($ligne[2], 6, 4)."-".substr($ligne[2], 3, 2)."-".substr($ligne[2], 0, 2);
					//$data['catid'] = $cid;//$ligne[3];
					$data['url'] = $ligne[4];
					
					$model->save($data);
					//echo $data[url], $data[title], $data['description'];
				}
			}
	
			fclose($fp);
		}
	
		// Preset the redirect
		$this->setRedirect(JRoute::_('index.php?option=com_documents&view=documents' . $this->getRedirectToListAppend(), false));
	
		return parent::batch($model);
	}
	
	/**
	 * Function that allows child controller access to model data after the data has been saved.
	 *
	 * @param   JModelLegacy  $model      The data model object.
	 * @param   array         $validData  The validated data.
	 *
	 * @return	void
	 *
	 * @since	1.6
	 */
	protected function postSaveHook(JModelLegacy $model, $validData = array())
	{
		$task = $this->getTask();

		if ($task == 'save')
		{
			$this->setRedirect(JRoute::_('index.php?option=com_documents&view=documents', false));
		}
	}
}
