<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/favicon.png') }}">
  <title>Residence</title>
  <link href="{{ asset('assets/bootstrap/dist/css/bootstrap-5.min.css') }}" rel="stylesheet">
  <script src="{{ asset('assets/plugins/components/jquery/dist/jquery.min.js') }}"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    .navbar-custom {
      background-color:  #198754; /* Tosca color */
      padding-top: 0px;
      padding-bottom: 0px;
    }
      
    .card , .login-alert{
        margin: 10px; /* Batas atas, kiri, kanan, dan bawah */
    }
    .card-header{
       background-color:  #198754;
    }
  </style>
</head>
<body>
  
  <nav class="navbar navbar-custom navbar-dark navbar-expand">
    <div class="container-fluid">
      <ul class="navbar-nav nav-justified w-100">
        <a class="nav-link text-center text-white">
            <i class="fa fa-home fa-2x"><span>&nbsp;Residence</span></i>
        </a>
      </ul>
    </div>
  </nav>

  
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="login-alert">
                @include('layouts.elements.flash')
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-center text-white">Aktifasi Akun</h5>
                </div>
                <div class="card-body">
                   
                    <form id="activedform" method="post" action="{{ route('postActivated') }}">
                        @csrf
                        <input type="text" name="code" class="form-control" id="code" required>
                        <i class="fa fa-key fa-2x"></i>
                        <button type="submit" class="btn btn-lg btn-success"><i class="fa fa-key"></i> Aktifasi Akun</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
 
  <script src="{{ asset('assets/bootstrap/dist/js/bootstrap-5.min.js') }}"></script>
 
</body>
</html>
