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
      background-color:  #198754; /* Tosca color */
      padding-top: 0px;
      padding-bottom: 0px;
    }
      
    .card , .login-alert, .logo{
        margin: 10px; /* Batas atas, kiri, kanan, dan bawah */
    }
    .card-header{
       background-color:  #198754;
    }

    a {
      text-decoration: none;
    }

    .waca-logo {
        width: 200px; /* Sesuaikan ukuran yang diinginkan */
        height: 97px; /* Sesuaikan ukuran yang diinginkan */
    }

    
  </style>
</head>
<body>
{{--   
  <nav class="navbar navbar-custom navbar-dark navbar-expand">
    <div class="container-fluid">
      <ul class="navbar-nav nav-justified w-100">
        <a class="nav-link text-center text-white">
            <i class="fa fa-home fa-2x"><span>&nbsp;Residence</span></i>
        </a>
      </ul>
    </div>
  </nav> --}}

  
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="logo" style="display: flex; justify-content: center; align-items: center;">
              <picture>
                <img src="{{ asset('assets/plugins/images/wacalogo.jpg') }}" class="img-fluid img-thumbnail waca-logo" alt="Waca Logo">
              </picture>
            </div>
            <div class="mb-3">
              <strong><p class="text-center">Selamat Datang di Waca</p></strong>
            </div>

            <div class="login-alert">
              @include('layouts.elements.flash')
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-center text-white">User Login</h5>
                </div>
                <div class="card-body">
                    <form id="loginform" method="post" action="{{ route('postlogin') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>

                        <div class="row">
                          <div class="col-md-12 col-sm-12">
                              <div class="pull-left">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" id="showPasswordCheckbox" onclick="togglePasswordVisibility()">
                                  <label class="form-check-label" for="showPasswordCheckbox">
                                      Lihat Password
                                  </label>
                                </div>
                              </div>
                              <div class="pull-right">
                                  <a href="">Lupa Kata Sandi ?</a>
                              </div>
                          </div>
                        </div>
                        <br>

                        {{-- <div class="mb-3 pull-right">
                            <a href="#">Lupa Kata Sandi ?</a>
                        </div> --}}
                        {{-- <div class="mb-3">
                          <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-key"></i> Login</button>
                        </div> --}}
                        <div class="row">
                          <div class="col-md-12">
                              <button type="submit" id="submitBtn" class="btn btn-success form-control" type="button" disabled><i class="fa fa-key"></i> Masuk</button>
                          </div>
                        </div>
                        <br>
                        <div class="mb-3">
                          <p class="text-center">Belum punya akun? <a href="{{ route('showRegister') }}"> Daftar</a></p>
                        </div>
                       
                        {{-- <a class="btn btn-success" href="#" role="button"><i class="fa fa-pencil"></i> Registrasi</a> --}}
                        {{-- <a class="btn btn-success" href="#" role="button"><i class="fa fa-question-circle"></i> Lupa Password</a> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
 
  <script src="{{ asset('assets/bootstrap/dist/js/bootstrap-5.min.js') }}"></script>

  <script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const showPasswordCheckbox = document.getElementById('showPasswordCheckbox');

        // Ubah tipe input antara 'password' dan 'text' berdasarkan checkbox
        if (showPasswordCheckbox.checked) {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
  </script>

  <script>
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const submitBtn = document.getElementById('submitBtn');

    function toggleSubmitButton() {
        // Aktifkan tombol jika kedua input terisi, jika tidak nonaktifkan
        if (emailInput.value.trim() && passwordInput.value.trim()) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }

    // Pasang event listener untuk memantau perubahan pada kedua input
    emailInput.addEventListener('input', toggleSubmitButton);
    passwordInput.addEventListener('input', toggleSubmitButton);
  </script>
 
</body>
</html>
