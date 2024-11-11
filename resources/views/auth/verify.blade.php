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
        border:0px;
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

                  {{-- <div class="mb-3">
                    <p class="text-left">Selamat Datang di Waca</p>
                  </div> --}}
                    <h6 class="card-title text-center">Registrasi Sukses</h6>
                    <img src="{{ asset('assets/plugins/images/verified.jpg') }}" class="card-img-top mx-auto d-block mt-3 text-center" alt="Image" style="width: 160px; height: 135px;">
                    <br>
                    <p class="card-text text-center">Anda sudah terdaftar sebagai warga, lanjutkan untuk verifikasi</p>
                    <form id="verified" method="post" action="{{ route('postVerified') }}">
                        @csrf
                        <input type="hidden" class="form-control" name="code" id="code">
                        <input type="hidden" class="form-control" name="token" id="token">
                        <br>
                        <div class="row">
                          <div class="col-md-12">
                              <button type="submit" id="submitBtn" class="btn btn-success form-control" type="button">Verifikasi</button>
                          </div>
                        </div>
                        {{-- <br>
                        <div class="mb-3">
                          <p class="text-center">Belum punya akun? Hubungi Pengurus.</p>
                        </div> --}}
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
  
</body>
</html>

