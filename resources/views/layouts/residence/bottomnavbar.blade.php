<!-- Bottom Navbar -->
<nav class="navbar navbar-custom navbar-dark navbar-expand fixed-bottom">
    <div class="container-fluid">
      <ul class="navbar-nav nav-justified w-100">

        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link text-center text-white">
            <i class="fa fa-home fa-2x"></i>
            <span class="small d-block">Home</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('pembayaran') }}" class="nav-link text-center text-white">
            <i class="fa fa-money fa-2x"></i>
            <span class="small d-block">Pembayaran</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('pengurus') }}" class="nav-link text-center text-white">
            <i class="fa fa-id-card fa-2x"></i>
            <span class="small d-block">Pengurus</span>
          </a>
        </li>
            
        <li class="nav-item dropup">
          <!-- Removed dropdown-toggle class to hide the arrow -->
          <a href="#" class="nav-link text-center text-white" role="button" id="dropdownMenuProfile" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-user fa-2x"></i>
            <span class="small d-block">Akun</span>
          </a>
          <!-- Dropup menu for profile -->
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuProfile">
            <li><a class="dropdown-item" href="{{ route('akun') }}">Detail Akun</a></li>
            <li><a class="dropdown-item" href="{{ route('edit') }}">Edit Akun</a></li>
            <li><a class="dropdown-item" href="{{ route('registrasi') }}">Registrasi</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('logout') }}">Keluar</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>