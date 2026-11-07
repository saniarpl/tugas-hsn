# FrankenPHP + Caddy — Laravel on Vercel (Container Service)
# Ref: https://vercel.com/kb/guide/laravel-php-with-docker
FROM dunglas/frankenphp:1-php8.4-bookworm AS base

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && echo "max_execution_time = 300" >> "$PHP_INI_DIR/php.ini" \
    && echo "max_input_time = 300" >> "$PHP_INI_DIR/php.ini" \
    && echo "default_socket_timeout = 300" >> "$PHP_INI_DIR/php.ini" \
    && install-php-extensions pdo_pgsql gd intl zip bcmath

WORKDIR /app

FROM base AS dependencies

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --optimize-autoloader \
    --prefer-dist

FROM node:22-bookworm-slim AS assets

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources resources
COPY vite.config.js ./
RUN npm run build

FROM base AS runtime

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . .
# COPY . . di Buildah tidak menghormati .dockerignore untuk `vendor`,
# jadi hapus vendor + cache host secara eksplisit sebelum menyalin vendor production.
# Tanpa ini, vendor lokal (76+ packages termasuk Boost) akan merge ke image.
RUN rm -rf /app/vendor \
    && rm -f /app/bootstrap/cache/packages.php /app/bootstrap/cache/services.php \
    && rm -rf /app/public/storage \
    && ln -s /app/storage/app/public /app/public/storage
COPY --from=dependencies /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build
COPY --chown=www-data:www-data Caddyfile /etc/frankenphp/Caddyfile

RUN grep -c "laravel/boost" vendor/composer/installed.json && echo "ERROR: laravel/boost in installed.json" && exit 1 || echo "OK: laravel/boost NOT in installed.json" \
    && test ! -f vendor/laravel/boost/composer.json || (echo "ERROR: Boost found in production vendor" && exit 1) \
    && mkdir -p \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/app/public \
        bootstrap/cache \
    && rm -f bootstrap/cache/packages.php bootstrap/cache/services.php \
    && composer dump-autoload --no-dev --classmap-authoritative \
    && mkdir -p /config/caddy /data/caddy \
    && setcap CAP_NET_BIND_SERVICE=+eip /usr/local/bin/frankenphp \
    && chown -R www-data:www-data /app/storage /app/bootstrap/cache /config/caddy /data/caddy

ENV PORT=80 \
    APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    CACHE_STORE=database \
    SESSION_DRIVER=database \
    QUEUE_CONNECTION=sync

USER www-data

CMD ["frankenphp", "run", "--config", "/etc/frankenphp/Caddyfile"]
