@extends('layouts.residence.basetemplate')
@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('pengurus') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Biaya
            </h1>
        </div>

        <div class="flex items-left w-full max-w-full">
            <div class="pb-2">
                <div class="flex items-lefts" style="padding-bottom: 10px;">
                    <div class="flex items-left">
                        <a href="javascript:void(0)" class="btn btn-default toggle-tagihan">Daftar Biaya</a> 
                        <a href="javascript:void(0)" class="btn btn-default toggle-approval">Menunggu Konfirmasi</a>
                        <a href="javascript:void(0)" class="btn btn-default toggle-approved">Disetujui</a>
                        <a href="javascript:void(0)" class="btn btn-default toggle-tunggakan">Tunggakan</a>
                    </div>
                </div>
            </div>   
        </div>  

        <div class="col-md-12 col-sm-12 tagihan-list" style="display:block;padding-left:10px;padding-right:10px;">
            @include('pengurus.tagihan.list')
        </div>
        <div class="col-md-12 col-sm-12 tagihan-approval" style="display:none;padding-left:10px;padding-right:10px;">
            @include('pengurus.tagihan.approval')
        </div>
        <div class="col-md-12 col-sm-12 tagihan-approved" style="display:none;padding-left:10px;padding-right:10px;">
            @include('pengurus.tagihan.approved')
        </div>
        <div class="col-md-12 col-sm-12 tagihan-tunggakan" style="display:none;padding-left:10px;padding-right:10px;">
            @include('pengurus.tagihan.tunggakan')
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".toggle-tagihan").click(function () {
            $(".tagihan-list").show();
            $(".tagihan-approval, .tagihan-approved, .tagihan-tunggakan").hide();
            updateActiveButton($(this));
        });
    
        $(".toggle-approval").click(function () {
            $(".tagihan-approval").show();
            $(".tagihan-list, .tagihan-approved, .tagihan-tunggakan").hide();
            updateActiveButton($(this));
        });
    
        $(".toggle-approved").click(function () {
            $(".tagihan-approved").show();
            $(".tagihan-list, .tagihan-approval, .tagihan-tunggakan").hide();
            updateActiveButton($(this));
        });
    
        $(".toggle-tunggakan").click(function () {
            $(".tagihan-tunggakan").show();
            $(".tagihan-list, .tagihan-approval, .tagihan-approved").hide();
            updateActiveButton($(this));
        });
    
        function updateActiveButton(activeButton) {
            $(".btn").css("color", ""); // Reset warna teks semua tombol
            activeButton.css("color", "green"); // Ubah warna teks tombol aktif menjadi hijau
        }
    });
    </script>
    
@endsection