=== Multiloquent ===
Contributors: localhost8080
Tags: block-editor-support, custom-colors, custom-menu, custom-header, featured-images, wide-blocks, post-formats, right-sidebar, two-columns, responsive-layout, accessibility-ready
Requires at least: 6.4
Tested up to: 6.7
Requires PHP: 8.1
Stable tag: 26.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A modern, block-editor-ready WordPress theme built with Tailwind CSS v4 and theme.json.

== Description ==

Multiloquent is a classic WordPress theme built for the modern block editor. It replaces Bootstrap and LESS with Tailwind CSS v4 and a comprehensive theme.json configuration that controls colours, typography and spacing in both the editor and the frontend.

The default look is **Forest & Cream** — a flat, warm design system (forest
green, cream, light green and dark green) with soft single-tone drop-shadows,
pill buttons, and a self-hosted Inter / Plus Jakarta Sans / JetBrains Mono
type system, inspired by huzzle.com. Six legacy **Neumorphism** (soft-UI)
colour variations remain available in the Styles panel.

Key features:

* Full Gutenberg block editor support (align-wide, wp-block-styles, responsive-embeds, appearance-tools)
* theme.json v3 — fluid typography, spacing scale, colour palette, element styles, shadow presets
* Seven style variations selectable in the Styles panel: Forest & Cream (default) plus six Neumorphism colour schemes (Blue/Green/Red × Light/Dark)
* Two bundled patterns — Hero (default scheme) and CTA Band (inverted forest-green scheme) — demonstrating both colour directions
* Self-hosted Google Fonts (Inter, Plus Jakarta Sans, JetBrains Mono) — no external font requests
* Slide-in sidebar navigation — accessible, keyboard-friendly, works on all viewport sizes
* Tailwind CSS v4 — zero framework lock-in, compiled from source
* Zero JavaScript dependencies — no jQuery, no Bootstrap JS
* Eight widget areas (sidebar top/primary/bottom, three footer columns, two advert areas)
* Featured posts grid on the homepage (integrates with Top 10 plugin)
* Compatible with Top 10 and Jetpack

== Installation ==

1. Upload the `multiloquent` directory to `/wp-content/themes/`
2. Activate the theme in Appearance → Themes
3. The theme includes a pre-built `assets/css/main.css` — no build step required for basic use

To build from source (recommended for customisation):

  npm install
  npm run build

== Colour Schemes ==

Seven style variations are available in Appearance → Editor → Styles:

* Forest & Cream (default) — Forest green primary, cream background, dark-green text; flat surfaces with soft drop-shadows and pill buttons
* Neumorphism — Blue Light / Blue Dark
* Neumorphism — Green Light / Green Dark
* Neumorphism — Red Light / Red Dark

The six Neumorphism variations are the classic soft-UI look (dual light/dark
shadows, every element the same colour as the page background). Each
variation overrides the full 14-colour semantic palette, gradients, and
duotone presets — see DESIGN.md for the full token reference and how the
default and Neumorphism skins share one compiled stylesheet.

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

= 26.2.0 =
* New default design system: "Forest & Cream" — replaces Neumorphism as the default look
* New default palette: Forest Green, Cream, Light Green, Dark Green (plus Gold/Terracotta/Danger accents)
* New default typography: self-hosted Inter (body), Plus Jakarta Sans (headings), JetBrains Mono (code, tag pills, breadcrumbs, captions) — no external font requests
* New soft single-tone drop-shadow system and pill-shaped buttons, replacing the dual-shadow neumorphic look site-wide by default
* Added "Inverted" button style (cream pill / dark-green text) for use on forest-green or dark-green section backgrounds
* Added two bundled patterns: "Hero — Forest & Cream" and "CTA Band — Forest Green (inverted)"
* The six Neumorphism colour variations remain fully selectable and unchanged in appearance
* Featured-image hero overlay (single/page templates) re-tinted from black to the theme's dark green

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
