FROM php:7.3-fpm
WORKDIR /var/www/html/

RUN apt-get update && apt-get install -y ca-certificates \
make \
curl \
vim \
less \
wget \
libfreetype6-dev \
libjpeg62-turbo-dev \
libxslt-dev \
libicu-dev \
libmcrypt-dev \
libpng-dev \
libxml2-dev \
unzip \
zlib1g-dev \
libzip-dev \
&& pecl install xdebug-2.8.1 \
&& pecl install -o -f redis \
 && rm -rf /var/lib/apt/lists/* \
 &&  docker-php-ext-enable redis \
 && docker-php-ext-install iconv mbstring mysqli pdo_mysql zip \
&& docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr \
&& docker-php-ext-install gd \
 && pecl clear-cache \
 && apt-get -y autoremove

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
# Copy existing application directory contents
#COPY . /var/www/html
# Copy existing application directory permissions
#COPY --chown=www:www . /var/www/html/
# Change current user to www
USER www


