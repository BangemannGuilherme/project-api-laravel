FROM php:8.1.2
RUN apt-get update -y && apt-get install -y libpq-dev openssl zip unzip git curl
RUN docker-php-ext-install pdo_pgsql

WORKDIR /var/www

RUN git clone https://github.com/BangemannGuilherme/project-api-laravel.git
WORKDIR /var/www/project-api-laravel

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

RUN chown -R www-data:www-data . && chmod -R 775 .

RUN cp .env.example .env && php artisan key:generate
# RUN php artisan migrate --seed

# RUN ./vendor/bin/phpunit

CMD php artisan serve --host=0.0.0.0 --port=8181
EXPOSE 8181
