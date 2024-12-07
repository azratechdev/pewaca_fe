@php
use Carbon\Carbon;
$isPengurus = $user['is_pengurus'] ?? false;
$isChecker = $warga['is_checker'] ?? false;
@endphp
@if (!$isPengurus && !$isChecker)
<div class="container">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-center">
            <div class="max-w-sm w-full text-center">
                <img alt="Pewaca logo" class="mx-auto mt-4 mb-36" height="120" src="{{ asset('assets/plugins/images/wacalogo.jpg') }}" width="170"/>
                <div class="mb-10">
                    <img alt="Illustration of a document with a clock" class="mx-auto" height="200" src="{{ asset('assets/plugins/images/verified-wait.jpeg') }}" width="200"/>
                </div>
                <div class="mb-10">
                    <h1 class="text-xl font-semibold mb-2">
                    Pendaftaran menunggu di verifikasi pengurus
                    </h1>
                    <p class="text-gray-600">
                    Mohon menunggu untuk proses verifikasi oleh pengurus
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@else

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
            @foreach($stories as $story)
            <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="flex items-center p-4">
                    <img alt="Profile picture" class="w-12 h-12 rounded-full" height="161" src="{{ $story['image'] }}" width="161"/>
                    <div class="ml-4">
                        <div class="text-gray-900 font-bold">
                            {{ $story['created_by'] }}
                        </div>
                        <div class="text-gray-600 text-sm">
                            {{ Carbon::parse($story['created_on'])->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
                <div class="px-4 pb-4">
                    <h5 class="text-gray-900 font-bold">
                        Title Here
                    </h5>
                    <br/>
                    <img alt="Deskripsi gambar di sini" class="fixed-img" src="{{ $story['image'] }}"/>
                    <br/>
                    <br/>
                    <p class="text-gray-900">
                        {{ Str::length($story['story']) > 50 ? Str::limit($story['story'], 50) : $story['story'] }}
                    </p>
                    <br/>
                    <p class="text-gray-900">
                        Comments 0 Like {{ $story['total_like'] }}
                    </p>
                </div>
            </div>
            @endforeach
          
        </div>
    </div>
</div>

@endsection 

@endif