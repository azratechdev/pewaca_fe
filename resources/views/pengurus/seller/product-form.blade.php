@extends('layouts.residence.basetemplate')
@section('content')

<style>
.form-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  padding: 32px;
  border: 1px solid rgba(61, 115, 87, 0.1);
}

.image-preview {
  width: 100%;
  max-width: 400px;
  height: 300px;
  border-radius: 12px;
  border: 2px dashed #cbd5e0;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: #f7fafc;
  margin-bottom: 16px;
}

.image-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.btn-seller {
  background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 10px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-seller:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(61, 115, 87, 0.3);
  color: white;
}
</style>

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 style="color: #2d3748; font-weight: 800;">
        <i class="fas fa-{{ isset($product) ? 'edit' : 'plus-circle' }}"></i> 
        {{ isset($product) ? 'Edit' : 'Tambah' }} Produk
      </h1>
      <p class="text-muted mb-0">{{ $store->name }}</p>
    </div>
    <a href="{{ route('pengurus.seller.products', $store->id) }}" class="btn btn-outline-secondary">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div>

  <div class="form-card">
    <form action="{{ isset($product) ? route('pengurus.seller.products.update', [$store->id, $product->id]) : route('pengurus.seller.products.store', $store->id) }}" 
          method="POST" 
          id="productForm">
      @csrf
      @if(isset($product))
        @method('PUT')
      @endif

      <div class="row">
        <div class="col-md-6">
          <div class="mb-4">
            <label class="form-label fw-bold">Nama Produk <span class="text-danger">*</span></label>
            <input type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   name="name" 
                   value="{{ old('name', $product->name ?? '') }}" 
                   required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold">Deskripsi</label>
            <textarea class="form-control @error('description') is-invalid @enderror" 
                      name="description" 
                      rows="4">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-4">
                <label class="form-label fw-bold">Harga <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">Rp</span>
                  <input type="number" 
                         class="form-control @error('price') is-invalid @enderror" 
                         name="price" 
                         value="{{ old('price', $product->price ?? '') }}" 
                         min="0" 
                         step="0.01" 
                         required>
                </div>
                @error('price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-4">
                <label class="form-label fw-bold">Stock <span class="text-danger">*</span></label>
                <input type="number" 
                       class="form-control @error('stock') is-invalid @enderror" 
                       name="stock" 
                       value="{{ old('stock', $product->stock ?? 0) }}" 
                       min="0" 
                       required>
                @error('stock')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="mb-4">
            <div class="form-check form-switch">
              <input class="form-check-input" 
                     type="checkbox" 
                     name="is_available" 
                     id="isAvailable"
                     {{ old('is_available', $product->is_available ?? true) ? 'checked' : '' }}>
              <label class="form-check-label fw-bold" for="isAvailable">
                Produk Tersedia untuk Dijual
              </label>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-4">
            <label class="form-label fw-bold">Gambar Produk</label>
            <div class="image-preview" id="imagePreview">
              @if(isset($product) && $product->image)
                <img src="{{ $product->image }}" alt="Preview">
              @else
                <div class="text-center text-muted">
                  <i class="fas fa-image fa-3x mb-2"></i>
                  <p class="mb-0">Belum ada gambar</p>
                </div>
              @endif
            </div>

            <input type="file" 
                   class="form-control" 
                   id="imageInput" 
                   accept="image/*">
            <input type="hidden" name="image" id="imageBase64">
            <small class="text-muted">
              <i class="fas fa-info-circle"></i> Max 2MB, akan dikompres otomatis
            </small>
            <div id="compressionStatus" class="mt-2"></div>
          </div>
        </div>
      </div>

      <div class="d-flex gap-2 justify-content-end">
        <a href="{{ route('pengurus.seller.products', $store->id) }}" class="btn btn-outline-secondary">
          <i class="fas fa-times"></i> Batal
        </a>
        <button type="submit" class="btn-seller" id="submitBtn">
          <i class="fas fa-save"></i> {{ isset($product) ? 'Update' : 'Simpan' }} Produk
        </button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.0/dist/browser-image-compression.min.js"></script>
<script>
const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');
const imageBase64 = document.getElementById('imageBase64');
const compressionStatus = document.getElementById('compressionStatus');
const submitBtn = document.getElementById('submitBtn');

imageInput.addEventListener('change', async function(e) {
  const file = e.target.files[0];
  if (!file) return;

  if (!file.type.startsWith('image/')) {
    alert('File harus berupa gambar!');
    return;
  }

  compressionStatus.innerHTML = '<div class="alert alert-info"><i class="fas fa-spinner fa-spin"></i> Mengompres gambar...</div>';
  submitBtn.disabled = true;

  try {
    const options = {
      maxSizeMB: 2,
      maxWidthOrHeight: 1920,
      useWebWorker: true,
      fileType: file.type
    };

    const compressedFile = await imageCompression(file, options);
    
    const reader = new FileReader();
    reader.onloadend = function() {
      imageBase64.value = reader.result;
      imagePreview.innerHTML = `<img src="${reader.result}" alt="Preview">`;
      
      const originalSize = (file.size / 1024).toFixed(2);
      const compressedSize = (compressedFile.size / 1024).toFixed(2);
      compressionStatus.innerHTML = `<div class="alert alert-success">
        <i class="fas fa-check-circle"></i> Gambar berhasil dikompres!
        <br><small>Ukuran asli: ${originalSize}KB → Hasil: ${compressedSize}KB</small>
      </div>`;
      submitBtn.disabled = false;
    };
    reader.readAsDataURL(compressedFile);
    
  } catch (error) {
    console.error('Error compressing image:', error);
    compressionStatus.innerHTML = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Gagal mengompres gambar</div>';
    submitBtn.disabled = false;
  }
});
</script>

@endsection
