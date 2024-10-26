<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/favicon.png') }}">
  <title>Residence</title>
  <link href="{{ asset('assets/bootstrap/dist/css/bootstrap-5.min.css') }}" rel="stylesheet">
  <script src="{{ asset('assets/plugins/components/jquery/dist/jquery.min.js') }}"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    .navbar-custom {
      background-color:  #00ffc3; /* Tosca color */
      padding-top: 0px;
      padding-bottom: 0px;
    }
      
    .card {
            margin: 10px; /* Batas atas, kiri, kanan, dan bawah */
    }
    .card-header{
       background-color:  #00ffc3;
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
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-center text-white">Login Warga / Pengurus</h5>
                </div>
                <div class="card-body">
                    <form id="loginform" method="post" >
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password">
                        </div>
                        {{-- <button type="submit" class="btn btn-success"><i class="fa fa-key"></i> Login</button> --}}
                        <a class="btn btn-success" href="{{ route('home') }}" role="button"><i class="fa fa-key"></i> Login</a>
                        <a class="btn btn-success" href="#" role="button"><i class="fa fa-pencil"></i> Registrasi</a>
                        <a class="btn btn-success" href="#" role="button"><i class="fa fa-question-circle"></i> Lupa Password</a>
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
