# Panduan Migrasi Lengkap ke MySQL

## Status: Semua SQLite Connection Sudah Dihapus ✅

Semua model dan migration sudah diupdate untuk menggunakan MySQL default connection.

## Models yang Diupdate:
1. ✅ `SellerRequest` - removed `sqlite_backup`
2. ✅ `Vote` - removed `voting_sqlite`
3. ✅ `Candidate` - removed `voting_sqlite`
4. ✅ `Payment` - removed `sqlite`
5. ✅ `PaymentLog` - removed `sqlite`
6. ✅ `WebhookEvent` - removed `sqlite`
7. ✅ `Settlement` - removed `sqlite`

## Migration Files yang Diupdate:
1. ✅ `2025_11_02_102931_create_candidates_table.php` - removed connection('voting_sqlite')
2. ✅ `2025_11_02_102946_create_votes_table.php` - removed connection('voting_sqlite')

---

## LANGKAH 1: Update File .env

**Buka file `.env` dan ubah baris ke-14:**

```env
# SEBELUM:
DB_CONNECTION=sqlite_backup

# SESUDAH:
DB_CONNECTION=mysql
```

**Simpan file `.env`**

---

## LANGKAH 2: Jalankan SQL Queries di MySQL Server

**Login ke MySQL Production:**
```bash
mysql -h 43.156.75.206 -u root -p
```

**Masukkan password:** `NewStrongPwd_123!`

**Pilih database:**
```sql
USE pewaca_v1;
```

---

## SQL QUERIES UNTUK MEMBUAT SEMUA TABLE

