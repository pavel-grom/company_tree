FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        gnupg \
        zlib1g-dev \
        zip \
        git

RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -

RUN apt-get install -y nodejs npm

RUN docker-php-ext-install pdo_mysql

RUN docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/company-tree

CMD ["php-fpm"]
