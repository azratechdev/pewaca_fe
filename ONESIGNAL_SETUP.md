# OneSignal Setup untuk Push Notification Cashout

## 1. Registrasi OneSignal

1. Buka https://onesignal.com/ dan daftar akun gratis
2. Klik "New App/Website" 
3. Pilih "Web Push" sebagai platform
4. Isi nama app (contoh: "Pewaca Residence")
5. Pilih "Typical Site" untuk website biasa

## 2. Konfigurasi Web Push

### Site Setup:
- **Site Name**: Pewaca
- **Site URL**: http://127.0.0.1:9000 (untuk development)
  - Production: https://yourdomain.com
- **Auto Resubscribe**: Enable (Recommended)
- **Default Notification Icon**: Upload logo app (256x256 px)

### Permission Prompt:
- **Slide Prompt**: Enable
- **Auto-prompt**: Enable after 30 seconds
- **Custom Prompt Message**: "Terima notifikasi untuk update pembayaran Anda"

## 3. Copy Credentials

Setelah setup, dapatkan:

1. **App ID**: 
   - Dashboard → Settings → Keys & IDs
   - Copy "App ID"

2. **REST API Key**:
   - Dashboard → Settings → Keys & IDs  
   - Copy "REST API Key"

3. **Safari Web ID** (Optional untuk Safari):
   - Dashboard → Settings → Apple Safari (Web)
   - Copy "Safari Web ID"

## 4. Update .env File

Buka file `.env` dan isi:

```env
ONESIGNAL_APP_ID=your_app_id_here
ONESIGNAL_REST_API_KEY=your_rest_api_key_here
ONESIGNAL_SAFARI_WEB_ID=your_safari_web_id_here
```

Contoh:
```env
ONESIGNAL_APP_ID=12345678-1234-1234-1234-123456789abc
ONESIGNAL_REST_API_KEY=YourRestApiKeyHere
ONESIGNAL_SAFARI_WEB_ID=web.onesignal.auto.abcd1234
```

## 5. Testing

### Development (localhost):
1. Buka http://127.0.0.1:9000
2. Login sebagai user
3. Browser akan meminta izin notifikasi - klik "Allow"
4. Lakukan pembayaran/upload bukti pembayaran
5. Notifikasi akan muncul otomatis

### Production:
1. Website HARUS menggunakan HTTPS
2. Update `ONESIGNAL_APP_ID` di production .env
3. Update Site URL di OneSignal dashboard ke production URL

## 6. Fitur Notifikasi yang Sudah Diimplementasikan

### A. Payment Confirmation (Upload Bukti Pembayaran)
- **Trigger**: Saat user upload bukti pembayaran
- **Title**: "Pembayaran Sedang Diproses"
- **Message**: "Bukti pembayaran untuk [nama tagihan] sebesar Rp XXX telah diterima"
- **Action**: Klik notifikasi → redirect ke detail pembayaran

### B. Payment Approval (Belum diimplementasi - perlu dari Django)
- **Trigger**: Saat pengurus approve pembayaran
- **Title**: "Pembayaran Disetujui"
- **Message**: "Pembayaran untuk [nama tagihan] telah disetujui"
- **Action**: Klik notifikasi → redirect ke history

### C. Payment Rejection (Belum diimplementasi - perlu dari Django)
- **Trigger**: Saat pengurus tolak pembayaran
- **Title**: "Pembayaran Ditolak"
- **Message**: "Pembayaran untuk [nama tagihan] ditolak. Alasan: XXX"
- **Action**: Klik notifikasi → redirect ke list tagihan

### D. New Tagihan (Belum diimplementasi - perlu dari Django)
- **Trigger**: Saat ada tagihan baru
- **Title**: "Tagihan Baru"
- **Message**: "Anda memiliki tagihan baru: [nama] sebesar Rp XXX"
- **Action**: Klik notifikasi → redirect ke list tagihan

## 7. External User ID Mapping

OneSignal menggunakan External User ID untuk mengirim notifikasi ke user spesifik:
- Menggunakan `warga_id` dari session
- Set saat user login via `OneSignal.login(userId)`
- Logout otomatis saat user logout

## 8. Troubleshooting

### Notifikasi tidak muncul:
1. Cek browser sudah allow notification permission
2. Cek .env sudah terisi ONESIGNAL_APP_ID dan ONESIGNAL_REST_API_KEY
3. Cek console browser (F12) untuk error OneSignal
4. Cek log Laravel: `storage/logs/laravel.log`

### Error "OneSignal not configured":
- Pastikan .env sudah terisi
- Restart Laravel server: `php artisan serve`
- Clear config cache: `php artisan config:clear`

### Notification tidak sampai ke user:
1. Cek External User ID sudah ter-set
2. Cek di OneSignal Dashboard → Delivery → All Notifications
3. Lihat status delivery (Sent, Delivered, Clicked)

## 9. OneSignal Dashboard Monitoring

### Menu Penting:
- **Dashboard**: Overview statistics
- **Delivery → All Notifications**: History semua notifikasi
- **Audience → All Users**: Daftar user yang subscribe
- **Settings → Keys & IDs**: Credentials

### Metrics:
- **Sent**: Total notifikasi dikirim
- **Delivered**: Berhasil sampai ke device
- **Clicked**: User klik notifikasi
- **CTR (Click Through Rate)**: Persentase klik

## 10. Production Checklist

- [ ] Update Site URL ke production domain (HTTPS)
- [ ] Update .env production dengan credentials
- [ ] Test notifikasi di production
- [ ] Enable HTTPS (required by OneSignal)
- [ ] Upload proper notification icon (256x256 px)
- [ ] Set custom welcome notification
- [ ] Configure notification sound
- [ ] Test pada berbagai browser (Chrome, Firefox, Safari, Edge)

## 11. Next Steps (Future Enhancement)

1. **Scheduled Notifications**:
   - Reminder pembayaran H-3 sebelum jatuh tempo
   - Reminder tagihan overdue

2. **Rich Notifications**:
   - Tambahkan action buttons (Bayar Sekarang, Lihat Detail)
   - Tambahkan image untuk tagihan tertentu

3. **Segmentation**:
   - Group notifikasi per residence
   - Filter by user role (warga, pengurus)

4. **Analytics**:
   - Track conversion rate pembayaran via notifikasi
   - A/B testing notification message

## Support

- OneSignal Docs: https://documentation.onesignal.com/docs/web-push-quickstart
- OneSignal Support: https://onesignal.com/support
- Laravel Integration: https://documentation.onesignal.com/docs/server-api-overview
