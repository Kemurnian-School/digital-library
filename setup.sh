#!/bin/bash

docker-compose down -v

echo "Building containers..."
docker-compose build --no-cache

echo "Starting containers..."
docker-compose up -d

echo "Waiting for containers to be ready..."
sleep 15

if ! docker-compose ps | grep -q "app.*Up"; then
    echo "App container failed to start. Checking logs..."
    docker-compose logs app
    exit 1
fi

echo "Installing Composer and NPM dependencies..."
docker-compose exec -T app composer install --no-interaction
docker-compose exec -T app npm install

# Generate app key if needed
echo "Generating application key..."
docker-compose exec -T app php artisan key:generate --force

# Wait a bit more for MySQL
echo "Waiting for MySQL to be fully ready..."
sleep 5

# Run migrations and seed
echo "Running migrations..."
docker-compose exec -T app php artisan migrate --force
docker-compose exec -T app php artisan db:seed

echo "Fixing permissions..."
docker-compose exec -T app chmod -R 777 storage bootstrap/cache

echo ""
echo "Your application is ready:"
echo ""
echo "   Web:   http://localhost:8000"
echo "   Vite:  http://localhost:5173"
echo "   MySQL: localhost:3306"
echo ""
echo "Useful commands:"
echo "   View logs:     docker-compose logs -f"
echo "   Enter app:     docker-compose exec app bash"
echo "   Stop all:      docker-compose down"
echo ""
