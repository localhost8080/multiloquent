/**
 * Multiloquent cookie banner
 *
 * Lightweight consent banner with per-category defaults (Settings > Cookie
 * Banner). A category marked "enabled by default" is also asserted straight
 * from PHP on every request (see multiloquent_cookie_apply_default_consent()
 * in multiloquent-base.php) — this client-side pass mainly covers the
 * "waiting on a decision" categories, decided here via Accept/Decline. Every
 * decision is reported through the WP Consent API
 * (https://wordpress.org/plugins/wp-consent-api/) via the global
 * `wp_set_consent()` function that plugin exposes, when present, so other
 * consent-aware plugins (e.g. Site Kit by Google) respect the same choice
 * without this theme having to load any tracking script itself.
 */
(function () {
	'use strict';

	var banner = document.getElementById('multiloquent-cookie-banner');
	if (!banner) return;

	var STORAGE_KEY = 'multiloquent_cookie_consent';
	var CATEGORIES  = ['functional', 'analytics', 'marketing'];
	var defaults    = (window.multiloquentConsent && window.multiloquentConsent.categories) || {};
	// Maps our own category keys to the WP Consent API's standard category
	// names (e.g. our "analytics" is its "statistics") — see
	// multiloquent_cookie_category_consent_map() in multiloquent-base.php.
	var consentMap  = (window.multiloquentConsent && window.multiloquentConsent.consentMap) || {};

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
		if (hasWpConsentApi()) window.wp_set_consent(consentMap[category] || category, 'allow');
		unblockScripts(category);
	}

	function deny(category) {
		if (hasWpConsentApi()) window.wp_set_consent(consentMap[category] || category, 'deny');
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
