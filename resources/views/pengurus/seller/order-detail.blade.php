@extends('layouts.residence.basetemplate')
@section('content')

<style>
.detail-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  padding: 32px;
  border: 1px solid rgba(61, 115, 87, 0.1);
  margin-bottom: 20px;
}

.btn-seller {
  background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 10px;
  font-weight: 600;
}
</style>

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 style="color: #2d3748; font-weight: 800;">
        <i class="fas fa-receipt"></i> Detail Order
      </h1>
      <p class="text-muted mb-0">{{ $order->order_number }}</p>
    </div>
    <a href="{{ route('pengurus.seller.orders', $store->id) }}" class="btn btn-outline-secondary">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="detail-card">
        <h5 class="mb-4" style="color: #2d3748; font-weight: 700;">
          <i class="fas fa-box-open"></i> Produk yang Dipesan
        </h5>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach($order->items as $item)
              <tr>
                <td>
                  <strong>{{ $item->product_name }}</strong>
                </td>
                <td>{{ $item->formatted_price }}</td>
                <td>{{ $item->quantity }}</td>
                <td><strong>{{ $item->formatted_subtotal }}</strong></td>
              </tr>
              @endforeach
              <tr>
                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                <td><h5 style="color: #3d7357; margin: 0;">{{ $order->formatted_total }}</h5></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      @if($order->notes)
      <div class="detail-card">
        <h5 class="mb-3" style="color: #2d3748; font-weight: 700;">
          <i class="fas fa-sticky-note"></i> Catatan
        </h5>
        <p class="mb-0">{{ $order->notes }}</p>
      </div>
      @endif
    </div>

    <div class="col-md-4">
      <div class="detail-card">
        <h5 class="mb-4" style="color: #2d3748; font-weight: 700;">
          <i class="fas fa-info-circle"></i> Info Order
        </h5>

        <div class="mb-3">
          <div class="text-muted small">Status Order</div>
          <div class="mb-2">{!! $order->status_badge !!}</div>
          <select class="form-select" id="orderStatus">
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
          </select>
          <button class="btn btn-seller w-100 mt-2" onclick="updateStatus()">
            <i class="fas fa-sync"></i> Update Status
          </button>
        </div>

        <hr>

        <div class="mb-3">
          <div class="text-muted small">Status Pembayaran</div>
          <div>{!! $order->payment_status_badge !!}</div>
        </div>

        @if($order->payment_method)
        <div class="mb-3">
          <div class="text-muted small">Metode Pembayaran</div>
          <div>{{ ucfirst($order->payment_method) }}</div>
        </div>
        @endif

        <hr>

        <div class="mb-3">
          <div class="text-muted small">Pelanggan</div>
          <div class="fw-bold">{{ $order->customer_name }}</div>
        </div>

        @if($order->customer_phone)
        <div class="mb-3">
          <div class="text-muted small">No. HP</div>
          <div>{{ $order->customer_phone }}</div>
        </div>
        @endif

        @if($order->customer_address)
        <div class="mb-3">
          <div class="text-muted small">Alamat</div>
          <div>{{ $order->customer_address }}</div>
        </div>
        @endif

        <hr>

        <div>
          <div class="text-muted small">Tanggal Order</div>
          <div>{{ $order->created_at->format('d F Y, H:i') }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function updateStatus() {
  const newStatus = document.getElementById('orderStatus').value;
  
  if (!confirm('Yakin ingin mengubah status order ini?')) {
    return;
  }

  fetch('{{ route('pengurus.seller.orders.update-status', [$store->id, $order->id]) }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ status: newStatus })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert('Status order berhasil diupdate!');
      location.reload();
    } else {
      alert('Gagal update status: ' + data.message);
    }
  })
  .catch(err => alert('Error: ' + err.message));
}
</script>

@endsection
