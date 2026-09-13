#!/bin/bash
set -e

echo "🧹 Cleaning previous build..."
rm -rf deploy/
rm -f stellar-surge-deploy-*.zip

echo "📦 Installing production dependencies..."
composer install --no-dev --optimize-autoloader

echo "🎨 Building frontend assets..."
npm run build

echo "🧼 Clearing dev caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo "📁 Copying production files..."
mkdir -p deploy
rsync -av --exclude='node_modules' --exclude='.git' --exclude='tests' \
  --exclude='deploy' --exclude='.env' --exclude='storage/logs/*' \
  --exclude='storage/framework/cache/*' --exclude='storage/framework/sessions/*' \
  --exclude='storage/framework/views/*' \
  ./ deploy/

echo "🗜️ Zipping package..."
zip -r "stellar-surge-deploy-$(date +%Y-%m-%d).zip" deploy/

echo "✅ Done. Upload stellar-surge-deploy-$(date +%Y-%m-%d).zip to Hostinger via FileZilla."
