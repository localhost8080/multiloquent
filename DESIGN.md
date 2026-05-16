# Multiloquent — Neumorphism Design System

## Design Philosophy

**Neumorphism** (soft UI): every element shares the same colour as the page background and appears to emerge from — or recede into — the surface via dual-shadow lighting. A white/light highlight hits from the top-left and a darker shadow falls to the bottom-right. There are no visible borders; depth is created entirely by shadows.

- Raised elements (cards, buttons, pills, images): `box-shadow: dark bottom-right, light top-left`
- Inset elements (inputs, blockquotes, code): `box-shadow: inset dark, inset light`
- Background = element background colour — nothing is a different colour from the surface except the highlight accent

---

## Colour System

### Design tokens (CSS custom properties)

| Token                   | Role                                                                  |
|-------------------------|-----------------------------------------------------------------------|
| `--color-primary`       | **Highlight / accent** — the ONLY colour that changes between themes  |
| `--color-primary-dark`  | Hover / pressed state of primary                                      |
| `--color-primary-light` | Subtle tints, dark-theme hover                                        |
| `--color-secondary`     | Supporting accent                                                     |
| `--color-accent`        | Warm highlight (amber)                                                |
| `--color-danger`        | Error / destructive actions                                           |
| `--color-base`          | **Page background AND element background** — always the same value    |
| `--color-contrast`      | Body text                                                             |
| `--color-muted`         | Secondary text, placeholders, meta lines                              |
| `--color-surface`       | Synonym for base (same value, kept for WP block compatibility)        |
| `--color-surface-alt`   | Slightly darker recessed areas (image placeholders, etc.)             |
| `--color-border`        | Subtle dividers — rarely used since shadows carry all depth signals   |
| `--color-shadow-light`  | **Top-left highlight**: white on light themes, lighter shade on dark  |
| `--color-shadow-dark`   | **Bottom-right shadow**: grey on light themes, deep shade on dark     |

All 14 tokens are registered as WordPress palette entries (`slug` in `theme.json`) so every style variation can override them cleanly.

### Neumorphic shadow shorthands

Defined in `:root` — they reference the shadow colour tokens and automatically update when a variation is applied.

```css
--nm-raised      6px  dual shadow  /* cards, images, buttons, pills */
--nm-raised-lg   10px dual shadow  /* hover state elevation increase */
--nm-raised-sm   3px  dual shadow  /* small tag pills */
--nm-inset       4px  inset        /* input fields, blockquotes, code */
--nm-inset-sm    2px  inset        /* inline code, tight insets */
```

---

## Theme Variations

Six style variations live in `styles/`. Switch between them under **Appearance → Editor → Styles** in WordPress.

The **highlight colour** (`primary`, `primary-dark`, `primary-light`) is the **only** difference between variations of the same brightness. All structural and surface tokens (base, shadow, contrast…) are shared within the same light/dark family.

### Light family — base `#e0e5ec` (classic neumorphic grey)

| File                           | Title                     | Primary    | Shadow Light | Shadow Dark |
|--------------------------------|---------------------------|------------|--------------|-------------|
| `neumorphism-blue-light.json`  | Neumorphism — Blue Light  | `#4488ff`  | `#ffffff`    | `#a3b1c6`   |
| `neumorphism-green-light.json` | Neumorphism — Green Light | `#22cc66`  | `#ffffff`    | `#a3b1c6`   |
| `neumorphism-red-light.json`   | Neumorphism — Red Light   | `#ee4444`  | `#ffffff`    | `#a3b1c6`   |

### Dark family — base is a deep, tinted dark grey

| File                          | Title                    | Primary    | Base       | Shadow Light | Shadow Dark |
|-------------------------------|--------------------------|------------|------------|--------------|-------------|
| `neumorphism-blue-dark.json`  | Neumorphism — Blue Dark  | `#4488ff`  | `#2a2d3e`  | `#3a4060`    | `#1a1d2c`   |
| `neumorphism-green-dark.json` | Neumorphism — Green Dark | `#22cc66`  | `#1e2a26`  | `#2d4838`    | `#111a14`   |
| `neumorphism-red-dark.json`   | Neumorphism — Red Dark   | `#ee4444`  | `#2e2020`  | `#422e2e`    | `#1a1212`   |

The base `theme.json` palette defaults to **Blue Light**.

### Highlight colour values

| Name  | Primary    | Primary Dark | Primary Light |
|-------|------------|--------------|---------------|
| Blue  | `#4488ff`  | `#2266dd`    | `#77aaff`     |
| Green | `#22cc66`  | `#11994d`    | `#55dd88`     |
| Red   | `#ee4444`  | `#cc2222`    | `#ff7777`     |

---

## Typography

### Font families

| Slug     | Name              | Stack                                                                                                      | Use                           |
|----------|-------------------|------------------------------------------------------------------------------------------------------------|-------------------------------|
| `system` | System Sans-Serif | `-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif`             | All UI and body text (default)|
| `serif`  | Serif             | `Georgia, "Times New Roman", serif`                                                                        | Editorial / long-form         |
| `mono`   | Monospace         | `"Fira Code", "Fira Mono", "Cascadia Code", Consolas, monospace`                                           | Code blocks                   |

