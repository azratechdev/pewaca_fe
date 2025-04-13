@extends('layouts.residence.basetemplate')
@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('akun') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Kontak
            </h1>
            {{-- <p class="text-sm text-gray-500">Informasi akun warga</p> --}}
        </div>
        <!-- Profile Section -->
        <div class="p-6 flex items-center border-b">
            <div class="ml-4">
                <p class="font-semibold text-lg text-gray-800">
                    Email : cs@pewaca.id
                </p>
            </div>
        </div>

        <div class="p-6 flex items-center border-b">
            <div class="ml-4">
                <p class="font-semibold text-lg text-gray-800">
                    Telephone : +62 858-9263-9062
                </p>
                {{-- <p class="text-gray-500">
                    +62823456798
                </p> --}}
            </div>
        </div>
    </div>
</div>
    
@endsection
