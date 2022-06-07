#!/bin/sh

# composer
if [ ${APP_ENV} = "prod" ]; then
  APP_ENV=prod APP_DEBUG=0 composer install --no-dev --optimize-autoloader
else
    composer install
fi

composer dump-env ${APP_ENV}

# yarn
yarn install
yarn run build

# chmods
chmod -R 777 var
chmod -R 777 public

# migrations
if [ ${APP_ENV} != "prod" ]; then
  php bin/console doctrine:database:drop --force --if-exists --no-interaction
fi
php bin/console doctrine:database:create --if-not-exists --no-interaction
php bin/console doctrine:migrations:migrate --verbose --no-interaction --allow-no-migration
if [ ${APP_ENV} != "prod" ]; then
  php bin/console doctrine:fixtures:load --no-interaction --no-debug
fi

php-fpm -D &
nginx -g "daemon off;"
