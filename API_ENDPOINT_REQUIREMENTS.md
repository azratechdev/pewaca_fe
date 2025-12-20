# API Endpoint Requirements - Pengeluaran & Dana Tersimpan

## Overview
Buatkan 2 endpoint API Django REST Framework untuk fitur manajemen keuangan pengurus paguyuban. Endpoint ini akan digunakan oleh aplikasi Laravel frontend yang sudah ada.

---

## 1. GET /api/pengurus/pengeluaran/

### Purpose
Mengambil daftar semua pengeluaran paguyuban untuk pengurus yang sedang login.

### Authentication
- Required: Token Authentication
- Header: `Authorization: Token <user_token>`
- User harus memiliki role `is_pengurus = true`

### Request
```http
GET /api/pengurus/pengeluaran/
Authorization: Token eyJhbGc...
Accept: application/json
```

### Response Format
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "tanggal": "2025-12-15",
            "kategori": "Operasional",
            "keterangan": "Pembelian ATK untuk kantor sekretariat",
            "jumlah": 500000,
            "created_at": "2025-12-15T10:30:00Z",
            "updated_at": "2025-12-15T10:30:00Z"
        },
        {
            "id": 2,
            "tanggal": "2025-12-18",
            "kategori": "Keamanan",
            "keterangan": "Gaji satpam bulan Desember",
            "jumlah": 3000000,
            "created_at": "2025-12-18T14:20:00Z",
            "updated_at": "2025-12-18T14:20:00Z"
        }
    ]
}
```

### Response Fields
- `success` (boolean): Status keberhasilan request
- `data` (array): List pengeluaran
  - `id` (integer): Primary key pengeluaran
  - `tanggal` (string): Tanggal pengeluaran format YYYY-MM-DD
  - `kategori` (string): Kategori pengeluaran (Operasional, Keamanan, Kebersihan, Pemeliharaan, Acara, Lainnya)
  - `keterangan` (string): Deskripsi detail pengeluaran
  - `jumlah` (integer): Nominal pengeluaran dalam Rupiah
  - `created_at` (datetime): Timestamp pembuatan record
  - `updated_at` (datetime): Timestamp update terakhir

### Business Logic
- Filter pengeluaran berdasarkan residence_id dari user yang login
- Urutkan dari tanggal terbaru ke terlama (ORDER BY tanggal DESC, created_at DESC)
- Return empty array jika belum ada data: `{"success": true, "data": []}`

### Error Responses
```json
// Unauthorized (401)
{
    "success": false,
    "message": "Authentication credentials were not provided."
}

// Forbidden (403)
{
    "success": false,
    "message": "Anda tidak memiliki akses pengurus."
}
```

---

## 2. POST /api/pengurus/pengeluaran/

### Purpose
Menambahkan pengeluaran baru ke database.

### Authentication
- Required: Token Authentication
- Header: `Authorization: Token <user_token>`
- User harus memiliki role `is_pengurus = true`

### Request
```http
POST /api/pengurus/pengeluaran/
Authorization: Token eyJhbGc...
Content-Type: application/json

{
    "tanggal": "2025-12-19",
    "kategori": "Kebersihan",
    "keterangan": "Pembelian alat kebersihan dan sabun",
    "jumlah": 750000
}
```

### Request Body Fields
- `tanggal` (required, string): Tanggal pengeluaran format YYYY-MM-DD
- `kategori` (required, string): Kategori dari pilihan: Operasional, Keamanan, Kebersihan, Pemeliharaan, Acara, Lainnya
- `keterangan` (required, string): Deskripsi detail (min 10 karakter)
- `jumlah` (required, integer): Nominal pengeluaran (harus positif, min 1000)

### Validation Rules
```python
{
    'tanggal': {
        'required': True,
        'type': 'date',
        'format': 'YYYY-MM-DD'
    },
    'kategori': {
        'required': True,
        'choices': ['Operasional', 'Keamanan', 'Kebersihan', 'Pemeliharaan', 'Acara', 'Lainnya']
    },
    'keterangan': {
        'required': True,
        'min_length': 10,
        'max_length': 500
    },
    'jumlah': {
        'required': True,
        'type': 'integer',
        'min': 1000
    }
}
```

### Response Format (Success)
```json
{
    "success": true,
    "message": "Pengeluaran berhasil ditambahkan",
    "data": {
        "id": 3,
        "tanggal": "2025-12-19",
        "kategori": "Kebersihan",
        "keterangan": "Pembelian alat kebersihan dan sabun",
        "jumlah": 750000,
        "created_at": "2025-12-19T16:45:00Z",
        "updated_at": "2025-12-19T16:45:00Z"
    }
}
```

### Business Logic
- Auto-assign `residence_id` dari user yang sedang login
- Auto-assign `created_by` user_id
- Set timezone Indonesia (WIB)
- Validasi tanggal tidak boleh di masa depan lebih dari 1 hari

### Error Responses
```json
// Validation Error (400)
{
    "success": false,
    "message": "Validation error",
    "errors": {
        "tanggal": ["Field ini wajib diisi"],
        "jumlah": ["Jumlah minimal Rp 1.000"]
    }
}

