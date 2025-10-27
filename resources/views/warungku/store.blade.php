<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/logo.png') }}">
  <title>{{ $store->name }} - Warungku</title>
  <link rel="manifest" href="{{ url('manifest.json') }}">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .store-header {
      background: linear-gradient(135deg, #5FA782 0%, #4a8a68 100%);
      color: white;
      padding: 2rem 0;
    }
    .store-logo-large {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      border: 4px solid white;
      object-fit: cover;
      background-color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #5FA782;
      font-size: 2.5rem;
    }
    .store-logo-large img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 50%;
    }
    .product-card {
      border: 1px solid #e0e0e0;
      border-radius: 12px;
      overflow: hidden;
      transition: all 0.3s ease;
      background: white;
      margin-bottom: 1.5rem;
    }
    .product-card:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transform: translateY(-2px);
    }
    .product-image {
      width: 100%;
      height: 180px;
      object-fit: cover;
      background-color: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #adb5bd;
      font-size: 3rem;
    }
    .product-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .badge-stock {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: #28a745;
      color: white;
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 0.8rem;
    }
    .badge-out-stock {
      background-color: #dc3545;
    }
    .price-tag {
      color: #5FA782;
      font-size: 1.2rem;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <!-- Store Header -->
  <div class="store-header">
    <div class="container">
      <div class="d-flex align-items-center mb-3">
        <a href="{{ route('warungku.index') }}" class="text-white text-decoration-none me-3">
          <i class="fas fa-arrow-left fa-lg"></i>
        </a>
      </div>
      <div class="d-flex align-items-center">
        <div class="store-logo-large me-4">
          @if($store->logo)
            <img src="{{ $store->logo }}" 
                 alt="{{ $store->name }}"
                 onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-store\'></i>';">
          @else
            <i class="fas fa-store"></i>
          @endif
        </div>
        <div>
          <h3 class="mb-2">{{ $store->name }}</h3>
          <p class="mb-1"><i class="fas fa-star text-warning"></i> {{ number_format($store->rating, 1) }}</p>
          <p class="mb-1"><i class="fas fa-map-marker-alt"></i> {{ $store->address ?? 'Lokasi tidak tersedia' }}</p>
          <p class="mb-0"><i class="fas fa-phone"></i> {{ $store->phone ?? 'Kontak tidak tersedia' }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Products -->
  <div class="container mt-4 mb-5 pb-5">
    <h5 class="mb-4">Produk {{ $store->name }}</h5>

    @if($store->products->isEmpty())
      <div class="alert alert-info text-center">
        <i class="fas fa-box-open fa-3x mb-3"></i>
        <p class="mb-0">Belum ada produk tersedia di toko ini</p>
      </div>
    @else
      <div class="row">
        @foreach($store->products as $product)
        <div class="col-md-6 col-lg-4">
          <div class="product-card">
            <div class="position-relative product-image">
              @if($product->image)
                <img src="{{ $product->image }}" 
                     alt="{{ $product->name }}"
                     onerror="this.style.display='none'; this.parentElement.classList.add('d-flex', 'align-items-center', 'justify-content-center'); this.parentElement.innerHTML='<i class=&quot;fas fa-box&quot;></i>';">
                <span class="badge-stock {{ $product->stock > 0 ? '' : 'badge-out-stock' }}">
                  @if($product->stock > 0)
                    Stok: {{ $product->stock }}
                  @else
                    Habis
                  @endif
                </span>
              @else
                <i class="fas fa-box"></i>
              @endif
            </div>
            <div class="p-3">
              <h6 class="fw-bold mb-2">{{ $product->name }}</h6>
              <p class="text-muted small mb-2">{{ Str::limit($product->description, 60) }}</p>
              <div class="d-flex justify-content-between align-items-center">
                <span class="price-tag">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                <a href="{{ route('warungku.product', $product->id) }}" class="btn btn-sm" style="background-color: #5FA782; color: white;">
                  Detail
                </a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    @endif
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
