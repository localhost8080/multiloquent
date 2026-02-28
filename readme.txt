=== Multiloquent ===
Contributors: localhost8080
Tags: block-editor-support, custom-colors, custom-menu, custom-header, featured-images, wide-blocks, post-formats, right-sidebar, two-columns, responsive-layout, accessibility-ready
Requires at least: 6.4
Tested up to: 6.7
Requires PHP: 8.1
Stable tag: 11.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A modern, block-editor-ready WordPress theme built with Tailwind CSS v4 and theme.json.

== Description ==

Multiloquent is a classic WordPress theme built for the modern block editor. It replaces Bootstrap and LESS with Tailwind CSS v4 and a comprehensive theme.json configuration that controls colours, typography and spacing in both the editor and the frontend.

Key features:

* Full Gutenberg block editor support (align-wide, wp-block-styles, responsive-embeds, appearance-tools)
* theme.json v3 — fluid typography, spacing scale, colour palette, element styles, shadow presets
* Five colour schemes selectable in the Styles panel (Default, Ocean, Forest, Ember, Midnight, Rose)
* Slide-in sidebar navigation — accessible, keyboard-friendly, works on all viewport sizes
* Tailwind CSS v4 — zero framework lock-in, compiled from source
* Zero JavaScript dependencies — no jQuery, no Bootstrap JS
* Eight widget areas (sidebar top/primary/bottom, three footer columns, two advert areas)
* Featured posts grid on the homepage (integrates with Top 10 plugin)
* Compatible with YARPP, Top 10, and Jetpack

== Installation ==

1. Upload the `multiloquent` directory to `/wp-content/themes/`
2. Activate the theme in Appearance → Themes
3. The theme includes a pre-built `assets/css/main.css` — no build step required for basic use

To build from source (recommended for customisation):

  npm install
  npm run build

== Colour Schemes ==

Six colour schemes are available in Appearance → Editor → Styles:

* Default — Classic blue primary, green secondary
* Ocean   — Cyan and teal, amber accent
* Forest  — Deep green primary, sky blue secondary
* Ember   — Warm orange-red, pink secondary
* Midnight — Indigo/violet palette, dark mode-ready
* Rose    — Pink primary, violet secondary

Each scheme overrides the full 12-colour semantic palette, gradients, and duotone presets.

== Widget Areas ==

* Sidebar Top — above the navigation in the slide-in sidebar
* Primary Sidebar — main sidebar widget area
* Sidebar Bottom — below the main sidebar area
* Footer Column 1 — first footer column
* Footer Column 2 — second footer column
* Footer Column 3 — third footer column
* Advert Primary — in-content advertisement area
* Advert Secondary — secondary in-content advertisement area

== Navigation Menus ==

* Primary Menu — appears in the slide-in sidebar
* Footer Menu — inline links in the site footer

== Customiser Options ==

Under Appearance → Customize → Multiloquent Settings:

* Featured posts display style — Tags, Excerpt, or None
* Sidebar position — Left or Right (desktop)

== Featured Posts ==

The homepage displays a featured posts grid sourced from:
1. Top 10 plugin (most-viewed posts, monthly) — if installed
2. Sticky posts — if any are set
3. Latest posts — fallback

== Plugin Compatibility ==

* YARPP (Yet Another Related Posts Plugin) — related posts auto-injected below single posts
* Top 10 — used as the data source for the homepage featured posts grid
* Jetpack — social sharing positioned correctly in posts

== Custom Page Templates ==

* Full Width — full-width post or page (no sidebar)
* Full Width No Header — full-width, no hero image or site footer
* Category Index — lists all categories in hierarchical order
* Tag Index — lists all tags alphabetically

== Development ==

Source: src/tailwind.css
Output: assets/css/main.css

Build commands:
  npm run build   — production build (minified)
  npm run dev     — watch mode

Colour schemes are defined in the styles/ directory.
To add a new scheme, copy an existing file and update the palette, gradients, and duotone arrays.

== Changelog ==

= 11.0.0 =
* Complete overhaul — Bootstrap/LESS replaced with Tailwind CSS v4
* Added theme.json v3 with full block editor configuration
* Added five colour scheme style variations (Ocean, Forest, Ember, Midnight, Rose)
* Added slide-in sidebar with full ARIA accessibility
* Added vanilla JS (zero dependencies) replacing jQuery/Bootstrap JS
* Added eight named widget areas
* Added two navigation menus (primary, footer)
* Added Customiser settings: featured style, sidebar position
* Removed Bootswatch theme switcher
* Removed Font Awesome (inline SVGs used instead)
* Requires WordPress 6.4+ and PHP 8.1+

= 10.2.0 =
* Bootstrap 4, MDB v4.7.7, and all Bootswatch themes
* 12 widget areas
* WordPress Customizer colour and Bootswatch theme controls

== Upgrade Notice ==

= 11.0.0 =
Major rewrite. Bootstrap, Font Awesome, and all LESS files have been removed.
Run `npm install && npm run build` after updating to generate full frontend CSS.
Widget area IDs have changed — reassign widgets in Appearance → Widgets.
