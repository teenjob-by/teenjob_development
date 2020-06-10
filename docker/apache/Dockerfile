FROM php:7.4-apache
RUN pecl install xdebug-2.9.5
RUN docker-php-ext-enable xdebug
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/php.ini
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli
RUN apt update \
    && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev libonig-dev\
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd

# Enable apache modules
RUN a2enmod rewrite headers