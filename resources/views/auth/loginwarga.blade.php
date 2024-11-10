<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/favicon.png') }}">
  <title>Residence</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- CSS Select2 -->
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    .navbar-custom {
      background-color:  #198754; /* Tosca color */
      padding-top: 0px;
      padding-bottom: 0px;
    }
      
    .card , .login-alert, .logo{
        margin: 20px; /* Batas atas, kiri, kanan, dan bawah */
        border:0px;
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

  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                  <div class="mb-3" style="align-items: left;">
                    <picture>
                      <img src="{{ asset('assets/plugins/images/wacalogo.jpg') }}" class="img-fluid img-thumbnail waca-logo" alt="Waca Logo">
                    </picture>
                  </div>

                  <div class="mb-3">
                    <p class="text-left">Selamat Datang di Waca</p>
                  </div>
      
                  <div class="mb-3">
                    @include('layouts.elements.flash')
                  </div>
                    <form id="loginform" method="post" action="{{ route('postlogin') }}">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-12 col-sm-12">
                            <div class="d-flex justify-content-between align-items-center">
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="showPasswordCheckbox" onclick="togglePasswordVisibility()">
                                <label class="form-check-label" for="showPasswordCheckbox">
                                  Lihat Password
                                </label>
                              </div>
                              <div>
                                <a href="{{ route('showFormReset') }}">Lupa Kata Sandi?</a>
                              </div>
                            </div>
                          </div>
                        </div>

                        <br>
                        <div class="row">
                          <div class="col-md-12">
                              <button type="submit" id="submitBtn" class="btn btn-success form-control" type="button" disabled>Masuk</button>
                          </div>
                        </div>
                        <br>
                        <div class="mb-3">
                          <p class="text-center">Belum punya akun? Hubungi Pengurus.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
 
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
  <!-- JS Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS Select2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  
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
