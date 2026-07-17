# TikTok / Instagram Audio Downloader

A Laravel 9 PHP web app (v3.0.6) that lets users download audio from Instagram Reels, Posts, and Stories as MP3 or M4A.

## Stack
- **PHP 8.2** / **Laravel 9**
- **SQLite** (database at `database/database.sqlite`)
- **Alpine.js** frontend (served via CDN)
- **Theme system** — active theme: `Minimal` (at `themes/Minimal/`)

## How to run
The workflow `Start App` runs:
```
php artisan serve --host=0.0.0.0 --port=5000
```

## First-time setup (already done)
1. Environment variables set via Replit secrets (`DB_CONNECTION=sqlite`, etc.)
2. Migrations run: `php artisan migrate --force`
3. Theme assets linked: `php artisan theme:link --force`
   - Creates `public/theme-assets → themes/Minimal/resources/assets`
   - **Must re-run after restarting if the symlink is lost**

## Project structure
- `app/` — Laravel application code (controllers, models, middleware)
- `themes/Minimal/` — Active theme (views, assets, routes, service provider)
- `config/` — Laravel config files
- `database/` — SQLite database + migrations
- `public/` — Web root (served by Laravel's built-in server)
- `storage/` — Logs, cached views, framework files

## Known issues / notes
- `@error` in Alpine.js HTML attributes must be written as `@@error` in Blade templates to avoid being interpreted as a Blade directive (fixed in `splash.blade.php`)
- The Alpine.js Collapse plugin is not loaded — FAQ accordion uses `x-collapse` which shows console warnings but is non-fatal
- CSS/JS assets are served via a symlink at `public/theme-assets`

## User preferences
