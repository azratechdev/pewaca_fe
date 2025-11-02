# Placeholder Story Images untuk Pewaca

## 📸 Daftar File Gambar Story

Folder ini berisi gambar dummy untuk story yang siap diupload ke Tencent Cloud Object Storage (COS).

### File yang Tersedia:

| No | Filename | Story Content | Size |
|----|----------|---------------|------|
| 1 | **1000064123_0kslg52.jpg** | Rapat pembahasan persiapan mubes | ~500KB |
| 2 | **1000064123.jpg** | Rapat pembahasan persiapan mubes (duplikat) | ~500KB |
| 3 | **1000152742.jpg** | Obyek wisata area Bogor | ~450KB |
| 4 | **1000152879.jpg** | Jadi penonton (sports event) | ~480KB |
| 5 | **20250510_2312_image.png** | Lucu (cute character) | ~350KB |
| 6 | **1.jpeg** | Test image | ~420KB |

## 📊 Statistik:

- **Total file**: 6 gambar
- **Format**: JPG (5 files), PNG (1 file)
- **Total size**: ~2.7 MB
- **Kategori**: Community activities, tourist attractions, sports events

## 📤 Cara Upload ke Tencent COS:

### Langkah 1: Login ke Tencent Cloud Console
1. Buka: https://console.cloud.tencent.com/cos
2. Login dengan akun Anda

### Langkah 2: Pilih Bucket
1. Pilih bucket: **pewaca-1379748683**
2. Region: **ap-singapore**

### Langkah 3: Upload ke Folder story_images
1. Masuk ke folder **story_images/** (buat folder jika belum ada)
2. Klik tombol "Upload"
3. Pilih semua file dari folder `public/placeholder_story_images/`
4. Upload semua file (6 files)

### Langkah 4: Verifikasi Permission
Pastikan bucket permission sudah diset ke **Public Read/Private Write** (sudah dilakukan ✅)

## 🔗 URL Hasil Upload:

Setelah upload, gambar akan dapat diakses melalui URL:
```
https://pewaca-1379748683.cos.ap-singapore.myqcloud.com/story_images/1000064123_0kslg52.jpg
https://pewaca-1379748683.cos.ap-singapore.myqcloud.com/story_images/1000064123.jpg
https://pewaca-1379748683.cos.ap-singapore.myqcloud.com/story_images/1000152742.jpg
https://pewaca-1379748683.cos.ap-singapore.myqcloud.com/story_images/1000152879.jpg
https://pewaca-1379748683.cos.ap-singapore.myqcloud.com/story_images/20250510_2312_image.png
https://pewaca-1379748683.cos.ap-singapore.myqcloud.com/story_images/1.jpeg
```

## 🧪 Test URL:

Setelah upload, coba akses salah satu URL di browser untuk verifikasi:
```bash
curl -I https://pewaca-1379748683.cos.ap-singapore.myqcloud.com/story_images/1000064123.jpg
```

Jika return **200 OK**, berarti upload berhasil dan gambar bisa diakses! ✅

## ✅ Checklist Upload:

- [ ] Download semua file dari folder `public/placeholder_story_images/`
- [ ] Login ke Tencent Cloud Console
- [ ] Buat folder `story_images/` di bucket (jika belum ada)
- [ ] Upload 6 file gambar ke folder `story_images/`
- [ ] Verifikasi gambar bisa diakses via URL
- [ ] Test di aplikasi Pewaca - refresh halaman home
- [ ] Cek apakah gambar story sudah muncul

## 💡 Tips:

1. **Ukuran File**: Semua gambar sudah dioptimalkan untuk web (~300-500KB)
2. **Format**: Campuran JPG dan PNG untuk kompatibilitas maksimal
3. **Naming**: Nama file **persis sama** dengan yang ada di database
4. **Duplikat**: File `1000064123.jpg` dan `1000064123_0kslg52.jpg` berisi gambar yang sama (intentional)

## 📁 Struktur Folder di COS:

```
pewaca-1379748683/
├── profile_photos/          ← Avatar users (5 files)
│   ├── 1000135983.jpg
│   ├── 1000130747_HZkDAX9.jpg
│   ├── Default_a_banana_white_background_2.jpg
│   ├── UniversalUpscaler_2f46b51b-c971-4dc9-8c7d-47b1a72fbf63.jpg
│   └── default_avatar.jpg
└── story_images/            ← Story images (6 files)
    ├── 1000064123_0kslg52.jpg
    ├── 1000064123.jpg
    ├── 1000152742.jpg
    ├── 1000152879.jpg
    ├── 20250510_2312_image.png
    └── 1.jpeg
```

## 🎉 Hasil Akhir:

Setelah upload avatar (5 files) + story images (6 files):
- ✅ Total 11 gambar siap di COS
- ✅ Semua profile picture akan muncul
- ✅ Semua story images akan tampil
- ✅ Aplikasi Pewaca akan terlihat lengkap dan profesional!

---
Generated on: October 25, 2025
Detected from API: https://admin.pewaca.id/api/stories/
