
FROM php:8.1-fpm

# Устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip

RUN git clone https://github.com/yiisoft/yii2-gii.git /var/www/html/gii
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer



# Установка зависимостей в первый раз
RUN composer install -d /var/www/html/gii

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Устанавливаем Select2
RUN git clone https://github.com/buttflattery/yiiSelect2.git /var/www/html/vendor
RUN composer require --prefer-dist kartik-v/yii2-widget-select2

USER "1000:1000"

WORKDIR /var/www

ENTRYPOINT [ "php-fpm" ]
