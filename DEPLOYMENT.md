# Stellar Surge Deployment Guide

## 1. Local build and package

1. Make sure the app is running locally on XAMPP.
2. Run:
   ```bash
   composer install
   npm install
   npm run build
   ```
3. Create your `.env` file from `.env.example` and generate the application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Run the database migrations:
   ```bash
   php artisan migrate --force
   ```
5. Create a deployment package:
   - On Mac/Linux: `./deploy.sh`
   - On Windows: `deploy.bat`
6. Upload the generated zip file to Hostinger via FileZilla.

## 2. Hostinger first-time upload

1. Upload the zip to the domain root or a temporary folder.
2. Extract the archive in Hostinger File Manager.
3. Move the contents of the extracted `public/` folder into `public_html/`.
4. Update `public_html/index.php` to point to the Laravel app directory:
   ```php
   require __DIR__.'/../laravel_app/vendor/autoload.php';
   $app = require_once __DIR__.'/../laravel_app/bootstrap/app.php';
   ```
5. Create a production `.env` file with the correct values.
6. Run the following commands through Hostinger SSH or Terminal:
   ```bash
   php artisan key:generate
   php artisan migrate --force
   php artisan storage:link
   ```
7. Set permissions on storage and cache directories:
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

### Uploaded media

Filament uploads use Laravel's `public` disk. The database stores the file path, while the actual files are saved in `storage/app/public` and served through the `public/storage` symlink. The `public/storage` symlink and uploaded files are intentionally excluded from Git, so a fresh computer or deployment package will not contain them automatically.

Keep `storage/app/public` backed up separately and transfer it during deployment, then run `php artisan storage:link` on the target server. The repository's `logos/` folder contains bundled brand assets and is tracked separately from admin uploads.

## 3. Subdomain setup

In Hostinger hPanel → Subdomains create:
- `events.thestellarsurge.com` → `domains/thestellarsurge.com/subdomains/events`
- `entrepreneurship.thestellarsurge.com` → `domains/thestellarsurge.com/subdomains/entrepreneurship`
- `training.thestellarsurge.com` → `domains/thestellarsurge.com/subdomains/training`

Each subdomain public index should point to the same Laravel app:
```php
require __DIR__.'/../../laravel_app/vendor/autoload.php';
$app = require_once __DIR__.'/../../laravel_app/bootstrap/app.php';
```

## 4. Subsequent updates

1. Run the package script again locally.
2. Upload the updated zip.
3. Extract and overwrite the app files.
4. Do not overwrite `.env`, `storage/app/public`, or `public/uploads`.
5. Run:
   ```bash
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
6. Clear browser and PWA caches if needed.

## 5. Shared session configuration

Ensure this is set in `.env`:
```env
SESSION_DOMAIN=.thestellarsurge.com
```

This allows the main domain and subdomains to share authentication.
