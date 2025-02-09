@extends('layouts.residence.basetemplate')
@section('content')

<div class="container">
  <div class="container mx-auto px-4">
    <div class="flex justify-between items-center" style="padding-top: 10px;">
      <div class="flex items-center">
        <h1 class="text-xl font-semibold text-gray-800">
          <a href="{{ route('pembayaran') }}" class="text-dark">
              <i class="fas fa-arrow-left"></i>
          </a>&nbsp;Pembayaran Tagihan
      </h1>
      </div>
    </div>
    <br>
    <div class="mb-3">
        @include('layouts.elements.flash')
    </div>
   
    <div class="flex justify-between items-center">
        <div class="flex items-center">
            <p class="d-flex align-items-center">
              <strong>{{ $tagihan['data']['tagihan']['name'] ?? 'Nama Tagihan' }}</strong>
            </p>
        </div>
    </div>

    <div class="flex justify-between items-center mt-2">
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                {{ $tagihan['data']['tagihan']['description'] ?? 'Deskripsi tidak ada' }}
            </p>
        </div>
    </div> 
    <div class="flex justify-between items-center mt-1">
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                Nominal
            </p>
        </div>
        
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                @php
                    $formattedAmount = number_format((int) $tagihan['data']['tagihan']['amount'], 0, ',', '.');
                @endphp
                <strong>Rp {{ $formattedAmount }}</strong>
            </p>
        </div>
    </div> 

    <hr class="mt-2">

    <div class="flex justify-between items-center mt-1">
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                Transfer ke :
            </p>
        </div>
        
    </div> 
    
    <div class="flex justify-between items-center mt-1">
        <div class="flex items-center">
            <p class="d-flex align-items-center" style="font-size:10px;">
               No. Rekening
            </p>
        </div>
       
    </div> 
    
    <div class="flex justify-between items-center mt-1">
        <div class="flex items-center">
            <div class="d-flex align-items-center norek">
                <strong>
                    {{ $tagihan['data']['residence_bank']['account_number'] ?? '123456789' }}
                </strong>
            </div>
        </div>
        
        <div class="flex items-center">
            <p class="d-flex align-items-center salin" style="color:lightgreen;">
                Salin
            </p>
        </div>
    </div> 
    <div class="flex justify-between items-center mt-1">
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                Atas Nama
            </p>
        </div>
        
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                <strong>{{ $tagihan['data']['residence_bank']['account_holder_name'] }}</strong>
            </p>
        </div>
    </div> 
    <div class="flex justify-between items-center mt-1">
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                Nama Bank
            </p>
        </div>
        
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                <strong>{{ $tagihan['data']['residence_bank']['bank']['bank_name'] }}</strong>
            </p>
        </div>
    </div> 
    <hr class="mt-2">
    <br>
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('pembayaran.upload_bukti', ['id' => $tagihan['data']['id']]) }}" class="btn btn-secondary form-control d-flex align-items-center justify-content-between">
                <span>
                    <i class="fa fa-file-invoice me-2"></i> Upload Bukti Pembayaran
                </span>
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>

  </div>
</div>
  

<script>
    const paymentInput = document.getElementById('nominal');
    const typeInput = document.getElementById('tipe');
    
    // Ambil nilai amount dari server dan hapus ".00" jika ada
    let amount = "{{ $tagihan['data']['tagihan']['amount'] }}".split('.')[0]; // Mengambil angka sebelum "."
    const typeValue = typeInput.value; // Ambil tipe
  
    // Set nilai awal berdasarkan tipe
    if (typeValue === 'wajib') {
      paymentInput.value = `Rp. ${parseInt(amount, 10).toLocaleString('id-ID')}`;
      paymentInput.readOnly = true; // Input tidak dapat diubah
    } else {
      paymentInput.value = ''; // Kosongkan jika tidak wajib
      paymentInput.readOnly = false;
    }
  
    // Event listener untuk format Rupiah saat user mengetik (jika tidak wajib)
    paymentInput.addEventListener('input', function (e) {
      if (typeValue !== 'wajib') {
        let value = this.value.replace(/[^0-9]/g, ''); // Hanya angka
        if (value) {
          value = parseInt(value, 10).toLocaleString('id-ID'); // Format angka ke Rupiah
          this.value = `Rp. ${value}`;
        } else {
          this.value = '';
        }
      }
    });
  
    // Event listener untuk mengatur nilai default jika input dikosongkan
    paymentInput.addEventListener('blur', function () {
      if (typeValue !== 'wajib' && !this.value.startsWith('Rp.')) {
        this.value = ''; // Kosongkan input jika tidak "wajib"
      }
    });
</script>

<script>
$(document).ready(function () {
    $('.salin').on('click', function () {
        // Debugging: Log untuk memastikan elemen ditemukan
        const norekElement = $('.norek strong');
        
        // Ambil teks di dalam elemen
        const norekText = norekElement.text().trim();
        console.log('Teks yang diambil:', norekText);

        if (norekText) {
            // Salin teks ke clipboard menggunakan API modern
            if (navigator.clipboard) {
                navigator.clipboard.writeText(norekText)
                    .then(() => {
                        alert('Berhasil menyalin: ' + norekText);
                    })
                    .catch(err => {
                        console.error('Gagal menyalin:', err);
                        alert('Gagal menyalin teks.');
                    });
            } else {
                // Fallback untuk browser lama
                const tempInput = $('<textarea>');
                $('body').append(tempInput);
                tempInput.val(norekText).css({
                    position: 'absolute',
                    left: '-9999px',
                }).select();
                try {
                    document.execCommand('copy');
                    alert('Berhasil menyalin: ' + norekText);
                } catch (err) {
                    console.error('Gagal menyalin:', err);
                    alert('Gagal menyalin teks.');
                }
                tempInput.remove();
            }
        } else {
            alert('Tidak ada teks untuk disalin.');
        }
    });
});

</script>   


@endsection 