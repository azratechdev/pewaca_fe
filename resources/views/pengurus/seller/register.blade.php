@extends('layouts.residence.basetemplate')
@section('content')

<style>
.registration-container {
  max-width: 700px;
  margin: 40px auto;
}

.registration-card {
  background: white;
  border-radius: 24px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.1);
  overflow: hidden;
}

.registration-header {
  background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
  padding: 40px 30px;
  text-align: center;
  color: white;
}

.registration-header h1 {
  font-weight: 800;
  margin-bottom: 8px;
  font-size: 2rem;
}

.registration-header p {
  opacity: 0.9;
  margin-bottom: 0;
}

.registration-body {
  padding: 40px 30px;
}

.form-label {
  font-weight: 600;
  color: #2d3748;
  margin-bottom: 8px;
}

.form-control, .form-control:focus {
  border-radius: 12px;
  padding: 12px 16px;
  border: 2px solid #e2e8f0;
  font-size: 0.95rem;
}

.form-control:focus {
  border-color: #3d7357;
  box-shadow: 0 0 0 3px rgba(61, 115, 87, 0.1);
}

textarea.form-control {
  min-height: 80px;
  resize: vertical;
}

.benefits-section {
  background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
  border-radius: 16px;
  padding: 24px;
  margin-bottom: 24px;
}

.benefit-item {
  display: flex;
  align-items: start;
  margin-bottom: 12px;
}

.benefit-item:last-child {
  margin-bottom: 0;
}

.benefit-icon {
  width: 28px;
  height: 28px;
  background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  margin-right: 12px;
  flex-shrink: 0;
}

.terms-box {
  background: #f8fafc;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  padding: 20px;
  margin-bottom: 24px;
}

.form-check-input:checked {
  background-color: #3d7357;
  border-color: #3d7357;
}

.form-check-input:focus {
  border-color: #3d7357;
  box-shadow: 0 0 0 3px rgba(61, 115, 87, 0.1);
}

.btn-register {
  background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
  color: white;
  border: none;
  padding: 14px 32px;
  border-radius: 12px;
  font-weight: 700;
  font-size: 1.05rem;
  width: 100%;
  transition: all 0.3s ease;
}

.btn-register:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(61, 115, 87, 0.3);
  color: white;
}

.btn-register:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-back {
  color: #64748b;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  font-weight: 600;
  transition: all 0.2s ease;
}

.btn-back:hover {
  color: #3d7357;
}

.char-counter {
  font-size: 0.85rem;
  color: #64748b;
  text-align: right;
  margin-top: 4px;
}
</style>

