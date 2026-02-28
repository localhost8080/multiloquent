# Multiloquent

A modern, block-editor-ready WordPress theme built with Tailwind CSS v4.

## Overview

Multiloquent is a classic WordPress theme that fully embraces the modern block editor. It replaces the old Bootstrap/LESS stack with Tailwind CSS v4 and a comprehensive `theme.json` configuration, giving you fine-grained control over colours, typography and spacing — both in the editor and on the frontend.

## Requirements

| Requirement   | Minimum  |
|---------------|----------|
| WordPress     | 6.4      |
| PHP           | 8.1      |
| Node.js       | 18+      |

## Quick start

```bash
npm install
npm run build   # production build (minified)
npm run dev     # watch mode
```

The build compiles `src/tailwind.css` → `assets/css/main.css`. A minimal placeholder `main.css` is committed so the theme activates without a build step, but you should run the build for full styles.

## Features

### Block editor

- Full Gutenberg/block editor support
- `align-wide` and `align-full` blocks
- `wp-block-styles` (opinionated core block styles)
- Responsive embeds
- Editor stylesheet — Tailwind output injected into the block editor
- `appearance-tools` — border, padding, margin, colour controls in the editor

### theme.json

- **Colour palette** — 12 semantic colour tokens (primary, secondary, accent, base, contrast, muted, surface, surface-alt, border, danger)
- **Fluid typography** — 6 size steps, min/max clamped
- **Spacing scale** — 9 preset sizes
- **Layout** — content width 780 px, wide width 1200 px
- **Element styles** — headings, links, buttons, code, quote, separator
- **Shadow presets** — Natural, Deep, Sharp
- **Aspect ratio presets** — Square, Standard, Portrait, Classic, Wide, Ultra-wide

### Colour schemes (Style Variations)

Five built-in colour schemes selectable in **Appearance → Editor → Styles**:

| Scheme       | Primary     | Flavour                    |
|--------------|-------------|----------------------------|
| **Default**  | Blue        | Classic blue/green          |
| **Ocean**    | Cyan/Teal   | Cool ocean blues            |
| **Forest**   | Green       | Deep natural greens         |
| **Ember**    | Orange/Red  | Warm earthy tones           |
| **Midnight** | Indigo      | Dark mode-ready purples     |
| **Rose**     | Pink        | Soft pink/violet            |

Each variation ships in `styles/<name>.json` and overrides the full colour palette, gradients, and duotone presets.

### Layout

- Fixed top navbar with site name and desktop search
- Slide-in sidebar (all viewports) — accessible with ARIA attributes, Escape key close, overlay tap to close
- Sidebar contains: primary navigation, three widget areas
- Three-column footer widget area
- Footer navigation menu

### JavaScript

Zero framework dependencies. `assets/js/theme.js` handles:

- Sidebar toggle with ARIA-expanded state
- Keyboard accessibility (Escape to close)
- Submenu disclosure buttons for nested nav items
- Current-page link highlighting
- Smooth scroll for same-page anchors

### Widget areas

| ID                | Location                         |
|-------------------|----------------------------------|
| `sidebar-top`     | Sidebar — above navigation       |
| `sidebar-primary` | Sidebar — main area              |
| `sidebar-bottom`  | Sidebar — below main area        |
| `footer-col-1`    | Footer — first column            |
| `footer-col-2`    | Footer — second column           |
| `footer-col-3`    | Footer — third column            |
| `advert-primary`  | In-content advert area           |
| `advert-secondary`| Secondary in-content advert area |

### Navigation menus

| Location        | Description                    |
|-----------------|--------------------------------|
| `primary-menu`  | Slide-in sidebar menu          |
| `footer-menu`   | Inline footer links            |

### Customiser options

Under **Appearance → Customize → Multiloquent Settings**:

- **Featured posts display style** — Tags, Excerpt, or None
- **Sidebar position** — Left or Right (desktop)

### Featured posts

The homepage shows a featured posts grid. Posts are sourced from:

1. [Top 10 plugin](https://wordpress.org/plugins/top-10/) — most-viewed posts (monthly), if installed
2. Sticky posts — if any are set
3. Latest posts — fallback

### Post templates

| Template file                          | Description                                  |
|----------------------------------------|----------------------------------------------|
| `single.php`                           | Default single post                          |
| `page.php`                             | Static page                                  |
| `template-full-width-single.php`       | Full-width post (no sidebar)                 |
| `template-full-width-no-header-single.php` | Full-width, no hero image or footer     |
| `template-category-index.php`          | Lists all categories in hierarchy            |
| `template-tag-index.php`               | Lists all tags alphabetically                |

### Plugin compatibility

| Plugin | Integration |
|--------|-------------|
| [YARPP](https://wordpress.org/plugins/yet-another-related-posts-plugin/) | Related posts auto-injected at bottom of single posts |
| [Top 10](https://wordpress.org/plugins/top-10/) | Used as data source for the featured posts grid |
| [Jetpack](https://wordpress.org/plugins/jetpack/) | Social sharing positioned correctly in post |

## Development

### Tailwind v4

Source: `src/tailwind.css`
Output: `assets/css/main.css`

Design tokens are defined in the `@theme` block:

```css
@theme {
  --color-primary:      oklch(52% 0.22 264);
  --color-secondary:    oklch(62% 0.16 150);
  --width-sidebar:      18rem;
  /* … */
}
```

Custom component classes (`.entry-card`, `.tag-label`, `.pagination-link`, `.entry-content`, etc.) are defined in the same file after the `@theme` block.

### Adding a new colour scheme

1. Copy `styles/ocean.json` to `styles/your-name.json`
2. Set the `"title"` field
3. Update the `"palette"` array — all 12 colour slugs must be present
4. Update `"gradients"` and `"duotone"` to match
5. Activate in **Appearance → Editor → Styles**

### File structure

```
multiloquent/
├── src/
│   └── tailwind.css          # Tailwind v4 source
├── assets/
│   ├── css/main.css          # Compiled output (committed)
│   └── js/theme.js           # Vanilla JS
├── styles/                   # Colour scheme variations
│   ├── ocean.json
│   ├── forest.json
│   ├── ember.json
│   ├── midnight.json
│   └── rose.json
├── theme.json                # Block editor settings & styles
├── style.css                 # WordPress theme header only
├── functions.php             # Theme bootstrap
├── multiloquent-base.php     # Core theme class
├── header.php / footer.php / sidebar.php
├── index.php / home.php / single.php / page.php / archive.php / search.php / 404.php
├── template-*.php            # Custom page templates
└── package.json              # Build scripts
```

## Licence

GNU General Public License v2 or later — see [LICENSE](LICENSE)
