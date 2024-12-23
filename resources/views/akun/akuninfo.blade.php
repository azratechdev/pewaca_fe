@extends('layouts.residence.basetemplate')

@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('akun') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Info Akun
            </h1>
            {{-- <br>
            <div class="flex justify-between items-center mt-2">
                <div class="flex items-center">
                    <p class="text-warning d-flex align-items-center">
                       <i class="far fa-clock"></i>&nbsp; Waiting Approval
                    </p>
                </div>
                
                <div class="flex items-center">
                    <p class="text-dark d-flex align-items-center">
                        <i class="far fa-calendar"></i>&nbsp; 12 Agustus 2024
                    </p>
                </div>
            </div> --}}
        </div>
        
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center">
                    <span class="text-gray-600">Photo Profile <br>
                        <img 
                        alt="Belum ada" 
                        class="profile-picture rounded w-32 h-32" 
                        src="https://storage.googleapis.com/a1aa/image/ZoAiGzvASA4pG9oiGwu50UAjrOG21IrMhFOGfFnKGy1xU85JA.jpg"
                    /></span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Nama Perumahan <br>
                       <strong>{{ $data['residence']['name'] }}</strong></span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">No Unit <br>
                        <strong>{{ $data['residence']['name'] }}</strong></span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">NIK <br>
                        <strong>{{ $data['warga']['nik'] }}</strong>
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Nama Lengkap <br>
                        <strong>{{ $data['warga']['full_name'] }}</strong>
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Email <br>
                        <strong>{{ $data['user']['email'] }}</strong>
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">No Ponsel <br>
                        <strong>{{ $data['warga']['phone_no'] }}</strong>
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Jenis Kelamin <br>
                       @if($data['warga']['gender_id'] == 1)
                        Laki-laki
                       @else
                        Perempuan
                       @endif 
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Tanggal Lahir <br>
                       <strong>{{ $data['warga']['date_of_birth'] }}</strong>
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Agama <br>
                        <strong>{{ $data['warga']['religion']}}</strong>
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Status <br>
                        <strong>{{ $data['warga']['marital_status']}}</strong> <p class="text-green-500">Lihat Buku Nikah</p>
                    </span>
                </div>
                {{-- <div class="flex items-center">
                    <span class="text-gray-600">Buku Nikah <br>
                        <img 
                        alt="Belum ada" 
                        class="profile-picture rounded w-32 h-24" 
                        src="https://storage.googleapis.com/a1aa/image/ZoAiGzvASA4pG9oiGwu50UAjrOG21IrMhFOGfFnKGy1xU85JA.jpg"
                    /></span>
                </div> --}}
                <div class="flex items-center">
                    <span class="text-gray-600">Pekerjaan <br>
                        <strong>{{ $data['warga']['occupation'] }}</strong>
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Pendidikan <br>
                        <strong>{{ $data['warga']['education'] }}</strong>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
