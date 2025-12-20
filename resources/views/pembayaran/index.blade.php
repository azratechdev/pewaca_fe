@extends('layouts.residence.basetemplate')
@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                Transaksi
            </h1>
        </div>
        
        <div class="flex items-left w-full max-w-full">
            <div class="pb-2">
                <div class="flex items-lefts" style="padding-bottom: 10px;">
                    <div class="flex items-left">
                        <a href="javascript:void(0)" class="btn btn-default toggle-pembayaran">Pembayaran</a> 
                        <a href="javascript:void(0)" class="btn btn-default toggle-riwayat">Riwayat</a>
                        {{-- <a href="javascript:void(0)" class="btn btn-default toggle-postingan">Postingan</a> --}}
                    </div>
                </div>
            </div>   
        </div>  

        <div class="col-md-12 col-sm-12 pembayaran-list" style="display:block;padding-left:15px;padding-right:15px;">
            @include('pembayaran.list')
        </div>
        <div class="col-md-12 col-sm-12 pembayaran-riwayat" style="display:none;padding-left:15px;padding-right:15px;">
            @include('pembayaran.history')
        </div>
        <div class="col-md-12 col-sm-12 postingan-riwayat" style="display:none;padding-left:15px;padding-right:15px;">
            postingan list
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".toggle-pembayaran").click(function () {
            $(".pembayaran-list").show();
            $(".pembayaran-riwayat, .postingan-riwayat").hide();
            updateActiveButton($(this));
        });
    
        $(".toggle-riwayat").click(function () {
            $(".pembayaran-riwayat").show();
            $(".pembayaran-list, .postingan-riwayat").hide();
            updateActiveButton($(this));
        });
    
        $(".toggle-postingan").click(function () {
            $(".postingan-riwayat").show();
            $(".pembayaran-list, .pembayaran-riwayat").hide();
            updateActiveButton($(this));
        });
    
        function updateActiveButton(activeButton) {
            $(".btn").css("color", ""); // Reset warna teks semua tombol
            activeButton.css("color", "green"); // Ubah warna teks tombol aktif menjadi hijau
        }
    });
    </script>
    
    
  
@endsection 