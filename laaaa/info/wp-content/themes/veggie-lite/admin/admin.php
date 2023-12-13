<?php

if (!defined('ABSPATH')) {
	exit;
}

/***** Welcome Notice in WordPress Dashboard *****/

if (!function_exists('veggie_lite_admin_notice')) {
	function veggie_lite_admin_notice() {
		global $pagenow, $veggie_lite_version;
		if (current_user_can('edit_theme_options') && 'index.php' === $pagenow && !get_option('veggie_lite_notice_welcome') || current_user_can('edit_theme_options') && 'themes.php' === $pagenow && isset($_GET['activated']) && !get_option('veggie_lite_notice_welcome')) {
			wp_enqueue_style('veggie-lite-admin-notice', get_template_directory_uri() . '/admin/admin-notice.css', array(), $veggie_lite_version);
			veggie_lite_welcome_notice();
		}
	}
}
add_action('admin_notices', 'veggie_lite_admin_notice');

/***** Hide Welcome Notice in WordPress Dashboard *****/

if (!function_exists('veggie_lite_hide_notice')) {
	function veggie_lite_hide_notice() {
		if (isset($_GET['veggie-lite-hide-notice']) && isset($_GET['_veggie_lite_notice_nonce'])) {
			if (!wp_verify_nonce($_GET['_veggie_lite_notice_nonce'], 'veggie_lite_hide_notices_nonce')) {
				wp_die(esc_html__('Action failed. Please refresh the page and retry.', 'veggie-lite'));
			}
			if (!current_user_can('edit_theme_options')) {
				wp_die(esc_html__('You do not have the necessary permission to perform this action.', 'veggie-lite'));
			}
			$hide_notice = sanitize_text_field($_GET['veggie-lite-hide-notice']);
			update_option('veggie_lite_notice_' . $hide_notice, 1);
		}
	}
}
add_action('wp_loaded', 'veggie_lite_hide_notice');

/***** Content of Welcome Notice in WordPress Dashboard *****/

if (!function_exists('veggie_lite_welcome_notice')) {
	function veggie_lite_welcome_notice() {
		global $veggie_lite_data; ?>
		<div class="notice notice-success veggie-welcome-notice">
			<a class="notice-dismiss veggie-welcome-notice-hide" href="<?php echo esc_url(wp_nonce_url(remove_query_arg(array('activated'), add_query_arg('veggie-lite-hide-notice', 'welcome')), 'veggie_lite_hide_notices_nonce', '_veggie_lite_notice_nonce')); ?>">
				<span class="screen-reader-text">
					<?php echo esc_html__('Dismiss this notice.', 'veggie-lite'); ?>
				</span>
			</a>
			<p><?php printf(esc_html__('Thanks for choosing Veggie Lite! To get started please make sure you visit our %2$swelcome page%3$s.', 'veggie-lite'), $veggie_lite_data['Name'], '<a href="' . esc_url(admin_url('themes.php?page=blog')) . '">', '</a>'); ?></p>
			<p><?php printf(esc_html__('Veggie Lite is proudly brought to you by Anariel Design. If you like the theme do us a favor and give it a 5-star rating on WordPress to help us spread the word.', 'veggie-lite')); ?><a href="<?php echo esc_url('https://wordpress.org/support/view/theme-reviews/veggie-lite?filter=5'); ?>">
				<?php esc_html_e('Rate This Theme', 'veggie-lite'); ?></a></p>
			<p class="veggie-welcome-notice-button">
				<a class="button" href="<?php echo esc_url(admin_url('themes.php?page=blog')); ?>">
					<?php printf(esc_html__('Get Started with Veggie Lite', 'veggie-lite'), $veggie_lite_data['Name']); ?>
				</a>
				<a class="button-primary" href="<?php echo esc_url('https://wordpress.org/support/view/theme-reviews/veggie-lite?filter=5'); ?>">
					<?php printf(esc_html__('Rate This Theme', 'veggie-lite'), $veggie_lite_data['Name']); ?>
				</a>
			</p>
		</div><?php
	}
}

/***** Theme Info Page *****/

if (!function_exists('veggie_lite_theme_info_page')) {
	function veggie_lite_theme_info_page() {
		add_theme_page(esc_html__('Welcome to Veggie Lite', 'veggie-lite'), esc_html__('Theme Info', 'veggie-lite'), 'edit_theme_options', 'blog', 'veggie_lite_display_theme_page');
	}
}
add_action('admin_menu', 'veggie_lite_theme_info_page');

