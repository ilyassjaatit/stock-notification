FROM php:7.4-fpm

# Install  PHP extensions
RUN apt-get update && apt-get install -y \
git \
curl \
# php extencion zip
libzip-dev \
# php extencion xsl
libxslt1-dev \
# php extencion posgrestsql
libpq-dev


RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
bcmath \
intl \
pdo_pgsql \
simplexml \
xsl \
zip \
fileinfo

RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

# Install composer
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/app

EXPOSE 9000
CMD ["php-fpm"]
