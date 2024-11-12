# Используем официальный PHP образ с поддержкой FPM
FROM php:8.2-fpm

# Устанавливаем зависимости
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Копируем composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Создаем пользователя и группу
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
USER www