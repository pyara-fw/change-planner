FROM alpine:latest

LABEL author="Eduardo Luz <eduardo @ eduardo-luz.com>"
LABEL project="Pyara-core"
LABEL version="0.0.1"

WORKDIR /app

# Add repos
RUN echo "http://dl-cdn.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories


RUN apk update \
    && apk upgrade \
    && apk add --update util-linux  \
    && apk add bash  curl ca-certificates zip unzip tzdata openntpd libssh2-dev \
               openssl openssh git autoconf build-base \
               php8 php8-phar php8-zip php8-mbstring php8-openssl \
               php8-json php8-iconv php8-fileinfo php8-dom php8-xml php8-xmlwriter \
               php8-tokenizer php8-session  php8-sqlite3  php8-curl php8-pdo \
               php8-mysqli php8-pdo_mysql php8-redis php8-xdebug php8-fpm \
               php8-ctype php8-bcmath

# pecl install ssh2-1.3.1 && docker-php-ext-enable ssh2

RUN cp /usr/bin/php8 /usr/bin/php \
    && rm -f /var/cache/apk/*


# Add Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer


COPY ./src/* /app/src
COPY ./tests/* /app/tests
COPY ./composer.* /app/
COPY ./phpunit.* /app/

COPY _docker_/php-dev/50_xdebug.ini /etc/php8/conf.d/

ENTRYPOINT ["sleep","infinity"]
