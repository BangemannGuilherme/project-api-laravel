FROM php:8.1.2
RUN apt-get update -y && apt-get install -y libpq-dev openssl zip unzip git curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN curl -fsSL https://deb.nodesource.com/setup_14.x | bash
# RUN apt install -y nodejs
# RUN curl -f https://get.pnpm.io/v6.7.js | node - add --global pnpm
RUN docker-php-ext-install pdo_pgsql
WORKDIR /app
COPY . /app
RUN composer install
#RUN rm -rf node_modules
# RUN pnpm install
RUN chown -R www-data:www-data . && chmod -R 775 .

RUN cp .env.example .env && php artisan key:generate

RUN php artisan migrate --seed

RUN ./vendor/bin/phpunit

CMD php artisan serve --host=0.0.0.0 --port=8181
EXPOSE 8181