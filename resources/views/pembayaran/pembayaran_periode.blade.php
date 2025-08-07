@extends('layouts.residence.basetemplate')
@section('content')
<style>
    .container {
        padding: 20px;
        background: #fff;
    }
    
    .total-section {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #fff;
        padding: 15px 20px;
        border-top: 1px solid #eee;
    }
    .btn-lanjutkan {
        background: #00A884;
        color: white;
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        text-align: center;
        font-weight: 500;
    }
    .periode-title {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 4px;
    }
    .btn-tambah {
        color: #00A884;
        border: 1px solid #00A884;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .month-selected{
        padding: 10px 20px;
        background: #f8f9fa;
        font-weight: 500;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }
</style>
<div class="container">
    <div class="container mx-auto px-4">
        <div class="flex items-center mb-6">
            <a href="{{ route('pembayaran.list') }}" class="text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-xl font-semibold ml-4">Pembayaran</h1>
        </div>

        <div class="periode">
            <h1>Pembayaran Sampah & Keamanan</h1>
            <p class="text-gray-500 text-sm mb-4">deskripsi dummy</p>
            
            <div class="flex justify-between mb-4">
                <span class="text-gray-600">Nominal</span>
                <span class="font-semibold">Rp150.000</span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-600">Terakhir Pembayaran</span>
                <span>12 Agustus 2025</span>
            </div>
        </div>
        <hr class="mt-2">

        <div class="mt-6">
            <div class="flex justify-between items-center mb-2">
                <div>
                    <h2 class="periode-title">Periode</h2>
                    <p class="text-gray-500 text-xs">Anda bisa tambah jumlah periode untuk bayar</p>
                </div>
                <a href="{{ route('pembayaran.periode') }}" class="btn-tambah">
                    <i class="fas fa-plus"></i>
                    Tambah
                </a>
            </div>
            <br>
           
            {{-- <div class="flex items-center justify-between mt-2">
                <span>Agustus</span>
                <button class="btn"><span class="fa fa-trash text-red-500"></span></button>
            </div> --}}
            
            <div class="month-selected">
                <span>Agustus</span>
                <i class="fas fa-trash text-red-500"></i>
            </div>&nbsp;
            <div class="month-selected">
                <span>September</span>
                <i class="fas fa-trash text-red-500"></i>
            </div>
           
        </div>

        <div class="mt-6">
            <hr class="mb-2">
           
            <div class="flex justify-between items-center mb-4">
                <span>Periode</span>
                <span class="font-semibold">Agustus</span>
            </div>
            
        </div>
        <div class="mt-6">
            <div class="flex justify-between items-center mb-4">
                <span>Total Bayar</span>
                <span class="font-semibold">Rp150.000</span>
            </div>
            <button class="btn-lanjutkan">Lanjutkan</button>
        </div>

        <div class="total-section">
           
        </div>
    </div>
</div>


@endsection 