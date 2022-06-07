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

RUN npm install yarn@latest -g

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tld && \
    mv composer.phar /usr/local/bin/composer

COPY nginx.conf /etc/nginx/nginx.conf
COPY php.ini /usr/local/etc/php/conf.d/local.ini

WORKDIR /var/www

COPY . .

ARG APP_ENV=${APP_ENV}
ENV APP_ENV=${APP_ENV}

ARG DATABASE_URL=${DATABASE_URL}
ENV DATABASE_URL=${DATABASE_URL}

RUN echo "DATABASE_URL=$DATABASE_URL" >> .env.local

RUN if [ "$APP_ENV" = "prod" ]; \
    then APP_ENV=prod APP_DEBUG=0 composer install --no-dev --optimize-autoloader; \
    else composer install; \
    fi

RUN composer dump-env ${APP_ENV}

RUN yarn install
RUN yarn run build

EXPOSE 80

ENTRYPOINT ["sh", "docker-entry.sh"]
