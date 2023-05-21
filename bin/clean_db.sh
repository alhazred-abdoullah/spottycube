#!/usr/bin/env sh

php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console hautelook:fixtures:load --no-interaction
