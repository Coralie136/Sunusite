/* Add theme related links to theme customizer */

(function($) {
	if ('undefined' !== typeof veggie_links) {

		// Add Upgrade Notice
		upgrade = $('<a class="veggie-upgrade-link"></a>')
			.attr('href', veggie_links.upgradeURL)
			.attr('target', '_blank')
			.text(veggie_links.upgradeLabel);

		$('.preview-notice').append(upgrade);

		// Theme Links
		box = $('<div class="veggie-theme-links-wrap"></div>');

		title = $('<h3 class="veggie-theme-links-title"></h3>')
			.text(veggie_links.title);

		themePage = $('<a class="veggie-theme-link veggie-theme-link-info"></a>')
			.attr('href', veggie_links.themeURL)
			.attr('target', '_blank')
			.text(veggie_links.themeLabel);

		themeDocu = $('<a class="veggie-theme-link veggie-theme-link-docs"></a>')
			.attr('href', veggie_links.docsURL)
			.attr('target', '_blank')
			.text(veggie_links.docsLabel);

		themeSupport = $('<a class="veggie-theme-link veggie-theme-link-support"></a>')
			.attr('href', veggie_links.supportURL)
			.attr('target', '_blank')
			.text(veggie_lite_links.supportLabel);

		themeRate = $('<a class="veggie-theme-link veggie-theme-link-rate"></a>')
			.attr('href', veggie_links.rateURL)
			.attr('target', '_blank')
			.text(veggie_links.rateLabel);

		// Add Theme Links
		links = box.append(title).append(themePage).append(themeDocu).append(themeSupport).append(themeRate);

		setTimeout(function() {
			$('#accordion-panel-veggie_theme_options .control-panel-content').append(links);
		}, 2000);

		// Remove accordion click event
		$('.veggie-upgrade-link, .veggie-theme-link').on('click', function(e) {
			e.stopPropagation();
		});

	}
})(jQuery);