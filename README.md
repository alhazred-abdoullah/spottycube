# Installation 

See documentation for [installation instructions](docs/installation.md).

# Starting the app

```sh
docker-compose up -d
```

# Stopping the app

```sh
docker-compose down
```

# Updating the app

```sh
docker-compose build --pull --no-cache
docker-compose up -d
```

# Run unit tests

```sh
docker-compose exec php php bin/phpunit
```

# Run e2e tests

```sh
yarn test:e2e

# or with a specific browser
yarn test:e2e --headed --browser=chrome # or firefox
```

# Run static analysis

```sh
docker-compose exec php php vendor/bin/phpstan analyse
```

# Check the crap load of code

```sh
docker-compose exec php php bin/phpunit --log-junit var/log/phpunit/reports/crap4j.xml
docker-compose exec php php bin/crap-checker var/log/phpunit/reports/crap4j.xml 0 # 0 is the threshold
```

# Check the code coverage

```sh
docker-compose exec php php bin/phpunit
docker-compose exec php php bin/phpunit-coverage-checker var/log/phpunit/reports/clover.xml 80 # 80 is the threshold
```

# Check the code style

```sh
docker-compose exec php composer install --working-dir=tools/php-cs-fixer 
docker-compose exec php php tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --dry-run --diff
```
