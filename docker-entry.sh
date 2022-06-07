#!/bin/sh

# composer
if [ ${APP_ENV} != "prod" ]; then
  # composer install
fi

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



# apache2-foreground



#set -e
#
## php composer.phar update
#
### Symfony configuration
#if [ ${APP_ENV} != "prod" ]; then
#  php bin/console doctrine:database:drop --force --quiet --if-exists --no-interaction
#fi
#php bin/console doctrine:database:create --if-not-exists --quiet --no-interaction
#php bin/console doctrine:migrations:migrate --verbose --no-interaction --allow-no-migration
#if [ ${APP_ENV} != "prod" ]; then
#  php bin/console doctrine:fixtures:load --quiet --no-interaction --no-debug
#fi
#
#php bin/console cache:clear
#php bin/console cache:warmup
#
#chmod -R 777 /var/www/var
#chmod -R 777 /var/www/public
#
### server config
#php-fpm -D &
#nginx -g "daemon off;"
