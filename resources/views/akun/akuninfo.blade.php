@extends('layouts.residence.basetemplate')

@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl rounded-lg shadow-lg">
        <!-- Header -->
        <div class="p-6 border-b">
            
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('akun') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Info Akun
            </h1>
            {{-- <p class="text-sm text-gray-500">Informasi akun warga</p> --}}
        </div>
        <!-- Profile Section -->
        <div class="p-6 flex items-center border-b">
            <img 
                alt="User profile picture" 
                class="w-16 h-16 rounded-full border-2 border-gray-300" 
                src="https://via.placeholder.com/150" 
            />
            <div class="ml-4">
                <p class="font-semibold text-lg text-gray-800">
                    {{ $user['username'] }}
                </p>
                <p class="text-gray-500">
                    {{ $user['email'] }}
                </p>
            </div>
        </div>
        <!-- Detail Section -->
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">NIK:</span>
                    <span class="font-medium text-gray-800"> {{ $warga['nik'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Nama Lengkap:</span>
                    <span class="font-medium text-gray-800">{{ $warga['full_name'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">No. Telepon:</span>
                    <span class="font-medium text-gray-800">{{ $warga['phone_no'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Tempat Tinggal:</span>
                    <span class="font-medium text-gray-800">Unit 22, Blok 24</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Status Pengurus:</span>
                    <span class="font-medium text-gray-800">Tidak</span>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="p-6 border-t">
            <button 
                class="w-full bg-green-600 text-white py-2 px-4 rounded-lg">
                Ubah Data
            </button>
        </div>
    </div>
</div>
    
@endsection
