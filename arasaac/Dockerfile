FROM php:5.6-apache
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install mysql

#Done in varnish, .htaccess renamed to htaccess
#RUN a2enmod rewrite

# Set the locale
#RUN apt-get clean && apt-get update
#RUN apt-get install locales
#RUN locale-gen en_US.UTF-8
#ENV LANG en_US.UTF-8  
#ENV LANGUAGE en_US:en  
#ENV LC_ALL en_US.UTF-8 

COPY config/php.ini /usr/local/etc/php/
COPY config/apache2.conf /etc/apache2/
