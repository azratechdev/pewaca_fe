
{{-- <div class="navbar navbar-custom navbar-dark navbar-expand fixed-bottom"> --}}
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
            <a href="{{ route('pengurus') }}" class="nav-link text-center {{ Request::is('pengurus') ? 'active' : '' }}">
                <i class="fa fa-id-card fa-2x"></i>
                <span class="small d-block">Pengurus</span>
            </a>
        </li>
      @endif
      <li class="nav-item">
        <a href="{{ route('pembayaran') }}" class="nav-link text-center {{ Request::is('pembayaran') ? 'active' : '' }}">
          <i class="fa fa-receipt fa-2x"></i> <!-- Ikon Purchase Order -->
          <span class="small d-block">Cashout</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('akun') }}" class="nav-link text-center {{ Request::is('akun') ? 'active' : '' }}">
          <i class="fa fa-user fa-2x"></i> <!-- Ikon Purchase Order -->
          <span class="small d-block">Akun</span>
        </a>
      </li>

      {{-- <li class="nav-item dropup">
        <a href="#" 
          class="nav-link text-center {{ Request::is('akun') || Request::is('edit') || Request::is('registrasi') ? 'active' : '' }}" 
          role="button" 
          id="dropdownMenuProfile" 
          data-bs-toggle="dropdown" 
          aria-expanded="false">
            <i class="fa fa-user fa-2x"></i>
            <span class="small d-block">Akun</span>
        </a>
        
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuProfile">
          <li>
              <a class="dropdown-item" href="{{ route('akun') }}">Profile</a>
          </li>
          <li>
              <a class="dropdown-item" href="{{ route('edit') }}">Edit Profile</a>
          </li>
          <li>
              <a class="dropdown-item" href="{{ route('registrasi') }}">Registrasi</a>
          </li>
          <li>
              <hr class="dropdown-divider">
          </li>
          <li>
              <a class="dropdown-item" href="{{ route('logout') }}">Keluar</a>
          </li>
        </ul>
      </li> --}}
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