<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/logo.png') }}">
  <title>{{ $product->name }} - Warungku</title>
  <link rel="manifest" href="{{ url('manifest.json') }}">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .product-image-main {
      width: 100%;
      max-height: 400px;
      object-fit: contain;
      background-color: #f8f9fa;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #adb5bd;
      font-size: 5rem;
      min-height: 300px;
    }
    .product-image-main img {
      width: 100%;
      max-height: 400px;
      object-fit: contain;
      border-radius: 12px;
    }
    .product-info-card {
      background: white;
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 1rem;
    }
    .price-large {
      color: #5FA782;
      font-size: 2rem;
      font-weight: bold;
    }
    .stock-badge {
      background-color: #28a745;
      color: white;
      padding: 6px 12px;
      border-radius: 8px;
      display: inline-block;
    }
    .stock-badge-out {
      background-color: #dc3545;
    }
    .btn-add-cart {
      background-color: #5FA782;
      color: white;
      border: none;
      padding: 12px 30px;
      border-radius: 10px;
      font-size: 1.1rem;
      width: 100%;
      transition: all 0.3s;
    }
    .btn-add-cart:hover {
      background-color: #4a8a68;
      color: white;
    }
    .btn-add-cart:disabled {
      background-color: #cccccc;
      cursor: not-allowed;
    }
    .store-badge {
      background-color: #f8f9fa;
      padding: 1rem;
      border-radius: 10px;
      border: 1px solid #e0e0e0;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="container mt-3">
    <a href="{{ route('warungku.store', $product->store->id) }}" class="text-dark text-decoration-none">
      <i class="fas fa-arrow-left fa-lg"></i>
    </a>
  </div>

  <!-- Product Image -->
  <div class="container mt-3">
    <div class="product-image-main">
      @if($product->image)
        <img src="{{ $product->image }}" 
             alt="{{ $product->name }}"
             onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-box\'></i>';">
      @else
        <i class="fas fa-box"></i>
      @endif
    </div>
  </div>

  <!-- Product Info -->
  <div class="container mt-3 mb-5 pb-5">
    <div class="product-info-card">
      <h3 class="fw-bold mb-3">{{ $product->name }}</h3>
      
      <div class="mb-3">
        <span class="price-large">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
      </div>

      <div class="mb-3">
        @if($product->stock > 0)
          <span class="stock-badge">
            <i class="fas fa-check-circle"></i> Stok Tersedia: {{ $product->stock }}
          </span>
        @else
          <span class="stock-badge stock-badge-out">
            <i class="fas fa-times-circle"></i> Stok Habis
          </span>
        @endif
      </div>

      <hr>

      <h5 class="mb-3">Deskripsi Produk</h5>
      <p class="text-muted">
        {{ $product->description ?? 'Deskripsi produk tidak tersedia.' }}
      </p>

      <hr>

      <h5 class="mb-3">Informasi Toko</h5>
      <div class="store-badge">
        <div class="d-flex align-items-center">
          <div style="width: 50px; height: 50px; border-radius: 50%; background-color: #5FA782; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem;">
            @if($product->store->logo)
              <img src="{{ $product->store->logo }}" 
                   alt="{{ $product->store->name }}"
                   style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;"
                   onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-store\'></i>';">
            @else
              <i class="fas fa-store"></i>
            @endif
          </div>
          <div class="ms-3">
            <h6 class="mb-1">{{ $product->store->name }}</h6>
            <small class="text-muted">
              <i class="fas fa-star text-warning"></i> {{ number_format($product->store->rating, 1) }}
            </small>
          </div>
        </div>
      </div>
    </div>

    <!-- Add to Cart Button -->
    <button class="btn btn-add-cart" 
            id="btnAddCart"
            @if($product->stock <= 0 || !$product->is_available) disabled @endif>
      <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
    </button>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('btnAddCart')?.addEventListener('click', function() {
      alert('Produk "{{ $product->name }}" berhasil ditambahkan ke keranjang!\n\n(Fitur checkout akan segera hadir)');
    });
  </script>
</body>
</html>
