@extends('layouts.residence.basetemplate')
@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('akun') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Keluarga
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
                    {{ $warga['full_name'] }}
                </p>
                <p class="text-gray-500">
                    {{ $warga['family_as']['name'] }}
                </p>
            </div>
        </div>

        <div class="p-6 flex items-center border-b">
            <img 
                alt="User profile picture" 
                class="w-16 h-16 rounded-full border-2 border-gray-300" 
                src="https://via.placeholder.com/150" 
            />
            <div class="ml-4">
                <p class="font-semibold text-lg text-gray-800">
                    Ana
                </p>
                <p class="text-gray-500">
                    Istri
                </p>
            </div>
        </div>

        <div class="p-6 flex items-center border-b">
            <img 
                alt="User profile picture" 
                class="w-16 h-16 rounded-full border-2 border-gray-300" 
                src="https://via.placeholder.com/150" 
            />
            <div class="ml-4">
                <p class="font-semibold text-lg text-gray-800">
                    Boni
                </p>
                <p class="text-gray-500">
                    Anak
                </p>
            </div>
        </div>

        <div class="p-0 mt-2">
            <a href="{{ route('addkeluarga') }}" 
                class="btn btn-success w-full bg-green-600 text-white py-2 px-4 rounded-lg">
                ADD
            </a>
        </div>
        
    </div>
</div>
    
@endsection
