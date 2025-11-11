@extends('layouts.residence.basetemplate')

@section('content')
<style>
  body {
    background: linear-gradient(135deg, #f5f7fa 0%, #e8f0f3 100%);
  }
  
  .store-card {
    border: none;
    border-radius: 20px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: white;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(95, 167, 130, 0.08);
    overflow: hidden;
  }
  
  .store-card:hover {
    box-shadow: 0 12px 28px rgba(95, 167, 130, 0.2), 0 6px 12px rgba(0, 0, 0, 0.08);
    transform: translateY(-8px);
  }
  
  .store-logo {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.2rem;
    box-shadow: 0 4px 12px rgba(61, 115, 87, 0.3);
    border: 3px solid white;
  }
  
  .store-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
  }
  
  .rating-badge {
    background: linear-gradient(135deg, #92400e 0%, #78350f 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(146, 64, 14, 0.3);
  }
  
  .btn-lihat-toko {
    background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 12px;
    transition: all 0.3s ease;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(61, 115, 87, 0.3);
  }
  
  .btn-lihat-toko:hover {
    background: linear-gradient(135deg, #2d5642 0%, #1e3f2f 100%);
    color: white;
    transform: scale(1.02);
    box-shadow: 0 6px 16px rgba(61, 115, 87, 0.4);
  }
  
  .warungku-header {
    background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
    color: white;
    padding: 2rem 0;
    margin: -20px -20px 30px -20px;
    box-shadow: 0 4px 16px rgba(61, 115, 87, 0.25);
  }
  
  .warungku-header h4 {
    font-weight: 700;
    font-size: 1.8rem;
  }
  
  .cart-icon-container {
    position: relative;
    display: inline-block;
    background: rgba(255, 255, 255, 0.2);
    padding: 10px 14px;
    border-radius: 12px;
    transition: all 0.3s ease;
  }
  
  .cart-icon-container:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
  }
  
  .cart-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background: linear-gradient(135deg, #991b1b 0%, #7f1d1d 100%);
    color: white;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: bold;
    box-shadow: 0 2px 8px rgba(153, 27, 27, 0.4);
    animation: pulse 2s infinite;
  }
  
  @keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
  }
  
  .store-card-content {
    padding: 1.5rem;
  }
  
  .store-name {
    color: #2d3748;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
  }
  
  .store-desc {
    color: #718096;
    font-size: 0.9rem;
    line-height: 1.5;
  }
  
  .product-count {
    color: #2d5642;
    font-weight: 600;
  }
  
  .seller-cta-banner {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    border: 2px solid #3d7357;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 16px rgba(61, 115, 87, 0.15);
    position: relative;
    overflow: hidden;
  }
  
  .seller-cta-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(61, 115, 87, 0.1) 0%, transparent 70%);
    border-radius: 50%;
  }
  
  .seller-cta-content {
    position: relative;
    z-index: 1;
  }
  
  .btn-mulai-jualan {
    background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
    color: white;
    border: none;
    padding: 14px 32px;
    border-radius: 14px;
    font-weight: 700;
    font-size: 1.05rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(61, 115, 87, 0.3);
  }
  
  .btn-mulai-jualan:hover {
    background: linear-gradient(135deg, #2d5642 0%, #1e3f2f 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(61, 115, 87, 0.4);
  }
  
  .seller-cta-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    box-shadow: 0 4px 12px rgba(61, 115, 87, 0.3);
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
        <a href="{{ route('cart.index') }}" class="text-white text-decoration-none cart-icon-container">
          <i class="fas fa-shopping-cart fa-lg"></i>
          <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
        </a>
      </div>
    </div>
  </div>
</div>

<div class="container mb-5 pb-5">
  {{-- DEBUG: Check session-based auth and seller status --}}
  <div style="background: #fff3cd; padding: 15px; margin-bottom: 20px; border: 2px solid #856404; border-radius: 8px;">
    <strong>🔍 DEBUG INFO:</strong><br>
    <strong>Session Token:</strong> {{ Session::has('token') ? '✅ HAS TOKEN' : '❌ NO TOKEN' }}<br>
    <strong>Session Cred:</strong> {{ Session::has('cred') ? '✅ HAS CRED' : '❌ NO CRED' }}<br>
    @if(Session::has('cred'))
      @php
        $cred = Session::get('cred');
        $isSeller = $cred['is_seller'] ?? 0;
      @endphp
      <strong>Email:</strong> {{ $cred['email'] ?? 'N/A' }}<br>
      <strong>is_seller value:</strong> {{ var_export($isSeller, true) }}<br>
      <strong>Banner should show:</strong> {{ !$isSeller ? '✅ YES' : '❌ NO (already seller)' }}<br>
    @else
      <strong>User:</strong> Not logged in - banner will NOT show
    @endif
  </div>
  
  {{-- Seller Registration Banner: Show to authenticated non-sellers only --}}
  @if(Session::has('token') && Session::has('cred'))
    @php
      $cred = Session::get('cred');
      $isSeller = $cred['is_seller'] ?? 0;
    @endphp
    
    @if(!$isSeller)
    <div class="seller-cta-banner">
      <div class="seller-cta-content">
        <div class="row align-items-center">
          <div class="col-md-2 text-center mb-3 mb-md-0">
            <div class="seller-cta-icon mx-auto">
              <i class="fas fa-store-alt"></i>
            </div>
          </div>
          <div class="col-md-7 mb-3 mb-md-0">
            <h4 style="color: #2d5642; font-weight: 800; margin-bottom: 0.5rem;">
              Mulai Jualan di Warungku!
            </h4>
            <p style="color: #166534; margin-bottom: 0; font-size: 0.95rem;">
              Punya produk untuk dijual? Daftar jadi seller sekarang dan jangkau ribuan warga residence dengan mudah. Gratis dan tanpa biaya tersembunyi!
            </p>
          </div>
          <div class="col-md-3 text-center text-md-end">
            <a href="{{ route('pengurus.seller.register') }}" class="btn btn-mulai-jualan">
              <i class="fas fa-rocket me-2"></i> Daftar Sekarang
            </a>
          </div>
        </div>
      </div>
    </div>
    @endif
  @endif

  <h5 class="mb-4" style="color: #2d3748; font-weight: 700; font-size: 1.5rem;">
    <i class="fas fa-store-alt" style="color: #3d7357;"></i> Daftar Toko
  </h5>

  @if($stores->isEmpty())
    <div class="alert alert-info text-center" style="border: none; border-radius: 16px; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
      <i class="fas fa-store-slash fa-3x mb-3" style="color: #3d7357;"></i>
      <p class="mb-0" style="color: #718096;">Belum ada toko tersedia</p>
    </div>
  @else
    <div class="row">
      @foreach($stores as $store)
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="store-card">
          <div class="store-card-content">
            <div class="text-center mb-3">
              <div class="store-logo mx-auto">
                @if($store->logo)
                  <img src="{{ $store->logo }}" 
                       alt="{{ $store->name }}"
                       onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-store\'></i>';">
                @else
                  <i class="fas fa-store"></i>
                @endif
              </div>
            </div>
            
            <h6 class="store-name text-center">{{ $store->name }}</h6>
            <p class="store-desc text-center mb-3">{{ Str::limit($store->description, 70) }}</p>
            
            <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
              <span class="rating-badge">
                <i class="fas fa-star"></i> {{ number_format($store->rating, 1) }}
              </span>
              <span class="product-count">
                <i class="fas fa-box"></i> {{ $store->products_count }} Produk
              </span>
            </div>
            
            <a href="{{ route('warungku.store', $store->id) }}" class="btn btn-lihat-toko w-100">
              <i class="fas fa-shopping-bag"></i> Lihat Toko
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  @endif
</div>

<script>
  // Load cart count on page load
  fetch('{{ route("cart.count") }}')
    .then(res => res.json())
    .then(data => {
      const badge = document.getElementById('cartBadge');
      if (data.count > 0) {
        badge.textContent = data.count;
        badge.style.display = 'flex';
      }
    })
    .catch(err => console.error('Failed to load cart count:', err));
</script>
@endsection
