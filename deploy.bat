@echo off

echo Cleaning previous build...
rmdir /s /q deploy
del stellar-surge-deploy-*.zip

echo Installing production dependencies...
call composer install --no-dev --optimize-autoloader

echo Building frontend assets...
call npm run build

echo Clearing dev caches...
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo Copying production files...
mkdir deploy
xcopy /E /I /Y /EXCLUDE:deploy-exclude.txt . deploy

echo Zipping package...
powershell Compress-Archive -Path deploy\* -DestinationPath "stellar-surge-deploy-%date:~-4,4%-%date:~-10,2%-%date:~-7,2%.zip"

echo Done. Upload the zip to Hostinger via FileZilla.
