<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_users/helpers/route.php';

JHtml::_('behavior.keepalive');
JHtml::_('bootstrap.tooltip');

?>


<div id="" class="k2LoginBlock">
	<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" name="login" id="form-login">
	  	<fieldset class="input">
		    <p id="form-login-username">
		      	<label for="modlgn_username"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME'); ?></label>
		      	<input id="modlgn-username" type="text" name="username" class="inputbox" tabindex="0" size="18" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" />
		    </p>
		    <p id="form-login-password">
		      	<label for="modlgn_passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
		      	<input id="modlgn-passwd" type="password" name="password" class="inputbox" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
		    </p>
		    <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
		    <p id="form-login-remember">
		      	<label for="modlgn_remember" class="checkbox"><?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?></label>
		      	<input id="modlgn_remember" name="remember" class="checkbox" value="yes" type="checkbox">
		    </p>
		    <?php endif;?>
		    <input name="Submit" class="button" value="<?php echo JText::_('JLOGIN') ?>" type="submit">
	  	</fieldset>
		<?php
			$usersConfig = JComponentHelper::getParams('com_users'); ?>
		<ul>
			<li>
				<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset&Itemid=' . UsersHelperRoute::getResetRoute()); ?>">
				<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
			</li>
			<li>
				<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind&Itemid=' . UsersHelperRoute::getRemindRoute()); ?>">
				<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
			</li>
		<?php if ($usersConfig->get('allowUserRegistration')) : ?>
			<li>
				<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration&Itemid=' . UsersHelperRoute::getRegistrationRoute()); ?>">
				<?php echo JText::_('MOD_LOGIN_REGISTER'); ?> <span class="icon-arrow-right"></span></a>
			</li>
		<?php endif; ?>
  		</ul>
	  
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.login" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>