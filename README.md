# universare-wp

Custom code for [universare.com](https://universare.com), deployed to Latinoamérica Hosting via **cPanel Git**.

This repo does **not** contain the full WordPress site. It tracks:

- `wp-content/themes/universare-child/` — child theme (CSS, PHP, theme.json)
- `wp-content/mu-plugins/universare-bootstrap.php` — optional site-wide tweaks
- `.cpanel.yml` — deployment instructions for cPanel

**Not in Git:** WordPress core, plugins, uploads, database, Elementor page content.

## Server layout

| Path | Purpose |
|------|---------|
| `/home/univers3/repositories/universare-wp` | cPanel Git clone |
| `/home/univers3/public_html/` | Live WordPress |
| GitHub | `Estebmaister/universare-wp` |

## Deploy to production

### Option A — GitHub Actions FTP (automatic on push) **recommended**

On push to `main`, theme and mu-plugin files deploy via FTP when those paths change.

**GitHub → Settings → Secrets and variables → Actions → New repository secret:**

| Secret | Value |
|--------|-------|
| `FTP_HOST` | `ftp.universare.com` (or `15.235.87.145`) |
| `FTP_USER` | `univers3` — **main cPanel user**, not `esteb@universare.com` |
| `FTP_PASSWORD` | cPanel password for `univers3` |

The restricted FTP account `esteb@universare.com` only has access to `public_html/esteb/` and **cannot** deploy themes.

Workflow: `.github/workflows/deploy-theme.yml`

After deploy: purge **LiteSpeed Cache** on live if styles don't update.

### Option B — cPanel Git (manual, 2 clicks)

1. Push changes to `main` on GitHub
2. cPanel → **Control de versión de Git** → `universare-wp`
3. **Extraer o desplegar** → **Actualizar desde remoto**
4. **Desplegar commit HEAD**

## Local development (WordPress Studio)

WordPress runs in [WordPress Studio](https://developer.wordpress.com/docs/developer-tools/studio/) — not from this repo directly. You edit theme/mu-plugin files here; Studio serves them via symlinks.

### Paths

| What | Path |
|------|------|
| **This repo** | `~/dev/maister/universare-wp` |
| **Studio site** | `~/Studio/universare-com-20260803/` |
| **Local URL** | http://universare.wp.local |

### One-time setup (symlinks)

If the site is new or the repo moved, point Studio at this repo:

```bash
STUDIO=~/Studio/universare-com-20260803
REPO=~/dev/maister/universare-wp

ln -sfn "$REPO/wp-content/themes/universare-child" \
  "$STUDIO/wp-content/themes/universare-child"

ln -sfn "$REPO/wp-content/mu-plugins/universare-bootstrap.php" \
  "$STUDIO/wp-content/mu-plugins/universare-bootstrap.php"

# Local-only (not in Git): auto-activates child theme
ln -sfn "$REPO/wp-content/mu-plugins/universare-local-dev.php" \
  "$STUDIO/wp-content/mu-plugins/universare-local-dev.php"
```

Parent theme is **Astra**. Child theme should auto-activate locally via `universare-local-dev.php`.

### Start local site (step by step)

```bash
# 1. Add Studio CLI to PATH (add to ~/.bashrc or ~/.zshrc to persist)
export PATH="$HOME/.studio/bin:$PATH"

# 2. Check if the site is running
studio status -p ~/Studio/universare-com-20260803

# 3. Start WordPress (skip browser if you only need the URL)
studio start -p ~/Studio/universare-com-20260803 --skip-browser

# 4. Open pages in the browser
open http://universare.wp.local/landing/
open http://universare.wp.local/landing-brujula/
open http://universare.wp.local/reflexiones/
```

**WP Admin:** `studio open -p ~/Studio/universare-com-20260803` (or open http://universare.wp.local/wp-admin/). Login credentials are shown when you run `studio start`.

**WP-CLI** (from the Studio site directory):

```bash
cd ~/Studio/universare-com-20260803
studio wp plugin list
studio wp eval 'echo count(universare_reflexiones_get_quotes());'
```

### Stop local site (save resources)

When you are done developing, stop Studio so PHP and the proxy do not keep running:

```bash
export PATH="$HOME/.studio/bin:$PATH"

# Stop this site only
studio stop -p ~/Studio/universare-com-20260803

# Or stop every Studio site on this machine
studio stop --all
```

Confirm it is off: `studio status -p ~/Studio/universare-com-20260803` should show the site as stopped.

### Quick reference

| Action | Command |
|--------|---------|
| List sites | `studio list` |
| Start | `studio start -p ~/Studio/universare-com-20260803` |
| Stop | `studio stop -p ~/Studio/universare-com-20260803` |
| Status | `studio status -p ~/Studio/universare-com-20260803` |
| WP-CLI | `cd ~/Studio/universare-com-20260803 && studio wp …` |

Edits under `wp-content/themes/universare-child/` in this repo appear immediately in the browser (hard-refresh if CSS looks cached).

## First-time live setup

After the first successful deploy:

1. WP Admin → **Apariencia → Temas**
2. Activate **Universare Child**
3. If parent theme differs from `hello-elementor`, edit `Template:` in `style.css` to match

## What Git does not sync

| Change | Sync method |
|--------|-------------|
| Elementor pages | DB export or Elementor template JSON |
| Media / uploads | FTP incremental (`uploads/` only) |
| Plugins | WP Admin on each environment |
| Database | phpMyAdmin / WP Migrate DB |

## Brújula landing page

After deploy, visit **https://universare.com/landing/** (auto-created on first site load).

- Template: `page-templates/landing-brujula.php`
- Styles: `assets/css/landing-brujula.css`
- Edit copy in the template file, or filter `universare_brujula_cta_url` for booking links

**Subdomain (optional):** cPanel → Subdominios → `landing.universare.com` → Redirect to `https://universare.com/landing/`

## Reflexiones page (`/reflexiones/`)

Random book quotes at **https://universare.com/reflexiones/**.

| Piece | Location |
|-------|----------|
| Template | `page-templates/reflexiones.php` |
| Loader + Drive sync | `inc/reflexiones-quotes.php` |
| CSV fallback (offline) | `data/libros-reflexiones.csv` |
| Sheet URL config | `mu-plugins/universare-bootstrap.php` → `universare_reflexiones_drive_csv_url` |

**Live Google Sheet:** [LIBROS Y REFLEXIONES](https://docs.google.com/spreadsheets/d/1lOilYoxw0IP1c9FHR1TuQWcjTRQlbDUkgY-AzV1rViE/edit?gid=0)

### Google Drive / Sheets sync

On each `/reflexiones/` page load, WordPress fetches the sheet as CSV, parses it, and updates a transient cache. Editing the sheet updates the live page on the next visit — no git deploy needed.

**Sheet requirements:**

1. Columns (row 1): `FRASE`, `LIBRO`, `AUTOR`
2. **Share → Anyone with the link → Viewer** (public read)
3. Paste the sheet URL in `universare-bootstrap.php` if it changes
4. Line breaks inside `FRASE` (Alt+Enter / Cmd+Enter in Sheets) are preserved on the page

**Behavior:**

| Event | Result |
|-------|--------|
| Someone visits `/reflexiones/` | Fetches CSV from Google, updates WP transient cache |
| Drive fetch fails | Uses last good cache, then bundled `data/libros-reflexiones.csv` |
| Drive URL empty | Uses bundled CSV only (local dev default) |

### Row validation (which quotes are used)

A row is **included** only when:

| Rule | Required |
|------|----------|
| `FRASE` not empty | Yes |
| `LIBRO` or `AUTOR` (at least one) | Yes — needed for the attribution line under the quote |

A row is **skipped** when `FRASE` is empty, or when both `LIBRO` and `AUTOR` are empty.

**Fix skipped rows:** fill at least `LIBRO` or `AUTOR` in the sheet (e.g. `Vivir por Amor`). Reload `/reflexiones/` to pick them up.

**Verify quote count (local):**

```bash
cd ~/Studio/universare-com-20260803
studio wp eval 'echo count( universare_reflexiones_get_quotes( true ) );'
```

The bundled `data/libros-reflexiones.csv` is a fallback only; the Google Sheet is the source of truth in production.

## Requirements

- Parent theme **Astra** installed on server (live active theme)
- cPanel Git repo with clean working tree before deploy
