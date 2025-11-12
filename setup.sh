#!/bin/bash
set -e

echo "Starting setup for the Digital Library project..."

if [ ! -f ".env" ]; then
    echo "Creating new .env file..."
    cat > .env << EOL
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=digital_library
DB_USERNAME=root
DB_PASSWORD=secret

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
EOL
    echo ".env file created."
else
    echo "Existing .env file found. Skipping creation."
fi

echo "Building and starting Docker containers..."
docker compose up -d --build

echo "Installing Composer dependencies..."
docker compose exec -T app composer install

echo "Installing NPM dependencies..."
docker compose exec -T app npm install

echo "Building assets..."
docker compose exec -T app npm run build

echo "Setting directory permissions for Laravel..."
# Create all necessary directories first
docker compose exec -T app mkdir -p storage/pail storage/logs storage/framework/cache storage/framework/sessions storage/framework/views storage/app/public bootstrap/cache
# Set ownership and permissions
docker compose exec -T app chown -R www-data:www-data storage bootstrap/cache
docker compose exec -T app chmod -R 775 storage bootstrap/cache

echo "Generating app key..."
docker compose exec -T app php artisan key:generate

echo "Running database migrations..."
docker compose exec -T app php artisan migrate

echo "------------------------------------------"
echo "Setup Complete!"
echo "Your application is running at: http://localhost:8000"
echo "Your MySQL database is available on host port: 33066"
echo "------------------------------------------"

# Git config
docker compose exec -T app git config --global --add safe.directory /var/www/html
docker compose exec app chown -R www-data:www-data /var/www/html/storage
docker compose exec app chmod -R 775 /var/www/html/storage

# Drop into interactive shell inside the app container
echo "Entering app container shell. Run 'npm run dev' or any commands you need."
docker compose exec app bash