<div class="registration-container">
  <div class="registration-card">
    <div class="registration-header">
      <i class="fas fa-store-alt fa-3x mb-3"></i>
      <h1>Daftar Jadi Seller</h1>
      <p>Mulai berjualan dan kembangkan bisnis Anda di Warungku</p>
    </div>

    <div class="registration-body">
      <div class="benefits-section">
        <h5 style="color: #2d5642; font-weight: 700; margin-bottom: 16px;">
          <i class="fas fa-gift"></i> Keuntungan Menjadi Seller
        </h5>
        <div class="benefit-item">
          <div class="benefit-icon">
            <i class="fas fa-check"></i>
          </div>
          <div>
            <strong style="color: #2d3748;">Kelola Toko Anda</strong>
            <p class="mb-0 small text-muted">Akses penuh untuk mengelola produk, stok, dan harga</p>
          </div>
        </div>
        <div class="benefit-item">
          <div class="benefit-icon">
            <i class="fas fa-check"></i>
          </div>
          <div>
            <strong style="color: #2d3748;">Pantau Pesanan Real-time</strong>
            <p class="mb-0 small text-muted">Terima dan kelola pesanan pelanggan secara langsung</p>
          </div>
        </div>
        <div class="benefit-item">
          <div class="benefit-icon">
            <i class="fas fa-check"></i>
          </div>
          <div>
            <strong style="color: #2d3748;">Laporan Penjualan</strong>
            <p class="mb-0 small text-muted">Analisis bisnis dan tracking pendapatan Anda</p>
          </div>
        </div>
        <div class="benefit-item">
          <div class="benefit-icon">
            <i class="fas fa-check"></i>
          </div>
          <div>
            <strong style="color: #2d3748;">Jangkau Warga Residence</strong>
            <p class="mb-0 small text-muted">Pasarkan produk langsung ke komunitas residence</p>
          </div>
        </div>
      </div>

      <form action="{{ route('pengurus.seller.register.process') }}" method="POST" id="registrationForm">
        @csrf

        <div class="mb-4">
          <label for="store_name" class="form-label">
            <i class="fas fa-store" style="color: #3d7357;"></i> 
            Nama Toko <span class="text-danger">*</span>
          </label>
          <input 
            type="text" 
            name="store_name" 
            id="store_name" 
            class="form-control @error('store_name') is-invalid @enderror" 
            placeholder="Contoh: Warung Berkah, Toko Segar, dll"
            value="{{ old('store_name') }}"
            required>
          @error('store_name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-4">
          <label for="store_address" class="form-label">
            <i class="fas fa-map-marker-alt" style="color: #3d7357;"></i> 
            Alamat Toko <span class="text-danger">*</span>
          </label>
          <textarea 
            name="store_address" 
            id="store_address" 
            class="form-control @error('store_address') is-invalid @enderror" 
            placeholder="Contoh: Blok A No. 15, Cluster Green Valley"
            rows="2"
            required>{{ old('store_address') }}</textarea>
          @error('store_address')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-4">
          <label for="product_type" class="form-label">
            <i class="fas fa-tags" style="color: #3d7357;"></i> 
            Jenis Produk <span class="text-danger">*</span>
          </label>
          <select 
            name="product_type" 
            id="product_type" 
            class="form-control @error('product_type') is-invalid @enderror"
            required>
            <option value="">-- Pilih Jenis Produk --</option>
            <option value="Makanan & Minuman" {{ old('product_type') == 'Makanan & Minuman' ? 'selected' : '' }}>Makanan & Minuman</option>
            <option value="Sayuran & Buah" {{ old('product_type') == 'Sayuran & Buah' ? 'selected' : '' }}>Sayuran & Buah</option>
            <option value="Kebutuhan Rumah Tangga" {{ old('product_type') == 'Kebutuhan Rumah Tangga' ? 'selected' : '' }}>Kebutuhan Rumah Tangga</option>
            <option value="Fashion & Aksesoris" {{ old('product_type') == 'Fashion & Aksesoris' ? 'selected' : '' }}>Fashion & Aksesoris</option>
            <option value="Elektronik" {{ old('product_type') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
            <option value="Kesehatan & Kecantikan" {{ old('product_type') == 'Kesehatan & Kecantikan' ? 'selected' : '' }}>Kesehatan & Kecantikan</option>
            <option value="Jasa" {{ old('product_type') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
            <option value="Lainnya" {{ old('product_type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
          </select>
          @error('product_type')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="terms-box">
          <h6 style="color: #2d3748; font-weight: 700; margin-bottom: 12px;">
            <i class="fas fa-file-contract" style="color: #3d7357;"></i> Syarat & Ketentuan
          </h6>
          <ul class="mb-3" style="font-size: 0.9rem; color: #475569;">
            <li class="mb-2">Saya bertanggung jawab penuh atas produk yang dijual</li>
            <li class="mb-2">Saya akan menjaga kualitas produk dan layanan</li>
            <li class="mb-2">Saya akan memproses pesanan dengan cepat dan profesional</li>
            <li class="mb-2">Saya menyetujui kebijakan Warungku marketplace</li>
            <li class="mb-0">Informasi yang saya berikan adalah benar dan akurat</li>
          </ul>
          
          <div class="form-check">
            <input 
              class="form-check-input @error('terms_accepted') is-invalid @enderror" 
              type="checkbox" 
              name="terms_accepted" 
              id="terms_accepted" 
              value="1"
              required>
            <label class="form-check-label" for="terms_accepted" style="color: #2d3748; font-weight: 600;">
              Saya menyetujui semua syarat dan ketentuan di atas <span class="text-danger">*</span>
            </label>
            @error('terms_accepted')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <button type="submit" class="btn btn-register" id="submitBtn">
          <i class="fas fa-rocket"></i> Daftar Sekarang
        </button>

        <div class="text-center mt-3">
          <a href="{{ route('pengurus') }}" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const termsCheckbox = document.getElementById('terms_accepted');
  const submitBtn = document.getElementById('submitBtn');
  const form = document.getElementById('registrationForm');

  function checkFormValidity() {
    submitBtn.disabled = !termsCheckbox.checked;
  }

  termsCheckbox.addEventListener('change', checkFormValidity);

  checkFormValidity();

  form.addEventListener('submit', function(e) {
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
  });
});
</script>

@endsection
