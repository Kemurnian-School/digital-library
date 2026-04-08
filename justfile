# Default command
default:
    @just --list

# Setup the project (RUN ONLY ONCE)
setup:
    composer install & npm install & php artisan key:generate

# Start and serve the project
serve:
    php artisan serve & npm run dev

# Create the SQLite database file if it doesn't exist
db-init:
    touch database/database.sqlite
    php artisan migrate

db-seed:
    php artisan db:seed

# Completely reset the database and run seeders
fresh-db:
    php artisan migrate:fresh --seed

# Open the database in the SQLite CLI to inspect tables
db-cli:
    sqlite3 database/database.sqlite
