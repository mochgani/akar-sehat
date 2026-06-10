# Panduan Deploy Akar Sehat ke cPanel

## Prasyarat Hosting
- PHP 8.2+ dengan ekstensi: pdo, pdo_mysql, mbstring, openssl, tokenizer, xml, ctype, json, bcmath
- MySQL 5.7+ atau MariaDB 10.3+
- mod_rewrite aktif (untuk .htaccess)
- Akses SSH atau File Manager cPanel

---

## Langkah 1 — Persiapan Database

Di cPanel → MySQL Databases:
1. Buat database baru: `namauser_akarsehat`
2. Buat user MySQL baru dengan password kuat
3. Assign user ke database (pilih ALL PRIVILEGES)
4. Catat: host, nama database, username, password

---

## Langkah 2 — Upload File

**Struktur upload di cPanel:**
```
public_html/          ← isi dengan konten dari folder public/
akar-sehat/           ← semua file Laravel KECUALI folder public/
  app/
  bootstrap/
  config/
  database/
  resources/
  routes/
  storage/
  vendor/
  .env
  artisan
  composer.json
  ... dst
```

**Cara paling mudah:**
1. Zip seluruh project (kecuali `vendor/` dan `node_modules/`)
2. Upload via File Manager cPanel
3. Ekstrak di luar `public_html/`
4. Upload isi folder `public/` ke dalam `public_html/`

---

## Langkah 3 — Konfigurasi .env untuk Production

Edit file `.env` di server:

```env
APP_NAME="Akar Sehat"
APP_ENV=production
APP_KEY=base64:...    # generate dengan: php artisan key:generate
APP_DEBUG=false
APP_URL=https://domainanda.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=namauser_akarsehat
DB_USERNAME=namauser_dbuser
DB_PASSWORD=password_database

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

---

## Langkah 4 — Update public/index.php

Setelah file displit (Laravel di luar public_html, public/ di dalam public_html), edit `public_html/index.php`:

```php
<?php

// Ganti path ini sesuai lokasi Laravel di server
require __DIR__.'/../akar-sehat/vendor/autoload.php';

$app = require_once __DIR__.'/../akar-sehat/bootstrap/app.php';
```

Juga update `public_html/.htaccess` — sudah ada, tidak perlu diubah.

---

## Langkah 5 — Install Dependencies & Setup

Via SSH di folder Laravel (`akar-sehat/`):

```bash
# Install dependencies tanpa dev packages
composer install --no-dev --optimize-autoloader

# Generate app key (jika belum ada di .env)
php artisan key:generate

# Jalankan migrations
php artisan migrate --force

# Isi data awal (jalankan hanya sekali)
php artisan db:seed --force

# Buat symlink storage
php artisan storage:link

# Set permission folder
chmod -R 775 storage bootstrap/cache

# Caching untuk performa optimal
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

---

## Langkah 6 — Aktifkan OPcache (opsional, tapi disarankan)

Di cPanel → PHP Selector / MultiPHP INI Editor, tambahkan:

```ini
opcache.enable=1
opcache.memory_consumption=64
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
```

---

## Perintah Setelah Update Code

Setiap kali update file di server, jalankan:

```bash
php artisan config:clear && php artisan config:cache
php artisan route:clear  && php artisan route:cache
php artisan view:clear   && php artisan view:cache
```

---

## Login Admin

URL: `https://domainanda.com/admin/login`

| Field    | Value          |
|----------|----------------|
| Username | `kangbahri`    |
| Password | `akarsehat123` |

**PENTING:** Ganti password admin segera setelah deploy pertama!

---

## Troubleshooting

| Masalah | Solusi |
|---------|--------|
| Error 500 | Cek `storage/logs/laravel.log`, pastikan `APP_DEBUG=true` sementara |
| 404 Not Found | Pastikan mod_rewrite aktif dan .htaccess ter-upload |
| Database error | Cek kredensial di .env, pastikan user MySQL punya privileges |
| Permission error | `chmod -R 775 storage bootstrap/cache` |
| Class not found | Jalankan ulang `composer install --no-dev --optimize-autoloader` |
