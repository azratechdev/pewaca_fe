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
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

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

                    <div class="mb-3 d-flex align-items-center">
                        <a href="{{ route('showLoginForm') }}" class="text-dark">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <strong>
                            <p class="text-left mb-0 ms-2">Buat Kata Sandi Baru</p>
                        </strong>
                    </div>

                    <div class="mb-3 d-flex align-items-center">
                        <p>Masukan kata sandi baru dan konfirmasi, pastikan bernilai sama.</p>
                    </div>

                    <div class="mb-3">
                        @include('layouts.elements.flash')
                    </div>
      
                    <form id="newPassword" method="POST" action="{{ route('sendNewpassword') }}">
                        @csrf
                        <input type="hidden" class="form-control" name="code" id="code">
                        <input type="hidden" class="form-control" name="token" id="token">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            <label for="floatingPassword">Buat Kata Sandi Baru</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Password">
                            <label for="floatingPassword">Kofirmasi Kata Sandi Baru</label>
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
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-12">
                              <button type="submit" id="submitBtn" class="btn btn-success form-control" type="button" disabled>Lanjutkan</button>
                          </div>
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
            // Mendapatkan URL saat ini
        let url = window.location.href;

        // Membagi URL berdasarkan '/'
        let urlParts = url.split('/');

        // UUID dan Token berada di posisi yang diinginkan
        let uuid = urlParts[4];  // 1c99af82-cfa0-4d95-8f3e-32d1556bd6ba
        let token = urlParts[5]; // 342343253463wefsdfgd

        $('input#code').val(uuid);
        $('input#token').val(token);

    </script>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm_password');
            const showPasswordCheckbox = document.getElementById('showPasswordCheckbox');
    
            // Ubah tipe input antara 'password' dan 'text' berdasarkan checkbox
            if (showPasswordCheckbox.checked) {
                passwordInput.type = 'text';
                confirmPasswordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
                confirmPasswordInput.type = 'password';
            }
        }
      </script>
    <script>
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const submitBtn = document.getElementById('submitBtn');

        function toggleSubmitButton() {
            // Aktifkan tombol jika kedua input terisi, jika tidak nonaktifkan
            if (passwordInput.value.trim() && confirmPasswordInput.value.trim()) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }
        // Pasang event listener untuk memantau perubahan pada kedua input
     
        passwordInput.addEventListener('input', toggleSubmitButton);
        confirmPasswordInput.addEventListener('input', toggleSubmitButton);
    </script>
 
</body>
</html>
