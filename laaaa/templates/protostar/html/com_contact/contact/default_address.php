<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * marker_class: Class based on the selection of text, none, or icons
 * jicon-text, jicon-none, jicon-icon
 */
?>

		<div class="map-wrapper">
			<div id="map">
				<div class="moduletable">
					<div class="mod-jgmap"
							id="map"
						style="width: 400px; height: 260px">
					</div>		
				</div>
			</div>
		</div>
		<div class="contact-contactinfo">
		</div>
		
		<div class="contact-miscinfo">
			<h3>Other information</h3>
			<div class="jicons-icons">
					<img src="/joomla_45490/media/contacts/images/con_info.png" alt="Other information: "  />
			</div>
			<div class="contact-misc">
					<p>
					<?php if ($this->contact->address && $this->params->get('show_street_address')) : ?>
						<span class="contact-street" itemprop="streetAddress">
							<?php echo $this->contact->address .'<br/>'; ?>
						</span>
					<?php endif; ?>
			
					<?php if ($this->contact->state && $this->params->get('show_state')) : ?>
						<span class="contact-state" itemprop="addressRegion">
							<?php echo $this->contact->state . '<br/>'; ?>
						</span>
					<?php endif; ?>
					<?php if ($this->contact->postcode && $this->params->get('show_postcode')) : ?>
						<span class="contact-postcode" itemprop="postalCode">
							<?php echo $this->contact->postcode .'<br/>'; ?>
						</span>
					<?php endif; ?>
					<?php if ($this->contact->suburb && $this->params->get('show_suburb')) : ?>
						<span class="contact-suburb" itemprop="addressLocality">
							<?php echo $this->contact->suburb .'  '; ?>
						</span>
					<?php endif; ?>
					<?php if ($this->contact->country && $this->params->get('show_country')) : ?>
						<span class="contact-country" itemprop="addressCountry">
							<?php echo $this->contact->country .'<br/>'; ?>
						</span>
					<?php endif; ?>

						
						<?php if ($this->contact->telephone && $this->params->get('show_telephone')) : ?>
							<span class="<?php echo $this->params->get('marker_class'); ?>" >
								<?php echo $this->params->get('marker_telephone'); ?>
							</span>
							<span class="contact-telephone" itemprop="telephone">
								<?php echo nl2br($this->contact->telephone); ?>
							</span>
						<?php endif; ?>
						<br /> 
						<?php if ($this->contact->fax && $this->params->get('show_fax')) : ?>
							<span class="<?php echo $this->params->get('marker_class'); ?>">
								<?php echo $this->params->get('marker_fax'); ?>
							</span>
							<span class="contact-fax" itemprop="faxNumber">
							<?php echo nl2br($this->contact->fax); ?>
							</span>
						<?php endif; ?>
						<br />					
						<?php if ($this->contact->email_to && $this->params->get('show_email')) : ?>
							<span class="<?php echo $this->params->get('marker_class'); ?>" itemprop="email">
								<?php echo nl2br($this->params->get('marker_email')); ?>
							</span>
							<span class="contact-emailto">
								<?php echo $this->contact->email_to; ?>
							</span>
						<?php endif; ?>
					</p>

			</div>
		</div>