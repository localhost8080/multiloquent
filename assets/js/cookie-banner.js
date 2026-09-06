/**
 * Multiloquent cookie banner
 *
 * Lightweight consent banner. The visitor's choice is reported through the
 * WP Consent API (https://wordpress.org/plugins/wp-consent-api/) — the
 * shared standard consent-aware plugins listen to — via the global
 * `wp_set_consent()` function that plugin exposes, when present. This lets
 * analytics, embeds, and other consent-aware scripts on the site react to
 * the same decision without a heavier consent-management plugin.
 */
(function () {
	'use strict';

	var banner = document.getElementById('multiloquent-cookie-banner');
	if (!banner) return;

	var STORAGE_KEY = 'multiloquent_cookie_consent';
	var CATEGORIES  = ['functional', 'preferences', 'statistics', 'statistics-anonymous', 'marketing'];

	function hasWpConsentApi() {
		return typeof window.wp_set_consent === 'function';
	}

	function setConsent(value) {
		if (hasWpConsentApi()) {
			CATEGORIES.forEach(function (category) {
				window.wp_set_consent(category, value);
			});
		}
		try {
			localStorage.setItem(STORAGE_KEY, value);
		} catch (e) {
			// localStorage unavailable (private mode, etc.) — the banner
			// simply reappears on the next page load.
		}
	}

	function getStoredConsent() {
		try {
			return localStorage.getItem(STORAGE_KEY);
		} catch (e) {
			return null;
		}
	}

	function hideBanner() {
		banner.hidden = true;
	}

	var acceptBtn  = banner.querySelector('.multiloquent-cookie-banner-accept');
	var declineBtn = banner.querySelector('.multiloquent-cookie-banner-decline');

	if (acceptBtn) {
		acceptBtn.addEventListener('click', function () {
			setConsent('allow');
			hideBanner();
		});
	}

	if (declineBtn) {
		declineBtn.addEventListener('click', function () {
			setConsent('deny');
			hideBanner();
		});
	}

	// Already decided on this browser? Don't show the banner again.
	if (!getStoredConsent()) {
		banner.hidden = false;
	}
})();
