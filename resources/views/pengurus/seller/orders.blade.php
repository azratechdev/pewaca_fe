@extends('layouts.residence.basetemplate')
@section('content')

<style>
.order-card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  padding: 20px;
  margin-bottom: 16px;
  border-left: 4px solid #3d7357;
  transition: all 0.3s ease;
}

.order-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(61, 115, 87, 0.15);
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
</style>

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 style="color: #2d3748; font-weight: 800;">
        <i class="fas fa-shopping-cart"></i> {{ $store->name }} - Orders
      </h1>
      <p class="text-muted mb-0">Kelola pesanan pelanggan</p>
    </div>
    <a href="{{ route('pengurus.seller.dashboard') }}" class="btn btn-outline-secondary">
      <i class="fas fa-arrow-left"></i> Dashboard
    </a>
  </div>

  @if($orders->isEmpty())
    <div class="alert alert-info text-center" style="border-radius: 16px; border: none;">
      <i class="fas fa-inbox fa-3x mb-3" style="color: #0097a7;"></i>
      <h4>Belum Ada Order</h4>
      <p>Order akan muncul di sini ketika ada pelanggan yang membeli produk Anda.</p>
    </div>
  @else
    @foreach($orders as $order)
    <div class="order-card">
      <div class="row align-items-center">
        <div class="col-md-3">
          <div class="fw-bold" style="color: #3d7357;">{{ $order->order_number }}</div>
          <div class="text-muted small">{{ $order->created_at->format('d/m/Y H:i') }}</div>
        </div>

        <div class="col-md-2">
          <div class="text-muted small">Pelanggan</div>
          <div class="fw-bold">{{ $order->customer_name }}</div>
        </div>

        <div class="col-md-2">
          <div class="text-muted small">Total</div>
          <div class="fw-bold" style="color: #3d7357;">{{ $order->formatted_total }}</div>
        </div>

        <div class="col-md-2">
          <div class="text-muted small">Status</div>
          <div>{!! $order->status_badge !!}</div>
        </div>

        <div class="col-md-2">
          <div class="text-muted small">Pembayaran</div>
          <div>{!! $order->payment_status_badge !!}</div>
        </div>

        <div class="col-md-1 text-end">
          <a href="{{ route('pengurus.seller.orders.detail', [$store->id, $order->id]) }}" class="btn btn-sm btn-seller">
            <i class="fas fa-eye"></i>
          </a>
        </div>
      </div>
    </div>
    @endforeach

    <div class="mt-4">
      {{ $orders->links() }}
    </div>
  @endif
</div>

@endsection
