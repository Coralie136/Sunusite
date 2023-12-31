<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');

if (isset($this->error)) : ?>
	<div class="contact-error">
		<?php echo $this->error; ?>
	</div>
<?php endif; ?>

<div class="contact-form">
	<form id="contact-form" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-validate">
		<fieldset>
			<legend><?php echo JText::_('COM_CONTACT_FORM_LABEL'); ?></legend>
			<dl>
				<dt><?php echo $this->form->getLabel('contact_name'); ?></dt>
				<dd><?php echo $this->form->getInput('contact_name'); ?></dd>
				<dt><?php echo $this->form->getLabel('contact_email'); ?></dt>
				<dd><?php echo $this->form->getInput('contact_email'); ?></dd>
				<dt><?php echo $this->form->getLabel('contact_subject'); ?></dt>
				<dd><?php echo $this->form->getInput('contact_subject'); ?></dd>
				<dt><?php echo $this->form->getLabel('contact_message'); ?></dt>
				<dd><?php echo $this->form->getInput('contact_message'); ?></dd>
				<?php if ($this->params->get('show_email_copy')) : ?>
					<dt class="emailCopy"><?php echo $this->form->getLabel('contact_email_copy'); ?></dt>
					<dd class="emailCopy"><?php echo $this->form->getInput('contact_email_copy'); ?></dd>
				<?php endif; ?>						     			          			     			          			               			               			                    			                         			                    			               			          			     				<dt></dt>
				<dd>
					<button class="button validate" type="submit"><?php echo JText::_('COM_CONTACT_CONTACT_SEND'); ?></button>
					<input type="hidden" name="option" value="com_contact" />
					<input type="hidden" name="task" value="contact.submit" />
					<input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />
					<input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>" />
					<?php echo JHtml::_('form.token'); ?>
				</dd>
			</dl>
		</fieldset>
	</form>
</div>

