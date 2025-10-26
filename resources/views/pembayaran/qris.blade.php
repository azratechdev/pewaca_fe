@extends('layouts.residence.basetemplate')
@section('content')

<div class="container">
    <div class="container mx-auto px-3">
        <div class="flex justify-between items-center" style="padding-top: 20px;">
            <div class="flex items-center">
                <h1 class="text-xl font-semibold text-gray-800">
                    <a href="{{ route('pembayaran.list') }}" class="text-dark">
                        <i class="fas fa-arrow-left"></i>
                    </a>&nbsp;&nbsp;Bayar via QRIS
                </h1>
            </div>
        </div>
        <br>
        
        <div class="mb-3">
            @include('layouts.elements.flash')
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 mb-4">
            <h5 class="font-bold mb-3">Detail Tagihan</h5>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Nama Tagihan:</span>
                <strong>{{ $tagihan['tagihan']['name'] }}</strong>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Deskripsi:</span>
                <span>{{ $tagihan['tagihan']['description'] }}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Jumlah:</span>
                <strong class="text-lg text-green-600">Rp {{ number_format((int) $tagihan['tagihan']['amount'], 0, ',', '.') }}</strong>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Batas Waktu:</span>
                <span>{{ \Carbon\Carbon::parse($tagihan['tagihan']['date_due'])->translatedFormat('d F Y') }}</span>
            </div>
        </div>

        <div id="qr-section" class="bg-white rounded-lg shadow-md p-4 text-center">
            <h5 class="font-bold mb-3">Scan QR Code untuk Bayar</h5>
            
            <div id="qr-display" class="mb-4">
                <div class="bg-gray-100 p-4 rounded-lg inline-block">
                    <div style="font-size: 150px; line-height: 1;">
                        <i class="fas fa-qrcode text-gray-400"></i>
                    </div>
                    <p class="text-gray-600 mt-2">QR Code Mock Provider</p>
                    <p class="text-sm text-gray-500">{{ $payment['qr_string'] ?? 'Tidak tersedia' }}</p>
                </div>
            </div>

            <div id="payment-status" class="mb-4">
                <div class="alert alert-info">
                    <i class="fas fa-clock"></i>
                    <span id="status-text">Menunggu Pembayaran...</span>
                </div>
            </div>

            <div class="text-sm text-gray-500 mb-3">
                <p>QR Code berlaku hingga:</p>
                <p class="font-bold" id="expires-at">{{ \Carbon\Carbon::parse($payment['expires_at'])->translatedFormat('d F Y H:i') }}</p>
            </div>

            <div class="text-sm text-gray-500">
                <p>Payment ID: <code>{{ $payment['payment_id'] }}</code></p>
            </div>
        </div>

        <div id="success-section" class="bg-white rounded-lg shadow-md p-4 text-center" style="display: none;">
            <div class="text-green-500" style="font-size: 80px;">
                <i class="fas fa-check-circle"></i>
            </div>
            <h4 class="font-bold text-green-600 mt-3">Pembayaran Berhasil!</h4>
            <p class="text-gray-600 mt-2">Tagihan Anda telah dibayar</p>
            <div class="mt-4">
                <a href="{{ route('pembayaran.list') }}" class="btn btn-success">
                    Kembali ke Daftar Tagihan
                </a>
            </div>
        </div>

        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
            <p class="text-sm text-blue-700">
                <i class="fas fa-info-circle"></i>
                <strong>Catatan:</strong> Saat ini menggunakan Mock Provider untuk testing. 
                Pada produksi nanti, QR code akan terhubung dengan payment gateway sesungguhnya.
            </p>
        </div>

    </div>
</div>

<script>
let paymentId = '{{ $payment['payment_id'] }}';
let checkInterval;

function checkPaymentStatus() {
    fetch('/api/check-payment/' + paymentId)
        .then(response => response.json())
        .then(data => {
            console.log('Payment status:', data.status);
            
            if (data.status === 'PAID') {
                document.getElementById('qr-section').style.display = 'none';
                document.getElementById('success-section').style.display = 'block';
                clearInterval(checkInterval);
            } else if (data.status === 'EXPIRED' || data.status === 'FAILED') {
                document.getElementById('payment-status').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i>
                        <span>Pembayaran ${data.status === 'EXPIRED' ? 'kadaluarsa' : 'gagal'}. Silakan coba lagi.</span>
                    </div>
                `;
                clearInterval(checkInterval);
                
                setTimeout(() => {
                    window.location.href = '{{ route("pembayaran.list") }}';
                }, 3000);
            }
        })
        .catch(error => {
            console.error('Error checking payment status:', error);
        });
}

checkInterval = setInterval(checkPaymentStatus, 3000);

setTimeout(() => {
    clearInterval(checkInterval);
}, 900000);
</script>

@endsection