// Unauthorized (401)
{
    "success": false,
    "message": "Authentication credentials were not provided."
}

// Forbidden (403)
{
    "success": false,
    "message": "Anda tidak memiliki akses pengurus."
}
```

---

## 3. GET /api/pengurus/dana-tersimpan/

### Purpose
Mengambil summary dana keuangan paguyuban (total pemasukan, pengeluaran, dan saldo).

### Authentication
- Required: Token Authentication
- Header: `Authorization: Token <user_token>`
- User harus memiliki role `is_pengurus = true`

### Request
```http
GET /api/pengurus/dana-tersimpan/
Authorization: Token eyJhbGc...
Accept: application/json
```

### Response Format
```json
{
    "success": true,
    "data": {
        "total_pemasukan": 25000000,
        "total_pengeluaran": 8500000,
        "saldo_tersisa": 16500000,
        "last_update": "2025-12-19 16:45:30"
    }
}
```

### Response Fields
- `success` (boolean): Status keberhasilan
- `data` (object): Summary keuangan
  - `total_pemasukan` (integer): Total semua pemasukan dalam Rupiah
  - `total_pengeluaran` (integer): Total semua pengeluaran dalam Rupiah
  - `saldo_tersisa` (integer): Selisih pemasukan - pengeluaran
  - `last_update` (string): Timestamp update terakhir format "YYYY-MM-DD HH:MM:SS"

### Business Logic
- `total_pemasukan`: SUM dari tabel pembayaran/tagihan yang status = 'paid' untuk residence_id user
- `total_pengeluaran`: SUM dari tabel pengeluaran (endpoint #1) untuk residence_id user
- `saldo_tersisa`: total_pemasukan - total_pengeluaran
- `last_update`: MAX(updated_at) dari gabungan tabel pembayaran dan pengeluaran

### Calculation Example
```python
# Pseudocode
pemasukan = Pembayaran.objects.filter(
    residence_id=user.residence_id,
    status='paid'
).aggregate(total=Sum('amount'))['total'] or 0

pengeluaran = Pengeluaran.objects.filter(
    residence_id=user.residence_id
).aggregate(total=Sum('jumlah'))['total'] or 0

saldo = pemasukan - pengeluaran

last_update = max(
    Pembayaran.objects.filter(residence_id=user.residence_id).aggregate(Max('updated_at')),
    Pengeluaran.objects.filter(residence_id=user.residence_id).aggregate(Max('updated_at'))
)
```

### Error Responses
```json
// Unauthorized (401)
{
    "success": false,
    "message": "Authentication credentials were not provided."
}

// Forbidden (403)
{
    "success": false,
    "message": "Anda tidak memiliki akses pengurus."
}
```

---

## Database Model Requirements

### Model: Pengeluaran

```python
class Pengeluaran(models.Model):
    # Primary fields
    residence = models.ForeignKey('MResidence', on_delete=models.CASCADE, related_name='pengeluaran')
    tanggal = models.DateField(verbose_name='Tanggal Pengeluaran')
    kategori = models.CharField(max_length=50, choices=[
        ('Operasional', 'Operasional'),
        ('Keamanan', 'Keamanan'),
        ('Kebersihan', 'Kebersihan'),
        ('Pemeliharaan', 'Pemeliharaan'),
        ('Acara', 'Acara'),
        ('Lainnya', 'Lainnya'),
    ])
    keterangan = models.TextField(verbose_name='Keterangan')
    jumlah = models.IntegerField(verbose_name='Jumlah (Rp)', validators=[MinValueValidator(1000)])
    
    # Audit fields
    created_by = models.ForeignKey('CustomUser', on_delete=models.SET_NULL, null=True)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    class Meta:
        db_table = 'pengeluaran'
        ordering = ['-tanggal', '-created_at']
        verbose_name = 'Pengeluaran'
        verbose_name_plural = 'Pengeluaran'
    
    def __str__(self):
        return f"{self.kategori} - Rp {self.jumlah:,} ({self.tanggal})"
```

---

## Frontend Integration Details

### Frontend menggunakan AJAX calls:
```javascript
// Load pengeluaran list
$.ajax({
    url: '/api/pengurus/pengeluaran',
    method: 'GET',
    success: function(response) {
        // Expected: response.data = array of objects
        response.data.forEach(item => {
            // item.tanggal, item.kategori, item.keterangan, item.jumlah
        });
    }
});

