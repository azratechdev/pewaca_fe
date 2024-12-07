@extends('layouts.residence.basetemplate')

@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl rounded-lg shadow-lg">
        <!-- Header -->
        <div class="p-6 border-b">
            
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('infokeluarga') }}" class="text-dark">
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
                    Jhondoe
                </p>
                <p class="text-gray-500">
                    Kepala Keluarga
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

        <div class="p-6 border-t">
            <button 
                class="w-full bg-green-600 text-white py-2 px-4 rounded-lg">
                ADD
            </button>
        </div>
        
    </div>
</div>
    
@endsection
