FROM php:8.0-fpm-alpine

RUN apk --no-cache update \
  && apk --no-cache upgrade \
  && apk --no-cache add \
    bash \
    git \
    vim \
    oniguruma-dev \
    zlib-dev \
    libpng-dev \
  && docker-php-ext-install -j$(nproc) \
    mbstring \
    pdo_mysql \
    gd
RUN git clone https://github.com/phpredis/phpredis.git /usr/src/php/ext/redis \
  && docker-php-ext-install redis

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
COPY ./docker/php-fpm/php.ini /usr/local/etc/php/conf.d/
COPY ./docker/php-fpm/init.sh /tmp

CMD /bin/sh /tmp/init.sh && php-fpm
