#!/bin/bash
set -e

until pg_isready -h db -U user; do
  echo "Waiting for PostgreSQL..."
  sleep 2
done

php bin/console doctrine:database:create --if-not-exists

php bin/console doctrine:migrations:migrate --no-interaction --no-interaction || echo "No migrations to execute"

php-fpm
