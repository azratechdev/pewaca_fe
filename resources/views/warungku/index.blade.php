<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/logo.png') }}">
  <title>Warungku - Pewaca Marketplace</title>
  <link rel="manifest" href="{{ url('manifest.json') }}">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .navbar-warungku {
      background-color: #5FA782;
      color: white;
      padding: 1rem;
    }
    .store-card {
      border: 1px solid #e0e0e0;
      border-radius: 12px;
      transition: all 0.3s ease;
      background: white;
      margin-bottom: 1.5rem;
    }
    .store-card:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transform: translateY(-2px);
    }
    .store-logo {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      background-color: #e9ecef;
    }
    .rating-badge {
      background-color: #ffc107;
      color: white;
      padding: 4px 8px;
      border-radius: 6px;
      font-size: 0.9rem;
    }
    .btn-lihat-toko {
      background-color: #5FA782;
      color: white;
      border: none;
      padding: 8px 20px;
      border-radius: 8px;
      transition: all 0.3s;
    }
    .btn-lihat-toko:hover {
      background-color: #4a8a68;
      color: white;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar-warungku">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <a href="{{ route('showLoginForm') }}" class="text-white text-decoration-none">
            <i class="fas fa-arrow-left"></i>
          </a>
          <span class="ms-3 fs-4 fw-bold">Warungku</span>
        </div>
        <div>
          <i class="fas fa-shopping-cart"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container mt-4 mb-5 pb-5">
    <h5 class="mb-4">Daftar Toko</h5>

    @if($stores->isEmpty())
      <div class="alert alert-info text-center">
        <i class="fas fa-store-slash fa-3x mb-3"></i>
        <p class="mb-0">Belum ada toko tersedia</p>
      </div>
    @else
      <div class="row">
        @foreach($stores as $store)
        <div class="col-md-6 col-lg-4">
          <div class="store-card p-3">
            <div class="d-flex align-items-start">
              <img src="{{ $store->logo ?? 'https://via.placeholder.com/80?text=TOKO' }}" 
                   alt="{{ $store->name }}" 
                   class="store-logo me-3"
                   onerror="this.src='https://via.placeholder.com/80?text=TOKO'">
              <div class="flex-grow-1">
                <h6 class="fw-bold mb-1">{{ $store->name }}</h6>
                <p class="text-muted small mb-2">{{ Str::limit($store->description, 50) }}</p>
                <div class="d-flex align-items-center mb-2">
                  <span class="rating-badge">
                    <i class="fas fa-star"></i> {{ number_format($store->rating, 1) }}
                  </span>
                  <span class="ms-2 text-muted small">
                    {{ $store->products_count }} Produk
                  </span>
                </div>
                <a href="{{ route('warungku.store', $store->id) }}" class="btn btn-lihat-toko btn-sm w-100">
                  <i class="fas fa-store"></i> Lihat Toko
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
