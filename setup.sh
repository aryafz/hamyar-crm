#!/bin/bash
set -e

# determine script directory and project directory
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_DIR="$SCRIPT_DIR/crm"

cd "$PROJECT_DIR"

# Copy .env if it doesn't exist
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Created .env from .env.example"
fi

# Generate application key if missing
if ! grep -q '^APP_KEY=' .env || grep -q '^APP_KEY=$' .env; then
    php artisan key:generate --ansi
fi

# Install composer dependencies
if [ ! -d vendor ]; then
    composer install
fi

echo "Setup completed."
