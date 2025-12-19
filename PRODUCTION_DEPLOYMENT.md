# 🚀 Production Deployment Guide - Pewaca

## 📋 Pre-Deployment Checklist

### 1. Server Requirements
- [x] PHP 8.2 atau lebih tinggi
- [x] MySQL 5.7+ atau MariaDB 10.3+
- [x] Composer 2.x
- [x] Web Server (Apache/Nginx)
- [x] SSL Certificate (HTTPS wajib untuk OneSignal)
- [x] Git

### 2. PHP Extensions Required
```bash
php -m | grep -E 'PDO|pdo_mysql|mbstring|tokenizer|xml|ctype|json|bcmath|openssl|curl'
```

Pastikan semua extension ini ter-install:
- PDO
- pdo_mysql
- mbstring
- tokenizer
- xml
- ctype
- json
- bcmath
- openssl
- curl

---

## 🔧 Installation Steps

### Step 1: Clone Repository
```bash
cd /var/www/html  # atau path server Anda
git clone <repository-url> pewaca_fe
cd pewaca_fe
```

### Step 2: Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
```

### Step 3: Setup Environment
```bash
cp .env.example .env
nano .env  # atau editor lain
```

**Update .env untuk Production:**
```env
APP_NAME=Pewaca
APP_ENV=production
APP_DEBUG=false  # WAJIB false di production!
APP_URL=https://pewaca.id

# Database Production
DB_CONNECTION=mysql
DB_HOST=43.156.75.206
DB_PORT=3306
DB_DATABASE=pewaca_dev
DB_USERNAME=pewaca_user
DB_PASSWORD=<password-production>

# API
API_URL=https://admin.pewaca.id
API_BASE_URL=https://admin.pewaca.id

# OneSignal - PRODUCTION CREDENTIALS
ONESIGNAL_APP_ID=<production-app-id>
ONESIGNAL_REST_API_KEY=<production-rest-api-key>

# Session
SESSION_DRIVER=file
SESSION_LIFETIME=10080
SESSION_SECURE_COOKIE=true  # Wajib true untuk HTTPS
SANCTUM_STATEFUL_DOMAINS=pewaca.id
```

### Step 4: Generate Application Key
```bash
php artisan key:generate
```

### Step 5: Cache Configuration
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 6: Set Permissions
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Step 7: Run Database Migration (jika ada)
```bash
php artisan migrate --force
```

---

## 🔔 OneSignal Production Setup

### 1. Create/Configure Production App
1. Login ke https://onesignal.com
2. Pilih App yang existing atau buat baru:
   - **App Name**: Pewaca Production
   
3. **Configure Web Platform:**
   - Click "Settings" → "Platforms" → "Web"
   - **Site Name**: Pewaca
   - **Site URL**: `https://pewaca.id`
   - **Auto Resubscribe**: ✅ Enable
   - **Default Notification Icon**: Upload icon 256x256px
   - **Permission Prompt**: Customize message
   - ❌ **DISABLE "Local Testing"** (hanya untuk localhost)

4. **Get Credentials:**
   - Copy **App ID**
   - Go to "Settings" → "Keys & IDs"
   - Copy **REST API Key**
   - Update di .env production

### 2. Upload Service Worker Files
Pastikan file ini ada di `public/`:
- `OneSignalSDKWorker.js`
- `OneSignalSDK.sw.js`

### 3. Test Production OneSignal
```
https://pewaca.id/test/onesignal
```

---

## 🌐 Web Server Configuration

### Nginx Configuration
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name pewaca.id www.pewaca.id;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name pewaca.id www.pewaca.id;
    root /var/www/html/pewaca_fe/public;

    # SSL Configuration
    ssl_certificate /etc/ssl/certs/pewaca.crt;
    ssl_certificate_key /etc/ssl/private/pewaca.key;
    ssl_protocols TLSv1.2 TLSv1.3;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Apache Configuration (.htaccess already included in Laravel)
Pastikan mod_rewrite enabled:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

---

## 🔐 Security Checklist

- [ ] APP_DEBUG=false di .env
- [ ] APP_KEY ter-generate
- [ ] SESSION_SECURE_COOKIE=true
- [ ] SSL Certificate installed
- [ ] File permissions correct (775 storage, 644 .env)
- [ ] .env tidak di-commit ke git
- [ ] Database password yang kuat
- [ ] CORS configured properly

---

## 🧪 Post-Deployment Testing

### 1. Test Basic Functionality
- [ ] Homepage loading: https://pewaca.id
- [ ] Login: https://pewaca.id/login
- [ ] Session working
- [ ] Database connection OK

### 2. Test OneSignal
- [ ] https://pewaca.id/test/onesignal
- [ ] Subscribe berhasil
- [ ] Test notification terkirim
- [ ] Check OneSignal Dashboard → Audience

### 3. Test Features
- [ ] CCTV list & monitoring
- [ ] Account switching (Warga/Pengurus)
- [ ] Payment upload & notification
- [ ] All routes accessible

---

## 📊 Monitoring & Maintenance

### View Logs
```bash
tail -f storage/logs/laravel.log
```

### Clear Cache (jika update code)
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Optimize untuk Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## 🐛 Troubleshooting

### OneSignal tidak muncul notifikasi
1. Cek Console browser (F12) untuk error
2. Verifikasi App ID & REST API Key di .env
3. Pastikan HTTPS aktif (wajib!)
4. Cek OneSignal Dashboard → Delivery untuk error

### Session tidak persist
1. Pastikan SESSION_SECURE_COOKIE=true
2. Cek permissions folder storage/framework/sessions
3. Verifikasi HTTPS aktif

### 500 Error
1. Cek `storage/logs/laravel.log`
2. Pastikan APP_DEBUG=true sementara untuk debug
3. Cek permissions storage & bootstrap/cache

---

## 📝 Deployment Command Summary

```bash
# Di server production
cd /var/www/html/pewaca_fe
git pull origin main
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 🎯 Rollback Plan

Jika terjadi masalah setelah deployment:

```bash
# Restore ke commit sebelumnya
git log --oneline  # lihat commit history
git reset --hard <commit-hash>

# Clear semua cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## ✅ Success Criteria

Deployment berhasil jika:
- ✅ Website accessible via HTTPS
- ✅ Login berfungsi normal
- ✅ OneSignal subscription berhasil
- ✅ Test notification terkirim
- ✅ Tidak ada error di logs
- ✅ All features working
- ✅ Performance acceptable (<2s page load)

---

**Last Updated:** 19 December 2025
**Version:** 1.0