No web font loading required — resolves to the OS-native UI font.

### Font size scale (fluid)

| Token slug    | Size (fluid range)    | Usage                   |
|---------------|-----------------------|-------------------------|
| `small`       | `0.875rem` (fixed)    | Captions, meta text     |
| `medium`      | `1rem` (fixed)        | Body copy — **default** |
| `large`       | `1.0625 → 1.125rem`   | Lead paragraph          |
| `x-large`     | `1.25 → 1.5rem`       | H3, sub-headings        |
| `xx-large`    | `1.5 → 2.25rem`       | H2, post titles         |
| `xxx-large`   | `2 → 3rem`            | H1, hero titles         |

Body `line-height: 1.7`. Heading `line-height: 1.25`. Heading `font-weight: 700`.

---

## Component Shadow Reference

| Component           | Style       | Variable        | Description                      |
|---------------------|-------------|-----------------|----------------------------------|
| Archive cards       | Raised      | `--nm-raised`   | 6px dual shadow                  |
| Cards (hover)       | Raised lg   | `--nm-raised-lg`| 10px — increases on hover        |
| Tag pills           | Raised sm   | `--nm-raised-sm`| 3px — small pill shadow          |
| Tag pills (hover)   | Inset sm    | `--nm-inset-sm` | Pressed state on hover           |
| Buttons             | Raised      | `--nm-raised`   | Same surface colour as page      |
| Buttons (hover)     | Raised lg   | `--nm-raised-lg`| Lifts more on hover              |
| Buttons (active)    | Inset       | `--nm-inset`    | Pressed into surface             |
| Input fields        | Inset       | `--nm-inset`    | Carved into background           |
| Input focus         | Inset + ring| —               | Inset + 2px primary colour ring  |
| Blockquotes         | Inset       | `--nm-inset`    | Recessed quote panel             |
| Code blocks         | Inset       | `--nm-inset`    | Recessed code panel              |
| Inline code         | Inset sm    | `--nm-inset-sm` | Tight inline inset               |
| Comments            | Raised sm   | `--nm-raised-sm`| Subtle card lift                 |
| Content images      | Raised      | `--nm-raised`   | Images float off the surface     |
| Hero image frame    | Raised      | `--nm-raised`   | Neumorphic frame around image    |
| Site header         | Directional | (custom)        | `0 4px 8px dark, 0 -2px 4px light` — bottom only |
| Footer              | Inset top   | (custom)        | `inset 0 4px 10px dark` — carved in |

---

## Archive Card Layout

Cards were restructured from a full-bleed image overlay to a two-section neumorphic card.

**Before (old):** image covered the full card, title and tags appeared as an overlay on top of the image.

**After (new):** image sits in the upper zone, tags and title appear BELOW the image in the card body — never overlaid on photography.

```
┌────────────────────────────┐  ←  .archive-card (nm-raised shadow)
│                            │
│      [Featured Image]      │  ←  .archive-card-image  (no overlay, no filter)
│                            │
├────────────────────────────┤
│  [tag]  [tag]              │  ←  .archive-card-tags (pill pills, nm-raised-sm)
│  Post Title Here           │  ←  .archive-card-title
│  1 Jan 2026 — Author Name  │  ←  .archive-card-meta (muted colour)
└────────────────────────────┘
```

The **hero card** (first post) spans 2 grid columns on desktop and has a taller image zone (22rem vs 12rem).

---

## Spacing Scale

| Slug | Size     |
|------|----------|
| 10   | 0.25 rem |
| 20   | 0.50 rem |
| 30   | 0.75 rem |
| 40   | 1.00 rem |
| 50   | 1.50 rem |
| 60   | 2.00 rem |
| 70   | 3.00 rem |
| 80   | 4.50 rem |
| 90   | 6.00 rem |

---

## Layout

| Token         | Value    |
|---------------|----------|
| Content width | 1000 px  |
| Wide width    | 1600 px  |
| Sidebar width | 18 rem   |

---

## Build

```bash
npm install          # install @tailwindcss/cli
npm run build        # compile src/tailwind.css → assets/css/main.css (minified)
npm run dev          # watch mode during development
```

Compiled `assets/css/main.css` is committed so the theme works on zero-build WordPress hosts.

---

## Adding a New Highlight Colour

1. Copy any `styles/neumorphism-*-light.json` (for a light variation).
2. Update `"title"`.
3. Change `primary`, `primary-dark`, and `primary-light` to the new colour values.
4. Keep all other tokens identical to the original light/dark template.
5. No CSS changes required — shadow variables inherit automatically from the colour tokens.

## Neumorphism Rules Checklist

- [ ] Every element background equals `--color-base` (= page background)
- [ ] No borders — depth from shadows only
- [ ] Raised elements: `box-shadow: Xpx Xpx Ypx shadow-dark, -Xpx -Xpx Ypx shadow-light`
- [ ] Inset elements: same but with `inset`
- [ ] Hover increases shadow distance (raised) or adds ring (inputs)
- [ ] Active/pressed state uses inset shadow
- [ ] Only `--color-primary` departs from the greyscale palette
- [ ] Background is never white — use the neumorphic grey or dark base
