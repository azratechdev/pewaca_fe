@extends('layouts.residence.basetemplate')
@section('content')

<style>
.available-store-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
  overflow: hidden;
  border: 1px solid rgba(61, 115, 87, 0.1);
}

.available-store-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(61, 115, 87, 0.15);
}

.store-img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  background: linear-gradient(135deg, #e0f2f1 0%, #b2dfdb 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3rem;
  color: #3d7357;
}

.btn-claim {
  background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 10px;
  font-weight: 600;
  width: 100%;
  transition: all 0.3s ease;
}

.btn-claim:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(61, 115, 87, 0.3);
  color: white;
}
</style>

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 style="color: #2d3748; font-weight: 800;">
        <i class="fas fa-search"></i> Cari Toko
      </h1>
      <p class="text-muted mb-0">Pilih toko yang ingin Anda kelola sebagai seller</p>
    </div>
    <a href="{{ route('pengurus.seller.my-stores') }}" class="btn btn-outline-secondary">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div>

  @if($availableStores->isEmpty())
    <div class="alert alert-warning text-center" style="border-radius: 16px; border: none;">
      <i class="fas fa-exclamation-circle fa-3x mb-3" style="color: #f59e0b;"></i>
      <h4>Tidak Ada Toko Tersedia</h4>
      <p>Semua toko sudah Anda kelola atau tidak ada toko aktif saat ini.</p>
      <a href="{{ route('pengurus.seller.dashboard') }}" class="btn btn-claim">
        <i class="fas fa-home"></i> Kembali ke Dashboard
      </a>
    </div>
  @else
    <div class="row g-4">
      @foreach($availableStores as $store)
      <div class="col-md-4">
        <div class="available-store-card">
          <div class="store-img">
            @if($store->logo)
              <img src="{{ $store->logo }}" alt="{{ $store->name }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
              <i class="fas fa-store"></i>
            @endif
          </div>

          <div class="p-4">
            <h5 style="color: #2d3748; font-weight: 700; margin-bottom: 8px;">{{ $store->name }}</h5>
            
            <div class="mb-3">
              <div class="d-flex align-items-center text-muted mb-2" style="font-size: 0.875rem;">
                <i class="fas fa-star" style="color: #fbbf24; margin-right: 6px;"></i>
                <span>{{ number_format($store->rating, 1) }}</span>
              </div>
              <div class="text-muted mb-2" style="font-size: 0.875rem;">
                <i class="fas fa-box" style="color: #92400e; margin-right: 6px;"></i>
                {{ $store->products_count ?? 0 }} Produk
              </div>
              @if($store->address)
              <div class="text-muted" style="font-size: 0.875rem;">
                <i class="fas fa-map-marker-alt" style="color: #3d7357; margin-right: 6px;"></i>
                {{ Str::limit($store->address, 40) }}
              </div>
              @endif
            </div>

            @if($store->description)
            <p class="text-muted mb-3" style="font-size: 0.875rem;">
              {{ Str::limit($store->description, 80) }}
            </p>
            @endif

            <form action="{{ route('pengurus.seller.claim-store', $store->id) }}" method="POST">
              @csrf
              <button type="submit" class="btn-claim" onclick="return confirm('Yakin ingin mengelola toko {{ $store->name }}?')">
                <i class="fas fa-hand-paper"></i> Kelola Toko Ini
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
