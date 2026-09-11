# Offizielles PHP-Image mit integriertem Webserver
FROM php:8.4-cli

WORKDIR /app

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY . .

EXPOSE 8888

CMD ["php", "-S", "0.0.0.0:8888", "-t", "."]