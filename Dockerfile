### ============================================================
### Stage 1 — Composer bağımlılıkları
### ============================================================
FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-reqs

COPY . ./
RUN composer dump-autoload --optimize --no-dev --ignore-platform-reqs


### ============================================================
### Stage 2 — Frontend (Vite / Tailwind) build
### ============================================================
FROM node:22-alpine AS assets

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci

COPY vite.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm run build


### ============================================================
### Stage 3 — Runtime: PHP-FPM + Nginx (tek container)
### ============================================================
FROM php:8.3-fpm-alpine AS runtime

# ----- Sistem bağımlılıkları -----
RUN apk add --no-cache \
    nginx \
    supervisor \
    bash \
    curl \
    icu-data-full \
    icu-libs \
    libpng \
    libjpeg-turbo \
    libwebp \
    libzip \
    oniguruma \
    libxml2 \
  && apk add --no-cache --virtual .build-deps \
    icu-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libzip-dev \
    oniguruma-dev \
    libxml2-dev \
    autoconf \
    g++ \
    make \
  && docker-php-ext-configure intl \
  && docker-php-ext-configure gd --with-jpeg --with-webp \
  && docker-php-ext-install -j$(nproc) \
    intl \
    pdo_mysql \
    mysqli \
    gd \
    zip \
    mbstring \
    exif \
    bcmath \
    opcache \
  && apk del .build-deps

# ----- PHP yapılandırması -----
RUN { \
    echo 'memory_limit=256M'; \
    echo 'upload_max_filesize=64M'; \
    echo 'post_max_size=80M'; \
    echo 'max_execution_time=120'; \
    echo 'opcache.enable=1'; \
    echo 'opcache.memory_consumption=192'; \
    echo 'opcache.max_accelerated_files=20000'; \
    echo 'opcache.validate_timestamps=0'; \
    echo 'opcache.jit=tracing'; \
    echo 'opcache.jit_buffer_size=128M'; \
} > /usr/local/etc/php/conf.d/dentila.ini

WORKDIR /var/www/html

# Uygulama + vendor (composer stage'inden)
COPY --from=vendor /app /var/www/html
# Derlenmiş frontend asset'leri (node stage'inden)
COPY --from=assets /app/public/build /var/www/html/public/build

# Sahiplik
RUN chown -R www-data:www-data /var/www/html \
  && chmod -R 775 storage bootstrap/cache

# ----- Nginx -----
COPY docker/nginx.conf /etc/nginx/nginx.conf

# ----- Supervisor (php-fpm + nginx) -----
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ----- Entrypoint -----
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
