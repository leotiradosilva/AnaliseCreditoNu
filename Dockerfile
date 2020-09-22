FROM php:7.0.33-apache
COPY . /var/www/html/
RUN echo "memory_limit=-1" > $PHP_INI_DIR/conf.d/memory-limit.ini
RUN echo "ignore_user_abort=TRUE" > $PHP_INI_DIR/conf.d/ignore-user-abort.ini
RUN echo "date.timezone = America/Fortaleza" > $PHP_INI_DIR/conf.d/timezone.ini
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        locales --no-install-recommends \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd
#RUN sed -i -e 's/# pt_BR.UTF-8 UTF-8/pt_BR.UTF-8 UTF-8/' /etc/locale.gen && dpkg-reconfigure --frontend noninteractive locales
RUN ln -fs /usr/share/zoneinfo/America/Fortaleza /etc/localtime && dpkg-reconfigure --frontend noninteractive tzdata
#ENV LANG pt_BR.UTF-8
#ENV LANGUAGE pt_BR.UTF-8 
#ENV LC_ALL pt_BR.UTF-8
WORKDIR  /var/www
RUN chmod -R 775 /var/www &&  chown -R www-data:www-data /var/www
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli && docker-php-ext-install calendar && docker-php-ext-configure calendar
RUN a2enmod rewrite
