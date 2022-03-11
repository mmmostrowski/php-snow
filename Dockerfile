FROM php:8.1.3-cli-alpine3.14

RUN apk add ncurses \
    && apk update && apk upgrade && apk add bash

COPY --from=composer:2.2.7 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app/

COPY /composer.json /app/composer.json
COPY /composer.lock /app/composer.lock

RUN composer install

COPY /docker/entrypoint.sh /

COPY /lib/ /app/lib/
COPY /snow.php /app/snow.php
COPY /app/ /app/app/

ENTRYPOINT [ "bash", "/entrypoint.sh", "php", "snow.php" ]

