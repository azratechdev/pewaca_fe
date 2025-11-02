# Placeholder Avatars untuk Pewaca

## 📸 Daftar File Avatar

Folder ini berisi avatar placeholder yang siap diupload ke Tencent Cloud Object Storage (COS).

### File yang Tersedia:

1. **1000135983.jpg** - Avatar untuk: adi handoko
2. **1000130747_HZkDAX9.jpg** - Avatar untuk: Azra
3. **Default_a_banana_white_background_2.jpg** - Avatar untuk: Cewica
4. **UniversalUpscaler_2f46b51b-c971-4dc9-8c7d-47b1a72fbf63.jpg** - Avatar untuk: beyedaj
5. **default_avatar.jpg** - Avatar default untuk user baru

## 📤 Cara Upload ke Tencent COS:

### Langkah 1: Login ke Tencent Cloud Console
1. Buka: https://console.cloud.tencent.com/cos
2. Login dengan akun Anda

### Langkah 2: Pilih Bucket
1. Pilih bucket: **pewaca-1379748683**
2. Region: **ap-singapore**

### Langkah 3: Upload ke Folder profile_photos
1. Masuk ke folder **profile_photos/**
2. Klik tombol "Upload"
3. Pilih semua file dari folder `public/placeholder_avatars/`
4. Upload semua file

### Langkah 4: Verifikasi Permission
Pastikan bucket permission sudah diset ke **Public Read/Private Write** (sudah dilakukan ✅)

## 🔗 URL Hasil Upload:

Setelah upload, gambar akan dapat diakses melalui URL:
```
https://pewaca-1379748683.cos.ap-singapore.myqcloud.com/profile_photos/1000135983.jpg
https://pewaca-1379748683.cos.ap-singapore.myqcloud.com/profile_photos/1000130747_HZkDAX9.jpg
https://pewaca-1379748683.cos.ap-singapore.myqcloud.com/profile_photos/Default_a_banana_white_background_2.jpg
https://pewaca-1379748683.cos.ap-singapore.myqcloud.com/profile_photos/UniversalUpscaler_2f46b51b-c971-4dc9-8c7d-47b1a72fbf63.jpg
https://pewaca-1379748683.cos.ap-singapore.myqcloud.com/profile_photos/default_avatar.jpg
```

## ✅ Checklist:

- [ ] Download semua file dari folder `public/placeholder_avatars/`
- [ ] Login ke Tencent Cloud Console
- [ ] Upload ke folder `profile_photos/` di bucket `pewaca-1379748683`
- [ ] Verifikasi gambar bisa diakses melalui browser
- [ ] Test di aplikasi Pewaca

## 💡 Tips:

- Jika ada user baru yang belum punya avatar, gunakan `default_avatar.jpg`
- Anda bisa generate avatar tambahan jika diperlukan
- Pastikan nama file **persis sama** dengan yang ada di database

---
Generated on: October 25, 2025
