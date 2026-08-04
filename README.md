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

### Option A — cPanel UI (manual pull deploy)

1. Push changes to `main` on GitHub
2. cPanel → **Control de versión de Git** → `universare-wp`
3. **Extraer o desplegar** → **Actualizar desde remoto**
4. **Desplegar commit HEAD**

### Option B — Push from local (auto-deploy)

After cPanel cloned the repo, add the cPanel remote and push:

```bash
git push cpanel main
```

cPanel runs `.cpanel.yml` automatically on push when the repo includes that file.

## Local development

1. Clone this repo
2. Copy `wp-content/themes/universare-child/` into your WordPress Studio site:
   `~/Studio/universare/wp-content/themes/universare-child/`
3. Activate **Universare Child** in WP Admin (requires **Hello Elementor** parent on both local and live)

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

- Parent theme **Hello Elementor** installed on server (standard with Elementor sites)
- cPanel Git repo with clean working tree before deploy
