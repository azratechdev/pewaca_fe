# Panduan Debugging Backend Django - Error Registrasi Warga

## 🚨 Error Summary

**Error**: `Field 'user_id' doesn't have a default value` (MySQL Error 1364)  
**Endpoint**: `POST /api/auth/sign-up/{uuid}/`  
**HTTP Status**: 400 Bad Request  
**Impact**: Warga tidak bisa registrasi baru

---

## 🔍 Root Cause Analysis

### Masalah Utama:
Django mencoba membuat record di tabel **profile/residence_resident** (atau tabel relasi user lainnya) **SEBELUM** membuat record di tabel `auth_user`. Karena field `user_id` di tabel profile adalah **Foreign Key yang NOT NULL tanpa default value**, MySQL reject operasi INSERT tersebut.

### Urutan Yang Salah:
```python
# ❌ SALAH - Profile dibuat sebelum User
1. Serializer menerima data registrasi
2. Django mencoba INSERT ke tabel profile/resident
3. Field user_id kosong (user belum dibuat)
4. MySQL error: "Field 'user_id' doesn't have a default value"
```

### Urutan Yang Benar:
```python
# ✅ BENAR - User dibuat dulu, baru Profile
1. Serializer menerima data registrasi
2. Django create auth_user terlebih dahulu
3. Assign user.id ke profile.user_id
4. Baru INSERT profile/resident
```

---

## 📋 Step-by-Step Debugging Trace

### 1. Enable Django Debug Mode

Edit `settings.py`:
```python
DEBUG = True

LOGGING = {
    'version': 1,
    'disable_existing_loggers': False,
    'handlers': {
        'console': {
            'class': 'logging.StreamHandler',
        },
    },
    'loggers': {
        'django.db.backends': {
            'handlers': ['console'],
            'level': 'DEBUG',
        },
    },
}
```

Restart Django server, sekarang setiap SQL query akan tercetak di console.

---

### 2. Reproduce Error dengan Full Traceback

Gunakan Postman atau bash script untuk kirim POST request:

```bash
curl -X POST "https://admin.pewaca.id/api/auth/sign-up/350c228d-2121-47fd-a808-456a7523e527/" \
  -F "email=test@example.com" \
  -F "password=testpass123" \
  -F "first_name=John" \
  -F "last_name=Doe" \
  -F "nik=1234567890123456" \
  -F "phone=081234567890" \
  -F "unit=1"
```

**Lihat console Django**, akan ada error traceback seperti:

```
Traceback (most recent call last):
  File "/path/to/views.py", line XX, in create
    serializer.save()
  File "/path/to/serializers.py", line XX, in create
    resident = MResidenceResident.objects.create(**validated_data)
  File "/path/to/models.py", line XX, in create
    return self.model(**kwargs).save()
django.db.utils.IntegrityError: (1364, "Field 'user_id' doesn't have a default value")
```

**Catat line number** dari error tersebut!

---

### 3. Inspect Serializer Code

Buka file serializer untuk endpoint sign-up (kemungkinan di `api/serializers.py` atau `auth/serializers.py`):

```python
class SignUpSerializer(serializers.ModelSerializer):
    
    def create(self, validated_data):
        # ⚠️ CEK BAGIAN INI - Apakah user dibuat terlebih dahulu?
        
        # ❌ CONTOH KODE YANG SALAH:
        resident = MResidenceResident.objects.create(
            email=validated_data['email'],
            # user_id tidak ada! Error di sini!
        )
        
        # ✅ CONTOH KODE YANG BENAR:
        # 1. Create user dulu
        user = User.objects.create_user(
            username=validated_data['email'],
            email=validated_data['email'],
            password=validated_data['password'],
            first_name=validated_data['first_name'],
            last_name=validated_data['last_name'],
        )
        
        # 2. Baru create resident dengan user_id
        resident = MResidenceResident.objects.create(
            user=user,  # ← PENTING!
            nik=validated_data['nik'],
            phone=validated_data['phone'],
            unit_id=validated_data['unit'],
        )
        
        return resident
```

---

### 4. Check Database Schema

Jalankan di MySQL console:

```sql
-- Lihat struktur tabel user/resident
SHOW CREATE TABLE auth_user;
SHOW CREATE TABLE main_residence_resident;  -- atau nama tabel profile/resident

-- Cek apakah user_id adalah NOT NULL tanpa default
DESC main_residence_resident;
```

Output yang bermasalah:
```
+----------+---------+------+-----+---------+
| Field    | Type    | Null | Key | Default |
+----------+---------+------+-----+---------+
| user_id  | int(11) | NO   | MUL | NULL    |  ← Ini masalahnya!
+----------+---------+------+-----+---------+
```

---

### 5. Check Django Models

Buka file model (kemungkinan `main/models/m_residence_resident.py` atau `main/models.py`):

```python
class MResidenceResident(models.Model):
    user = models.ForeignKey(
        User,
        on_delete=models.CASCADE,
        # ⚠️ CEK: Apakah ada null=True atau default?
    )
    nik = models.CharField(max_length=16)
    phone = models.CharField(max_length=15)
    # ... field lainnya
```

**Jika tidak ada `null=True` atau `default=...`**, field ini wajib diisi!

---

### 6. Check Migration History

```bash
# Lihat migration history
python manage.py showmigrations

# Lihat isi migration terakhir untuk app 'main'
python manage.py sqlmigrate main 0001  # ganti dengan nomor migration terakhir
```

