@extends('layouts.residence.basetemplate')

@section('content')
<style>
  .cart-header {
    background: linear-gradient(135deg, #5FA782 0%, #4a8a68 100%);
    color: white;
    padding: 1.5rem 0;
    /* margin: -20px -20px 20px -20px; */
  }
  .cart-item {
    background: white;
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
    border: 1px solid #e0e0e0;
  }
  .cart-item-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    font-size: 2rem;
  }
  .cart-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
  }
  .quantity-control {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  .quantity-btn {
    width: 32px;
    height: 32px;
    border: 1px solid #dee2e6;
    background: white;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
  }
  .quantity-btn:hover {
    background: #f8f9fa;
    border-color: #5FA782;
  }
  .quantity-input {
    width: 50px;
    text-align: center;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 0.25rem;
  }
  .summary-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e0e0e0;
    position: sticky;
    top: 20px;
  }
  .btn-checkout {
    background-color: #5FA782;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 10px;
    width: 100%;
    font-weight: 600;
    transition: all 0.3s;
  }
  .btn-checkout:hover {
    background-color: #4a8a68;
    color: white;
  }
  .price-tag {
    color: #5FA782;
    font-weight: bold;
  }
</style>

<div class="cart-header">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <div class="p-2">
        <a href="{{ route('warungku.index') }}" class="text-white text-decoration-none me-3">
          <i class="fas fa-arrow-left fa-lg"></i>
        </a>
      </div>
      <div class="p-2">
          <h4 class="mb-0"><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h4>
          <small>{{ $cart->total_items }} item</small>
      </div>
    </div>
    {{-- <div class="d-flex align-items-center">
      <div class="p-6"
        <a href="{{ route('warungku.index') }}" class="text-white text-decoration-none me-3">
          <i class="fas fa-arrow-left fa-lg"></i>
        </a>
        <div>
          <h4 class="mb-0">Keranjang Belanja <i class="fas fa-shopping-cart"></i></h4>
          <small>{{ $cart->total_items }} item</small>
        </div>
      </div>
    </div> --}}
  </div>
</div>

<div class="container mb-5 pb-5">
  @if($cart->items->isEmpty())
    <div class="text-center py-5">
      <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
      <h5>Keranjang Kosong</h5>
      <p class="text-muted">Belum ada produk di keranjang Anda</p>
      <a href="{{ route('warungku.index') }}" class="btn btn-checkout mt-3" style="width: auto; padding: 12px 30px;">
        <i class="fas fa-store"></i> Belanja Sekarang
      </a>
    </div>
  @else
    <div class="row">
      <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="mb-0">Produk ({{ $cart->items->count() }})</h5>
          <button class="btn btn-sm btn-outline-danger" id="btnClearCart">
            <i class="fas fa-trash"></i> Kosongkan
          </button>
        </div>

        <div id="cartItemsList">
          @foreach($cart->items as $item)
            <div class="cart-item" data-item-id="{{ $item->id }}">
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="cart-item-image">
                    @if($item->product->image)
                      <img src="{{ $item->product->image }}" 
                           alt="{{ $item->product->name }}"
                           onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-box\'></i>';">
                    @else
                      <i class="fas fa-box"></i>
                    @endif
                  </div>
                </div>
                <div class="col">
                  <h6 class="mb-1">{{ $item->product->name }}</h6>
                  <small class="text-muted">{{ $item->product->store->name }}</small>
                  <div class="price-tag mt-1">
                    Rp {{ number_format($item->price, 0, ',', '.') }}
                  </div>
                </div>
                <div class="col-auto">
                  <div class="quantity-control" data-item-id="{{ $item->id }}" data-max-stock="{{ $item->product->stock }}">
                    <button class="quantity-btn btn-decrease">
                      <i class="fas fa-minus"></i>
                    </button>
                    <input type="number" class="quantity-input" value="{{ $item->quantity }}" 
                           min="1" max="{{ $item->product->stock }}" readonly>
                    <button class="quantity-btn btn-increase">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                  <div class="text-center mt-2">
                    <small class="text-muted">Stok: {{ $item->product->stock }}</small>
                  </div>
                </div>
                <div class="col-auto text-end">
                  <div class="price-tag item-subtotal">
                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                  </div>
                  <button class="btn btn-sm btn-link text-danger mt-2" onclick="removeItem({{ $item->id }})">
                    <i class="fas fa-trash"></i> Hapus
                  </button>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="col-lg-4">
        <div class="summary-card">
          <h5 class="mb-3">Ringkasan Belanja</h5>
          <div class="d-flex justify-content-between mb-2">
            <span>Total Item</span>
            <span id="summaryTotalItems">{{ $cart->total_items }}</span>
          </div>
          <hr>
          <div class="d-flex justify-content-between mb-3">
            <h6>Total Harga</h6>
            <h5 class="price-tag mb-0" id="summaryTotal">Rp {{ number_format($cart->total, 0, ',', '.') }}</h5>
          </div>
          <button class="btn btn-checkout">
            <i class="fas fa-check-circle"></i> Checkout
          </button>
          <small class="text-muted d-block text-center mt-2">Fitur checkout akan segera hadir</small>
        </div>
      </div>
    </div>
  @endif
