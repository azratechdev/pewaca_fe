<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/logo.png') }}">
  <title>Pewaca</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="manifest" href="{{ url('manifest.json') }}">
  
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
        width: 190px; /* Sesuaikan ukuran yang diinginkan */
        height: 60px; /* Sesuaikan ukuran yang diinginkan */
        border:0px;
    }

    .swal2-popup.rounded-alert {
    border-radius: 12px !important;
    padding: 20px;
    width: 400px !important;
    max-width: 75%;
}

/* Tambahan styling opsional */
.swal2-popup .swal2-title {
    font-size: 20px !important;
    font-weight: bold !important;
    margin: 10px 0 !important;
}

.swal2-popup .swal2-content {
    font-size: 14px !important;
    margin-bottom: 10px !important;
    text-align: center;
}
.swal2-actions {
    display: flex !important; /* Atur elemen pembungkus tombol agar fleksibel */
    justify-content: center !important; /* Pusatkan tombol */
    width: 100% !important; /* Pastikan pembungkus tombol lebar penuh */
    margin: 0 !important;
}

.swal-confirm-btn {
    display: block !important; /* Ubah tombol menjadi elemen blok */
    width: 100% !important; /* Pastikan tombol melebar penuh */
    padding: 10px !important; /* Tinggi tombol */
    font-size: 16px !important; /* Ukuran teks */
    background-color: #198754 !important; /* Warna hijau success */
    color: white !important; /* Teks putih */
    border: none !important; /* Hapus border */
    border-radius: 4px !important; /* Sudut melengkung */
    text-align: center !important; /* Teks di tengah */
}
  </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
          
            <div class="card">
                <div class="card-body">
                    <div class="mb-4 mt-4" style="align-items: left;">
                        <picture>
                          <img src="{{ asset('assets/plugins/images/mainlogo.png') }}" class="img-fluid img-thumbnail waca-logo" alt="Waca Logo">
                        </picture>
                    </div> 

                    <div class="mb-3 d-flex align-items-center">
                        <p>Masukan kata sandi baru dan konfirmasi, pastikan bernilai sama.</p>
                    </div>

                    {{-- <div class="mb-3">
                        @include('layouts.elements.flash')
                    </div>
       --}}
                    <form id="newPassword" method="POST" action="{{ route('sendNewpassword') }}">
                        @csrf
                        <input type="hidden" class="form-control" name="code" id="code">
                        <input type="hidden" class="form-control" name="token" id="token">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control"  @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" id="password" placeholder="Password">
                            <label for="floatingPassword">Buat Kata Sandi Baru</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control"  @error('confirm_password') is-invalid @enderror" value="{{ old('confirm_password') }}" name="confirm_password" id="confirm_password" placeholder="Password">
                            <label for="floatingPassword">Konfirmasi Kata Sandi Baru</label>
                            @error('confirm_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Mendapatkan URL saat ini
        let url = window.location.href;

        // Membagi URL berdasarkan '/'
        let urlParts = url.split('/');

        // UUID dan Token berada di posisi yang diinginkan
        let uuid = urlParts[4];  // 1c99af82-cfa0-4d95-8f3e-32d1556bd6ba
        let token = urlParts[5]; // 342343253463wefsdfgd

        //alert(token);

        $('input#code').val(uuid);
        $('input#token').val(token);

    </script>

  <script>
    
      $('#newPassword').on('submit', function(e) {
        Swal.fire({
            title: 'Mengganti kata sandi',
            text: 'Harap tunggu sebentar...',
            allowOutsideClick: false, 
            allowEscapeKey: false,  
            didOpen: () => {
                Swal.showLoading(); 
            }
        });
      });
  </script>

@if (session('status') == 'success')
<script>

    Swal.fire({
        html: `
            <div style="text-align: center; font-size: 14px;">
                <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0">
                   {{ session("message") }}
                </h2>
                <p>Berhasil mangganti kata sandi, Lanjutkan login kembali!</p>
                <img
                    src="{{ asset('assets/plugins/images/verified-success.jpeg') }}"
                    alt="Verified"
                    style="width: 180px; height: 175px; margin: 10px 0" />
            </div>
        `,
        
        showConfirmButton: true,
        confirmButtonText: 'Lanjutkan Login',
        allowOutsideClick: false,
        allowEscapeKey: false,
        customClass: {
            popup: 'rounded-alert', // Class untuk border-radius
            confirmButton: 'swal-confirm-btn'
        }
    }).then(() => {
        window.location.href = '{{ route('showLoginForm') }}';
    });
</script>
@elseif (session('status') == 'warning')
<script>
    
    Swal.fire({
        html: `
            <div style="text-align: center; font-size: 14px;">
                <i class="swal2-icon swal2-error" style="font-size: 50px; margin-bottom: 10px;"></i>
                <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0;">
                   Periksa kembali kata sandi!
                </h2>
                <p>{{ session("message") }}</p>
            </div>
        `,
        showConfirmButton: true,
        icon: 'warning',
        confirmButtonText: 'Mengerti',
        allowOutsideClick: false,
        allowEscapeKey: false,
        customClass: {
            popup: 'rounded-alert',
            confirmButton: 'swal-confirm-btn'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            let uuid = $('input#code').length ? $('input#code').val() : '';
            let token = $('input#token').length ? $('input#token').val() : '';
            $('form#newPassword').reset();
            window.location.href = '{{ route('newPassword', ['uuid' => '']) }}' + uuid + '/token=' + token;
        }
    });

</script>
@elseif (session('status') == 'error')
<script>
   
    Swal.fire({
        html: `
            <div style="text-align: center; font-size: 14px;">
                <i class="swal2-icon swal2-error" style="font-size: 50px; margin-bottom: 10px;"></i>
                <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0;">
                    {{ session("message") }}
                </h2>
                <p>Pastikan anda memiliki koneksi internet!</p>
            </div>
        `,
        showConfirmButton: true,
        icon: 'error',
        confirmButtonText: 'Mengerti',
        allowOutsideClick: false,
        allowEscapeKey: false,
        customClass: {
            popup: 'rounded-alert',
            confirmButton: 'swal-confirm-btn'
        }
    }).then((result) => {
       if (result.isConfirmed) {
            let uuid = $('input#code').length ? $('input#code').val() : '';
            let token = $('input#token').length ? $('input#token').val() : '';
            window.location.href = '{{ route('newPassword', ['uuid' => '']) }}'+'/'+ uuid + '/' + token;
         }
  });
</script>

@endif
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
