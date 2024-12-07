
{{-- <div class="navbar navbar-custom navbar-dark navbar-expand fixed-bottom"> --}}
  @php
    $isPengurus = Session::get('cred.is_pengurus') ?? false;
    $isChecker = Session::get('warga.is_checker') ?? false;
  @endphp
  <div class="navbar navbar-custom navbar-dark navbar-expand fixed-bottom bg-white">
  <div class="container-fluid">
    <ul class="navbar-nav nav-justified w-100">

      <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link text-center {{ Request::is('home') ? 'active' : '' }}">
          <i class="fa fa-home fa-3x"></i>
          <span class="small d-block">Home</span>
        </a>
      </li>

      @if(Session::has('cred') && collect(Session::get('cred')['residence_commites'])->contains(function ($commite) {
        return isset($commite['role']['id']) && $commite['role']['id'] === 1;
        }))
        <li class="nav-item">
            <a href="{{ route('pengurus') }}" class="nav-link text-center">
                <i class="fa fa-id-card fa-2x"></i>
                <span class="small d-block">Pengurus</span>
            </a>
        </li>
      @endif

      <li class="nav-item">
        <a href="{{ route('pembayaran') }}" class="nav-link text-center" @if (!$isPengurus && !$isChecker) cursor-not-allowed text-gray-400 @endif" 
        style="@if (!$isPengurus && !$isChecker) pointer-events: none; @endif">
          <i class="fa fa-receipt fa-2x"></i> <!-- Ikon Purchase Order -->
          <span class="small d-block">Cashout</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('akun') }}" class="nav-link text-center">
          <i class="fa fa-user fa-2x"></i> <!-- Ikon Purchase Order -->
          <span class="small d-block">Akun</span>
        </a>
      </li>

    </ul>
  </div>
</div>

<div class="fixed-bottom bg-white py-2 border-t border-gray-200">
  <div class="flex justify-center items-center py-2">
      <i class="fas fa-lock text-gray-500"></i>
      <span class="ml-2 text-gray-700">lingka.id</span>
  </div>
  <div class="flex justify-center">
      <div class="w-25 h-1 bg-black rounded-full"></div>
  </div>
</div>