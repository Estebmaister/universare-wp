# Universare WP — Cursor agent context

Compressed memory for future agents working on this repo. Last updated: 2026-08-04.

## What this repo is

- **Not** a full WordPress install — only custom code deployed to [universare.com](https://universare.com).
- **GitHub:** `Estebmaister/universare-wp` (branch `main`).
- **Repo path (local):** `~/dev/maister/universare-wp` (moved from `~/Projects/universare-wp` in Aug 2026).
- **Tracked paths:**
  - `wp-content/themes/universare-child/` — Astra child theme
  - `wp-content/mu-plugins/universare-bootstrap.php` — site-wide bootstrap (landing page creation)
  - `.cpanel.yml` — cPanel Git deploy tasks (manual fallback)
  - `.github/workflows/deploy-theme.yml` — **primary deploy** (FTP on push)

**Not in Git:** WP core, plugins, uploads, database, Elementor page JSON.

## Production vs local architecture

| | Production | Local (WordPress Studio) |
|---|-----------|--------------------------|
| **WordPress root** | `/home/univers3/public_html/` | `~/Studio/universare-com-20260803/` |
| **This repo** | Deployed via FTP to theme + mu-plugin dirs | Symlinked into Studio site |
| **URL** | https://universare.com/landing/ | http://universare.wp.local/landing/ |
| **Parent theme** | Astra | Astra |

**Studio symlinks** (must point at repo after moves):

```
~/Studio/universare-com-20260803/wp-content/themes/universare-child
  -> ~/dev/maister/universare-wp/wp-content/themes/universare-child

~/Studio/.../mu-plugins/universare-bootstrap.php
  -> ~/dev/maister/universare-wp/wp-content/mu-plugins/universare-bootstrap.php

~/Studio/.../mu-plugins/universare-local-dev.php
  -> ~/dev/maister/universare-wp/wp-content/mu-plugins/universare-local-dev.php
```

**Studio CLI config:** `~/.studio/cli.json` (not `Application Support/Studio`). Site id path: `~/Studio/universare-com-20260803`.

## Deploy

### Automatic (recommended)

Push to `main` triggers `.github/workflows/deploy-theme.yml` when these paths change:

- `wp-content/themes/universare-child/**`
- `wp-content/mu-plugins/**`

**GitHub secrets:** `FTP_HOST`, `FTP_USER` (`univers3` — main cPanel user), `FTP_PASSWORD`.

FTP deploys to:

- `public_html/wp-content/themes/universare-child/`
- `public_html/wp-content/mu-plugins/`

**After deploy:** purge **LiteSpeed Cache** on live if CSS/icons look stale.

### Manual fallback

cPanel → Git → pull → deploy using `.cpanel.yml`.

### Do not commit / deploy

- `wp-content/mu-plugins/universare-local-dev.php` — local-only (auto-activates child theme when `WP_ENVIRONMENT_TYPE=local`)
- `.playwright-screenshots/`, reference JPEGs, root `compass_maze.png` duplicate
- Secrets (`.env`, FTP creds)

## Brújula landing page (`/landing/`)

Main product page: **BRÚJULA — Sesión de Claridad**.

| Concern | Location |
|---------|----------|
| Template (copy + structure) | `page-templates/landing-brujula.php` |
| CSS entry | `assets/css/landing-brujula.css` → imports modular `assets/css/brujula/*.css` |
| SVG icons | `inc/brujula-icons.php` — `universare_brujula_icon( $slug, $args )` |
| Compass hero (insight section) | `universare_brujula_compass_hero()` → `assets/images/compass-labyrinth.svg` |
| Work-section photo | `universare_brujula_compass_maze()` → `assets/images/compass-maze.png` |
| Page auto-create | `universare-bootstrap.php` — creates `/landing`, assigns template, fixes template if page exists |

**Filters** (in template):

- `universare_brujula_cta_url` — booking link (default `#agendar`)
- `universare_brujula_instagram_url` — default `https://www.instagram.com/universare/`
- `universare_brujula_whatsapp_url` — default `wa.me/573165137110` + text *"Quiero encontrar mi brújula"*

Standalone HTML template (minimal Astra chrome): body class `bru-landing-body`, wrapper `.bru-landing`.

## CSS architecture (modular)

Edit in this order:

1. **`brujula/tokens.css`** — colors, spacing, radii, icon sizes, CTA overlay
2. **`brujula/base.css`** — page-level typography, section spacing
3. **`brujula/components.css`** — buttons, cards, icons, grid, nav
4. **`brujula/sections.css`** — hero, VS, work/pillars, steps, final CTA, footer

**Design tokens (summary):**

- Cream `#faf6f0`, beige `#ebe3d6`, gold `#b8956b` / `#9a7348`, brown text `#4a4038`
- Buttons: `--bru-radius-btn: 8px`; cards: `10px`
- Icons: `--bru-icon-lg: 104px`, `--bru-icon-md: 80px`, color `--bru-gold-dark`
- Final CTA: lighter overlay so mountain photo shows; white button on dark photo

**Work-section image:** `.bru-work__visual` has no padding; `.bru-work__visual-img` uses `position: absolute; inset: 0; object-fit: cover` for full-bleed compass maze.

## Icon system

All landing icons: **48×48 viewBox** (logo 24×24), **1.5px stroke**, `currentColor` (gold via CSS).

**Slugs in use** (array keys in template = icon slug):

| Section | Slugs |
|---------|-------|
| Feelings | `scatter`, `book`, `cloud`, `spiral` |
| Pillars | `leaf`, `magnify`, `order`, `compass` |
| Steps | `calendar`, `chat`, `map`, `target` |
| Para quién | `self`, `overthink`, `suncloud`, `crossroads` |
| UI | `logo`, `check`, `cross`, `arrow` |

**Meanings (intentional):**

- `scatter` — mind in many places at once
- `overthink` — head with inward swirl (distinct from `spiral` = confusion)
- `magnify` — discover patterns
- `order` — bulleted list, not heart
- `map` — head + location pin (inner map)
- `target` — clarity/focus bullseye
- `crossroads` — fork with two arrow paths

Add icons in `brujula-icons.php`; use slug as array key in `landing-brujula.php`.

## Common pitfalls

1. **Studio shows wrong theme** — child not active; check symlinks + `universare-local-dev.php` locally.
2. **Local edits invisible** — symlink still pointing at old `~/Projects/universare-wp` path after move.
3. **Deploy OK but live unchanged** — LiteSpeed cache; or wrong FTP user (`esteb@` cannot deploy themes).
4. **Icon empty on page** — slug in template doesn't exist in `$icons` array.
5. **Bump `Version:` in `style.css`** after theme changes to bust browser cache.

## Visual QA

Use Playwright against `http://universare.wp.local/landing/` for section screenshots. Sections: `#sobre`, `.bru-work`, `#como-funciona`, `#para-quien`, `.bru-final-cta`.

## Recent work (Aug 2026)

- Redesigned all Brújula SVG icons for clearer meaning
- Modular CSS split (`tokens`, `base`, `components`, `sections`)
- Added `compass-maze.png` full-bleed in work section
- Fixed final CTA contrast + Instagram/WhatsApp footer links
- Repo moved to `~/dev/maister/universare-wp`; Studio symlinks updated
- Deploy commit `b33f82b` — icons, layout, compass artwork live on production

## Commands cheat sheet

```bash
# Local
studio list && studio start
open http://universare.wp.local/landing/

# Deploy
git push origin main
gh run list --workflow deploy-theme.yml
gh run watch   # latest run id

# Verify symlinks
ls -la ~/Studio/universare-com-20260803/wp-content/themes/universare-child
```
