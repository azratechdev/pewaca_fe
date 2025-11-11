@extends('layouts.residence.basetemplate')
@section('content')

<style>
.product-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
  overflow: hidden;
  border: 1px solid rgba(61, 115, 87, 0.1);
}

.product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(61, 115, 87, 0.15);
}

.product-img {
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

.stock-badge {
  position: absolute;
  top: 12px;
  right: 12px;
  padding: 6px 12px;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 600;
  background: linear-gradient(135deg, #07301d 0%, #064e3b 100%);
  color: white;
}

.stock-low {
  background: linear-gradient(135deg, #92400e 0%, #78350f 100%);
}

.stock-out {
  background: linear-gradient(135deg, #991b1b 0%, #7f1d1d 100%);
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
</style>

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 style="color: #2d3748; font-weight: 800;">
        <i class="fas fa-box"></i> {{ $store->name }} - Produk
      </h1>
      <p class="text-muted mb-0">Kelola produk toko Anda</p>
    </div>
    <div>
      <a href="{{ route('pengurus.seller.dashboard') }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-arrow-left"></i> Dashboard
      </a>
      <a href="{{ route('pengurus.seller.products.create', $store->id) }}" class="btn btn-seller">
        <i class="fas fa-plus-circle"></i> Tambah Produk
      </a>
    </div>
  </div>

  @if($products->isEmpty())
    <div class="alert alert-info text-center" style="border-radius: 16px; border: none;">
      <i class="fas fa-box-open fa-3x mb-3" style="color: #0097a7;"></i>
      <h4>Belum Ada Produk</h4>
      <p>Tambahkan produk pertama Anda sekarang!</p>
      <a href="{{ route('pengurus.seller.products.create', $store->id) }}" class="btn btn-seller">
        <i class="fas fa-plus"></i> Tambah Produk
      </a>
    </div>
  @else
    <div class="row g-4">
      @foreach($products as $product)
      <div class="col-md-4">
        <div class="product-card">
          <div class="position-relative">
            <div class="product-img">
              @if($product->image)
                <img src="{{ $product->image }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
              @else
                <i class="fas fa-box"></i>
              @endif
            </div>
            <div class="stock-badge {{ $product->stock == 0 ? 'stock-out' : ($product->stock < 10 ? 'stock-low' : '') }}">
              @if($product->stock == 0)
                <i class="fas fa-times-circle"></i> Habis
              @else
                <i class="fas fa-cubes"></i> {{ $product->stock }}
              @endif
            </div>
          </div>

          <div class="p-4">
            <h5 style="color: #2d3748; font-weight: 700; margin-bottom: 8px;">{{ $product->name }}</h5>
            <p class="text-muted mb-3" style="font-size: 0.875rem;">
              {{ Str::limit($product->description, 80) }}
            </p>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div>
                <div class="text-muted small">Harga</div>
                <h4 style="color: #3d7357; font-weight: 800; margin: 0;">{{ $product->formatted_price }}</h4>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" {{ $product->is_available ? 'checked' : '' }} disabled>
                <label class="form-check-label small">{{ $product->is_available ? 'Tersedia' : 'Tidak Tersedia' }}</label>
              </div>
            </div>

            <div class="d-grid gap-2">
              <a href="{{ route('pengurus.seller.products.edit', [$store->id, $product->id]) }}" class="btn btn-seller">
                <i class="fas fa-edit"></i> Edit Produk
              </a>
              <div class="row g-2">
                <div class="col-6">
                  <button class="btn btn-outline-primary w-100 btn-sm" onclick="updateStock({{ $product->id }}, {{ $product->stock }})">
                    <i class="fas fa-warehouse"></i> Update Stock
                  </button>
                </div>
                <div class="col-6">
                  <form action="{{ route('pengurus.seller.products.delete', [$store->id, $product->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus produk ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100 btn-sm">
                      <i class="fas fa-trash"></i> Hapus
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div class="mt-4">
      {{ $products->links() }}
    </div>
  @endif
</div>

<script>
function updateStock(productId, currentStock) {
  const newStock = prompt('Update stock untuk produk ini:', currentStock);
  if (newStock !== null && newStock !== '') {
    fetch(`{{ route('pengurus.seller.products.update-stock', [$store->id, '__PRODUCT_ID__']) }}`.replace('__PRODUCT_ID__', productId), {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ stock: parseInt(newStock) })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert('Stock berhasil diupdate!');
        location.reload();
      } else {
        alert('Gagal update stock: ' + data.message);
      }
    })
    .catch(err => alert('Error: ' + err.message));
  }
}
</script>

@endsection
