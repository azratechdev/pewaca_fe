{{-- resources/views/components/biaya-menu.blade.php --}}
<div class="flex items-left w-full max-w-full pb-2">
  <!-- Desktop: tampilkan semua menu sebaris, tanpa scroll -->
  <div class="hidden md:flex space-x-3 px-2">
    <a href="{{ route('pengurus.biaya.konfirmasi') }}" 
       class="btn btn-default whitespace-nowrap px-4 py-2 rounded {{ request()->routeIs('pengurus.biaya.konfirmasi') ? 'text-green-500 font-bold' : '' }}">
      Menunggu Konfirmasi
    </a>
    <a href="{{ route('pengurus.biaya.list') }}" 
       class="btn btn-default whitespace-nowrap px-4 py-2 rounded {{ request()->routeIs('pengurus.biaya.list') ? 'text-green-500 font-bold' : '' }}">
      Daftar Biaya
    </a> 
    <a href="{{ route('pengurus.biaya.disetujui') }}" 
       class="btn btn-default whitespace-nowrap px-4 py-2 rounded {{ request()->routeIs('pengurus.biaya.disetujui') ? 'text-green-500 font-bold' : '' }}">
      Disetujui
    </a>
    <a href="{{ route('pengurus.biaya.tunggakan') }}" 
       class="btn btn-default whitespace-nowrap px-4 py-2 rounded {{ request()->routeIs('pengurus.biaya.tunggakan') ? 'text-green-500 font-bold' : '' }}">
      Tunggakan
    </a>
    {{-- <a href="#" 
       class="btn btn-default whitespace-nowrap px-4 py-2 rounded text-green-500 font-bold">
      Pengeluaran
    </a> --}}
  </div>

  <!-- Mobile: scrollable horizontal -->
  <div class="md:hidden overflow-x-auto hide-scrollbar px-2">
    <div class="flex items-left w-full max-w-full">
      <a href="{{ route('pengurus.biaya.konfirmasi') }}" 
         class="btn btn-default whitespace-nowrap px-3 py-2 rounded {{ request()->routeIs('pengurus.biaya.konfirmasi') ? 'text-green-500 font-bold' : '' }}">
        Menunggu Konfirmasi
      </a>
      <a href="{{ route('pengurus.biaya.list') }}" 
         class="btn btn-default whitespace-nowrap px-3 py-2 rounded {{ request()->routeIs('pengurus.biaya.list') ? 'text-green-500 font-bold' : '' }}">
        Daftar Biaya
      </a> 
      <a href="{{ route('pengurus.biaya.disetujui') }}" 
         class="btn btn-default whitespace-nowrap px-3 py-2 rounded {{ request()->routeIs('pengurus.biaya.disetujui') ? 'text-green-500 font-bold' : '' }}">
        Disetujui
      </a>
      <a href="{{ route('pengurus.biaya.tunggakan') }}" 
         class="btn btn-default whitespace-nowrap px-3 py-2 rounded {{ request()->routeIs('pengurus.biaya.tunggakan') ? 'text-green-500 font-bold' : '' }}">
        Tunggakan
      </a>
      {{-- <a href="#" 
        class="btn btn-default whitespace-nowrap px-3 py-2 rounded text-green-500 font-bold">
        Pengeluaran
      </a> --}}
    </div>
  </div>
</div>

{{-- Opsional: sembunyikan scrollbar --}}
<style>
  .hide-scrollbar::-webkit-scrollbar {
    display: none;
  }
  .hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
</style>