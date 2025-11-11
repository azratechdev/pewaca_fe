@extends('layouts.residence.basetemplate')
@section('content')

<style>
.store-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
  border: 1px solid rgba(61, 115, 87, 0.1);
  overflow: hidden;
}

.store-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(61, 115, 87, 0.15);
}

.store-header {
  background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
  padding: 24px;
  color: white;
}

.btn-seller {
  background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 10px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-seller:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(61, 115, 87, 0.3);
  color: white;
}

.btn-danger-seller {
  background: linear-gradient(135deg, #991b1b 0%, #7f1d1d 100%);
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.875rem;
}
</style>

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 style="color: #2d3748; font-weight: 800;">
        <i class="fas fa-store"></i> Toko Saya
      </h1>
      <p class="text-muted mb-0">Daftar toko yang Anda kelola</p>
    </div>
    <a href="{{ route('pengurus.seller.browse-stores') }}" class="btn btn-seller">
      <i class="fas fa-plus-circle"></i> Tambah Toko
    </a>
  </div>

  @if($stores->isEmpty())
    <div class="alert alert-info text-center" style="border-radius: 16px; border: none;">
      <i class="fas fa-info-circle fa-3x mb-3" style="color: #0097a7;"></i>
      <h4>Belum Ada Toko</h4>
      <p>Anda belum mengelola toko apapun. Klaim toko sekarang!</p>
      <a href="{{ route('pengurus.seller.browse-stores') }}" class="btn btn-seller">
        <i class="fas fa-store"></i> Cari Toko
      </a>
    </div>
  @else
    <div class="row g-4">
      @foreach($stores as $store)
      <div class="col-md-6">
        <div class="store-card">
          <div class="store-header">
            <div class="d-flex align-items-center">
              <div style="width: 60px; height: 60px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                @if($store->logo)
                  <img src="{{ $store->logo }}" alt="{{ $store->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                  <i class="fas fa-store" style="font-size: 1.5rem; color: #3d7357;"></i>
                @endif
              </div>
              <div class="ms-3">
                <h5 class="mb-1" style="font-weight: 700;">{{ $store->name }}</h5>
                <div style="font-size: 0.875rem; opacity: 0.9;">
                  <i class="fas fa-star" style="color: #fbbf24;"></i> {{ number_format($store->rating, 1) }}
                </div>
              </div>
            </div>
          </div>

          <div class="p-4">
            <div class="row g-3 mb-3">
              <div class="col-6">
                <div style="background: #f3f4f6; padding: 12px; border-radius: 10px; text-align: center;">
                  <div style="font-size: 0.75rem; color: #6b7280;">Produk</div>
                  <div style="font-size: 1.75rem; font-weight: 700; color: #3d7357;">{{ $store->products_count ?? 0 }}</div>
                </div>
              </div>
              <div class="col-6">
                <div style="background: #f3f4f6; padding: 12px; border-radius: 10px; text-align: center;">
                  <div style="font-size: 0.75rem; color: #6b7280;">Order</div>
                  <div style="font-size: 1.75rem; font-weight: 700; color: #0284c7;">{{ $store->orders_count ?? 0 }}</div>
                </div>
              </div>
            </div>

            <div class="d-grid gap-2 mb-3">
              <a href="{{ route('pengurus.seller.products', $store->id) }}" class="btn btn-seller">
                <i class="fas fa-box"></i> Kelola Produk
              </a>
              <div class="row g-2">
                <div class="col-6">
                  <a href="{{ route('pengurus.seller.orders', $store->id) }}" class="btn btn-outline-primary w-100">
                    <i class="fas fa-shopping-cart"></i> Order
                  </a>
                </div>
                <div class="col-6">
                  <a href="{{ route('pengurus.seller.reports', $store->id) }}" class="btn btn-outline-success w-100">
                    <i class="fas fa-chart-line"></i> Laporan
                  </a>
                </div>
              </div>
            </div>

            <form action="{{ route('pengurus.seller.leave-store', $store->id) }}" method="POST" class="d-inline w-100" onsubmit="return confirm('Yakin ingin keluar dari toko ini?')">
              @csrf
              <button type="submit" class="btn btn-danger-seller w-100">
                <i class="fas fa-sign-out-alt"></i> Keluar dari Toko
              </button>
            </form>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  @endif
</div>

@endsection
