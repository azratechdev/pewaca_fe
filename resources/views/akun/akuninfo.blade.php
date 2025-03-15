@extends('layouts.residence.basetemplate')

@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <img src="{{ $data['residence']['image'] }}" class="bg-img">

        <div style="position: relative;top:-290px">
            <div class="p-6">
                <div class="flex justify-between items-center mt-2">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold text-gray-800">
                            <a href="{{ route('akun') }}" class="text-dark">
                                <i class="fas fa-arrow-left"></i>
                            </a>&nbsp;&nbsp;&nbsp;&nbsp;Info Akun
                        </h1>
                    </div>
                    
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold text-gray-800">
                            <a href="{{ route('akunEdit') }}" class="text-dark" title="Edit Akun">
                                <i class="fas fa-user-edit"></i>
                            </a>
                        </h1>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    @include('layouts.elements.flash')
                    <div class="flex items-center">
                        <span class="text-gray-600"><br>
                            <img 
                            alt="Belum ada" 
                            class="profile-picture rounded w-32 h-32" 
                            src="{{ $data['warga']['profile_photo'] }}"
                        /></span>
                    </div>
                    <br>
                    <div class="flex items-center">
                        <span class="text-gray-600">Nama Perumahan <br>
                        <strong>{{ $data['warga']['unit_id']['unit_residence_name'] }}</strong></span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-600">No Unit <br>
                            <strong>{{ $data['warga']['unit_id']['unit_size'] }}</strong></span>
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
                                <strong>Laki-laki</strong>
                            @else
                                <strong>Perempuan</strong>
                            @endif 
                        </span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-600">Tanggal Lahir <br>
                        <strong>{{ $data['warga']['date_of_birth'] ?? '00-00-0000'}}</strong>
                        </span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-600">Agama <br>
                            <strong>{{ $data['warga']['religion']['name']}}</strong>
                        </span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-600">Status <br>
                            <strong>{{ $data['warga']['marital_status']['name']}}</strong>
                        </span>
                    </div>

                    @if( $data['warga']['marital_status']['id'] != '2')
                        <div class="flex items-center">
                            <span class="text-gray-600">Buku Nikah <br>
                                <img 
                                alt="Belum ada" 
                                class="profile-picture rounded w-32 h-24" 
                                src="https://storage.googleapis.com/a1aa/image/ZoAiGzvASA4pG9oiGwu50UAjrOG21IrMhFOGfFnKGy1xU85JA.jpg"
                            /></span>
                        </div>
                    @endif

                    <div class="flex items-center">
                        <span class="text-gray-600">Pekerjaan <br>
                            <strong>{{ $data['warga']['occupation']['name'] }}</strong>
                        </span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-600">Pendidikan <br>
                            <strong>{{ $data['warga']['education']['name'] }}</strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<style>
    img.bg-img{
        min-width:430px;
        min-height: 100%;
        width:100%;
        height:300px;
        /* object-fit: cover */
    }
</style>