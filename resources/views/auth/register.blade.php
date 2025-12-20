<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/logo.png') }}">
  <title>Pewaca</title>
  <link rel="manifest" href="{{ url('manifest.json') }}">

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   <script src="https://www.google.com/recaptcha/api.js?render={{ config('recaptcha.sitekey') }}"></script>
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

    /* Style untuk input file */
      
        .form-control[type="file"] {
            padding: 1.625rem 0.75rem 0.5rem;
        }

        .form-control[type="file"]::file-selector-button {
            display: none;
        }

        .form-control[type="file"]::-webkit-file-upload-button {
            display: none;
        }

        /* Style untuk preview container setengah lebar */
        #imagePreviewContainer {
            transition: all 0.3s ease;
        }

        /* Style untuk tombol remove */
        #removeImageButton {
            background-color: #dc3545;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        #removeImageButton:hover {
            background-color: #c82333;
        } 

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #6b7280;
    }
  
  </style>

<style>
    /* Styling untuk container input */
    .form-group {
        position: relative;
        margin: 20px 0;
        width: 100%;
    }

    /* Styling untuk .input-group */
    .input-group {
        display: flex;
        align-items: center;
        width: 100%;
       
    }

    /* Styling untuk prefix */
    .input-group-text {
        padding: 10px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-right: none;
        font-size: 1em;
        color: #333;
        border-radius: 4px 0 0 4px;
        display: flex;
        align-items: center;
    }

    /* Styling untuk input */
    .form-control {
        width: 100%;
        padding: 10px;
        font-size: 1em;
        border: 1px solid #ccc;
        border-radius: 4px 4px 4px 4px;
        outline: none;
    }

    /* Styling untuk label */
    .form-label {
        position: absolute;
        left: 12px;
        top: 10px;
        font-size: 1em;
        color: #999;
        background-color: white;
        padding: 0 5px;
        transition: 0.2s ease;
        pointer-events: none;
    }

    /* Styling ketika input diisi atau di-fokus */
    .form-control:focus + .form-label,
    .form-control:not(:placeholder-shown) + .form-label{
        top: -10px; /* Pindahkan label ke luar input */
        left: 8px;
        font-size: 0.85em;
        color: #333;
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
<style>
    .form-floating > .form-control:not(:placeholder-shown) ~ label,
.form-floating > .form-select ~ label {
    opacity: 1;
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
}

/* Atur tampilan Select2 agar sesuai dengan form-floating */
.select2-container .select2-selection--single {
    height: calc(3.5rem + 2px); /* Sesuaikan dengan tinggi form-floating */
    padding: 1rem 0.75rem;
    border-radius: 0.25rem;
    border: 1px solid #ced4da;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 100%;
    top: 0;
    right: 0.75rem;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 2.5;
    padding-left: 0;
    padding-right: 0;
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
                        <div class="mb-3">
                            @php
                                $image = $data['residence']['image'] ?? '';
                                if (str_contains($image, '127.0.0.1:8000/https://')) {
                                    $image = '';
                                }
                            @endphp
                            <p class="text-left" style="font-size: 1.2em;">Pendaftaran Warga</p>
                            <div class="d-flex align-items-center" style="font-size: 1.0em;">
                                <img src="{{ $image ?: asset('assets/plugins/images/house-2.png') }}" alt="Icon Perumahan" style="width: 24px; height: 24px; margin-right: 8px;">
                                <span>{{ $resdetail['name'] }}</span>
                            </div><br>
                            {{-- <p  style="font-size: 1.0em;">{{ $resdetail['name'] }}</p> --}}
                            <p style="font-size:0.8em;">Mohon lengkapi data untuk persyaratan menjadi warga<p>
                        </div>
              
                        {{-- <div class="mb-3">
                            @include('layouts.elements.flash')
                        </div>  --}}

                        <form id="registrasi" method="post" action="{{ route('postRegister') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="hidden" id="code" class="form-control" value="" name="code" required>
                                <label for="code">Kode</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <select class="form-control form-select @error('unit_id') is-invalid @enderror" id="unitSelect" name="unit_id" required>
                                    {{-- <option value="" disabled selected hidden>-Pilih Unit-</option> --}}
                                    <option>-Pilih unit-</option>
                                    @foreach ($units as $unit )
                                    <option value="{{ $unit['unit_id'] }}" {{ old('unit_id') == $unit['unit_id'] ? 'selected' : '' }}>{{ $unit['unit_name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="noUnit">No Unit</label>
                                @error('unit_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                            </div>
                        
                        
                            <div class="form-floating mb-3">
                                <input type="text" pattern="[A-Za-z\s]+" class="form-control" id="full_name" name="full_name" placeholder=" " value="{{ old('full_name') }}" required>
                                <label for="full_name ">Nama Lengkap</label>
                                
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                                                
                            <div class="form-floating mb-3">
                                <input type="text" pattern="\d{8,13}" minlength="8" maxlength="13" inputmode="numeric" class="form-control @error('phone_no') is-invalid @enderror"  value="{{ old('phone_no') }}" id="phone_no" name="phone_no" placeholder=" " required>
                                <label for="phone_no ">Nomor Telepon</label>
                                <small class="text-danger d-none" id="phone_no-error">Nomor Telepon minimal 8 digit dan maksimal 13 digit</small>
                                {{-- @error('phone_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror --}}
                            </div>

                            <div class="form-floating mb-3">
                                <select class="form-select" id="family_as" name="family_as" required>
                                    <option value="" disabled selected hidden>-Pilih Sebagai-</option>
                                    @foreach ($families as $family)
                                    <option value="{{ $family['id'] }}" {{ old('family_as') == $family['id'] ? 'selected' : '' }}>{{ $family['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="family_as">Family As</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email" name="email" placeholder=" " required>
                                <label for="email">Alamat Email</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" id="password" name="password" placeholder=" " required>
                                <label for="password">Buat Kata Sandi</label>
                                <i class="fas fa-eye-slash toggle-password" id="togglePassword"></i>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="g-recaptcha"
                                data-sitekey="{{ config('recaptcha.sitekey') }}"
                                data-callback="onSubmit"
                                data-size="invisible">
                            </div>
                        
                            <div class="form-group mb-3">
                                <button type="submit" id="submitBtn" class="btn btn-success form-control">Daftar Sebagai Warga</button>
                            </div>
                        
                            <br>
                            <div class="mb-3">
                                <p class="text-center">Sudah punya akun? <a href="{{ route('showLoginForm') }}"> Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
   
  <!-- Tambahkan jQuery -->
  {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <!-- JS Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <!-- Select2 for Enhanced Dropdowns -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  
  <!-- Browser Image Compression Library -->
  <script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
   
     // Password toggle functionality
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    if (togglePassword && password) {
        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }
});
</script>
    <script>
        $('#registrasi').on('submit', function(e) {
            e.preventDefault(); // Hentikan submit default

            const form = this;
            Swal.fire({
                title: 'Memproses Data',
                text: 'Harap tunggu sebentar...',
                allowOutsideClick: false, 
                allowEscapeKey: false,  
                didOpen: () => {
                    Swal.showLoading(); 
                }
             });
            // const btn = $('#submitBtn');
            // btn.addClass('loading');
            // btn.html('<span>Memproses Data...</span>');

            // Jalankan reCAPTCHA invisible
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('recaptcha.sitekey') }}', { action: 'registrasi' })
                    .then(function(token) {
                        // Tambahkan token ke form sebagai input hidden
                        let recaptchaInput = form.querySelector('input[name="g-recaptcha-response"]');
                        if (!recaptchaInput) {
                            recaptchaInput = document.createElement('input');
                            recaptchaInput.type = 'hidden';
                            recaptchaInput.name = 'g-recaptcha-response';
                            form.appendChild(recaptchaInput);
                        }
                        recaptchaInput.value = token;

                        // Kirim form
                        form.submit();
                    })
                    .catch(function(error) {
                        console.error('reCAPTCHA error:', error);
                        Swal.close();
                        btn.removeClass('loading');
                        btn.html('Login');
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Verifikasi keamanan gagal. Silakan coba lagi.'
                        });
                    });
            });
        });
   
        // $('#registrasi').on('submit', function(e) {
        //     Swal.fire({
        //         title: 'Memproses Data',
        //         text: 'Harap tunggu sebentar...',
        //         allowOutsideClick: false, 
        //         allowEscapeKey: false,  
        //         didOpen: () => {
        //             Swal.showLoading(); 
        //         }
        //     });
        // });
    </script>
  @if (session('status') == 'success')
    <script>
    
        Swal.fire({
            html: `
                <div style="text-align: center; font-size: 14px;">
                    <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0">
                        {{ session("message") }}
                    </h2>
                    <p>Silahkan cek email Anda untuk melanjutkan verifikasi.</p>
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
     
      let uuid = $('input#code').length ? $('input#code').val() : '';

        Swal.fire({
            html: `
                <div style="text-align: center; font-size: 14px;">
                    <i class="swal2-icon swal2-error" style="font-size: 50px; margin-bottom: 10px;"></i>
                    <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0;">
                       {{ session("message") }}
                    </h2>
                    <p>Gagal Verifikasi, Pastikan anda memiliki akses internet.</p>
                </div>
            `,
            showConfirmButton: true,
            icon: 'error',
            confirmButtonText: 'Verifikasi Ulang',
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                popup: 'rounded-alert',
                confirmButton: 'swal-confirm-btn'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                if (uuid) {
                    window.location.href = '{{ route('showRegister', ['uuid' => '']) }}' + uuid;
                }
            }
        });
    </script>

@endif
    <script>
     
        const form = document.getElementById('registrasi');
        const submitBtn = document.getElementById('submitBtn');
        
      
        function checkFormValidity() {
           
            const isValid = [...form.querySelectorAll('input[required], select[required]')].every(input => {
            
                if (input.type === 'file') {
                    return input.files.length > 0 || input.optional; // Periksa jika input file kosong
                }
                return input.value.trim() !== '';
            });
         
            submitBtn.disabled = !isValid;
        }

        form.addEventListener('input', checkFormValidity);

        checkFormValidity();
    </script>
    <script>
        const url = window.location.href;
        const id = url.split('/').pop();
        $('input#code').val(id);

        function validateUUID(id) {
            const uuidRegex = /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i;
            return uuidRegex.test(id);
        }
       
        document.getElementById("registrasi").addEventListener("submit", function(event) {
            const id = document.getElementById("code").value;
            if (!validateUUID(id)) {
                event.preventDefault();
                Swal.fire({
                    html: `
                        <div style="text-align: center; font-size: 14px;">
                            <i class="swal2-icon swal2-error" style="font-size: 50px; margin-bottom: 10px;"></i>
                            <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0;">
                                Unknow Page
                            </h2>
                            <p>Tindakan tidak dikenali, pastikan anda menuju halaman yang benar.</p>
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
                        if (uuid) {
                            window.location.href = '{{ route('showRegister', ['uuid' => '']) }}' + uuid;
                        }
                    }
                });
            }
        });
    </script>


<script>
    document.getElementById('phone_no').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, ''); // Hanya angka

    if (value.length > 13) {
        value = value.substring(0, 13); // Batasi 16 digit
    }

    e.target.value = value;

    const errorEl = document.getElementById('phone_no-error');
    const counterEl = document.getElementById('phone_no-counter');

    // Tampilkan error jika tidak kosong dan < 8
    if ((value.length > 0 && value.length < 8) || value.length > 13) {
        errorEl.classList.remove('d-none');
        e.target.classList.add('is-invalid');
    } else {
        errorEl.classList.add('d-none');
        e.target.classList.remove('is-invalid');
    }

    // Update counter jika ada
    if (counterEl) {
        counterEl.textContent = `${value.length}/8`;
    }
});
</script>
<script>
    $(document).ready(function() {
        $('#unitSelect').select2({
            placeholder: " ",
            allowClear: true,
            width: '100%',
        });
    });
</script>

</body>
</html>

