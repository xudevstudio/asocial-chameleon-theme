/**
 * File: assets/js/customizer.js
 * Theme Customizer enhancements for a better user experience.
 */

(function ($) {
	// Hero Height - Live Preview
	wp.customize('hero_banner_height', function (value) {
		value.bind(function (newval) {
			$('.hero-banner').css('height', newval + 'px');
		});
	});

	// Background Vertical Position - Live Preview
	wp.customize('hero_banner_bg_pos_y', function (value) {
		value.bind(function (newval) {
			$('.hero-bg-animated').css('background-position', 'center ' + newval + '%');
		});
	});

	// Banner Width - Live Preview
	wp.customize('hero_banner_width', function (value) {
		value.bind(function (newval) {
			$('.hero-banner').css('width', newval + '%');
		});
	});

	// Background Size Mode
	wp.customize('hero_banner_bg_size', function (value) {
		value.bind(function (newval) {
			$('.hero-bg-animated').css('background-size', newval);
		});
	});

	// --- Hero Content ---
	wp.customize('hero_title_text', function (value) {
		value.bind(function (newval) {
			$('.hero-title').text(newval);
		});
	});

	wp.customize('hero_subtitle_text', function (value) {
		value.bind(function (newval) {
			$('.hero-subtitle').text(newval);
		});
	});

	wp.customize('hero_btn_text', function (value) {
		value.bind(function (newval) {
			$('.hero-button').text(newval);
		});
	});

	wp.customize('hero_btn_url', function (value) {
		value.bind(function (newval) {
			var url = newval;
			if (!url) { url = '#'; } // fallback strictly for preview
			$('.hero-button').attr('href', url);
		});
	});

	// --- Logo & Header ---

	// Logo Width (Desktop)
	wp.customize('logo_width_desktop', function (value) {
		value.bind(function (newval) {
			// Only affect desktop view in preview if possible, or just general selector
			$('.logo-image').not('.mobile-logo').css('width', newval + 'px');
		});
	});

	// Logo Width (Mobile)
	wp.customize('logo_width_mobile', function (value) {
		value.bind(function (newval) {
			$('.mobile-logo').css('width', newval + 'px');
		});
	});

})(jQuery);
