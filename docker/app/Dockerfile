FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libgd-dev \
    libpq-dev \
    libz-dev libbz2-dev \
    librabbitmq-dev \
    && pecl install amqp \
    && pecl install xdebug-3.2.2 \
    && docker-php-ext-install pdo_mysql mysqli mbstring exif pcntl bcmath gd zip intl simplexml bz2 \
    && docker-php-ext-configure gd \
    && docker-php-ext-enable amqp

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /var/www

USER $user
