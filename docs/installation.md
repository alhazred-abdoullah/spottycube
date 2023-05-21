# Requirements 
 
- Node.js v16 and higher
- Docker v20 and higher
- Docker Compose v2 and higher
- Yarn v1.22 and higher

# Installation

## Install via docker compose

```sh
docker-compose build
docker-compose up -d

# wait for the app to start (it can take some time)
```

## Load the fixtures

```sh
docker-compose exec php bin/console d:m:m -n
docker-compose exec php bin/console hautelook:fixtures:load -n
``` 

## Install the frontend dependencies

```sh
yarn install
yarn watch
```


Go to http://localhost, and you should see the app running.

Credentials:
- email/password: admin@example.com/password
