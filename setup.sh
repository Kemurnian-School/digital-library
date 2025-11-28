#!/bin/bash

echo "Setting up Laravel with Docker..."

# Stop any running containers
docker-compose down -v

# Build containers
echo "Building containers..."
docker-compose build --no-cache

# Start containers
echo "Starting containers..."
docker-compose up -d

# Wait for containers
echo "Waiting for containers to be ready..."
sleep 15

# Check if app is running
if ! docker-compose ps | grep -q "app.*Up"; then
    echo "App container failed to start. Checking logs..."
    docker-compose logs app
    exit 1
fi

# Install Composer dependencies (app container)
echo "Installing Composer dependencies..."
docker-compose exec -T app composer install --no-interaction

# NOTE: We DON'T run npm install here because the vite container does it automatically!

# Generate app key
echo "Generating application key..."
docker-compose exec -T app php artisan key:generate --force

# Wait for MySQL
echo "Waiting for MySQL to be fully ready..."
sleep 5

# Run migrations and seed
echo "Running migrations and seed..."
docker-compose exec -T app php artisan migrate --force
docker-compose exec -T app php artisan db:seed

# Create storage link
echo "Creating storage symlink..."
docker-compose exec -T app php artisan storage:link

# Fix permissions
echo "Fixing permissions..."
docker-compose exec -T app chmod -R 777 storage bootstrap/cache
docker-compose exec -T app mkdir -p storage/app/public/books
docker-compose exec -T app chmod -R 777 storage/app/public

# Restart vite container to ensure it's working
echo "Restarting Vite container..."
docker-compose restart vite

echo ""
echo "Your application is ready:"
echo ""
echo "   Web:   http://localhost:8000"
echo "   Vite:  http://localhost:5173"
echo "   MySQL: localhost:3306"
echo ""
echo "Useful commands:"
echo "   View logs:     docker-compose logs -f"
echo "   View Vite:     docker-compose logs -f vite"
echo "   Enter app:     docker-compose exec app bash"
echo "   Stop all:      docker-compose down"
echo ""
