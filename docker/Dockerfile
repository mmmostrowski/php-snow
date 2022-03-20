FROM php:8.1.3-cli-alpine3.14

RUN apk add ncurses \
    && apk update && apk upgrade && apk add bash

COPY --from=composer:2.2.7 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app/

COPY /app/composer.json /app/

RUN composer install \
    && cp -rf /app/vendor/ /app-vendor/

COPY /app/lib/ /app/lib/
COPY /docker/entrypoint.sh /
COPY /app/snow.php /app/snow.php
COPY /app/src/ /app/src/

RUN echo "export PS1='devbox# '" >> /etc/profile

ENTRYPOINT [ "bash", "/entrypoint.sh"  ]

