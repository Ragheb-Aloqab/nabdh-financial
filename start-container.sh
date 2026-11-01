#!/bin/bash
# -----------------------------------------------------------------------------
# Railway / Railpack container start script for «نبض للتوعية المالية».
#
# Railpack automatically uses this file (instead of its default Laravel script)
# because it lives in the project root. It mirrors the upstream script:
#   https://github.com/railwayapp/railpack/blob/main/core/providers/php/start-container.laravel.sh
# and adds: DB wait/retry + seeding the initial content on a fresh database only.
# -----------------------------------------------------------------------------

set -e

# Clear any config cached at build time so runtime variables are always used.
php artisan optimize:clear

if [ "$RAILPACK_SKIP_MIGRATIONS" != "true" ]; then
  echo "Running migrations ..."
  attempt=1
  until php artisan migrate --force; do
    if [ "$attempt" -ge 10 ]; then
      echo "Migrations failed after $attempt attempts. Is the database reachable (DB_URL / DB_HOST)?"
      exit 1
    fi
    echo "Database not ready yet (attempt $attempt). Retrying in 5 seconds ..."
    attempt=$((attempt + 1))
    sleep 5
  done

  # Seeds the initial content ONLY when the database is empty.
  # Safe on every deploy: it never overwrites content edited from /admin.
  php artisan app:seed-if-empty
fi

# Uploaded files live in storage/app/public (mount a Railway Volume there).
mkdir -p storage/app/public
php artisan storage:link --force || true

# https://laravel.com/docs/12.x/deployment#optimization
php artisan optimize

echo "Starting Laravel server ..."

# Start the FrankenPHP server
docker-php-entrypoint --config /Caddyfile --adapter caddyfile 2>&1
