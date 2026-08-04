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

Studio site on this machine:

```text
Path: ~/Studio/universare-com-20260803/
URL:  http://universare.wp.local
```

Theme is symlinked from this repo (edit in `~/Projects/universare-wp`, changes appear in Studio):

```text
~/Studio/universare-com-20260803/wp-content/themes/universare-child
  -> ~/Projects/universare-wp/wp-content/themes/universare-child
```

```bash
export PATH="$HOME/.studio/bin:$PATH"
studio list    # confirm site path
studio start   # if stopped
```

Activate **Universare Child** in WP Admin. Parent theme is **Astra** (already on live and local).

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

## Requirements

- Parent theme **Astra** installed on server (live active theme)
- cPanel Git repo with clean working tree before deploy
