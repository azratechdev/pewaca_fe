@extends('layouts.residence.basetemplate')

@section('content')
@php
    session(['origin_page' => url()->current()]);
    $cred = session('cred');
    $backRoute = isset($cred['is_pengurus']) && $cred['is_pengurus'] ? route('pengurus') : route('home');
    $activeTab = request('tab', 'pengeluaran'); // Default tab pengeluaran
@endphp

<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ $backRoute }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Transaksi
            </h1>
        </div>

        @include('pembayaran.menupembayaran')

        <!-- Under Development Alert -->
        @if(in_array($activeTab, ['pengeluaran', 'dana']))
        <div class="mx-6 mt-6 mb-4 bg-gradient-to-r from-yellow-50 to-amber-50 border-l-4 border-yellow-500 p-4 rounded-r-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-semibold text-yellow-800">
                        <i class="fas fa-tools mr-2"></i>Under Development
                    </p>
                    <p class="text-sm text-yellow-700 mt-1">
                        Fitur ini sedang dalam tahap pengembangan. API endpoint belum tersedia. Data yang ditampilkan adalah contoh (dummy data).
                    </p>
                </div>
            </div>
        </div>
        @endif

        @if($activeTab == 'dana')
            <!-- Dana Tersimpan Tab -->
            <div class="p-6">
                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Total Pemasukan Card -->
                        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-100 text-sm mb-2">Total Pemasukan</p>
                                    <h3 class="text-3xl font-bold" id="total-pemasukan">Rp 0</h3>
                                </div>
                                <div class="bg-white bg-opacity-20 rounded-full p-4">
                                    <i class="fas fa-arrow-down text-3xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Total Pengeluaran Card -->
                        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-red-100 text-sm mb-2">Total Pengeluaran</p>
                                    <h3 class="text-3xl font-bold" id="total-pengeluaran">Rp 0</h3>
                                </div>
                                <div class="bg-white bg-opacity-20 rounded-full p-4">
                                    <i class="fas fa-arrow-up text-3xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Saldo Card -->
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-100 text-sm mb-2">Saldo Tersisa</p>
                                    <h3 class="text-3xl font-bold" id="saldo-tersisa">Rp 0</h3>
                                </div>
                                <div class="bg-white bg-opacity-20 rounded-full p-4">
                                    <i class="fas fa-wallet text-3xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Breakdown -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <h4 class="font-semibold text-lg mb-4 text-gray-800">
                        <i class="fas fa-chart-pie text-blue-500 mr-2"></i>
                        Detail Keuangan
                    </h4>
                    <div id="dana-detail" class="space-y-3">
                        <div class="flex justify-center items-center py-8">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-500"></div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Pengeluaran Tab (existing content) -->
<div class="container-fluid px-3 py-4" style="background: #f8f9fa; min-height: 100vh;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; background: linear-gradient(135deg, #2ca25f 0%, #006d2c 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-white mb-1 fw-bold">
                                <i class="fas fa-wallet me-2"></i>Manajemen Pengeluaran
                            </h4>
                            <p class="text-white-50 mb-0 small">Kelola pengeluaran paguyuban</p>
                        </div>
                        <div class="text-end">
                            <p class="text-white-50 mb-1 small">Periode</p>
                            <h5 class="text-white mb-0 fw-bold">{{ date('F Y') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Button -->
    <div class="row mb-3">
        <div class="col-12">
            <button class="btn w-100 py-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahPengeluaranModal" style="background: #2ca25f; color: white; border: none; border-radius: 15px; font-weight: 600;">
                <i class="fas fa-plus-circle me-2"></i>Tambah Pengeluaran Baru
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; background: linear-gradient(135deg, #66c2a4 0%, #2ca25f 100%);">
                <div class="card-body text-center py-3">
                    <p class="text-white mb-1 small fw-semibold">Total Pengeluaran</p>
                    <h4 class="text-white mb-0 fw-bold">Rp <span id="totalPengeluaran">0</span></h4>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; background: #edf8fb; border: 2px solid #99d8c9;">
                <div class="card-body text-center py-3">
                    <p class="text-dark mb-1 small fw-semibold" style="color: #006d2c !important;">Jumlah Transaksi</p>
                    <h4 class="mb-0 fw-bold" style="color: #2ca25f;"><span id="jumlahPengeluaran">0</span></h4>
                </div>
            </div>
        </div>
    </div>

    <!-- List Pengeluaran -->
    <div id="listPengeluaran">
        <!-- Dynamic content will be loaded here -->
    </div>
</div>

<!-- Modal Tambah Pengeluaran -->
<div class="modal fade" id="tambahPengeluaranModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header border-0 pb-0" style="background: linear-gradient(135deg, #2ca25f 0%, #006d2c 100%); border-radius: 20px 20px 0 0;">
                <h5 class="modal-title text-white fw-bold"><i class="fas fa-plus-circle me-2"></i>Tambah Pengeluaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formPengeluaran">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small" style="color: #006d2c;"><i class="fas fa-calendar me-2"></i>Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" required style="border-radius: 10px; border-color: #99d8c9;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small" style="color: #006d2c;"><i class="fas fa-list me-2"></i>Kategori</label>
                        <select class="form-select" id="kategori" required style="border-radius: 10px; border-color: #99d8c9;">
                            <option value="">Pilih kategori...</option>
                            <option value="Operasional">Operasional</option>
                            <option value="Keamanan">Keamanan</option>
                            <option value="Kebersihan">Kebersihan</option>
                            <option value="Pemeliharaan">Pemeliharaan</option>
                            <option value="Acara">Acara</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small" style="color: #006d2c;"><i class="fas fa-file-alt me-2"></i>Keterangan</label>
                        <textarea class="form-control" id="keterangan" rows="3" required style="border-radius: 10px; border-color: #99d8c9;"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small" style="color: #006d2c;"><i class="fas fa-money-bill-wave me-2"></i>Jumlah (Rp)</label>
                        <input type="number" class="form-control" id="jumlah" required style="border-radius: 10px; border-color: #99d8c9;">
                    </div>
                    <button type="submit" class="btn w-100 py-2 fw-semibold" style="border-radius: 10px; background: #2ca25f; border: none; color: white;">
                        <i class="fas fa-save me-2"></i>Simpan Pengeluaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.form-control:focus, .form-select:focus {
    border-color: #2ca25f;
    box-shadow: 0 0 0 0.2rem rgba(44, 162, 95, 0.25);
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    loadPengeluaran();
    loadDanaTersimpan();
    initChart();

    // Set today's date as default
    document.getElementById('tanggal').valueAsDate = new Date();

    // Form submit
    $('#formPengeluaran').on('submit', function(e) {
        e.preventDefault();
        
        const data = {
            tanggal: $('#tanggal').val(),
            kategori: $('#kategori').val(),
            keterangan: $('#keterangan').val(),
            jumlah: $('#jumlah').val()
        };

        $.ajax({
            url: '/api/pengurus/pengeluaran/store',
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#tambahPengeluaranModal').modal('hide');
                $('#formPengeluaran')[0].reset();
                loadPengeluaran();
                loadDanaTersimpan();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Pengeluaran berhasil ditambahkan',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menyimpan data'
                });
            }
        });
    });
});

