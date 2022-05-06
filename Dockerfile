FROM php:8.1

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -; \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list;

RUN apt-get update; \
    apt-get install -y \
        git \
        zlib1g-dev \
        libzip-dev \
        libpng-dev \
        nodejs \
        zsh \
        wget \
        yarn; \
    apt --yes --quiet autoremove --purge; \
    rm -rf  /var/lib/apt/lists/* /tmp/* /var/tmp/* \
                /usr/share/doc/* /usr/share/groff/* /usr/share/info/* /usr/share/linda/* \
                /usr/share/lintian/* /usr/share/locale/* /usr/share/man/*

RUN docker-php-ext-install zip pdo pdo_mysql;

RUN docker-php-ext-configure zip pdo pdo_mysql; \
    docker-php-ext-enable zip pdo pdo_mysql

COPY --from=composer:2.3 /usr/bin/composer /usr/bin/composer
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN wget https://get.symfony.com/cli/installer -O - | bash; \
    mv /root/.symfony/bin/symfony /usr/local/bin/symfony; \
    chmod +x /usr/local/bin/symfony;
RUN symfony server:ca:install

WORKDIR /srv/app

COPY . .

RUN composer install --no-scripts
