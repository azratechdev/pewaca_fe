@extends('layouts.residence.basetemplate')
@section('content')

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
                <img alt="Pewaca logo" class="mx-auto mt-4 mb-20" height="120" src="{{ asset('assets/plugins/images/wacalogo.jpeg') }}" width="170"/>
                <div class="mb-10">
                    <img alt="Illustration of a document with a clock" class="mx-auto" height="200" src="{{ asset('assets/plugins/images/verified-wait.jpeg') }}" width="200"/>
                </div>
                <div>
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

<div class="container">
    <div class="container mx-auto">
       <div class="flex justify-between items-center" style="padding-top: 10px;">
            <div class="flex items-center">
                <img alt="Waca Logo" height="120"  width="170" src="{{ asset('assets/plugins/images/wacalogo.jpeg') }}"/>
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
            @foreach($stories as $story)
            <div class="w-full max-w-full bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Header Section -->
                <div class="flex items-center p-4">
                    <img 
                        alt="Profile picture" 
                        class="profile-picture rounded-full" 
                        src="{{ $story['warga']['profile_photo'] }}" 
                    />
                    <div class="ml-4">
                        <div class="text-gray-900 font-bold">
                            {{ $story['warga']['full_name'] }}
                        </div>
                        <div class="text-gray-600 text-sm">
                            {{ Carbon::parse($story['created_on'])->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
        
                <!-- Content Section -->
                <div class="px-4 pb-4 card-content">
                    <p class="text-gray-900 text-justify">
                        <span class="story-preview">
                            {{ Str::limit($story['story'], 40) }}
                        </span>
                        <span class="story-full d-none">
                            {{ $story['story'] }}
                        </span>
                        @if(Str::length($story['story']) > 40)
                            <a href="javascript:void(0)" class="toggle-story text-green-500">selengkapnya</a>
                        @endif
                    </p>
                    <br/>
                    @if(!empty($story['image']))
                        <img alt="Deskripsi gambar di sini" class="fixed-img" src="{{ $story['image'] }}" />
                        <br/>
                    @endif
                    <p class="text-gray-900 d-inline-flex gap-1">
                        <button class="btn btn-sm btn-default" type="button" data-bs-toggle="collapse" data-bs-target="#comment-area" aria-expanded="false" aria-controls="collapseExample">
                          Comment 
                        </button>
                    </p>
                    <div class="collapse" id="comment-area">
                        Comment Here
                    
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle story
    document.querySelectorAll('.toggle-story').forEach(function (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const parent = this.closest('.card-content');
            const preview = parent.querySelector('.story-preview');
            const full = parent.querySelector('.story-full');

            if (preview.classList.contains('d-none')) {
                preview.classList.remove('d-none');
                full.classList.add('d-none');
                this.textContent = 'selengkapnya';
            } else {
                preview.classList.add('d-none');
                full.classList.remove('d-none');
                this.textContent = 'sembunyikan';
            }
        });
    });

});

</script>
@endsection 
@endif