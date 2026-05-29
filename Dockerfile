FROM php:8.2-apache

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html/photos \
    && chmod -R 775 /var/www/html/photos

EXPOSE 80