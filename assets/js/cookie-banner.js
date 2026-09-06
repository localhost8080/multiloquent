/**
 * Multiloquent cookie banner
 *
 * Lightweight consent banner with per-category defaults (Settings > Cookie
 * Banner). A category marked "enabled by default" runs on every page load
 * without waiting for a decision; any other category stays gated until a
 * visitor clicks Accept. Decisions are also reported through the WP Consent
 * API (https://wordpress.org/plugins/wp-consent-api/) via the global
 * `wp_set_consent()` function that plugin exposes, when present, so other
 * consent-aware plugins/scripts on the site respect the same choice.
 */
(function () {
	'use strict';

	var banner = document.getElementById('multiloquent-cookie-banner');
	if (!banner) return;

	var STORAGE_KEY = 'multiloquent_cookie_consent';
	var CATEGORIES  = ['functional', 'analytics', 'marketing'];
	var defaults    = (window.multiloquentConsent && window.multiloquentConsent.categories) || {};

	function hasWpConsentApi() {
		return typeof window.wp_set_consent === 'function';
	}

	function readStored() {
		try {
			return JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}');
		} catch (e) {
			return {};
		}
	}

	function writeStored(state) {
		try {
			localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
		} catch (e) {
			// localStorage unavailable (private mode, etc.) — the banner
			// simply reappears on the next page load.
		}
	}

	// Re-activates any gated <script type="text/plain"> tag for a category
	// (see multiloquent_cookie_scripts_output() in multiloquent-base.php)
	// by cloning it into a real, executing <script> element.
	function unblockScripts(category) {
		var blocked = document.querySelectorAll(
			'script[type="text/plain"][data-multiloquent-consent="' + category + '"]'
		);
		blocked.forEach(function (oldScript) {
			var newScript = document.createElement('script');
			Array.prototype.forEach.call(oldScript.attributes, function (attr) {
				if (attr.name !== 'type') newScript.setAttribute(attr.name, attr.value);
			});
			newScript.text = oldScript.text;
			oldScript.parentNode.replaceChild(newScript, oldScript);
		});
	}

	function grant(category) {
		if (hasWpConsentApi()) window.wp_set_consent(category, 'allow');
		unblockScripts(category);
	}

	function deny(category) {
		if (hasWpConsentApi()) window.wp_set_consent(category, 'deny');
	}

	function applyState(state) {
		CATEGORIES.forEach(function (category) {
			if (defaults[category] || state[category] === 'allow') {
				grant(category);
			} else {
				deny(category);
			}
		});
	}

	var stored  = readStored();
	var decided = Object.keys(stored).length > 0;

	// Default-enabled categories run on every page load, decided or not.
	applyState(stored);

	if (!decided) {
		banner.hidden = false;
	}

	function decide(value) {
		var state = {};
		CATEGORIES.forEach(function (category) {
			state[category] = defaults[category] ? 'allow' : value;
		});
		writeStored(state);
		applyState(state);
		banner.hidden = true;
	}

	var acceptBtn  = banner.querySelector('.multiloquent-cookie-banner-accept');
	var declineBtn = banner.querySelector('.multiloquent-cookie-banner-decline');

	if (acceptBtn) {
		acceptBtn.addEventListener('click', function () {
			decide('allow');
		});
	}

	if (declineBtn) {
		declineBtn.addEventListener('click', function () {
			decide('deny');
		});
	}
})();
