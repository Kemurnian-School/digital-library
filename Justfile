# Default to development mode
mode := "dev"

# Helper to get the correct compose file
compose_file := "docker-compose." + mode + ".yml"
dc := "docker compose -f " + compose_file

# Complete setup from scratch
setup mode="dev":
    @echo "Setting up Laravel for {{mode}}..."
    {{dc}} down -v
    {{dc}} build --no-cache
    {{dc}} up -d
    @echo "Waiting for containers..."
    sleep 15
    {{dc}} exec -T app composer install --no-interaction
    {{dc}} exec -T app php artisan key:generate --force
    @echo "Waiting for MySQL..."
    sleep 5
    {{dc}} exec -T app php artisan migrate --force
    {{dc}} exec -T app php artisan db:seed
    {{dc}} exec -T app php artisan storage:link
    {{dc}} exec -T app chmod -R 777 storage bootstrap/cache
    {{dc}} exec -T app mkdir -p storage/app/public/books
    {{dc}} exec -T app chmod -R 777 storage/app/public
    {{dc}} restart vite
    @echo "Setup complete for {{mode}}!"

# Start the containers
up mode="dev":
    {{dc}} up -d

# Stop the containers
down mode="dev":
    {{dc}} down

# View logs
logs service="" mode="dev":
    {{dc}} logs -f {{service}}

# Enter the app container
shell mode="dev":
    {{dc}} exec app bash

# Run artisan commands
artisan cmd mode="dev":
    {{dc}} exec app php artisan {{cmd}}
