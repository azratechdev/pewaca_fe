@extends('layouts.residence.basetemplate')

@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('akun') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;FAQ - Pertanyaan yang Sering Diajukan
            </h1>
        </div>

        <!-- Content Section -->
        <div class="p-6 text-gray-800 text-sm space-y-6">
            <!-- FAQ 1 -->
            <div class="grid grid-cols-[1.5rem_auto] gap-x-2">
                <span>1.</span>
                <div>
                    <strong>Apa itu aplikasi Pewaca?</strong><br>
                    Pewaca adalah aplikasi yang dikembangkan untuk mempermudah komunikasi, pengelolaan data warga, dan berbagai keperluan administratif dalam lingkungan perumahan.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="grid grid-cols-[1.5rem_auto] gap-x-2">
                <span>2.</span>
                <div>
                    <strong>Bagaimana cara mendaftar di aplikasi Pewaca?</strong><br>
                    Anda dapat mendaftar melalui fitur registrasi dengan mengisi data pribadi yang diperlukan dan menunggu persetujuan dari admin.
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="grid grid-cols-[1.5rem_auto] gap-x-2">
                <span>3.</span>
                <div>
                    <strong>Apakah data saya aman di Pewaca?</strong><br>
                    Ya, kami melindungi data Anda dengan standar keamanan dan hanya digunakan untuk keperluan internal pengelolaan perumahan.
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="grid grid-cols-[1.5rem_auto] gap-x-2">
                <span>4.</span>
                <div>
                    <strong>Bagaimana cara menghapus akun?</strong><br>
                    Anda dapat menghubungi admin atau pengurus perumahan untuk mengajukan permintaan penghapusan akun.
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="grid grid-cols-[1.5rem_auto] gap-x-2">
                <span>5.</span>
                <div>
                    <strong>Apa yang harus dilakukan jika lupa password?</strong><br>
                    Gunakan fitur "Lupa Password" di halaman login dan ikuti petunjuk untuk mengatur ulang kata sandi Anda.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
