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
<div class="bg-gray-100 min-h-screen flex flex-col items-center py-8">
   
    <!-- Menu List -->
    <div class="w-full max-w-5xl space-y-4 p-6">
        <!-- Report -->
        <a href="#" class="flex items-center bg-white p-6 rounded-lg shadow hover:bg-gray-50">
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
    </div>
</div>


{{-- <div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                Pengurus (Admin Operasional)
            </h1>
        </div>

        <div class="p-2">
            <ul class="nav nav-tabs" role="tablist" style="border:none;">
                <li class="nav-item">
                    <a href="{{ route('pengurus.biaya.list') }}" class="nav-link custom-nav-button active">
                        <i class="fa fa-check-circle fa-2x"></i> <!-- Ikon Approval -->
                        <span class="d-block">Biaya</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengurus.role') }}" class="nav-link custom-nav-button active">
                        <i class="fa fa-id-card fa-2x"></i> <!-- Ikon History -->
                        <span class="d-block">Peran</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengurus.warga.waiting') }}" class="nav-link custom-nav-button active">
                        <i class="fa fa-users fa-2x"></i> <!-- Ikon Warga -->
                        <span class="d-block">Warga</span>
                    </a>
                </li>
              </ul>            
        
        </div>
       
    </div>
</div> --}}
@endsection 
