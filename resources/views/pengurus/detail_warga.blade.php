@extends('layouts.residence.basetemplate')

@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('pengurus') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Info Warga
            </h1>
            <br>
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
            </div>
        </div>
        
        <div class="card card-body p-6">
            <div class="space-y-4">
                <div class="flex items-center">
                    <span class="text-gray-600">Photo Profile <br>
                        <img 
                        alt="Belum ada" 
                        class="profile-picture rounded w-32 h-24" 
                        src="https://storage.googleapis.com/a1aa/image/ZoAiGzvASA4pG9oiGwu50UAjrOG21IrMhFOGfFnKGy1xU85JA.jpg"
                    /></span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">No Unit <br>
                       belum ada</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">NIK <br>
                        {{ $warga['nik'] }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Jenis Kelamin <br>
                        {{ $warga['gender'] }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Tanggal Lahir <br>
                       belum ada</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Agama <br>
                        {{ $warga['religion']['name'] }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Tempat Lahir <br>
                       belum ada</span>
                </div>
                <hr>
                <div class="flex items-center">
                    <span class="text-gray-600">Status <br>
                        {{ $warga['marital_status']['name'] }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Buku Nikah <br>
                        <img 
                        alt="Belum ada" 
                        class="profile-picture rounded w-32 h-24" 
                        src="https://storage.googleapis.com/a1aa/image/ZoAiGzvASA4pG9oiGwu50UAjrOG21IrMhFOGfFnKGy1xU85JA.jpg"
                    /></span>
                </div>
                <hr>
                <div class="flex items-center">
                    <span class="text-gray-600">Pekerjaan <br>
                        Belum Ada</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Pendidikan <br>
                        Belum Ada</span>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="flex justify-content-between" style="padding:10px;">
            <a href="{{ route('reject_warga', ['id' => $warga['id']]) }}" class="btn btn-danger w-40 me-2">Reject</a>
            <button class="btn btn-success w-60">Approve</button>
        </div>
    </div>
</div>
    
@endsection
