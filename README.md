
Install Command:
composer install --optimize-autoloader --no-dev --ignore-platform-reqs && npm install

Build Command:
npm run build

Start Command:
php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=80

Port: 80

Environment Variables:

APP_DEBUG=false
APP_ENV=production
APP_KEY=base64:luDUPWYiSyNubQP4b0UyYAON5N55iLC6bagvVO+csXw=
APP_NAME=Hamyar CRM
APP_URL=http://
CACHE_DRIVER=file
DB_CONNECTION=pgsql
DB_DATABASE=
DB_HOST=
DB_PASSWORD=
DB_PORT=5432
DB_USERNAME=
FILESYSTEM_DISK=public
LOG_CHANNEL=stack
LOG_LEVEL=error
NIXPACKS_PHP_FALLBACK_PATH=/index.php
NIXPACKS_PHP_ROOT_DIR=/app/public
NIXPACKS_PHP_VERSION=8.2
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
VITE_APP_NAME=${APP_NAME}
