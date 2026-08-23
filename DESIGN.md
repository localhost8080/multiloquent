# Multiloquent — Design System

## Design Philosophy

The default theme is **Forest & Cream**: flat, warm surfaces, soft single-tone
drop-shadows, and pill-shaped buttons — inspired by huzzle.com's forest-green
and cream palette. Six legacy **Neumorphism** colour variations (soft-UI,
dual-shadow) ship alongside it and remain fully selectable in
**Appearance → Editor → Styles** — see "Two design languages, one stylesheet"
below for how both coexist in one compiled stylesheet.

- Cards, buttons, pills and inputs each have their own surface colour —
  they no longer have to match the page background.
- Depth comes from a single soft, warm-tinted drop-shadow (colour-mixed from
  the theme's dark-green tone), not a dual light/dark neumorphic carve.
- Buttons are fully-rounded pills; cards use a generous ~1.25rem radius.
- Small labels (tag pills, breadcrumbs, post meta, stat captions) use a
  monospace type treatment — uppercase, letter-spaced — as a deliberate
  "technical label vs. human headline" contrast, echoing huzzle.com's UI.

---

## Colour System

### The four core colours

| Colour            | Hex       | Role                                                          |
|--------------------|-----------|----------------------------------------------------------------|
| **Cream**          | `#FEFBEA` | Main page background                                          |
| **Forest Green**    | `#2E6F40` | Buttons, links, pills, primary accents                        |
| **Dark Green**      | `#15321D` | Body text; also selectable as a section/hero background       |
| **Light Green**     | `#E6EEE8` | Card/pill backgrounds, alternating section background          |

Every one of these is a real `theme.json` palette entry (not just a CSS
token), so an editor can apply any of the four directly to a Group block's
background via the block editor's colour picker — that's how the bundled
"CTA Band" pattern gets its solid forest-green section, and how a future
section could use Dark Green or Light Green as its background instead.

### Full design-token palette (CSS custom properties)

| Token                   | Name (in the editor) | Hex       | Role                                              |
|-------------------------|-----------------------|-----------|----------------------------------------------------|
| `--color-primary`       | Forest Green          | `#2E6F40` | Buttons, links, pill text                          |
| `--color-primary-dark`  | Forest Green Dark     | `#1E482A` | Hover / pressed state of primary                   |
| `--color-primary-light` | Light Green           | `#E6EEE8` | Pill/badge backgrounds, footer text on dark green   |
| `--color-secondary`     | Gold                  | `#8C6B26` | Supporting accent (editor palette only)            |
| `--color-accent`        | Terracotta            | `#A35022` | Warm accent (editor palette only)                  |
| `--color-danger`        | Danger                | `#B3402B` | Error / destructive actions                        |
| `--color-base`          | Cream                 | `#FEFBEA` | Page background; button text on primary            |
| `--color-contrast`      | Dark Green            | `#15321D` | Body text; footer background; hero overlay tint    |
| `--color-muted`         | Muted Green           | `#677865` | Secondary text, captions, placeholders             |
| `--color-surface`       | Surface               | `#F2F6F4` | Card backgrounds (near-white, cool green cast)     |
| `--color-surface-alt`   | Surface Alt           | `#D5E2D9` | Image placeholders, deeper recessed areas          |
| `--color-border`        | Border                | `#DEE8E0` | Hairline dividers, input borders                   |
| `--color-shadow-light`  | Shadow Light          | `#FFFFFF` | Unused by the default skin; kept for the neumorphic variations |
| `--color-shadow-dark`   | Shadow Dark            | `#15321D` | Tint source for the default skin's soft shadows; neumorphic dark shadow colour |

All 14 tokens are registered as WordPress palette entries (`slug` in
`theme.json`) so every style variation can override them cleanly — exactly
as before.

### The "alternate"/inverted scheme

The brief for this redesign was: *cream background + dark-green text is the
default, but a section can flip to forest-green background + cream button +
dark-green button text.* Two building blocks make that a one-click option
for an editor rather than hand-written CSS:

1. Set any Group block's background colour to **Forest Green** (or **Dark
   Green**) directly from the block editor's colour picker.
2. Apply the **"Inverted"** button style (Buttons block → Styles panel) to
   get a cream pill with dark-green text — the normal button style would
   otherwise render forest-green-on-forest-green and disappear.

The bundled **"CTA Band — Forest Green (inverted)"** pattern
(`patterns/cta-band.php`) demonstrates both at once. The **"Hero — Forest &
Cream"** pattern (`patterns/hero.php`) demonstrates the normal (non-inverted)
scheme: cream background, dark-green heading, forest-green highlight and CTA.

---

## Two design languages, one stylesheet

`src/tailwind.css` never hardcodes a shadow shape or a card/button/pill
colour directly. Instead every shadow and every interactive surface reads
from a small set of **skin tokens**:

```
--shadow-sm / --shadow-md / --shadow-lg / --shadow-inset / --shadow-inset-sm
--card-bg / --card-radius
--button-bg / --button-text / --button-bg-hover / --button-text-hover / --button-radius / --button-shadow-active
--pill-bg / --pill-text / --pill-text-hover / --pill-shadow / --pill-shadow-active
--input-bg / --input-border / --input-shadow / --input-radius
```

These tokens are **not** defined in the compiled stylesheet — they live
entirely in `theme.json`'s top-level `styles.css` (WordPress's "Additional
CSS" mechanism):

- The base `theme.json` defines them once, as the **Forest & Cream** flat
  defaults (single soft `color-mix()` drop-shadows, pill buttons, cards on
  `--color-surface`, etc.).
- Each of the six `styles/neumorphism-*.json` variations re-declares the
  *same token names* with the classic dual-shadow neumorphic formulas
  (`6px 6px 12px dark, -6px -6px 12px light`, background always equal to the
  page background, etc.), built from that variation's own palette colours.

WordPress merges a style variation's `styles.css` as a **full replacement**
of the base theme's — a deterministic swap resolved by WordPress's own
theme.json merge, not a browser cascade race between two separately-enqueued
stylesheets. That's what makes it safe: whichever variation is active, its
values always win, regardless of stylesheet load order. Every component
rule in `src/tailwind.css` only ever *reads* these tokens with `var(...)` —
it never branches on which skin is active.

This is why the six neumorphism files still look and behave exactly as
before (soft-UI, same-colour-as-background, dual light/dark shadows) even
though the shared component CSS underneath was rewritten for the new
default look.

---

## Typography

### Font families (self-hosted, no external requests)

| Slug      | Name              | Stack                                                      | Use                                  |
|-----------|-------------------|-------------------------------------------------------------|----------------------------------------|
| `system`  | Inter             | `'Inter', -apple-system, BlinkMacSystemFont, ...`           | Body copy, UI text — **default**       |
| `heading` | Plus Jakarta Sans | `'Plus Jakarta Sans', 'Inter', ...`                          | Headings, post titles                  |
| `serif`   | Serif             | `Georgia, "Times New Roman", serif`                         | Editorial / long-form (opt-in)         |
| `mono`    | JetBrains Mono    | `'JetBrains Mono', 'Fira Code', ...`                        | Code, tag pills, breadcrumbs, captions |

All three self-hosted families (Inter, Plus Jakarta Sans, JetBrains Mono)
are free on Google Fonts. Woff2 files live in `assets/fonts/<family>/` and
are registered via `theme.json`'s `fontFace` mechanism (`file:./assets/…`) —
no `fonts.googleapis.com` request happens at runtime, matching this theme's
"no framework/service lock-in" ethos and avoiding GDPR/privacy concerns with
directly linking Google's font CDN. Only the latin subset is bundled to keep
the payload small (~220 KB across all three families); add further subsets
in `theme.json`'s `fontFace` array if the site needs them.

### Font size scale (fluid)

| Token slug    | Size (fluid range)    | Usage                   |
|---------------|-----------------------|-------------------------|
| `small`       | `0.875rem` (fixed)    | Captions, meta text     |
| `medium`      | `1rem` (fixed)        | Body copy — **default** |
| `large`       | `1.0625 → 1.125rem`   | Lead paragraph          |
| `x-large`     | `1.25 → 1.5rem`       | H3, sub-headings        |
| `xx-large`    | `1.5 → 2.25rem`       | H2, post titles         |
| `xxx-large`   | `2 → 3rem`            | H1, hero titles         |

Body `line-height: 1.75`. Heading `line-height: 1.15`, `font-weight: 700`
(`800` for H1), `letter-spacing: -0.01em` — tight and bold, matching
huzzle.com's headline treatment. Tag pills, breadcrumbs, post meta and stat
captions use JetBrains Mono, uppercase, `letter-spacing: 0.04em`.

---

## Component Shadow Reference (default Forest & Cream skin)

| Component           | Token                | Description                                |
|----------------------|-----------------------|----------------------------------------------|
| Cards (resting)       | `--shadow-md`         | Soft warm-tinted drop-shadow                |
| Cards (hover)         | `--shadow-lg`         | Larger, softer — card also lifts 2px        |
| Buttons (resting)     | `--shadow-md`         | Same soft shadow as cards                   |
| Buttons (hover)       | `--shadow-lg`         | Larger shadow                               |
| Buttons (active)      | `--button-shadow-active` (`--shadow-sm`) | Shadow shrinks + 1px press |
| Tag pills             | `--pill-shadow` (`none`) | Flat — no shadow, like huzzle's badges   |
| Nav toggle / post-nav | `--shadow-sm` → `--shadow-md` on hover | Small lift |
| Inputs                | `--input-shadow` (`none`) + 1px border | Hairline outline, no carve |
| Input focus           | 3px `color-mix()` ring in Forest Green | Focus indicator |
| Site header           | `--shadow-sm` + 1px bottom border | Light hairline lift |
| Featured-image hero   | Dark-green tinted gradient overlay | See templates/single.html, page.html |

