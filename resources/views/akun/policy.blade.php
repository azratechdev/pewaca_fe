@extends('layouts.residence.basetemplate')

@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('akun') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Kebijakan Privasi
            </h1>
        </div>

        <!-- Content Section -->
        <div class="p-6 text-gray-800 text-sm space-y-6">
            <!-- Intro -->
            <p>
                <strong>Kebijakan Privasi</strong><br>
                Aplikasi Pewaca menghormati dan melindungi privasi setiap pengguna. Kebijakan privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi pengguna.
            </p>

            <!-- Point 1 -->
            <div class="grid grid-cols-[1.5rem_auto] gap-x-2">
                <span>1.</span>
                <div>
                    <strong>Informasi yang Kami Kumpulkan</strong><br>
                    Saat menggunakan aplikasi, kami dapat mengumpulkan informasi pribadi berikut:
                    <ul class="list-disc pl-5 mt-2">
                        <li>Nama lengkap</li>
                        <li>NIK (Nomor Induk Kependudukan)</li>
                        <li>Nomor telepon</li>
                        <li>Alamat email</li>
                        <li>Jenis kelamin, agama, status pernikahan, pekerjaan, pendidikan</li>
                        <li>Foto profil</li>
                        <li>Foto atau dokumen pendukung (misalnya buku nikah)</li>
                        <li>Aktivitas dalam aplikasi (seperti postingan atau bukti transfer)</li>
                        <li>Data login dan verifikasi (termasuk email verifikasi)</li>
                        <li>Persetujuan pendaftaran oleh admin</li>
                    </ul>
                </div>
            </div>

            <!-- Point 2 -->
            <div class="grid grid-cols-[1.5rem_auto] gap-x-2">
                <span>2.</span>
                <div>
                    <strong>Cara Kami Menggunakan Informasi</strong><br>
                    Informasi yang dikumpulkan digunakan untuk:
                    <ul class="list-disc pl-5 mt-2">
                        <li>Verifikasi dan validasi data pengguna</li>
                        <li>Proses registrasi dan manajemen akun</li>
                        <li>Menyediakan fitur utama aplikasi, seperti posting konten atau unggah bukti transfer</li>
                        <li>Meningkatkan kualitas dan keamanan layanan</li>
                        <li>Melakukan verifikasi email dan persetujuan akun oleh admin</li>
                    </ul>
                </div>
            </div>

            <!-- Point 3 -->
            <div class="grid grid-cols-[1.5rem_auto] gap-x-2">
                <span>3.</span>
                <div>
                    <strong>Pengungkapan Informasi</strong><br>
                    Kami tidak akan membagikan informasi pribadi Anda kepada pihak ketiga tanpa persetujuan Anda, kecuali diwajibkan oleh hukum atau otoritas resmi.
                </div>
            </div>

            <!-- Point 4 -->
            <div class="grid grid-cols-[1.5rem_auto] gap-x-2">
                <span>4.</span>
                <div>
                    <strong>Keamanan Data</strong><br>
                    Kami menerapkan langkah-langkah teknis dan administratif yang wajar untuk melindungi informasi pribadi Anda dari akses tidak sah, perubahan, pengungkapan, atau penghapusan.
                </div>
            </div>

            <!-- Point 5 -->
            <div class="grid grid-cols-[1.5rem_auto] gap-x-2">
                <span>5.</span>
                <div>
                    <strong>Konten Buatan Pengguna</strong><br>
                    Pengguna bertanggung jawab atas konten yang mereka unggah ke aplikasi. Kami berhak menghapus konten yang melanggar syarat dan ketentuan yang berlaku.
                </div>
            </div>

            <!-- Point 6 -->
            <div class="grid grid-cols-[1.5rem_auto] gap-x-2">
                <span>6.</span>
                <div>
                    <strong>Hak Pengguna</strong><br>
                    Pengguna dapat meminta penghapusan akun dan data pribadi mereka dengan menghubungi admin atau pengurus perumahan.
                </div>
            </div>

            <!-- Point 7 -->
            <div class="grid grid-cols-[1.5rem_auto] gap-x-2">
                <span>7.</span>
                <div>
                    <strong>Perubahan Kebijakan Privasi</strong><br>
                    Kami dapat memperbarui kebijakan ini dari waktu ke waktu. Setiap perubahan akan diinformasikan melalui aplikasi.
                </div>
            </div>

            <!-- Point 8 -->
            <div class="grid grid-cols-[1.5rem_auto] gap-x-2">
                <span>8.</span>
                <div>
                    <strong>Kontak</strong><br>
                    Jika Anda memiliki pertanyaan mengenai kebijakan privasi ini, silakan hubungi kami di <a href="mailto:cs@pewaca.id" class="text-green-600 underline">cs@pewaca.id</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
