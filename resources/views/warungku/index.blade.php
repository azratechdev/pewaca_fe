@extends('layouts.residence.basetemplate')

@section('content')
<style>
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
    background-color: #5FA782;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
  }
  .store-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
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
  .warungku-header {
    background-color: #5FA782;
    color: white;
    padding: 1.5rem 0;
    margin: -20px -20px 20px -20px;
  }
</style>

<div class="warungku-header">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h4 class="mb-0"><i class="fas fa-store"></i> Warungku</h4>
        <small>Marketplace Warga Pewaca</small>
      </div>
      <div>
        <i class="fas fa-shopping-cart fa-lg"></i>
      </div>
    </div>
  </div>
</div>

<div class="container mb-5 pb-5">
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
            <div class="store-logo me-3">
              @if($store->logo)
                <img src="{{ $store->logo }}" 
                     alt="{{ $store->name }}"
                     onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-store\'></i>';">
              @else
                <i class="fas fa-store"></i>
              @endif
            </div>
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
@endsection