</div>

<script>
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  function updateQuantity(itemId, quantity) {
    if (quantity < 1) {
      removeItem(itemId);
      return;
    }

    fetch(`/warungku/keranjang/update/${itemId}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      },
      body: JSON.stringify({ quantity: parseInt(quantity) })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        updateCartUI(data, itemId);
      } else {
        alert(data.message);
        location.reload();
      }
    })
    .catch(err => {
      console.error(err);
      alert('Terjadi kesalahan');
    });
  }

  function removeItem(itemId) {
    if (!confirm('Hapus produk ini dari keranjang?')) return;

    fetch(`/warungku/keranjang/remove/${itemId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.querySelector(`[data-item-id="${itemId}"]`).remove();
        updateCartUI(data);
        
        if (data.cart_count === 0) {
          location.reload();
        }
      }
    })
    .catch(err => {
      console.error(err);
      alert('Terjadi kesalahan');
    });
  }

  document.getElementById('btnClearCart')?.addEventListener('click', function() {
    if (!confirm('Kosongkan seluruh keranjang?')) return;

    fetch('/warungku/keranjang/clear', {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        location.reload();
      }
    })
    .catch(err => {
      console.error(err);
      alert('Terjadi kesalahan');
    });
  });

  function updateCartUI(data, itemId = null) {
    // Update subtotal untuk item yang diupdate
    if (itemId && data.subtotal !== undefined) {
      const itemCard = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
      if (itemCard) {
        const subtotalElement = itemCard.querySelector('.item-subtotal');
        if (subtotalElement) {
          subtotalElement.textContent = 'Rp ' + data.subtotal.toLocaleString('id-ID');
        }
      }
    }
    
    // Update total items
    if (data.cart_count !== undefined) {
      document.getElementById('summaryTotalItems').textContent = data.cart_count;
      
      const badge = document.querySelector('.cart-badge');
      if (badge) {
        badge.textContent = data.cart_count;
        badge.style.display = data.cart_count > 0 ? 'inline-block' : 'none';
      }
    }
    
    // Update total harga
    if (data.total !== undefined) {
      document.getElementById('summaryTotal').textContent = 'Rp ' + data.total.toLocaleString('id-ID');
    }
  }

  // Event listeners untuk tombol + dan -
  document.querySelectorAll('.quantity-control').forEach(control => {
    const itemId = control.dataset.itemId;
    const maxStock = parseInt(control.dataset.maxStock);
    const input = control.querySelector('.quantity-input');
    const btnIncrease = control.querySelector('.btn-increase');
    const btnDecrease = control.querySelector('.btn-decrease');

    btnIncrease.addEventListener('click', () => {
      const currentQty = parseInt(input.value);
      const newQty = currentQty + 1;
      
      if (newQty <= maxStock) {
        input.value = newQty;
        updateQuantity(itemId, newQty);
      } else {
        alert(`Stok maksimal: ${maxStock}`);
      }
    });

    btnDecrease.addEventListener('click', () => {
      const currentQty = parseInt(input.value);
      const newQty = currentQty - 1;
      
      if (newQty >= 1) {
        input.value = newQty;
        updateQuantity(itemId, newQty);
      } else {
        removeItem(itemId);
      }
    });
  });
</script>
@endsection
