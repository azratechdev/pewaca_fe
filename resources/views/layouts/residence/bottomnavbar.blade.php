
{{-- <div class="navbar navbar-custom navbar-dark navbar-expand fixed-bottom"> --}}
  @php
    $isPengurus = Session::get('cred.is_pengurus') ?? false;
    $isChecker = Session::get('warga.is_checker') ?? false;
    $isSeller = auth()->check() && auth()->user()->is_seller;
  @endphp
<div class="navbar navbar-custom navbar-dark navbar-expand fixed-bottom bg-white" style="padding: 0px;">
  <div class="container-fluid" style="padding-left: 0px;padding-right: 0px;height: 75px;">
    <ul class="navbar-nav nav-justified w-100">

      <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link text-center {{ Request::is('home') ? 'active' : '' }}">
          <i class="fa fa-home menu-icon"></i>
          <span class="small d-block menu-text">Home</span>
        </a>
      </li>

      {{-- @if(Session::has('cred') && collect(Session::get('cred')['residence_commites'])->contains(function ($commite) {
        return isset($commite['role']['id']) && $commite['role']['id'] === 1;
        })) --}}
      @if(Session::has('cred') && collect(Session::get('cred')['residence_commites'])->contains(function ($commite) {
          return isset($commite['role']['id']);
        }))
        <li class="nav-item">
            <a href="{{ route('pengurus') }}" class="nav-link text-center {{ Request::is('pengurus') ? 'active' : '' }}">
                <i class="fa fa-id-card menu-icon"></i>
                <span class="small d-block menu-text">Pengurus</span>
            </a>
        </li>
      @endif

      @if($isSeller)
        <li class="nav-item">
            <a href="{{ route('pengurus.seller.dashboard') }}" class="nav-link text-center {{ Request::is('pengurus/seller*') ? 'active' : '' }}">
                <i class="fa fa-shopping-bag menu-icon"></i>
                <span class="small d-block menu-text">Seller</span>
            </a>
        </li>
      @elseif(auth()->check())
        <li class="nav-item">
            <a href="{{ route('pengurus.seller.register') }}" class="nav-link text-center {{ Request::is('pengurus/seller/register*') ? 'active' : '' }}">
                <i class="fa fa-store-alt menu-icon"></i>
                <span class="small d-block menu-text">Daftar Seller</span>
            </a>
        </li>
      @endif

      <li class="nav-item">
        <a href="{{ route('warungku.index') }}" class="nav-link text-center {{ Request::is('warungku*') ? 'active' : '' }}">
          <i class="fa fa-store menu-icon"></i>
          <span class="small d-block menu-text">Warungku</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('pembayaran.list') }}" class="nav-link text-center {{ request()->routeIs(['pembayaran.list', 'pembayaran.history', 'postingan']) ? 'active' : '' }}" @if (!$isPengurus && !$isChecker) cursor-not-allowed text-gray-400 @endif" 
        style="@if (!$isPengurus && !$isChecker) pointer-events: none; @endif">
          <i class="fa fa-receipt menu-icon"></i> <!-- Ikon Purchase Order -->
          <span class="small d-block menu-text">Cashout</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('akun') }}" class="nav-link text-center {{ Request::is('akun') ? 'active' : '' }}">
          <i class="fa fa-user menu-icon"></i> <!-- Ikon Purchase Order -->
          <span class="small d-block menu-text">Akun</span>
        </a>
      </li>
    </ul>
  </div>
</div>

{{-- <div class="fixed-bottom bg-white py-2 border-t border-gray-200">
  <div class="flex justify-center items-center py-2">
      <i class="fas fa-lock text-gray-500"></i>
      <span class="ml-2 text-gray-700">lingka.id</span>
  </div>
  <div class="flex justify-center">
      <div class="w-25 h-1 bg-black rounded-full"></div>
  </div>
</div> --}}