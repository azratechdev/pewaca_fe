<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/pewaca-green.jpeg') }}">
  <title>Pewaca</title>
  
  <!-- JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <!-- CSS -->
  <link href="{{ asset('assets/bootstrap/dist/css/bootstrap-5.min.css') }}" rel="stylesheet">
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
    /* .navbar-custom { background-color: #198754 !important; padding: 0; }
    .navbar-nav .nav-link { font-size: 0.7rem; } */
    .card { margin: 10px; }
    /* .card-header .nav-tabs { background-color: #198754 !important; }
    .nav-tabs .nav-link { color: #5cb85c; }
    .nav-tabs .nav-link.active { color: white; background-color: #198754; }
    .nav-tabs { border-bottom: 2px solid #198754; } */

    .card-header .nav-tabs {
    background-color: #198754 !important;
    }   

    .nav-tabs .nav-link {
        color: #5cb85c; /* Warna default teks */
        transition: all 0.3s ease-in-out; /* Efek transisi halus */
    }

   
    .nav-tabs .nav-link:hover,
    .nav-tabs .nav-link.active {
        color: white !important; /* Warna teks putih saat aktif */
        background-color: #198754 !important; /* Latar belakang hijau */
    }

    .nav-tabs {
        border-bottom: 2px solid #198754; /* Garis bawah tab */
    }
    .table thead th { background-color: #198754; color: white; }
    .table, .table-bordered th, .table-bordered td { border-color: #198754; }

    .navbar-custom {
    background-color: #ffffff !important;
    padding: 0;
    border-bottom: 2px solid #6c757d; /* Garis abu-abu di atas navbar */
    margin: 0; /* Menambahkan jarak 20px ke kiri dan kanan */
    /* border-radius: 0 0 10px 10px;  */
    }

.navbar-nav .nav-link {
    font-size: 1.4rem; /* Ukuran 2 kali lebih besar */
    color: #6c757d !important; /* Abu-abu */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100px; /* Disesuaikan untuk ukuran dua kali lipat */
    width: 100px;
    transition: color 0.3s ease-in-out;
   
}

.navbar-nav .nav-link i {
    font-size: 2rem; /* Ikon 2 kali lebih besar */
    /* margin-bottom: 0.5rem; */
}

.navbar-nav .nav-link:hover, 
.navbar-nav .nav-link.active {
    color: #198754 !important; /* Hijau pada hover atau aktif */
    background-color: #ffffff !important; /* Background tetap putih */
}

.dropdown-menu .dropdown-item {
    color: #6c757d; /* Warna default teks abu-abu */
    transition: all 0.3s ease-in-out; /* Efek transisi halus */
}

.dropdown-menu .dropdown-item:hover,
.dropdown-menu .dropdown-item:focus,
.dropdown-menu .dropdown-item.active {
    color: #ffffff !important; /* Warna teks putih */
    background-color: #198754 !important; /* Warna hijau */
}


.nav-link {
    color: #6c757d; /* Default abu-abu */
    transition: color 0.3s ease-in-out; /* Transisi halus */
}

.nav-link:hover, 
.nav-link.active, 
.nav-link[aria-expanded="true"] {
    color: #198754 !important; /* Hijau saat aktif atau hover */
}

.nav-link i,
.nav-link span {
    color: inherit; /* Ikon dan teks mengikuti warna link */
}

  </style>
</head>
<body>
  
  {{-- @include('layouts.residence.topnavbar') --}}
  @include('layouts.residence.bottomnavbar')
  @yield('content')
  
  
  <script src="{{ asset('assets/bootstrap/dist/js/bootstrap-5.min.js') }}"></script>

  
</body>
</html>
