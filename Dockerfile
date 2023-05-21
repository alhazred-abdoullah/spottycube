ARG VARNISH_VERSION=stable

FROM php:8.1-apache AS sftpl_php

# Install System Packages
RUN apt-get update && apt install -y libzip-dev \
	unzip \
	zlib1g-dev \
	libicu-dev \
	libsqlite3-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    curl \
    git

# Install PHP Extensions
RUN docker-php-ext-install pdo_mysql zip pcntl intl gd opcache

RUN pecl install apcu
RUN docker-php-ext-enable apcu

RUN a2enmod proxy_fcgi ssl rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY composer.* symfony.lock ./

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"

RUN composer install -n --no-scripts
RUN composer clear-cache

COPY .env ./
COPY bin bin/
COPY config config/
COPY public public/
COPY src src/

RUN mkdir -p var/cache var/log
RUN composer run-script post-install-cmd
RUN chmod +x bin/console
RUN sync

VOLUME /srv/api/var

COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

EXPOSE 80

ENTRYPOINT ["docker-entrypoint"]

CMD ["apache2-foreground"]


FROM sftpl_php AS sftpl_php_dev

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

EXPOSE 80

ENTRYPOINT ["docker-entrypoint"]

CMD ["apache2-foreground"]


FROM sftpl_php AS sftpl_php_prod

COPY docker/php/conf.d/php.prod.ini /usr/local/etc/php/conf.d/99-php-custom.ini
COPY docker/apache/vhosts /etc/apache2/sites-enabled

EXPOSE 80

ENTRYPOINT ["docker-entrypoint"]

CMD ["apache2-foreground"]

# "varnish" stage
# does not depend on any of the above stages, but placed here to keep everything in one Dockerfile
FROM varnish:${VARNISH_VERSION} AS sftpl_varnish

COPY docker/varnish/conf/default.vcl /etc/varnish/default.vcl

CMD ["varnishd", "-F", "-f", "/etc/varnish/default.vcl", "-p", "http_resp_hdr_len=65536", "-p", "http_resp_size=98304"]