For the neumorphic variations' equivalents, see "Two design languages, one
stylesheet" above — the mapping is the same dual-shadow formula as before
(documented in the Neumorphism section below).

---

## Bundled patterns

| Pattern                                | Slug                      | Demonstrates                                                    |
|-----------------------------------------|---------------------------|--------------------------------------------------------------------|
| Hero — Forest & Cream                   | `multiloquent/hero`       | Default scheme: cream bg, dark-green heading, forest-green CTA     |
| CTA Band — Forest Green (inverted)      | `multiloquent/cta-band`   | Inverted scheme: forest-green bg, cream "Inverted" button, stat row |

---

## Archive Card Layout

Cards are a two-section layout: image on top, tags/title/meta below —
never overlaid on the photo. Photography is shown at full clarity by
default; a very faint (8% opacity) dark-green tint appears only on hover as
an affordance, replacing the neumorphic version's permanent 50%-opacity
overlay.

```
┌────────────────────────────┐  ←  .archive-card (--shadow-md, lifts on hover)
│                            │
│      [Featured Image]      │  ←  .archive-card-image  (clear by default)
│                            │
├────────────────────────────┤
│  [tag]  [tag]              │  ←  .archive-card-tags (mono pills, --pill-bg)
│  Post Title Here           │  ←  .archive-card-title (Plus Jakarta Sans)
│  1 JAN 2026 — AUTHOR NAME  │  ←  .archive-card-meta (mono, uppercase)
└────────────────────────────┘
```

The **hero card** (first post) spans 2 grid columns on desktop and has a
taller image zone (22rem vs 12rem).

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

Compiled `assets/css/main.css` is committed so the theme works on zero-build
WordPress hosts.

---

# Legacy: Neumorphism style variations

Six **Neumorphism** (soft-UI) colour variations ship in `styles/` and remain
fully selectable — they are not the default, but every file still renders
authentic neumorphism thanks to the token architecture described above.

## Neumorphism design rules

Every element shares the same colour as the page background and appears to
emerge from — or recede into — the surface via dual-shadow lighting. A
white/light highlight hits from the top-left and a darker shadow falls to
the bottom-right. There are no visible borders; depth is created entirely
by shadows.

- Raised elements (cards, buttons, pills, images): `box-shadow: dark bottom-right, light top-left`
- Inset elements (inputs, blockquotes, code): `box-shadow: inset dark, inset light`
- Background = element background colour — nothing is a different colour from the surface except the highlight accent

### Variations

| File                           | Title                     | Primary    | Base       |
|--------------------------------|---------------------------|------------|------------|
| `neumorphism-blue-light.json`  | Neumorphism — Blue Light  | `#4488ff`  | `#e0e5ec`  |
| `neumorphism-green-light.json` | Neumorphism — Green Light | `#38B09D`  | `#E1F3F0`  |
| `neumorphism-red-light.json`   | Neumorphism — Red Light   | `#ee4444`  | `#e0e5ec`  |
| `neumorphism-blue-dark.json`   | Neumorphism — Blue Dark   | `#4488ff`  | `#2a2d3e`  |
| `neumorphism-green-dark.json`  | Neumorphism — Green Dark  | `#38B09D`  | `#152A27`  |
| `neumorphism-red-dark.json`    | Neumorphism — Red Dark    | `#ee4444`  | `#2e2020`  |

## Adding a new colour variation

1. Copy any `styles/neumorphism-*.json` file (light or dark family, as a
   starting point).
2. Update `"title"`, and the `primary`/`primary-dark`/`primary-light` (and
   other palette) values.
3. Keep the `"css"` key (the neumorphic skin-token block) as-is — it
   references the file's own palette colours via `var(--wp--preset--color--*)`
   and needs no changes.
4. No other CSS changes required.

## Neumorphism Rules Checklist

- [ ] Every element background equals `--color-base` (= page background)
- [ ] No borders — depth from shadows only
- [ ] Raised elements: `box-shadow: Xpx Xpx Ypx shadow-dark, -Xpx -Xpx Ypx shadow-light`
- [ ] Inset elements: same but with `inset`
- [ ] Hover increases shadow distance (raised) or adds ring (inputs)
- [ ] Active/pressed state uses inset shadow
- [ ] Only `--color-primary` departs from the greyscale palette
- [ ] Background is never white — use the neumorphic grey or dark base
