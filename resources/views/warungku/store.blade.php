@extends('layouts.residence.basetemplate')

@section('content')
<style>
  body {
    background: linear-gradient(135deg, #f5f7fa 0%, #e8f0f3 100%);
  }
  
  .store-header {
    background: linear-gradient(135deg, #5FA782 0%, #3d7357 100%);
    color: white;
    padding: 2.5rem 0;
    margin: -20px -20px 30px -20px;
    box-shadow: 0 4px 20px rgba(95, 167, 130, 0.25);
  }
  
  .store-logo-large {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    border: 5px solid white;
    object-fit: cover;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #5FA782;
    font-size: 2.8rem;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
  }
  
  .store-logo-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
  }
  
  .product-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: white;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(95, 167, 130, 0.08);
  }
  
  .product-card:hover {
    box-shadow: 0 12px 28px rgba(95, 167, 130, 0.2), 0 6px 12px rgba(0, 0, 0, 0.08);
    transform: translateY(-8px);
  }
  
  .product-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
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
    top: 12px;
    right: 12px;
    background: linear-gradient(135deg, #28a745 0%, #20893a 100%);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
  }
  
  .badge-out-stock {
    background: linear-gradient(135deg, #ff5757 0%, #dc3545 100%);
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
  }
  
  .price-tag {
    background: linear-gradient(135deg, #5FA782 0%, #4a8a68 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 1.3rem;
    font-weight: 800;
  }
  
  .btn-detail {
    background: linear-gradient(135deg, #5FA782 0%, #4a8a68 100%);
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 12px;
    transition: all 0.3s ease;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(95, 167, 130, 0.25);
  }
  
  .btn-detail:hover {
    background: linear-gradient(135deg, #4a8a68 0%, #3d7357 100%);
    color: white;
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(95, 167, 130, 0.35);
  }
  
  .product-name {
    color: #2d3748;
    font-weight: 700;
    font-size: 1.05rem;
  }
  
  .product-desc {
    color: #718096;
    font-size: 0.9rem;
    line-height: 1.5;
  }
  
  .back-btn {
    background: rgba(255, 255, 255, 0.2);
    padding: 8px 12px;
    border-radius: 12px;
    transition: all 0.3s ease;
  }
  
  .back-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
  }
</style>

<!-- Store Header -->
<div class="store-header">
  <div class="container">
    <div class="mb-3">
      <a href="{{ route('warungku.index') }}" class="text-white text-decoration-none back-btn d-inline-block">
        <i class="fas fa-arrow-left"></i> Kembali
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
        <h2 class="mb-2" style="font-weight: 800;">{{ $store->name }}</h2>
        <div class="mb-2">
          <span style="background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 12px; display: inline-block;">
            <i class="fas fa-star" style="color: #ffd700;"></i> 
            <strong>{{ number_format($store->rating, 1) }}</strong>
          </span>
        </div>
        <p class="mb-1" style="opacity: 0.95;"><i class="fas fa-map-marker-alt me-2"></i>{{ $store->address ?? 'Lokasi tidak tersedia' }}</p>
        <p class="mb-0" style="opacity: 0.95;"><i class="fas fa-phone me-2"></i>{{ $store->phone ?? 'Kontak tidak tersedia' }}</p>
      </div>
    </div>
  </div>
</div>

<!-- Products -->
<div class="container mb-5 pb-5">
  <h5 class="mb-4" style="color: #2d3748; font-weight: 700; font-size: 1.5rem;">
    <i class="fas fa-box-open" style="color: #5FA782;"></i> Produk {{ $store->name }}
  </h5>

  @if($store->products->isEmpty())
    <div class="alert alert-info text-center" style="border: none; border-radius: 16px; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
      <i class="fas fa-box-open fa-3x mb-3" style="color: #5FA782;"></i>
      <p class="mb-0" style="color: #718096;">Belum ada produk tersedia di toko ini</p>
    </div>
  @else
    <div class="row">
      @foreach($store->products as $product)
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="product-card">
          <div class="position-relative product-image">
            @if($product->image)
              <img src="{{ $product->image }}" 
                   alt="{{ $product->name }}"
                   onerror="this.style.display='none'; this.parentElement.classList.add('d-flex', 'align-items-center', 'justify-content-center'); this.parentElement.innerHTML='<i class=&quot;fas fa-box&quot;></i>';">
              <span class="badge-stock {{ $product->stock > 0 ? '' : 'badge-out-stock' }}">
                @if($product->stock > 0)
                  <i class="fas fa-check-circle"></i> Stok: {{ $product->stock }}
                @else
                  <i class="fas fa-times-circle"></i> Habis
                @endif
              </span>
            @else
              <i class="fas fa-box"></i>
            @endif
          </div>
          <div class="p-3">
            <h6 class="product-name mb-2">{{ $product->name }}</h6>
            <p class="product-desc mb-3">{{ Str::limit($product->description, 60) }}</p>
            <div class="d-flex justify-content-between align-items-center">
              <span class="price-tag">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
              <a href="{{ route('warungku.product', $product->id) }}" class="btn btn-detail btn-sm">
                <i class="fas fa-eye"></i> Detail
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
