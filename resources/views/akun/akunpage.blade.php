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
                <i class="fas fa-chevron-right ml-auto text-gray-500"></i>
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

            @if($isPengurus == true)
            <a class="flex items-center p-4 border-b hover:bg-gray-100">
                <i class="fas fa-sync text-green-600"></i>
                 <div id="roleText" class="ml-4">
                    <div class="font-medium">Anda Sebagai Warga</div>
                    <div class="text-xs text-gray-500 mt-1">Aktifkan untuk ganti ke Pengurus</div>
                </div>

                <!-- Toggle switch -->
                <label class="relative inline-flex items-center ml-auto cursor-pointer">
                    <input type="checkbox" id="roleToggleSwitch" class="sr-only peer" />
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-green-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                </label>
              
            </a>
            @endif

            <a class="flex items-center p-4 hover:bg-gray-100" href="{{ route('log_out') }}">
                <i class="fas fa-sign-out-alt text-green-600">
                </i>
                <span class="ml-4">
                    Logout
                </span>
                <i class="fas fa-chevron-right ml-auto text-gray-500"></i>
            </a>
        </div>
    </div>
</div>
<script>
  const toggle = document.getElementById('roleToggleSwitch');
  const roleText = document.getElementById('roleText');

  // Data pengguna dari controller (disisipkan via Blade)
  const userData = {
    user_id: {{ $user['user_id'] }},
    residence_commites: {{ Js::from($user['residence_commites']) }}
   
  };

  // Ekstrak data yang diperlukan
  const residence_id = userData.residence_commites[0]?.residence;
  const role_id = userData.residence_commites[0]?.role?.id;
  const token = userData.token;

  // Validasi data penting
  if (!residence_id || !role_id) {
    console.error('Data residence atau role tidak lengkap.');
  }

  // Fungsi perbarui teks UI
  function updateRoleText() {
    if (toggle.checked) {
      roleText.innerHTML = `
        <div>Anda Sebagai Pengurus</div>
        <div class="text-xs text-gray-500 mt-1">Nonaktifkan untuk ganti ke Warga</div>
      `;
    } else {
      roleText.innerHTML = `
        <div>Anda Sebagai Warga</div>
        <div class="text-xs text-gray-500 mt-1">Aktifkan untuk ganti ke Pengurus</div>
      `;
    }
  }

  // Fungsi kirim ke backend
  async function sendRoleChange() {
    const is_change = toggle.checked; // true = pengurus, false = warga

    const payload = {
      user_id: userData.user_id,
      residence_id: residence_id,
      role_id: role_id,
      is_change: is_change
    };

    try {
      const response = await fetch('/api/ganti-peran', {
        method: 'POST',
        headers: {
           "Accept": "application/json",
            "Authorization": "Token {{ Session::get('token') }}",
            "Content-Type": "application/json",
            "X-CSRFToken": "ehbPFxLcdp440i5BmhZAq8c1wRQZuJVIzR2CrWBrwS2CgMFuD0wRdd0Ifor2VLZB"
        },
        body: JSON.stringify(payload)
      });

      const result = await response.json();

      if (!response.ok) {
        throw new Error(result.message || 'Gagal mengubah peran');
      }

      // Opsional: tampilkan notifikasi sukses
      console.log('Peran berhasil diubah:', result);
    } catch (error) {
      console.error('Error saat mengubah peran:', error);
      // Opsional: tampilkan pesan error ke pengguna
      alert('Gagal mengubah peran. Silakan coba lagi.');
      
      // Kembalikan toggle ke posisi sebelumnya jika gagal
      toggle.checked = !is_pengurus;
      updateRoleText();
    }
  }

  // Inisialisasi awal
  toggle.checked = {{ $user['is_pengurus'] ? 'true' : 'false' }};
  updateRoleText();

  // Event listener
  toggle.addEventListener('change', function () {
    updateRoleText();
    sendRoleChange();
  });
</script>
  
  
@endsection 