@extends('layouts.residence.basetemplate')
@section('content')

<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <b>Pengurus</b> (Admin Operasional)
            </h1>
        </div>
    </div>
</div>
<div class="flex flex-col items-center py-8">
   
    <!-- Menu List -->
    <div class="w-full max-w-5xl space-y-4 p-6">
        <!-- Report -->
        <a href="{{ route('pengurus.report') }}" class="flex items-center bg-white p-6 rounded-lg shadow hover:bg-gray-50">
            <div class="bg-green-100 text-green-600 p-4 rounded-full">
                <i class="fas fa-chart-bar fa-lg"></i>
            </div>
            <div class="flex-1 ml-6">
                <h2 class="font-semibold text-2xl">Report</h2>
                <p class="text-gray-500 text-base">Jumlah Pemasukan, Jumlah Tunggakan</p>
            </div>
            <i class="fas fa-chevron-right text-gray-400 text-xl"></i>
        </a>

        <!-- Biaya -->
        <a href="{{ route('pengurus.biaya.list') }}" class="flex items-center bg-white p-6 rounded-lg shadow hover:bg-gray-50">
            <div class="bg-green-100 text-green-600 p-4 rounded-full">
                <i class="fas fa-receipt fa-lg"></i>
            </div>
            <div class="flex-1 ml-6">
                <h2 class="font-semibold text-2xl">Biaya</h2>
                <p class="text-gray-500 text-base">Daftar biaya, Menunggu konfirmasi, Tunggakan</p>
            </div>
            <i class="fas fa-chevron-right text-gray-400 text-xl"></i>
        </a>

        <!-- Role -->
        <a href="{{ route('pengurus.role') }}" class="flex items-center bg-white p-6 rounded-lg shadow hover:bg-gray-50">
            <div class="bg-green-100 text-green-600 p-4 rounded-full">
                <i class="fas fa-user-cog fa-lg"></i>
            </div>
            <div class="flex-1 ml-6">
                <h2 class="font-semibold text-2xl">Role</h2>
                <p class="text-gray-500 text-base">Add pengurus, Hapus pengurus</p>
            </div>
            <i class="fas fa-chevron-right text-gray-400 text-xl"></i>
        </a>

        <!-- Warga -->
        <a href="{{ route('pengurus.warga.waiting') }}" class="flex items-center bg-white p-6 rounded-lg shadow hover:bg-gray-50">
            <div class="bg-green-100 text-green-600 p-4 rounded-full">
                <i class="fas fa-users fa-lg"></i>
            </div>
            <div class="flex-1 ml-6">
                <h2 class="font-semibold text-2xl">Warga</h2>
                <p class="text-gray-500 text-base">Approval request, Data warga</p>
            </div>
            <i class="fas fa-chevron-right text-gray-400 text-xl"></i>
        </a>

        <!-- Kelola Seller - DISABLED -->
        {{-- 
        <a href="{{ route('pengurus.seller-requests.index') }}" class="flex items-center bg-white p-6 rounded-lg shadow hover:bg-gray-50">
            <div class="bg-green-100 text-green-600 p-4 rounded-full">
                <i class="fas fa-store fa-lg"></i>
            </div>
            <div class="flex-1 ml-6">
                <h2 class="font-semibold text-2xl">
                    Kelola Seller
                    @if($pendingCount > 0)
                        <span class="badge bg-warning text-dark ms-2" style="font-size: 0.75rem; vertical-align: middle;">{{ $pendingCount }}</span>
                    @endif
                </h2>
                <p class="text-gray-500 text-base">Persetujuan seller, Daftar toko</p>
            </div>
            <i class="fas fa-chevron-right text-gray-400 text-xl"></i>
        </a>
        --}}

        <!-- Security -->
        <a href="{{ route('pengurus.keamanan') }}" class="flex items-center bg-white p-6 rounded-lg shadow hover:bg-gray-50">
            <div class="bg-green-100 text-green-600 p-4 rounded-full">
                <i class="fas fa-id-card fa-lg"></i>
            </div>
            <div class="flex-1 ml-6">
                <h2 class="font-semibold text-2xl">Security</h2>
                <p class="text-gray-500 text-base">List Security, Add Security</p>
            </div>
            <i class="fas fa-chevron-right text-gray-400 text-xl"></i>
        </a>
    </div>
</div>

@endsection 
