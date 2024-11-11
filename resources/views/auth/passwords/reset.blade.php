<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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

  <!-- JS Select2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('status') == 'success')
    <script>
        Swal.fire({
            title: '<strong style="font-size: 20px; font-weight: bold;">Success</strong>',
            text: 'Silahkan cek email Anda untuk melanjutkan atur ulang kata sandi',
            confirmButtonText: 'Mengerti',
            customClass: {
                confirmButton: 'btn btn-sm col-md-12 btn-success' // Menyesuaikan tombol
            },
            imageUrl: "{{ asset('assets/plugins/images/envelope.jpg') }}", // Gambar ikon custom
            imageWidth: 120, // Ukuran gambar
            imageHeight: 120
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('showLoginForm') }}';
            }
        });
    </script>
    @elseif (session('status') == 'error')
    <script>
        Swal.fire({
            title: 'Error',
            text: 'Alamat Email tidak dikenal, masukan email yang sudah terdaftar.',
            icon: 'error',
            confirmButtonText: 'Mengerti',
            customClass: {
                confirmButton: 'btn btn-sm col-md-12 btn-success' // Menyesuaikan tombol
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('showLoginForm') }}';
            }
        });
    </script>
    @endif

  {{-- <script>
       
    Swal.fire({
        title: '<strong style="font-size: 20px; font-weight: bold;">Success</strong>',
        text: 'Silahkan cek email Anda untuk melanjutkan atur ulang kata sandi',
        
        confirmButtonText: 'Mengerti',
        customClass: {
            confirmButton: 'btn btn-sm col-md-12 btn-success' // Menyesuaikan tombol
        },
        imageUrl: "{{ asset('assets/plugins/images/envelope.jpg') }}", // Gambar ikon custom
        imageWidth: 120, // Ukuran gambar
        imageHeight: 120
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '{{ route('showLoginForm') }}';
        }
    });
   
  </script> --}}

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