function loadPengeluaran() {
    $.ajax({
        url: '/api/pengurus/pengeluaran',
        method: 'GET',
        success: function(response) {
            let html = '';
            let total = 0;
            
            if (response.data && response.data.length > 0) {
                response.data.forEach(item => {
                    total += parseInt(item.jumlah);
                    html += `
                        <div class="card border-0 shadow-sm mb-2" style="border-radius: 15px;">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="badge bg-primary me-2" style="border-radius: 8px;">${item.kategori}</span>
                                            <small class="text-muted"><i class="far fa-calendar me-1"></i>${formatDate(item.tanggal)}</small>
                                        </div> border-left: 4px solid #2ca25f;">
                            <div class="card-body p-3" style="background: white;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="badge me-2" style="background: #99d8c9; color: #006d2c; border-radius: 8px;">${item.kategori}</span>
                                            <small class="text-muted"><i class="far fa-calendar me-1"></i>${formatDate(item.tanggal)}</small>
                                        </div>
                                        <p class="mb-1 fw-semibold" style="color: #006d2c;">${item.keterangan}</p>
                                    </div>
                                    <div class="text-end">
                                        <h6 class="mb-0 fw-bold" style="color: #2ca25f;">Rp ${formatNumber(item.jumlah)}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $('#totalPengeluaran').text(formatNumber(total));
                $('#jumlahPengeluaran').text(response.data.length);
                $('#totalPengeluaranDana').text(formatNumber(total));
            } else {
                html = `
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x mb-3" style="color: #ccece6;
    });
}

function loadDanaTersimpan() {
    $.ajax({
        url: '/api/pengurus/dana-tersimpan',
        method: 'GET',
        success: function(response) {
            if (response.data) {
                // Update summary cards
                $('#total-pemasukan').text('Rp ' + formatNumber(response.data.total_pemasukan || 0));
                $('#total-pengeluaran').text('Rp ' + formatNumber(response.data.total_pengeluaran || 0));
                $('#saldo-tersisa').text('Rp ' + formatNumber(response.data.saldo_tersisa || 0));
                
                // Update detail breakdown
                let detailHtml = `
                    <div class="divide-y divide-gray-200">
                        <div class="flex justify-between items-center py-3">
                            <div class="flex items-center">
                                <div class="bg-green-100 rounded-full p-2 mr-3">
                                    <i class="fas fa-arrow-down text-green-600"></i>
                                </div>
                                <span class="text-gray-700">Total Pemasukan</span>
                            </div>
                            <span class="font-semibold text-green-600">Rp ${formatNumber(response.data.total_pemasukan || 0)}</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <div class="flex items-center">
                                <div class="bg-red-100 rounded-full p-2 mr-3">
                                    <i class="fas fa-arrow-up text-red-600"></i>
                                </div>
                                <span class="text-gray-700">Total Pengeluaran</span>
                            </div>
                            <span class="font-semibold text-red-600">Rp ${formatNumber(response.data.total_pengeluaran || 0)}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 bg-blue-50 -mx-6 px-6 rounded-lg">
                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-full p-2 mr-3">
                                    <i class="fas fa-wallet text-blue-600"></i>
                                </div>
                                <span class="text-gray-800 font-semibold">Saldo Akhir</span>
                            </div>
                            <span class="font-bold text-blue-600 text-xl">Rp ${formatNumber(response.data.saldo_tersisa || 0)}</span>
                        </div>
                    </div>
                `;
                $('#dana-detail').html(detailHtml);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading dana tersimpan:', error);
            $('#dana-detail').html(`
                <div class="text-center py-8">
                    <i class="fas fa-exclamation-circle text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Gagal memuat data keuangan</p>
                    <button onclick="loadDanaTersimpan()" class="mt-3 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        <i class="fas fa-redo mr-2"></i>Muat Ulang
                    </button>
                </div>
            `);
        }
    });
}

function initChart() {
    const ctx = document.getElementById('danaChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Dana Tersimpan',
                data: [0, 0, 0, 0, 0, 0],
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + formatNumber(value);
                        }
                    }
                }
            }
        }
    });
}

function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
}
</script>
        @endif
    </div>
</div>
@endsection
