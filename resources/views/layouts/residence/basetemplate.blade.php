<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/favicon.png') }}">
  <title>Residence</title>
  
  <!-- CSS -->
  <link href="{{ asset('assets/bootstrap/dist/css/bootstrap-5.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

  <style>
    .navbar-custom { background-color: #198754 !important; padding: 0; }
    .navbar-nav .nav-link { font-size: 0.7rem; }
    .card { margin: 10px; }
    .card-header .nav-tabs { background-color: #198754 !important; }
    .nav-tabs .nav-link { color: #5cb85c; }
    .nav-tabs .nav-link.active { color: white; background-color: #198754; }
    .nav-tabs { border-bottom: 2px solid #198754; }
    .table thead th { background-color: #198754; color: white; }
    .table, .table-bordered th, .table-bordered td { border-color: #198754; }
  </style>
</head>
<body>
  
  @include('layouts.residence.topnavbar')
  @include('layouts.residence.bottomnavbar')
  @yield('content')
  
  
  <script src="{{ asset('assets/bootstrap/dist/js/bootstrap-5.min.js') }}"></script>

  <!-- JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

</body>
</html>
