FROM php:7.2-apache

# Install PDO MySQL driver
# See https://github.com/docker-library/php/issues/62
RUN docker-php-ext-install pdo mysqli pdo_mysql 

RUN apt-get update -y && apt-get install -y libpng-dev libfreetype6-dev libyaml-dev git

RUN pecl install yamL

ADD https://github.com/PHPMailer/PHPMailer/archive/refs/tags/v6.5.3.tar.gz /var/www/
RUN tar xfz /var/www/v6.5.3.tar.gz -C /var/www/ && mv /var/www/PHPMailer-6.5.3 /var/www/PHPMailer && rm /var/www/v6.5.3.tar.gz

RUN docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/freetype2 \
    && docker-php-ext-install gd



# Workaround for write permission on write to MacOS X volumes
# See https://github.com/boot2docker/boot2docker/pull/534
RUN usermod -u 1000 www-data

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Enable yaml
#RUN a2enmod yaml