if (!function_exists('veggie_lite_display_theme_page')) {
	function veggie_lite_display_theme_page() {
		global $veggie_lite_data; ?>
		<div class="theme-info-wrap">
			<h1>
				<?php printf(esc_html__('Welcome to Veggie Lite', 'veggie-lite')); ?>
			</h1>
			<div class="veggie-row theme-intro clearfix">
				<div class="veggie-col-1-4">
					<img class="theme-screenshot" src="<?php echo get_template_directory_uri(); ?>/screenshot.png" alt="<?php esc_html_e('Theme Screenshot', 'veggie-lite'); ?>" />
				</div>
				<div class="veggie-col-3-4 theme-description">
					<p class="about">
						<?php printf(esc_html__('Veggie Lite is a modern responsive theme whose sole focus is to present your content in the best possible way on any screen size. Beautiful typography combined with clean layout draws and keeps readers attention to the most important, your content. Veggie is a perfect match for fashion, lifestyle and magazine style sites.', 'veggie-lite')); ?>
					</p>
				</div>
			</div>

			<hr>
			<div class="theme-links clearfix">
				<p>
					<strong><?php esc_html_e('Important Links:', 'veggie-lite'); ?></strong>
					<a href="<?php echo esc_url('http://www.anarieldesign.com/free-food-recipes-wordpress-theme/'); ?>">
						<?php esc_html_e('Theme Info Page', 'veggie-lite'); ?>
					</a>
					<a href="<?php echo esc_url('https://wordpress.org/support/theme/veggie-lite'); ?>">
						<?php esc_html_e('Free Support Forum', 'veggie-lite'); ?>
					</a>
					<a href="<?php echo esc_url('http://www.anarieldesign.com/support/'); ?>">
						<?php esc_html_e('Membership Support Center', 'veggie-lite'); ?>
					</a>
					<a href="<?php echo esc_url('http://www.anarieldesign.com/showcase/'); ?>">
						<?php esc_html_e('Anariel Design Themes Showcase', 'veggie-lite'); ?>
					</a>
				</p>
			</div>
			<hr>
			<div id="getting-started" class="bg">
				<h3>
					<?php printf(esc_html__('Get Started with %s', 'veggie-lite'), $veggie_lite_data['Name']); ?>
				</h3>
				<div class="veggie-row clearfix">
					<div class="veggie-col-1-2">
						<div class="section">
							<h4>
								<span class="dashicons dashicons-welcome-learn-more"></span>
								<?php esc_html_e('Theme Documentation', 'veggie-lite'); ?>
							</h4>
							<p class="about">
								<?php printf(esc_html__('Please check the documentation to get better overview of how the theme is structured.', 'veggie-lite'), $veggie_lite_data['Name']); ?>
							</p>
							<p>
								<a href="<?php echo esc_url('http://www.anarieldesign.com/documentation/veggielite/'); ?>" class="button button-secondary">
									<?php esc_html_e('Theme Documentation', 'veggie-lite'); ?>
								</a>
								<a href="<?php echo esc_url('https://wordpress.org/support/theme/veggie-lite'); ?>" class="button button-secondary">
									<?php esc_html_e('Support Forum', 'veggie-lite'); ?>
								</a>
							</p>
						</div>
						<div class="section">
							<h4>
								<span class="dashicons dashicons-admin-appearance"></span>
								<?php esc_html_e('Theme Options', 'veggie-lite'); ?>
							</h4>
							<p class="about">
								<?php printf(esc_html__('Click "Customize" to open the Customizer.',  'veggie-lite'), $veggie_lite_data['Name']); ?>
							</p>
							<p>
								<a href="<?php echo admin_url('customize.php'); ?>" class="button button-secondary">
									<?php esc_html_e('Customize Theme', 'veggie-lite'); ?>
								</a>
							</p>
						</div>
					</div>
					<div class="veggie-col-1-2">
						<div class="section">
							<h4>
								<span class="dashicons dashicons-cart"></span>
								<?php esc_html_e('Veggie Pro', 'veggie-lite'); ?>
							</h4>
							<p class="about">
								<?php esc_html_e('Full version of this theme includes additional features; additional page templates, custom widgets, additional front page widgetized areas, different blog options, different theme options, WooCommerce support, color options & premium theme support.', 'veggie-lite'); ?>
							</p>
							<p>
								<a href="<?php echo esc_url('http://www.anarieldesign.com/themes/food-blog-wordpress-theme/'); ?>" class="button button-primary">
									<?php esc_html_e('Upgrade to Veggie Pro', 'veggie-lite'); ?>
								</a>
							</p>
						</div>
					</div>
				</div>
			</div>
			<hr>
			<div class="theme-comparison">
				<h3 class="theme-comparison-intro">
					<?php esc_html_e('Upgrade to Veggie for more awesome features:', 'veggie-lite'); ?>
				</h3>
				<table>
					<thead class="theme-comparison-header">
						<tr>
							<th class="table-feature-title"><h3><?php esc_html_e('Features', 'veggie-lite'); ?></h3></th>
							<th><h3><?php esc_html_e('Veggie Lite', 'veggie-lite'); ?></h3></th>
							<th><h3><?php esc_html_e('Veggie', 'veggie-lite'); ?></h3></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><h3><?php esc_html_e('Theme Price', 'veggie-lite'); ?></h3></td>
							<td><?php esc_html_e('Free', 'veggie-lite'); ?></td>
							<td>
								<a href="<?php echo esc_url('http://www.anarieldesign.com/pricing/'); ?>">
									<?php esc_html_e('View Pricing', 'veggie-lite'); ?>
								</a>
							</td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Responsive Layout', 'veggie-lite'); ?></h3></td>
							<td><span class="dashicons dashicons-yes"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Page Templates', 'veggie-lite'); ?></h3></td>
							<td><?php esc_html_e('3', 'veggie-lite'); ?></td>
							<td><?php esc_html_e('5', 'veggie-lite'); ?></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Front Page Widgetized Areas', 'veggie-lite'); ?></h3></td>
							<td><?php esc_html_e('1', 'veggie-lite'); ?></td>
							<td><?php esc_html_e('4', 'veggie-lite'); ?></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Custom Menus', 'veggie-lite'); ?></h3></td>
							<td><?php esc_html_e('2', 'veggie-lite'); ?></td>
							<td><?php esc_html_e('2', 'veggie-lite'); ?></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Custom Widgets', 'veggie-lite'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Different Blog Layouts', 'veggie-lite'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Different Theme Options', 'veggie-lite'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Different Blog Options', 'veggie-lite'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Premium Slider', 'veggie-lite'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('WooCommerce Support', 'veggie-lite'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Custom Plugins', 'veggie-lite'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Color Options', 'veggie-lite'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Extended Features', 'veggie-lite'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Support', 'veggie-lite'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><?php esc_html_e('Help Desk Ticketing System', 'veggie-lite'); ?></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>
								<a href="<?php echo esc_url('http://www.anarieldesign.com/themes/food-blog-wordpress-theme/'); ?>" class="upgrade-button">
									<?php esc_html_e('Upgrade to Veggie Pro', 'veggie-lite'); ?>
								</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<hr>
			<div class="section bg1">
				<h3>
					<?php esc_html_e('More Themes by Anariel Design', 'veggie-lite'); ?>
				</h3>
				<p class="about">
					<?php printf(esc_html__('Build Your Dream WordPress Site with Premium Niche Themes for Bloggers & Charities',  'veggie-lite'), $veggie_lite_data['Name']); ?>
				</p>
				<a href="<?php echo esc_url('http://www.anarieldesign.com/themes/'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/anarieldesign-themes.jpg" alt="<?php esc_html_e('Theme Screenshot', 'veggie-lite'); ?>" /></a>
				<p>
					<a href="<?php echo esc_url('http://www.anarieldesign.com/themes/'); ?>" class="button button-primary advertising">
						<?php esc_html_e('More Themes', 'veggie-lite'); ?>
					</a>
				</p>
			</div>
			<hr>
			<div id="theme-author">
				<p>
					<?php printf(esc_html__('%1$1s is proudly brought to you by %2$2s. If you like %3$3s: %4$4s.', 'veggie-lite'), $veggie_lite_data['Name'], '<a href="http://www.anarieldesign.com/" title="Anariel Design Themes">Anariel Design Themes</a>', $veggie_lite_data['Name'], '<a href="https://wordpress.org/support/view/theme-reviews/veggie-lite?filter=5" title="Veggie Lite Review">' . esc_html__('Rate this theme', 'veggie-lite') . '</a>'); ?>
				</p>
			</div>
		</div><?php
	}
}

?>