### 1. Table: seller_requests
```sql
CREATE TABLE IF NOT EXISTS `seller_requests` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_address` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `rejection_reason` text COLLATE utf8mb4_unicode_ci,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seller_requests_user_id_foreign` (`user_id`),
  KEY `seller_requests_approved_by_foreign` (`approved_by`),
  CONSTRAINT `seller_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `seller_requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 2. Table: candidates (Voting)
```sql
CREATE TABLE IF NOT EXISTS `candidates` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `misi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `vote_count` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 3. Table: votes (Voting)
```sql
CREATE TABLE IF NOT EXISTS `votes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `voter_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `house_block` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `votes_candidate_id_foreign` (`candidate_id`),
  CONSTRAINT `votes_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 4. Table: payments (QRIS Payment)
```sql
CREATE TABLE IF NOT EXISTS `payments` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'IDR',
  `status` enum('CREATED','PENDING','PAID','EXPIRED','FAILED','REFUNDED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CREATED',
  `qris_payload` text COLLATE utf8mb4_unicode_ci,
  `provider_trx_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_ref_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `callback_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadata` json DEFAULT NULL,
  `signature_version` smallint(6) NOT NULL DEFAULT 1,
  `idempotency_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_order_id_unique` (`order_id`),
  UNIQUE KEY `payments_idempotency_key_unique` (`idempotency_key`),
  KEY `payments_provider_trx_id_index` (`provider_trx_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 5. Table: payment_logs (QRIS Payment)
```sql
CREATE TABLE IF NOT EXISTS `payment_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `payment_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event` enum('CREATED','WEBHOOK_SUCCESS','RETRY','EXPIRE','RECONCILE','ERROR') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` json DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_logs_payment_id_foreign` (`payment_id`),
  KEY `payment_logs_payment_id_created_at_index` (`payment_id`,`created_at`),
  CONSTRAINT `payment_logs_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 6. Table: webhook_events (QRIS Payment)
```sql
CREATE TABLE IF NOT EXISTS `webhook_events` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'qris_mock',
  `event_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` json NOT NULL,
  `received_at` timestamp NOT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `status` enum('OK','ERROR','PENDING') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `error_message` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `webhook_events_event_id_unique` (`event_id`),
  KEY `webhook_events_provider_received_at_index` (`provider`,`received_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 7. Table: settlements (QRIS Payment)
```sql
CREATE TABLE IF NOT EXISTS `settlements` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `provider_trx_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `fee` decimal(15,2) NOT NULL DEFAULT 0.00,
  `net_amount` decimal(15,2) NOT NULL,
  `settlement_date` date NOT NULL,
  `file_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reconciled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `settlements_provider_trx_id_index` (`provider_trx_id`),
  KEY `settlements_payment_id_foreign` (`payment_id`),
  KEY `settlements_settlement_date_reconciled_index` (`settlement_date`,`reconciled`),
  CONSTRAINT `settlements_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 8. Alter Table: stores (tambah kolom user_id dan product_type)
```sql
ALTER TABLE `stores` 
  ADD COLUMN `user_id` bigint(20) UNSIGNED DEFAULT NULL AFTER `id`,
  ADD COLUMN `product_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL AFTER `address`,
  ADD CONSTRAINT `stores_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
```

---

## LANGKAH 3: Seed Data Kandidat (Opsional)

Jika ingin menambahkan data kandidat pemilu:

```sql
INSERT INTO `candidates` (`name`, `photo`, `visi`, `misi`, `bio`, `vote_count`, `is_active`, `created_at`, `updated_at`) VALUES
('Budi Santoso', 'https://ui-avatars.com/api/?name=Budi+Santoso&size=512&background=5FA782&color=fff', 'Membangun lingkungan yang aman, nyaman, dan sejahtera untuk semua warga', 'Meningkatkan keamanan 24 jam, Menyediakan fasilitas umum yang memadai, Menjalin komunikasi yang baik dengan seluruh warga', 'Memiliki pengalaman 10 tahun di bidang manajemen properti dan organisasi kemasyarakatan', 0, 1, NOW(), NOW()),
('Siti Rahma Wati', 'https://ui-avatars.com/api/?name=Siti+Rahma&size=512&background=4A90E2&color=fff', 'Menciptakan lingkungan hijau dan berkelanjutan dengan partisipasi aktif warga', 'Mengembangkan taman dan area hijau, Program pengelolaan sampah terpadu, Kegiatan sosial dan budaya rutin', 'Aktivis lingkungan dengan pengalaman mengelola komunitas selama 8 tahun', 0, 1, NOW(), NOW()),
('Ahmad Hidayat', 'https://ui-avatars.com/api/?name=Ahmad+Hidayat&size=512&background=E74C3C&color=fff', 'Meningkatkan kualitas hidup warga melalui inovasi dan teknologi', 'Sistem keamanan berbasis teknologi, Digitalisasi administrasi warga, Program pelatihan dan pemberdayaan', 'Profesional IT dengan pengalaman organisasi masyarakat 5 tahun', 0, 1, NOW(), NOW());
```

---

## LANGKAH 4: Clear Cache & Restart Server

Setelah semua query dijalankan, clear cache Laravel:

```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
```

Restart server PHP artisan:
```bash
php artisan serve --host=0.0.0.0 --port=5000
```

---

## Verifikasi

Cek apakah semua table sudah ada:

```sql
SHOW TABLES LIKE '%seller_requests%';
SHOW TABLES LIKE '%candidates%';
SHOW TABLES LIKE '%votes%';
SHOW TABLES LIKE '%payments%';
SHOW TABLES LIKE '%payment_logs%';
SHOW TABLES LIKE '%webhook_events%';
SHOW TABLES LIKE '%settlements%';
```

Cek struktur table:
```sql
DESCRIBE seller_requests;
DESCRIBE candidates;
DESCRIBE votes;
```

---

## DONE! ✅

Setelah semua langkah selesai:
1. ✅ Tidak ada lagi SQLite connection di models
2. ✅ Tidak ada lagi SQLite connection di migrations  
3. ✅ Semua table dibuat di MySQL production
4. ✅ Application siap menggunakan 100% MySQL

---

## Troubleshooting

**Error "Table already exists":**
- Skip table yang sudah ada
- Atau tambahkan `DROP TABLE IF EXISTS` sebelum CREATE (hati-hati data akan hilang!)

**Error foreign key constraint:**
- Pastikan table parent (users, payments) sudah ada sebelum membuat child table
- Urutan pembuatan table harus sesuai dependency

**Connection timeout:**
- Cek koneksi ke server 43.156.75.206
- Pastikan firewall tidak memblokir port 3306
