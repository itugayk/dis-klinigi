# Mardent Ağız ve Diş Sağlığı Polikliniği — Coolify Deploy Notları

Tek container'da **PHP-FPM + Nginx + Supervisor**. MySQL Coolify üzerinde ayrı bir servis.
Migration ve demo seed entrypoint'te otomatik çalışır (seed yalnızca DB boşsa).

## 1) MySQL servisi
- Coolify → New Resource → Database → **MySQL 8**
- Veritabanı: `mardent_db` · Kullanıcı: `mardent` · Şifreyi kaydedin
- Internal hostname'i not alın (env'de `DB_HOST` olacak)

## 2) Uygulama servisi
- Coolify → New Resource → Application → **Dockerfile**
- Repo: `github.com/itugayk/dis-klinigi` · Branch: `main` · Build path: `/`
- Port: `80` · Domain: `dis-klinigi.demo.dijifa.com`

## 3) Environment Variables
```
APP_NAME=Mardent Ağız ve Diş Sağlığı Polikliniği
APP_ENV=production
APP_KEY=                      # boş bırakılırsa ilk açılışta otomatik üretilir (kalıcılık için kendiniz üretip girin: php artisan key:generate --show)
APP_DEBUG=false
APP_URL=https://dis-klinigi.demo.dijifa.com
APP_LOCALE=tr

LOG_CHANNEL=stderr
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=<coolify-mysql-internal-host>
DB_PORT=3306
DB_DATABASE=mardent_db
DB_USERNAME=mardent
DB_PASSWORD=<adım 1'deki şifre>

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=public

MAIL_MAILER=log               # gerçek e-posta için smtp + MAIL_* doldurun
MAIL_FROM_ADDRESS=info@mardent.com.tr
MAIL_FROM_NAME="Mardent Ağız ve Diş Sağlığı Polikliniği"

RUN_MIGRATIONS=true
RUN_SEED=true                 # ilk deploy'da demo veriyi yükler; doluysa atlar
```

> **APP_KEY önerisi:** Kalıcı oturumlar için kendi anahtarınızı üretip girin:
> `php artisan key:generate --show` → çıktıyı `APP_KEY` olarak yapıştırın.

## 4) Persistent Storage
- Coolify → Application → Storage → Volume mount:
  `/var/www/html/storage/app/public` (yüklenen blog görselleri kaybolmasın)

## 5) Domain & SSL
- Domain: `dis-klinigi.demo.dijifa.com` (A kaydı sunucuya yönlendirilmeli)
- Coolify otomatik Let's Encrypt SSL üretir

## 6) Health Check
- Path: `/up` → 200 "ok"

## 7) İlk deploy sonrası
- Admin paneli: `https://dis-klinigi.demo.dijifa.com/admin`
- Demo giriş: **admin@mardent.com.tr / password** (seed ile oluşur — production'da değiştirin!)
- Yeni admin: Terminal → `php artisan make:filament-user`
- **Site Ayarları** (admin → Klinik Ayarları → Site Ayarları): telefon, e-posta, çalışma
  saatleri, tatil günleri, sosyal medya — buradan düzenlenir.

## Yerel Docker testi
```bash
cp .env.example .env
echo "DB_PASSWORD=changeme" >> .env
docker compose up --build
```
- Site:  http://localhost:8080
- Admin: http://localhost:8080/admin

## Notlar
- `intl`, `gd`, `zip`, `pdo_mysql`, `opcache(+JIT)` Dockerfile'da kurulu
- Frontend asset'leri (Vite/Tailwind) image build aşamasında derlenir (node stage)
- Migration + (boşsa) seed entrypoint'te otomatik çalışır
- Storage symlink otomatik kurulur
- Demo görselleri Unsplash'tan çekilir; admin'den kendi görsellerinizi yükleyebilirsiniz
