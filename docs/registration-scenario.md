# Skenario Registrasi Warga - Pewaca Residence

## Daftar Isi
1. [Overview](#overview)
2. [Flow Diagram](#flow-diagram)
3. [API Endpoints](#api-endpoints)
4. [Langkah-langkah Registrasi](#langkah-langkah-registrasi)
5. [Validasi & Error Handling](#validasi--error-handling)
6. [Testing Scenarios](#testing-scenarios)

---

## Overview

Sistem registrasi warga Pewaca memungkinkan calon penghuni untuk mendaftar secara online menggunakan kode unik yang diberikan oleh pengurus residence. Setelah registrasi berhasil, warga akan menerima email verifikasi untuk mengaktifkan akun mereka.

**Base URL API**: `https://admin.pewaca.id/api`

**Teknologi**:
- Backend: Django REST Framework
- Frontend: Laravel 9 (Blade Templates)
- Database: MySQL (Backend), SQLite (Payment)

---

## Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                    SKENARIO REGISTRASI WARGA                    │
└─────────────────────────────────────────────────────────────────┘

1. PENGURUS MEMBERIKAN KODE REGISTRASI
   │
   └──> Kode UUID unik untuk residence tertentu
        Contoh: a1b2c3d4-e5f6-7890-abcd-ef1234567890

2. WARGA MENGAKSES LINK REGISTRASI
   │
   └──> URL: /registration/{uuid}
        GET Request ke API untuk data residence & master data

3. LOAD DATA MASTER
   ├──> GET /api/residence-by-code/{code}/    (Data Residence)
   ├──> GET /api/units/code/{code}/           (Daftar Unit)
   ├──> GET /api/gender/                      (Jenis Kelamin)
   ├──> GET /api/religions/                   (Agama)
   ├──> GET /api/family-as/                   (Status Keluarga)
   ├──> GET /api/education/                   (Pendidikan)
   ├──> GET /api/ocupation/                   (Pekerjaan)
   ├──> GET /api/marital-statuses/            (Status Pernikahan)
   └──> GET /api/cities/                      (Kota)

4. WARGA MENGISI FORM REGISTRASI
   │
   └──> Data yang dibutuhkan:
        - No Unit (unit_id)
        - NIK (16 digit)
        - Nama Lengkap
        - No HP
        - Jenis Kelamin
        - Tanggal Lahir
        - Agama
        - Tempat Lahir
        - Status Pernikahan
        - Pekerjaan
        - Pendidikan
        - Status Keluarga
        - Email
        - Password
        - Foto Profil (opsional)
        - Foto Pernikahan (jika sudah menikah)

5. SUBMIT REGISTRASI
   │
   └──> POST /api/auth/sign-up/{code}/
        - Multipart/form-data (untuk upload foto)
        - Validasi di frontend & backend

6. RESPONSE SUCCESS
   │
   └──> Redirect ke halaman "Cek Email"
        Notifikasi: "Silakan cek email untuk verifikasi"

7. WARGA CEK EMAIL
   │
   └──> Email berisi link verifikasi:
        https://pewaca-frontend.repl.co/verified/{uidb64}/{token}/

8. KLIK LINK VERIFIKASI
   │
   └──> GET /api/auth/verify/{uidb64}/{token}/
        - Success: Akun terverifikasi
        - Error: Token tidak valid/expired

9. VERIFIKASI BERHASIL
   │
   └──> Redirect ke halaman login
        Warga bisa login dengan email & password

10. LOGIN
    │
    └──> POST /api/auth/login/
         - email
         - password
         Response: Token JWT untuk autentikasi

┌─────────────────────────────────────────────────────────────────┐
│                         SELESAI                                 │
│              Warga berhasil terdaftar dan login                 │
└─────────────────────────────────────────────────────────────────┘
```

---

## API Endpoints

### 1. Get Residence by Code
**Endpoint**: `GET /api/residence-by-code/{code}/`

**Description**: Mengambil informasi residence berdasarkan kode registrasi

**Request**:
```http
GET https://admin.pewaca.id/api/residence-by-code/a1b2c3d4-e5f6-7890-abcd-ef1234567890/
Accept: application/json
```

**Response Success (200)**:
```json
{
  "data": {
    "residence_id": 1,
    "residence_name": "Residence Pewaca",
    "residence_code": "a1b2c3d4-e5f6-7890-abcd-ef1234567890",
    "address": "Jl. Contoh No. 123",
    "city": "Jakarta"
  }
}
```

---

### 2. Get Units by Code
**Endpoint**: `GET /api/units/code/{code}/`

**Description**: Mengambil daftar unit dalam residence

**Request**:
```http
GET https://admin.pewaca.id/api/units/code/a1b2c3d4-e5f6-7890-abcd-ef1234567890/
Accept: application/json
```

**Response Success (200)**:
```json
{
  "data": [
    {
      "unit_id": 1,
      "unit_name": "A-101"
    },
    {
      "unit_id": 2,
      "unit_name": "A-102"
    }
  ]
}
```

---

### 3. Get Gender List
**Endpoint**: `GET /api/gender/`

**Request**:
```http
GET https://admin.pewaca.id/api/gender/
Accept: application/json
```

**Response Success (200)**:
```json
{
  "data": [
    {
      "gender_id": 1,
      "gender_name": "Laki-laki"
    },
    {
      "gender_id": 2,
      "gender_name": "Perempuan"
    }
  ]
}
```

---

### 4. Get Religion List
**Endpoint**: `GET /api/religions/`

**Request**:
```http
GET https://admin.pewaca.id/api/religions/
Accept: application/json
```

**Response Success (200)**:
```json
{
  "data": [
    {
      "id": 1,
      "religion_name": "Islam"
    },
    {
      "id": 2,
      "religion_name": "Kristen"
    },
    {
      "id": 3,
      "religion_name": "Katolik"
    },
    {
      "id": 4,
      "religion_name": "Hindu"
    },
    {
      "id": 5,
      "religion_name": "Buddha"
    },
    {
      "id": 6,
      "religion_name": "Konghucu"
    }
  ]
}
```

---

### 5. Get Family Role List
**Endpoint**: `GET /api/family-as/`

**Request**:
```http
GET https://admin.pewaca.id/api/family-as/
Accept: application/json
```

**Response Success (200)**:
```json
{
  "data": [
    {
      "id": 1,
      "family_as_name": "Kepala Keluarga"
    },
    {
      "id": 2,
      "family_as_name": "Istri"
    },
    {
      "id": 3,
      "family_as_name": "Anak"
    }
  ]
}
```

---

### 6. Get Education List
**Endpoint**: `GET /api/education/`

**Request**:
```http
GET https://admin.pewaca.id/api/education/
Accept: application/json
```

**Response Success (200)**:
```json
{
  "data": [
    {
      "id": 1,
      "education_name": "SD"
    },
    {
      "id": 2,
      "education_name": "SMP"
    },
    {
      "id": 3,
      "education_name": "SMA"
    },
    {
      "id": 4,
      "education_name": "D3"
    },
    {
      "id": 5,
      "education_name": "S1"
    },
    {
      "id": 6,
      "education_name": "S2"
    },
    {
      "id": 7,
      "education_name": "S3"
    }
  ]
}
```

---

### 7. Get Occupation List
**Endpoint**: `GET /api/ocupation/`

**Request**:
```http
GET https://admin.pewaca.id/api/ocupation/
Accept: application/json
```

**Response Success (200)**:
```json
{
  "data": [
    {
      "id": 1,
      "occupation_name": "PNS"
    },
    {
      "id": 2,
      "occupation_name": "Swasta"
    },
    {
      "id": 3,
      "occupation_name": "Wiraswasta"
    },
    {
      "id": 4,
      "occupation_name": "Mahasiswa"
    }
  ]
}
```

---

### 8. Get Marital Status List
**Endpoint**: `GET /api/marital-statuses/`

**Request**:
```http
GET https://admin.pewaca.id/api/marital-statuses/
Accept: application/json
```

**Response Success (200)**:
```json
{
  "data": [
    {
      "id": 1,
      "marital_status_name": "Belum Menikah"
    },
    {
      "id": 2,
      "marital_status_name": "Menikah"
    },
    {
      "id": 3,
      "marital_status_name": "Cerai"
    }
  ]
}
```

---

### 9. Get Cities List
**Endpoint**: `GET /api/cities/`

**Request**:
```http
GET https://admin.pewaca.id/api/cities/
Accept: application/json
```

**Response Success (200)**:
```json
{
  "data": [
    {
      "id": 1,
      "city_name": "Jakarta"
    },
    {
      "id": 2,
      "city_name": "Bandung"
    }
  ]
}
```

---

### 10. Sign Up (Registration)
**Endpoint**: `POST /api/auth/sign-up/{code}/`

**Description**: Submit data registrasi warga baru

**Request**:
```http
POST https://admin.pewaca.id/api/auth/sign-up/a1b2c3d4-e5f6-7890-abcd-ef1234567890/
Content-Type: multipart/form-data
Accept: application/json

Form Data:
- email: warga@example.com
- password: SecurePass123
- unit_id: 1
- nik: 1234567890123456
- full_name: John Doe
- phone_no: 081234567890
- gender_id: 1
- date_of_birth: 1990-01-15
- religion: 1
- place_of_birth: Jakarta
- marital_status: 2
- occupation: 2
- education: 5
- family_as: 1
- code: a1b2c3d4-e5f6-7890-abcd-ef1234567890
- profile_photo: [file]
- marital_photo: [file] (jika menikah)
```

**Response Success (201)**:
```json
{
  "success": true,
  "message": "Registrasi berhasil. Silakan cek email untuk verifikasi.",
  "data": {
    "user_id": 123,
    "email": "warga@example.com",
    "full_name": "John Doe"
  }
}
```

**Response Error (400)**:
```json
{
  "success": false,
  "message": "Validasi gagal",
  "errors": {
    "email": ["Email sudah terdaftar"],
    "nik": ["NIK harus 16 digit"]
  }
}
```

---

### 11. Email Verification
**Endpoint**: `GET /api/auth/verify/{uidb64}/{token}/`

**Description**: Verifikasi email setelah registrasi

**Request**:
```http
GET https://admin.pewaca.id/api/auth/verify/MQ/abc123-def456/
Accept: application/json
```

**Response Success (200)**:
```json
{
  "success": true,
  "message": "Email berhasil diverifikasi. Silakan login."
}
```

**Response Error (400)**:
```json
{
  "success": false,
  "message": "Token verifikasi tidak valid atau sudah kadaluarsa."
}
```

---

### 12. Resend Verification Email
**Endpoint**: `POST /api/auth/verify/resend/`

**Description**: Mengirim ulang email verifikasi

**Request**:
```http
POST https://admin.pewaca.id/api/auth/verify/resend/
Content-Type: application/json
Accept: application/json

{
  "email": "warga@example.com"
}
```

**Response Success (200)**:
```json
{
  "success": true,
  "message": "Email verifikasi telah dikirim ulang."
}
```

---

### 13. Login
**Endpoint**: `POST /api/auth/login/`

**Description**: Login untuk mendapatkan token autentikasi

**Request**:
```http
POST https://admin.pewaca.id/api/auth/login/
Content-Type: application/json
Accept: application/json

{
  "email": "warga@example.com",
  "password": "SecurePass123"
}
```

**Response Success (200)**:
```json
{
  "success": true,
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "user": {
    "user_id": 123,
    "email": "warga@example.com",
    "full_name": "John Doe",
    "role": "warga"
  }
}
```

**Response Error (401)**:
```json
{
  "success": false,
  "message": "Email atau password salah"
}
```

---

## Langkah-langkah Registrasi

### Step 1: Persiapan
1. Pengurus residence membuat kode registrasi unik (UUID)
2. Kode diberikan kepada calon warga (via email/WhatsApp/SMS)

### Step 2: Akses Form Registrasi
1. Warga membuka link: `https://pewaca-frontend.repl.co/registration/{uuid}`
2. Sistem load data residence dan master data dari API
3. Form registrasi ditampilkan dengan dropdown yang sudah terisi

### Step 3: Pengisian Data
1. Warga memilih **No Unit** dari dropdown
2. Mengisi **NIK** (16 digit angka)
3. Mengisi **Nama Lengkap**
4. Mengisi **No HP** (format: 08xxxxxxxxxx)
5. Memilih **Jenis Kelamin**
6. Mengisi **Tanggal Lahir** (date picker)
7. Memilih **Agama**
8. Mengisi **Tempat Lahir**
9. Memilih **Status Pernikahan**
   - Jika "Menikah": Upload foto pernikahan (wajib)
10. Memilih **Pekerjaan**
11. Memilih **Pendidikan**
12. Memilih **Status Keluarga** (Kepala Keluarga/Istri/Anak)
13. Mengisi **Email** (untuk login)
14. Mengisi **Password** (minimal 8 karakter)
15. Upload **Foto Profil** (opsional)

### Step 4: Validasi Frontend
- NIK: Harus tepat 16 digit angka
- No HP: Minimal 10 digit, maksimal 13 digit
- Email: Format email valid
- Password: Minimal 8 karakter
- Foto Pernikahan: Wajib jika status "Menikah"

### Step 5: Submit
1. Klik tombol **Daftar**
2. Loading indicator muncul
3. Data dikirim ke API via POST multipart/form-data

### Step 6: Response Handling
**Jika Success**:
- Redirect ke halaman "Cek Email"
- Sweet Alert: "Registrasi berhasil! Silakan cek email untuk verifikasi"

**Jika Error**:
- Tampilkan pesan error spesifik
- Form tetap menampilkan data yang sudah diisi
- User bisa memperbaiki dan submit ulang

### Step 7: Verifikasi Email
1. Warga cek inbox email
2. Klik link verifikasi dalam email
3. Sistem memanggil API verification
4. Jika berhasil: Sweet Alert "Verifikasi Berhasil! Silakan login"
5. Redirect ke halaman login

### Step 8: Login
1. Masukkan email & password
2. Submit login
3. Mendapat token JWT
4. Token disimpan di session
5. Redirect ke dashboard warga

---

## Validasi & Error Handling

### Frontend Validation
```javascript
// NIK: 16 digit
pattern="\d{16}" maxlength="16"

// No HP: 10-13 digit
pattern="\d{10,13}" maxlength="13"

// Email
type="email"

// Password
minlength="8"

// Foto Pernikahan
Conditional validation: required if marital_status == "Menikah"
```

### Backend Validation
- **Email**: Unique, format valid
- **NIK**: 16 digit, unique
- **Phone**: Format Indonesia
- **Password**: Minimal 8 karakter
- **Unit**: Harus ada dalam residence
- **Foto**: Format JPG/JPEG, max size

### Error Messages
| Error | Message (Bahasa) |
|-------|------------------|
| Email sudah terdaftar | Email sudah terdaftar. Gunakan email lain atau login. |
| NIK tidak valid | NIK harus 16 digit angka. |
| Unit tidak ditemukan | Unit tidak ditemukan dalam residence ini. |
| Kode tidak valid | Kode registrasi tidak valid atau sudah kadaluarsa. |
| Foto format salah | Foto harus format JPG/JPEG. |
| Foto terlalu besar (413) | Ukuran foto terlalu besar. Maksimal 2MB per file. |
| Token expired | Token verifikasi sudah kadaluarsa. Kirim ulang email verifikasi. |

---

## Testing Scenarios

### Scenario 1: Happy Path (Registrasi Sukses)
```bash
1. GET /api/residence-by-code/{valid-uuid}/
   Expected: 200 OK, data residence
   
2. GET /api/units/code/{valid-uuid}/
   Expected: 200 OK, list units
   
3. GET master data endpoints (gender, religion, etc.)
   Expected: 200 OK for all
   
4. POST /api/auth/sign-up/{valid-uuid}/
   Body: Complete valid data
   Expected: 201 Created, success message
   
5. GET /api/auth/verify/{uidb64}/{token}/
   Expected: 200 OK, verification success
   
6. POST /api/auth/login/
   Body: email + password
   Expected: 200 OK, JWT token returned
```

### Scenario 2: Invalid Code
```bash
1. GET /api/residence-by-code/{invalid-uuid}/
   Expected: 404 Not Found
   
Frontend should display: "Kode registrasi tidak valid"
```

### Scenario 3: Duplicate Email
```bash
1. POST /api/auth/sign-up/{valid-uuid}/
   Body: Email already registered
   Expected: 400 Bad Request
   Error: "Email sudah terdaftar"
```

### Scenario 4: Invalid NIK
```bash
1. POST /api/auth/sign-up/{valid-uuid}/
   Body: NIK = "12345" (less than 16 digits)
   Expected: 400 Bad Request
   Error: "NIK harus 16 digit"
```

### Scenario 5: Expired Verification Token
```bash
1. GET /api/auth/verify/{uidb64}/{expired-token}/
   Expected: 400 Bad Request
   Message: "Token sudah kadaluarsa"
```

### Scenario 6: Resend Verification
```bash
1. POST /api/auth/verify/resend/
   Body: {"email": "warga@example.com"}
   Expected: 200 OK
   Message: "Email verifikasi telah dikirim ulang"
```

---

## Troubleshooting

### Error: "413 Request Entity Too Large"

**Penyebab**:
- File upload (foto profil atau foto pernikahan) **terlalu besar**
- Ukuran melebihi batas yang diizinkan server (biasanya 2MB)

**Solusi**:
1. ✅ **Kompres foto sebelum upload**
   - Gunakan tool online: TinyPNG, Compressor.io
   - Atau resize di HP sebelum upload
   - Target ukuran: < 500KB untuk foto profil, < 1MB untuk foto lainnya

2. ✅ **Validasi ukuran di frontend**
   ```javascript
   // Tambahkan validasi ukuran file (contoh: max 2MB)
   const maxSize = 2 * 1024 * 1024; // 2MB in bytes
   if (fileInput.files[0].size > maxSize) {
       alert('Ukuran file terlalu besar! Maksimal 2MB.');
       return false;
   }
   ```

3. ✅ **Ubah format foto ke JPEG dengan kualitas lebih rendah**
   - JPEG quality 80% biasanya cukup untuk foto profil
   - Hindari PNG untuk foto (ukuran lebih besar)

**Testing**:
```bash
# Check file size before upload
ls -lh profile_photo.jpg

# Expected output: file should be < 2MB
-rw-r--r-- 1 user user 456K Oct 26 10:00 profile_photo.jpg  ✓ OK
-rw-r--r-- 1 user user 3.2M Oct 26 10:00 too_large.jpg      ✗ TOO LARGE
```

---

### Error: "Unauthorized: /api/auth/login/ [26/Oct/2025 02:37:24] POST 401"

**Kemungkinan Penyebab**:
1. ❌ **Password salah** - User input password yang tidak sesuai
2. ❌ **Email salah** - Email tidak terdaftar di database
3. ❌ **Email belum diverifikasi** - User belum klik link verifikasi
4. ❌ **Account inactive** - Account di-suspend oleh admin

**Solusi**:
```bash
# Check di database apakah email terdaftar
SELECT * FROM users WHERE email = 'xxx@example.com';

# Check status verifikasi
SELECT is_verified FROM users WHERE email = 'xxx@example.com';

# Jika lupa password, gunakan password reset
POST /api/auth/password-reset/
Body: {"email": "xxx@example.com"}
```

**Testing Login**:
```bash
curl -X POST https://admin.pewaca.id/api/auth/login/ \
  -H "Content-Type: application/json" \
  -d '{
    "email": "pengurus1@gmail.com",
    "password": "your-correct-password"
  }'
```

---

## Best Practices

### Security
1. ✅ Gunakan HTTPS untuk semua request
2. ✅ Password di-hash di backend (bcrypt/argon2)
3. ✅ Token JWT dengan expiry time
4. ✅ Validasi file upload (type, size)
5. ✅ Rate limiting untuk prevent brute force

### UX
1. ✅ Real-time validation saat user mengetik
2. ✅ Counter untuk NIK dan No HP
3. ✅ Loading state saat submit
4. ✅ Clear error messages dalam Bahasa Indonesia
5. ✅ Auto-redirect setelah sukses verifikasi

### Performance
1. ✅ Parallel loading master data endpoints
2. ✅ Image optimization sebelum upload
3. ✅ Lazy loading untuk dropdown options
4. ✅ Cache master data di frontend

---

## Lampiran

### Contoh UUID Valid
```
a1b2c3d4-e5f6-7890-abcd-ef1234567890
550e8400-e29b-41d4-a716-446655440000
```

### Contoh NIK Valid
```
3174010112900001
3201234567890123
```

### Contoh Phone Number Valid
```
081234567890
08123456789
+6281234567890
```

### Contoh Email Valid
```
warga@example.com
john.doe@gmail.com
resident123@pewaca.id
```

---

**Dokumen ini dibuat untuk membantu developer memahami flow registrasi warga secara menyeluruh.**

**Last Updated**: 26 Oktober 2025  
**Version**: 1.0  
**Author**: Pewaca Development Team