// Add new pengeluaran
$.ajax({
    url: '/api/pengurus/pengeluaran/store',
    method: 'POST',
    data: {
        tanggal: '2025-12-19',
        kategori: 'Operasional',
        keterangan: 'Desc...',
        jumlah: 500000
    }
});

// Load dana tersimpan
$.ajax({
    url: '/api/pengurus/dana-tersimpan',
    method: 'GET',
    success: function(response) {
        // Expected: response.data.total_pemasukan, total_pengeluaran, saldo_tersisa
    }
});
```

### Laravel Controller melakukan HTTP call:
```php
Http::withOptions(['verify' => false])
    ->timeout(10)
    ->withHeaders([
        'Accept' => 'application/json',
        'Authorization' => 'Token ' . Session::get('token'),
    ])
    ->get(env('API_URL') . '/api/pengurus/pengeluaran/');
```

---

## Testing Checklist

### Endpoint 1: GET /api/pengurus/pengeluaran/
- [ ] Returns empty array when no data exists
- [ ] Returns correct data structure with all required fields
- [ ] Data sorted by tanggal DESC, created_at DESC
- [ ] Only returns data for user's residence_id
- [ ] Returns 401 when no token provided
- [ ] Returns 403 when user is not pengurus

### Endpoint 2: POST /api/pengurus/pengeluaran/
- [ ] Successfully creates new record with valid data
- [ ] Returns created record with id in response
- [ ] Validates all required fields
- [ ] Validates kategori from allowed choices
- [ ] Validates jumlah minimum 1000
- [ ] Validates keterangan minimum 10 characters
- [ ] Auto-assigns residence_id from logged-in user
- [ ] Returns 400 with field errors for invalid data
- [ ] Returns 401 when no token provided
- [ ] Returns 403 when user is not pengurus

### Endpoint 3: GET /api/pengurus/dana-tersimpan/
- [ ] Calculates total_pemasukan correctly from pembayaran table
- [ ] Calculates total_pengeluaran correctly from pengeluaran table
- [ ] Calculates saldo_tersisa = pemasukan - pengeluaran
- [ ] Returns 0 values when no data exists (not null)
- [ ] Returns correct last_update timestamp
- [ ] Only calculates for user's residence_id
- [ ] Returns 401 when no token provided
- [ ] Returns 403 when user is not pengurus

---

## Security Requirements

1. **Authentication**: All endpoints require valid Token authentication
2. **Authorization**: User must have `is_pengurus = True` in profile
3. **Data Isolation**: Users can only access data from their own residence
4. **Input Validation**: Sanitize all input fields to prevent SQL injection
5. **CORS**: Allow requests from Laravel frontend domain
6. **Rate Limiting**: Implement rate limiting (optional, recommended: 100 req/min per user)

---

## Notes for Backend Developer

1. **Existing Tables**: 
   - Gunakan tabel `pembayaran` atau `tagihan` yang sudah ada untuk menghitung `total_pemasukan`
   - Buat tabel baru `pengeluaran` sesuai model di atas

2. **Timezone**: 
   - Gunakan timezone Asia/Jakarta (WIB)
   - Format datetime: ISO 8601

3. **Number Format**: 
   - Semua nominal dalam INTEGER (Rupiah, tanpa desimal)
   - Frontend akan format dengan separator ribuan

4. **Error Handling**:
   - Gunakan consistent response format
   - Include detail error messages untuk debugging
   - Log semua error ke file log

5. **Performance**:
   - Gunakan database indexing pada: residence_id, tanggal, created_at
   - Optimize query dengan select_related() / prefetch_related()
   - Consider pagination jika data > 100 records

6. **Testing**:
   - Test dengan user pengurus dan non-pengurus
   - Test dengan berbagai residence_id
   - Test edge cases (empty data, invalid input, etc.)

---

## Example cURL Commands for Testing

```bash
# 1. Get pengeluaran list
curl -X GET "https://admin.pewaca.id/api/pengurus/pengeluaran/" \
  -H "Authorization: Token YOUR_TOKEN_HERE" \
  -H "Accept: application/json"

# 2. Create new pengeluaran
curl -X POST "https://admin.pewaca.id/api/pengurus/pengeluaran/" \
  -H "Authorization: Token YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "tanggal": "2025-12-19",
    "kategori": "Operasional",
    "keterangan": "Test pengeluaran dari API",
    "jumlah": 500000
  }'

# 3. Get dana tersimpan summary
curl -X GET "https://admin.pewaca.id/api/pengurus/dana-tersimpan/" \
  -H "Authorization: Token YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

---

## API Base URL
- Development: `https://admin.pewaca.id`
- Production: `https://admin.pewaca.id`

## Expected Response Time
- GET endpoints: < 500ms
- POST endpoints: < 1000ms

## Contact
Jika ada pertanyaan atau butuh klarifikasi, silakan hubungi tim frontend.
