#
# Prep App's PHP Dependencies
#
#FROM composer:2.1 as vendor
#
#WORKDIR /app
#
#COPY composer.json composer.json
#COPY composer.lock composer.lock
#
#RUN composer install \
#    --ignore-platform-reqs \
#    --no-interaction \
#    --no-plugins \
#    --no-scripts \
#    --prefer-dist \
#    --quiet

FROM php:8.1-fpm-alpine as phpserver

# add cli tools
RUN apk update \
    && apk upgrade \
    && apk add \
    nginx nodejs npm \
    git \
    # intl
    icu-dev \
    # pour php gd
    zlib-dev \
    libpng-dev \
    # pour zip
    libzip-dev \
    zip \
    # pour xsl
    libxslt-dev

RUN docker-php-ext-install gd intl pdo pdo_mysql zip xsl opcache

#RUN npm install npm@latest -g
RUN npm install yarn@latest -g

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tld && \
    mv composer.phar /usr/local/bin/composer

COPY nginx.conf /etc/nginx/nginx.conf

COPY php.ini /usr/local/etc/php/conf.d/local.ini

WORKDIR /var/www

COPY . .

# Some secret from ENV
ARG DATABASE_URL=${DATABASE_URL}
ENV DATABASE_URL=${DATABASE_URL}
RUN echo "DATABASE_URL=$DATABASE_URL" >> .env.local

RUN APP_ENV=prod APP_DEBUG=0 composer install --no-dev --optimize-autoloader \
    && composer dump-env prod

RUN yarn install
RUN yarn run build
RUN chmod -R 777 var
RUN chmod -R 777 public

EXPOSE 80

# ENTRYPOINT ["sh", "/etc/entrypoint.sh"]
