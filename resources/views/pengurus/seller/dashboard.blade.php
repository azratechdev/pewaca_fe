@extends('layouts.residence.basetemplate')
@section('content')

<style>
.stats-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
  border: 1px solid rgba(61, 115, 87, 0.1);
}

.stats-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(61, 115, 87, 0.15);
}

.stats-icon {
  width: 60px;
  height: 60px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.75rem;
}

.store-card {
  background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
  border-radius: 16px;
  padding: 24px;
  color: white;
  box-shadow: 0 4px 12px rgba(61, 115, 87, 0.3);
  transition: all 0.3s ease;
}

.store-card:hover {
  transform: scale(1.02);
  box-shadow: 0 8px 20px rgba(61, 115, 87, 0.4);
}

.btn-seller {
  background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 12px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-seller:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(61, 115, 87, 0.3);
  color: white;
}

.order-badge {
  font-size: 0.75rem;
  padding: 4px 12px;
  border-radius: 12px;
  font-weight: 600;
}
</style>

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 style="color: #2d3748; font-weight: 800;">
        <i class="fas fa-store" style="color: #3d7357;"></i> Seller Dashboard
      </h1>
      <p class="text-muted mb-0">Kelola toko dan produk Anda</p>
    </div>
    <a href="{{ route('pengurus.seller.browse-stores') }}" class="btn btn-seller">
      <i class="fas fa-plus-circle"></i> Kelola Toko
    </a>
  </div>

  @if($stores->isEmpty())
    <div class="alert alert-info text-center" style="border-radius: 16px; border: none; background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%);">
      <i class="fas fa-info-circle fa-3x mb-3" style="color: #0097a7;"></i>
      <h4 style="color: #006064;">Belum Ada Toko</h4>
      <p class="mb-3">Anda belum mengelola toko apapun. Klaim toko sekarang untuk mulai berjualan!</p>
      <a href="{{ route('pengurus.seller.browse-stores') }}" class="btn btn-seller">
        <i class="fas fa-store"></i> Cari Toko
      </a>
    </div>
  @else
    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
      <div class="col-md-3">
        <div class="stats-card p-4">
          <div class="d-flex align-items-center">
            <div class="stats-icon" style="background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);">
              <i class="fas fa-store text-white"></i>
            </div>
            <div class="ms-3">
              <div class="text-muted small">Total Toko</div>
              <h3 class="mb-0" style="color: #2d3748; font-weight: 800;">{{ $totalStores }}</h3>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="stats-card p-4">
          <div class="d-flex align-items-center">
            <div class="stats-icon" style="background: linear-gradient(135deg, #92400e 0%, #78350f 100%);">
              <i class="fas fa-box text-white"></i>
            </div>
            <div class="ms-3">
              <div class="text-muted small">Total Produk</div>
              <h3 class="mb-0" style="color: #2d3748; font-weight: 800;">{{ $totalProducts }}</h3>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="stats-card p-4">
          <div class="d-flex align-items-center">
            <div class="stats-icon" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
              <i class="fas fa-shopping-cart text-white"></i>
            </div>
            <div class="ms-3">
              <div class="text-muted small">Total Order</div>
              <h3 class="mb-0" style="color: #2d3748; font-weight: 800;">{{ $totalOrders }}</h3>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="stats-card p-4">
          <div class="d-flex align-items-center">
            <div class="stats-icon" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);">
              <i class="fas fa-coins text-white"></i>
            </div>
            <div class="ms-3">
              <div class="text-muted small">Total Pendapatan</div>
              <h4 class="mb-0" style="color: #2d3748; font-weight: 800; font-size: 1.25rem;">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Stores List -->
    <h5 class="mb-4" style="color: #2d3748; font-weight: 700;">
      <i class="fas fa-store-alt" style="color: #3d7357;"></i> Toko yang Dikelola
    </h5>
    <div class="row g-4 mb-5">
      @foreach($stores as $store)
      <div class="col-md-6">
        <div class="store-card">
          <div class="d-flex align-items-center mb-3">
            <div style="width: 60px; height: 60px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
              @if($store->logo)
                <img src="{{ $store->logo }}" alt="{{ $store->name }}" style="width: 100%; height: 100%; object-fit: cover;">
              @else
                <i class="fas fa-store" style="font-size: 1.5rem; color: #3d7357;"></i>
              @endif
            </div>
            <div class="ms-3 flex-grow-1">
              <h5 class="mb-1" style="font-weight: 700;">{{ $store->name }}</h5>
              <div style="font-size: 0.875rem; opacity: 0.9;">
                <i class="fas fa-star" style="color: #fbbf24;"></i> {{ number_format($store->rating, 1) }}
              </div>
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-6">
              <div style="background: rgba(255,255,255,0.15); padding: 12px; border-radius: 10px;">
                <div style="font-size: 0.75rem; opacity: 0.8;">Produk</div>
                <div style="font-size: 1.5rem; font-weight: 700;">{{ $store->products->count() }}</div>
              </div>
            </div>
            <div class="col-6">
              <div style="background: rgba(255,255,255,0.15); padding: 12px; border-radius: 10px;">
                <div style="font-size: 0.75rem; opacity: 0.8;">Order</div>
                <div style="font-size: 1.5rem; font-weight: 700;">{{ $store->orders->count() }}</div>
              </div>
            </div>
          </div>

          <div class="d-grid gap-2">
            <a href="{{ route('pengurus.seller.products', $store->id) }}" class="btn btn-light">
              <i class="fas fa-box"></i> Kelola Produk
            </a>
            <a href="{{ route('pengurus.seller.orders', $store->id) }}" class="btn btn-light">
              <i class="fas fa-shopping-cart"></i> Lihat Order
            </a>
            <a href="{{ route('pengurus.seller.reports', $store->id) }}" class="btn btn-light">
              <i class="fas fa-chart-line"></i> Laporan Penjualan
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Recent Orders -->
    @if($recentOrders->isNotEmpty())
    <h5 class="mb-4" style="color: #2d3748; font-weight: 700;">
      <i class="fas fa-clock" style="color: #3d7357;"></i> Order Terbaru
    </h5>
    <div class="stats-card p-4">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr style="border-bottom: 2px solid #e5e7eb;">
              <th style="color: #374151; font-weight: 600;">Order #</th>
              <th style="color: #374151; font-weight: 600;">Toko</th>
              <th style="color: #374151; font-weight: 600;">Pelanggan</th>
              <th style="color: #374151; font-weight: 600;">Total</th>
              <th style="color: #374151; font-weight: 600;">Status</th>
              <th style="color: #374151; font-weight: 600;">Tanggal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($recentOrders as $order)
            <tr>
              <td><strong>{{ $order->order_number }}</strong></td>
              <td>{{ $order->store->name }}</td>
              <td>{{ $order->customer_name }}</td>
              <td><strong>{{ $order->formatted_total }}</strong></td>
              <td>{!! $order->status_badge !!}</td>
              <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif
  @endif
</div>

@endsection
