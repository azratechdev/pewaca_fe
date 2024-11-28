@extends('layouts.residence.basetemplate')
@section('content')

<div class="container">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center" style="padding-top: 10px;">
            <div class="flex items-center">
                <img alt="Waca Logo" height="120"  width="170" src="{{ asset('assets/plugins/images/wacalogo.jpg') }}"/>
            </div>
            <a href="{{ route('addpost') }}">
                <div class="flex items-center">
                    <span class="text-xl text-black mr-2">
                    Posting
                    </span>
                    <div class="flex items-center justify-center w-5 h-5 border border-black square-full">
                        <i class="fas fa-plus text-black"></i>
                    </div>
                </div>
            </a>
        </div>
        <br>
        @include('layouts.elements.flash')
        <div class="flex items-center justify-left bg-red-50 p-4 rounded-lg shadow-md w-full max-w-full mt-3">
            <div class="flex items-left">
                <i class="fas fa-receipt text-red-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-red-500 font-semibold">Tagihan sudah melewati jatuh tempo</p>
                    <p class="text-red-500">Segera lakukan pembayaran</p>
                </div>
            </div>
            <div class="ml-auto">
                <i class="fas fa-chevron-circle-right text-red-500 text-xl"></i>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-3">
            @for ($i = 0; $i < 12; $i++)
            <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="flex items-center p-4">
                    <img alt="Profile picture" class="w-12 h-12 rounded-full" height="161" src="https://storage.googleapis.com/a1aa/image/ZoAiGzvASA4pG9oiGwu50UAjrOG21IrMhFOGfFnKGy1xU85JA.jpg" width="161"/>
                    <div class="ml-4">
                        <div class="text-gray-900 font-bold">
                            Jhondoe
                        </div>
                        <div class="text-gray-600 text-sm">
                            12 Sep 2024 18:00
                        </div>
                    </div>
                    <div class="ml-auto text-green-500">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                </div>
                <div class="px-4 pb-4">
                    <h5 class="text-gray-900 font-bold">
                        Judul Postingan 1
                    </h5>
                    <br/>
                    <img alt="Deskripsi gambar di sini" class="w-full" height="300" src="https://storage.googleapis.com/a1aa/image/H57fey20D7hosUpCSOhc7cF23nePfIDDnB1EfPEiU8YiMFf8E.jpg" width="500"/>
                    <br/>
                    <br/>
                    <p class="text-gray-900">
                        Deskripsi postingan di sini
                    </p>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>
  
@endsection 

