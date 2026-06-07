#!/bin/sh
set -e

cd /var/www/html

# Yazılabilir dizinler
mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# APP_KEY yoksa üret (Coolify'da env verilmemişse demo için)
if [ -z "${APP_KEY}" ]; then
    echo "APP_KEY boş — geçici anahtar üretiliyor…"
    php artisan key:generate --force || true
fi

# Storage symlink (idempotent)
if [ ! -L public/storage ]; then
    php artisan storage:link || true
fi

# DB hazır olana kadar bekle
if [ -n "${DB_HOST}" ] && [ -n "${DB_PORT}" ]; then
    echo "DB bekleniyor: ${DB_HOST}:${DB_PORT}…"
    i=0
    until nc -z -w1 "${DB_HOST}" "${DB_PORT}" 2>/dev/null; do
        i=$((i+1))
        [ "$i" -ge 60 ] && echo "DB zaman aşımı (devam ediliyor)" && break
        sleep 1
    done
    echo "DB erişilebilir."
fi

# Migration (idempotent)
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    php artisan migrate --force --no-interaction || echo "Migration hatası (devam ediliyor)"
fi

# Demo verisini yalnızca ilk kurulumda (tedavi tablosu boşsa) yükle
if [ "${RUN_SEED:-true}" = "true" ]; then
    SEED_COUNT=$(php artisan tinker --execute='echo \App\Models\Treatment::count();' 2>/dev/null | tr -dc '0-9' | tail -c 6)
    if [ "${SEED_COUNT:-0}" = "0" ]; then
        echo "Veritabanı boş — demo verisi yükleniyor…"
        php artisan db:seed --force --no-interaction || echo "Seed hatası (devam ediliyor)"
    else
        echo "Veri mevcut (${SEED_COUNT} tedavi) — seed atlandı."
    fi
fi

# Production cache'leri
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Ana komutu çalıştır (supervisord)
exec "$@"