Cari apakah ada migration yang ALTER table user_id.

---

## 🔧 Cara Memperbaiki

### **Opsi 1: Fix Serializer (RECOMMENDED)**

Edit serializer untuk create user terlebih dahulu:

```python
# auth/serializers.py atau api/serializers.py

from django.contrib.auth.models import User
from rest_framework import serializers

class SignUpSerializer(serializers.Serializer):
    email = serializers.EmailField()
    password = serializers.CharField(write_only=True)
    first_name = serializers.CharField()
    last_name = serializers.CharField()
    nik = serializers.CharField(max_length=16)
    phone = serializers.CharField(max_length=15)
    unit = serializers.IntegerField()
    
    def create(self, validated_data):
        # 1. Extract data
        email = validated_data['email']
        password = validated_data.pop('password')
        first_name = validated_data['first_name']
        last_name = validated_data['last_name']
        unit_id = validated_data['unit']
        
        # 2. Create User FIRST
        user = User.objects.create_user(
            username=email,
            email=email,
            password=password,
            first_name=first_name,
            last_name=last_name,
        )
        
        # 3. Create Resident with user_id
        from main.models import MResidenceResident, MResidenceUnit
        
        unit = MResidenceUnit.objects.get(id=unit_id)
        
        resident = MResidenceResident.objects.create(
            user=user,  # ← ASSIGN USER!
            nik=validated_data['nik'],
            phone=validated_data['phone'],
            unit=unit,
            residence=unit.residence,
            # ... field lainnya
        )
        
        # 4. Send verification email (if needed)
        # send_verification_email(user)
        
        return resident
```

---

### **Opsi 2: Ubah Database Schema (NOT RECOMMENDED)**

Jika benar-benar ingin user_id boleh NULL (tidak disarankan):

```python
# main/models.py

class MResidenceResident(models.Model):
    user = models.ForeignKey(
        User,
        on_delete=models.CASCADE,
        null=True,  # ← Tambahkan ini
        blank=True,
    )
```

Lalu jalankan migration:

```bash
python manage.py makemigrations
python manage.py migrate
```

⚠️ **WARNING**: Ini bukan solusi yang baik karena resident HARUS punya user!

---

## 🧪 Testing Setelah Fix

### 1. Test Manual via Django Shell

```bash
python manage.py shell
```

```python
from django.contrib.auth.models import User
from main.models import MResidenceResident, MResidenceUnit

# Test create user
user = User.objects.create_user(
    username='test@example.com',
    email='test@example.com',
    password='testpass123',
    first_name='John',
    last_name='Doe',
)

# Test create resident
unit = MResidenceUnit.objects.first()
resident = MResidenceResident.objects.create(
    user=user,
    nik='1234567890123456',
    phone='081234567890',
    unit=unit,
    residence=unit.residence,
)

print(f"✅ Success! User ID: {user.id}, Resident ID: {resident.id}")
```

Jika berhasil tanpa error, serializer sudah bisa diperbaiki!

---

### 2. Test via API Endpoint

Gunakan Postman atau bash script dari Laravel testing tools:

```bash
# Dari Laravel project root
./tests/registration-test.sh --uuid 350c228d-2121-47fd-a808-456a7523e527
```

**Expected Response** (setelah fix):

```json
{
  "success": true,
  "message": "Registrasi berhasil. Silakan cek email untuk verifikasi.",
  "data": {
    "id": 123,
    "email": "test@example.com",
    "first_name": "John",
    "last_name": "Doe",
    "is_verified": false
  }
}
```

---

### 3. Test Full E2E Flow

1. ✅ **Sign-up** → Berhasil (HTTP 201)
2. ✅ **Email verification** → Terkirim
3. ✅ **Click verification link** → Email verified
4. ✅ **Login** → Berhasil dapat JWT token
5. ✅ **Access protected endpoint** → Authorized

---

## 📊 Debugging Checklist

### Pre-Fix Checklist:
- [ ] Enable Django DEBUG mode
- [ ] Enable SQL logging
- [ ] Reproduce error dengan full traceback
- [ ] Identifikasi file serializer yang bermasalah
- [ ] Cek database schema (SHOW CREATE TABLE)
- [ ] Cek Django model definition
- [ ] Cek migration history

### Fix Checklist:
- [ ] Edit serializer: Create User dulu sebelum Resident
- [ ] Pastikan user.id di-assign ke resident.user_id
- [ ] Test di Django shell (manual create)
- [ ] Clear Django cache (`find . -name "*.pyc" -delete`)
- [ ] Restart Django server
- [ ] Test via Postman/bash script
- [ ] Verify full E2E flow

### Post-Fix Checklist:
- [ ] Test registrasi baru berhasil (HTTP 201)
- [ ] Test email verification flow
- [ ] Test login dengan user baru
- [ ] Update dokumentasi dengan success response
- [ ] Commit changes ke git

---

## 🔗 Resources

- **Laravel Testing Tools**: `/test/registration` (web UI)
- **Bash Script**: `tests/registration-test.sh`
- **Postman Collection**: `tests/registration-api.postman_collection.json`
- **Full Documentation**: `docs/registration-scenario.md`

---

## 📞 Kontak

Jika masih ada masalah setelah mengikuti panduan ini, hubungi:
- **Frontend Team**: Laravel testing tools sudah siap
- **Backend Team**: Perlu fix serializer/model Django

---

**Last Updated**: 26 Oktober 2025  
**Version**: 1.0
