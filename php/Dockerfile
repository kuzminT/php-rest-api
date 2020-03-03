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

#COPY ./etc/php.ini /usr/local/etc/php/conf.d/99-custom.ini
#COPY xdebug.ini /usr/local/etc/php/conf.d/99-xdebug.ini
ADD . /var/www
RUN chown -R www-data:www-data /var/www/html/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
