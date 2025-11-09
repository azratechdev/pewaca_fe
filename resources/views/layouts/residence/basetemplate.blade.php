<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="72x72" href="{{ url('images/icons/icon-72x72.png') }}">
  <link rel="manifest" href="{{ url('manifest.json') }}">
  <title>Pewaca</title>
  
  {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
 
  
  <!-- CSS -->
  <link href="{{ url('assets/bootstrap/dist/css/bootstrap-5.min.css') }}" rel="stylesheet">
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    />
  <style>
  
    .card { margin: 10px; }
    .card-header {
    background-color: #198754 !important;
    }  
    
    /*CSS navbar with icon pada menu pengurus*/
    .custom-nav-button {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border-radius: 4px;
        padding: 10px;
        text-align: center;
        background-color: #f8f9fa; /* Background button */
        color: #abebc6; /* Hijau cerah untuk teks dan ikon */
        transition: background-color 0.3s ease;
    }

    .custom-nav-button:hover {
        color: white;
    }

    .custom-nav-button .fa {
        margin-bottom: 5px; /* Spacing between icon and text */
    }

    .custom-nav-button span {
        font-size: 12px; /* Font size for the text */
    }

    .nav-tabs .nav-link {
       transition: all 0.3s ease-in-out; /* Efek transisi halus */
    }
    /*sampai sini*/

    /*CSS Menu Bar*/
    .navbar-custom {
    background-color: #ffffff !important;
    padding-bottom: 55px;
    border-bottom: 0px solid #6c757d; /* Garis abu-abu di atas navbar */
    margin: 0; /* Menambahkan jarak 20px ke kiri dan kanan */
    /* border-radius: 0 0 10px 10px;  */
    }

    .navbar-nav .nav-link {
        font-size: 1rem; 
        color: #6c757d !important; /* Abu-abu */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 80px;
        width: 80px;
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
    /*samapai sini*/

    /*CSS content dan body*/
    #content {
        flex: 1; 
        overflow-y: auto; 
        margin-bottom: 100px;
    }
    /* body {
        padding-bottom: 100px;
    } */
    /*samapai sini*/

    /* css image story*/
    .fixed-img {
        width: 100%;
        height: 240px;
        object-fit: cover; /* Memastikan gambar tidak terdistorsi */
        border-radius: 8px; /* Memberikan sedikit radius pada gambar */
    }
    .card-content {
        min-height: 150px; /* Pastikan area teks memiliki tinggi minimum */
        width: 360px;
      
    }  
    .profile-picture {
        width: 48px; /* Ukuran konsisten untuk avatar */
        height: 48px;
        object-fit: cover;
    }
    /*sampai sini*/ 

    /* css image upload*/
    .img-upload {
        width: 220px;
        height: 240px;
        object-fit: cover;
    }

    /*css content story*/
    .d-none {
    display: none;
    }
    .text-green-500 {
        /* color: #007bff; */
        cursor: pointer;
    }
    .text-blue-500:hover {
        text-decoration: underline;
    }
    .text-justify {
        text-align: justify; /* Ratakan kiri dan kanan */
        word-spacing: 0.05em; /* Atur jarak antar kata */
        line-height: 1.2; /* Atur spasi antar baris */
        word-break: break-word;
    }
  
    .custom-card-content {
        padding-top: 0rem;
        padding-bottom: 0rem;
        margin-top: 0rem;
        margin-bottom: 0rem;
    }

    .custom-comment {
       resize: none;  /* Menghindari perubahan ukuran manual */
    }

    /* Custom Menu Icon and Text Sizes */
    .menu-icon {
        font-size: 30px !important; /* Ukuran ikon lebih kecil */
        /* line-height: 1.2 !important; */
    }

    .menu-text {
        font-size: 16px; /* Ukuran teks lebih kecil */
        line-height: 1.2; /* Jarak antar teks lebih rapat */
    }
    
  </style>
</head>

<body>

    <div id="content">
        @yield('content')
    </div>
      
    <div class="bottom-navbar">
        @include('layouts.residence.bottomnavbar')
    </div>

    <script src="{{ url('assets/bootstrap/dist/js/bootstrap-5.min.js') }}"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register("{{ url('serviceworker.js') }}")
                .then(function(registration) {
                    console.log('✅ Service Worker registered with scope:', registration.scope);
                })
                .catch(function(error) {
                    console.error('❌ Service Worker registration failed:', error);
                });
        }
    </script>
</body>
</html>
