@extends('layouts.residence.basetemplate')
@section('content')

<style>
.stats-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
  border: 1px solid rgba(61, 115, 87, 0.1);
  padding: 24px;
}

.stats-card:hover {
  transform: translateY(-2px);
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
</style>

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 style="color: #2d3748; font-weight: 800;">
        <i class="fas fa-chart-line"></i> {{ $store->name }} - Laporan Penjualan
      </h1>
      <p class="text-muted mb-0">Analisis performa toko Anda</p>
    </div>
    <a href="{{ route('pengurus.seller.dashboard') }}" class="btn btn-outline-secondary">
      <i class="fas fa-arrow-left"></i> Dashboard
    </a>
  </div>

  <div class="row g-4 mb-5">
    <div class="col-md-3">
      <div class="stats-card">
        <div class="d-flex align-items-center">
          <div class="stats-icon" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);">
            <i class="fas fa-dollar-sign text-white"></i>
          </div>
          <div class="ms-3">
            <div class="text-muted small">Total Pendapatan</div>
            <h4 class="mb-0" style="color: #16a34a; font-weight: 800; font-size: 1.25rem;">
              Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </h4>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="stats-card">
        <div class="d-flex align-items-center">
          <div class="stats-icon" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
            <i class="fas fa-shopping-cart text-white"></i>
          </div>
          <div class="ms-3">
            <div class="text-muted small">Total Order</div>
            <h3 class="mb-0" style="color: #0284c7; font-weight: 800;">{{ $totalOrders }}</h3>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="stats-card">
        <div class="d-flex align-items-center">
          <div class="stats-icon" style="background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);">
            <i class="fas fa-check-circle text-white"></i>
          </div>
          <div class="ms-3">
            <div class="text-muted small">Order Selesai</div>
            <h3 class="mb-0" style="color: #3d7357; font-weight: 800;">{{ $completedOrders }}</h3>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="stats-card">
        <div class="d-flex align-items-center">
          <div class="stats-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <i class="fas fa-clock text-white"></i>
          </div>
          <div class="ms-3">
            <div class="text-muted small">Order Pending</div>
            <h3 class="mb-0" style="color: #f59e0b; font-weight: 800;">{{ $pendingOrders }}</h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-7">
      <div class="stats-card mb-4">
        <h5 class="mb-4" style="color: #2d3748; font-weight: 700;">
          <i class="fas fa-chart-bar"></i> Pendapatan per Bulan
        </h5>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th style="color: #374151; font-weight: 600;">Bulan</th>
                <th style="color: #374151; font-weight: 600;" class="text-end">Pendapatan</th>
              </tr>
            </thead>
            <tbody>
              @forelse($revenueByMonth as $revenue)
              <tr>
                <td>{{ \Carbon\Carbon::parse($revenue->month . '-01')->format('F Y') }}</td>
                <td class="text-end"><strong style="color: #16a34a;">Rp {{ number_format($revenue->revenue, 0, ',', '.') }}</strong></td>
              </tr>
              @empty
              <tr>
                <td colspan="2" class="text-center text-muted">Belum ada data penjualan</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-5">
      <div class="stats-card">
        <h5 class="mb-4" style="color: #2d3748; font-weight: 700;">
          <i class="fas fa-trophy"></i> Top 10 Produk Terlaris
        </h5>
        <div class="table-responsive">
          <table class="table table-sm">
            <thead>
              <tr style="font-size: 0.875rem;">
                <th style="color: #374151; font-weight: 600;">#</th>
                <th style="color: #374151; font-weight: 600;">Produk</th>
                <th style="color: #374151; font-weight: 600;" class="text-end">Terjual</th>
              </tr>
            </thead>
            <tbody>
              @forelse($topProducts as $index => $product)
              <tr style="font-size: 0.875rem;">
                <td>
                  @if($index === 0)
                    <i class="fas fa-crown" style="color: #fbbf24;"></i>
                  @else
                    {{ $index + 1 }}
                  @endif
                </td>
                <td>
                  <strong>{{ $product->name }}</strong>
                  <div class="text-muted" style="font-size: 0.75rem;">
                    Rp {{ number_format($product->total_revenue, 0, ',', '.') }}
                  </div>
                </td>
                <td class="text-end">
                  <span class="badge" style="background: #3d7357;">{{ $product->total_quantity }} unit</span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="3" class="text-center text-muted" style="font-size: 0.875rem;">Belum ada produk terjual</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
