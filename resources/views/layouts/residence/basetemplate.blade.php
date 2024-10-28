<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/favicon.png') }}">
  <title>Residence</title>
  <link href="{{ asset('assets/bootstrap/dist/css/bootstrap-5.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="{{ asset('assets/plugins/components/jquery/dist/jquery.min.js') }}"></script>
  
  
  <style>
    .navbar-custom {
      background-color:  #198754 !important; /* Tosca color #00ffc3*/ 
      padding-top: 0px;
      padding-bottom: 0px;
    }
    
    .navbar-nav .nav-link {
      font-size: 0.7rem; /* Adjust font size */
    }

    .card {
      margin: 10px; /* Batas atas, kiri, kanan, dan bawah */
    }
    .card-header .nav-tabs{
       background-color:  #198754 !important;
    }

    /* Custom color for tabs */
    .nav-tabs .nav-link {
            color: #5cb85c; /* hijau tosca */
        }
        .nav-tabs .nav-link.active {
            color: white;
            background-color: #198754; /* hijau  #006666 */
        }
        /* Border color */
        .nav-tabs {
            border-bottom: 2px solid #198754; /* hijau tosca */
        }

    .table thead th {
            background-color: #198754; /* hijau tosca */
            color: white;
        }
        .table, .table-bordered th, .table-bordered td {
            border-color: #198754; /* hijau tosca */
        }
  </style>
</head>
<body>
  
  @include('layouts.residence.topnavbar')
  
  @include('layouts.residence.bottomnavbar')
  
  @yield('content')
  

  <!-- Bootstrap JS -->
  <script src="{{ asset('assets/bootstrap/dist/js/bootstrap-5.min.js') }}"></script>
  
 
</body>
</html>
