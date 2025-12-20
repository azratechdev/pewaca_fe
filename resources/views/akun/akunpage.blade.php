@extends('layouts.residence.basetemplate')
@section('content')

<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <div class="p-4 border-b">
            <h1 class="text-lg font-semibold">
            Akun
            </h1>
        </div>
        <div class="p-4 flex items-center border-b">
            <img alt="User profile picture" class="w-12 h-12 rounded-full" height="50" src="{{ $warga['profile_photo'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($warga['full_name'])}}" width="50"/>
            <div class="ml-4">
                <p class="font-semibold">
                    {{ $warga['full_name'] }}
                </p>
                {{-- <p class="text-gray-500">
                    {{ $user['email'] }}
                </p> --}}
            </div>
        </div>
        <div>
            @php
                $isPengurus = Session::get('cred.is_pengurus') ?? false;
                $isChecker = Session::get('warga.is_checker') ?? false;
            @endphp

            @if($isPengurus == true)
            <a class="flex items-center p-4 border-b hover:bg-gray-100" href="{{ route('inforekening') }}">
                <i class="fas fa-credit-card text-green-600">
                </i>
                <span class="ml-4">
                    Info Rekening
                </span>
                <i class="fas fa-chevron-right ml-auto text-gray-500">
                </i>
            </a>
            @endif

            <a class="flex items-center p-4 border-b hover:bg-gray-100 @if (!$isPengurus && !$isChecker) cursor-not-allowed text-gray-400 @endif" 
                href="{{ (!$isPengurus && !$isChecker) ? '#' : '/infoakun' }}" 
                style="@if (!$isPengurus && !$isChecker) pointer-events: none; @endif">
                <i class="fas fa-user text-green-600""></i>
                <span class="ml-4">
                    Info Akun
                </span>
                <i class="fas fa-chevron-right ml-auto text-gray-500"></i>
            </a>
        
            {{-- <a class="flex items-center p-4 border-b hover:bg-gray-100 @if (!$isPengurus && !$isChecker) cursor-not-allowed text-gray-400 @endif" 
                href="{{ (!$isPengurus && !$isChecker) ? '#' : '/infokeluarga' }}" 
                style="@if (!$isPengurus && !$isChecker) pointer-events: none; @endif">
                <i class="fas fa-users text-gray-500"></i>
                <span class="ml-4">
                    Keluarga
                </span>
                <i class="fas fa-chevron-right ml-auto text-gray-500"></i>
            </a> --}}

            <a class="flex items-center p-4 border-b hover:bg-gray-100 @if (!$isPengurus && !$isChecker) cursor-not-allowed text-gray-400 @endif" 
                href="{{ (!$isPengurus && !$isChecker) ? '#' : '/faq' }}" 
                style="@if (!$isPengurus && !$isChecker) pointer-events: none; @endif">
                <i class="fas fa-comments text-green-600""></i>
                <span class="ml-4">
                    FAQ
                </span>
                <i class="fas fa-chevron-right ml-auto text-gray-500"></i>
            </a>

            <a class="flex active items-center p-4 border-b hover:bg-gray-100 @if (!$isPengurus && !$isChecker) cursor-not-allowed text-gray-400 @endif" 
                href="{{ (!$isPengurus && !$isChecker) ? '#' : '/policy' }}" 
                style="@if (!$isPengurus && !$isChecker) pointer-events: none; @endif">
                <i class="fas fa-solid fa-gavel text-green-600""></i>
                <span class="ml-4">
                    Kebijakan Privasi
                </span>
                <i class="fas fa-chevron-right ml-auto text-gray-500"></i>
            </a>

            <a class="flex items-center p-4 border-b hover:bg-gray-100 @if (!$isPengurus && !$isChecker) cursor-not-allowed text-gray-400 @endif" 
                href="{{ (!$isPengurus && !$isChecker) ? '#' : '/kontak' }}" 
                style="@if (!$isPengurus && !$isChecker) pointer-events: none; @endif">
                <i class="fas fa-solid fa-headset text-green-600""></i>
                <span class="ml-4">
                    Hubungi Kami
                </span>
                <i class="fas fa-chevron-right ml-auto text-gray-500"></i>
            </a>

            <a class="flex items-center p-4 hover:bg-gray-100" href="{{ route('log_out') }}">
                <i class="fas fa-sign-out-alt text-green-600">
                </i>
                <span class="ml-4">
                    Logout
                </span>
                <i class="fas fa-chevron-right ml-auto text-gray-500">
                </i>
            </a>
        </div>
    </div>
</div>

  
  
@endsection 