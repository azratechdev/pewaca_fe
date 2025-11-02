@extends('layouts.residence.basetemplate')
@section('content')
<style>
   <style>
    /* Custom Switch Styles */
    .custom-switch .form-check-input {
      width: 4rem;
      height: 2rem;
      border-radius: 2rem;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }
    .custom-switch .form-check-input:not(:checked) {
      background-color: #ccc;
      border-color: #ccc;
    }
    .custom-switch .form-check-input:checked {
      background-color: #198754;
      border-color: #198754;
      box-shadow: 0 0 10px rgba(25, 135, 84, 0.5); */
    }

    #repeat-container {
      display: none;
    }
    
  </style>
</style>
<div class="container">
    <div class="container mx-auto px-3">
        <div class="flex justify-between items-center" style="padding-top: 20px;">
        <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-800">
            <a href="{{ route('pembayaran.list') }}" class="text-dark">
                <i class="fas fa-arrow-left"></i>
            </a>&nbsp;&nbsp;Pembayaran Tagihan
        </h1>
        </div>
        </div>
        <br>
        <div class="mb-3">
            @include('layouts.elements.flash')

            @if($tagihan['data']['status'] == 'rejected')
                @include('layouts.elements.rejected')
            @endif

            @if($tagihan['data']['status']== 'process')
                @include('layouts.elements.confirm')
            @endif

            @if(date('Y-m-d') > $tagihan['data']['tagihan']['date_due'] && $tagihan['data']['status']== 'unpaid') 
                @include('layouts.elements.tempo')
            @endif
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
        
        @if($tagihan['data']['status'] == 'unpaid')
            <div class="mb-3">
                <h6 class="text-muted mb-3">Pilih Metode Pembayaran:</h6>
            </div>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <a href="{{ route('pembayaran.qris', ['id' => $tagihan['data']['id']]) }}" class="btn btn-success form-control d-flex align-items-center justify-content-between py-3">
                        <span>
                            <i class="fa fa-qrcode me-2"></i> Bayar via QRIS
                        </span>
                        <i class="fa fa-arrow-right"></i>
                    </a>
                    <small class="text-muted d-block mt-1 text-center">Scan QR Code untuk pembayaran instan</small>
                </div>
                
                <div class="col-md-6">
                    <a href="{{ route('pembayaran.upload_bukti', ['id' => $tagihan['data']['id']]) }}" class="btn btn-secondary form-control d-flex align-items-center justify-content-between py-3">
                        <span>
                            <i class="fa fa-file-invoice me-2"></i> Upload Bukti Transfer
                        </span>
                        <i class="fa fa-arrow-right"></i>
                    </a>
                    <small class="text-muted d-block mt-1 text-center">Transfer manual ke rekening di atas</small>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('pembayaran.detail_bukti', ['id' => $tagihan['data']['id']]) }}" class="btn btn-success form-control d-flex align-items-center justify-content-between">
                        <span>
                            Detail Bukti Pembayaran
                        </span>
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>



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