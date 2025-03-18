<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/pewaca-green.jpeg') }}">
  <title>Pewaca</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   {{-- <!-- CSS Select2 -->
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

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
                        <a href="{{ route('showLoginForm') }}" class="text-dark">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <strong>
                            <p class="text-left mb-0 ms-2">Lupa Kata Sandi</p>
                        </strong>
                    </div>

                    <div class="mb-3 d-flex align-items-center">
                        <p>Masukan email yang terdaftar untuk atur ulang Kata Sandi.</p>
                    </div>
      
                    <form id="checkMail" method="POST" action="{{ route('sendMail') }}">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                            <label for="floatingInput">Alamat Email</label>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-12">
                              <button type="submit" id="submitBtn" class="btn btn-success form-control" type="button" disabled>Lanjutkan</button>
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
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('status') == 'success')
    <script>
        
        Swal.fire({
            html: `
                <div style="text-align: center; font-size: 14px;">
                    <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0">
                        Success
                    </h2>
                    <p>Silahkan cek email Anda untuk melanjutkan atur ulang kata sandi.</p>
                    <img
                        src="{{ asset('assets/plugins/images/verified-send.jpeg') }}"
                        alt="Verified"
                        style="width: 180px; height: 175px; margin: 10px 0" />
                </div>
            `,
            
            showConfirmButton: true,
            confirmButtonText: 'Mengerti',
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
    @elseif (session('status') == 'error')
    <script>
        Swal.fire({
            html: `
                <div style="text-align: center; font-size: 14px;">
                    <i class="swal2-icon swal2-error" style="font-size: 50px; margin-bottom: 10px;"></i>
                    <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0;">
                       Error
                    </h2>
                    <p>Alamat Email tidak dikenal, masukan email yang sudah terdaftar..</p>
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
                window.location.href = '{{ route('showLoginForm') }}';
            }
        });
    </script>
    @endif
  <script>
    const emailInput = document.getElementById('email');
   
    const submitBtn = document.getElementById('submitBtn');

    function toggleSubmitButton() {
        // Aktifkan tombol jika kedua input terisi, jika tidak nonaktifkan
        if (emailInput.value.trim()) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }

    // Pasang event listener untuk memantau perubahan pada kedua input
    emailInput.addEventListener('input', toggleSubmitButton);
  </script>
 
</body>
</html>
