#!/bin/sh
set -e

PHP_INI_RECOMMENDED="$PHP_INI_DIR/php.ini-production"
if [ "$APP_ENV" != 'prod' ]; then
  PHP_INI_RECOMMENDED="$PHP_INI_DIR/php.ini-development"
fi
ln -sf "$PHP_INI_RECOMMENDED" "$PHP_INI_DIR/php.ini"

mkdir -p var/cache var/log
chown -R "$(whoami)":www-data var
chmod -R 0775 var

if [ "$APP_ENV" != 'prod' ]; then
  composer install --prefer-dist --no-progress --no-suggest --no-interaction
fi

# Check if the APP_ENV is prod and if so, dump the autoloader with the --classmap-authoritative option
if [ "$APP_ENV" = 'prod' ]; then
  composer dump-autoload --classmap-authoritative --no-dev
fi

echo "Waiting for db to be ready..."
ATTEMPTS_LEFT_TO_REACH_DATABASE=60
until [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ] || bin/console doctrine:query:sql "SELECT 1" > /dev/null 2>&1; do
  sleep 1
  ATTEMPTS_LEFT_TO_REACH_DATABASE=$((ATTEMPTS_LEFT_TO_REACH_DATABASE-1))
  echo "Still waiting for db to be ready... Or maybe the db is not reachable. $ATTEMPTS_LEFT_TO_REACH_DATABASE attempts left"
done

if [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ]; then
  echo "The db is not up or not reachable"
  exit 1
else
   echo "The db is now ready and reachable"
fi

if [ "$( find ./migrations -iname '*.php' -print -quit )" ]; then
  php bin/console doctrine:migrations:migrate --no-interaction
fi

if [ "$APP_ENV" != 'prod' ]; then
  echo "Load fixtures"
  bin/console hautelook:fixtures:load --no-interaction
fi

exec docker-php-entrypoint "$@"
