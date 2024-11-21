<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/pewaca-green.jpeg') }}">
  <title>Pewaca</title>
  
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   
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
                            <p class="text-left" style="font-size: 1.2em;">Pendaftaran Warga</p>
                            <p  style="font-size: 1.0em;">Teras Country Residence</p>
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
                                <select class="form-select  @error('unit_id') is-invalid @enderror" id="unit_id" name="unit_id" required>
                                    <option value="" disabled selected hidden>-Pilih Unit-</option>
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
                                <input type="number" pattern="[0-9]*" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" id="nik" name="nik" placeholder=" " required>
                                <label for="nik">NIK</label>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="full_name" name="full_name" placeholder=" " value="{{ old('full_name') }}" required>
                                <label for="full_name ">Nama Lengkap</label>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                                                
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control @error('phone_no') is-invalid @enderror" pattern="[0-9]{8,13}" value="{{ old('phone_no') }}" id="phone_no" name="phone_no" placeholder=" " required>
                                <label for="phone_no ">Nomor Telepon</label>
                                @error('phone_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="form-floating mb-3">
                                <select class="form-select" id="gender_id" name="gender_id" required>
                                    <option value="" disabled selected hidden>-Pilih Jenis Kelamin-</option>
                                    @foreach ($genders as $gender)
                                    <option value="{{ $gender['id'] }}" {{ old('gender_id') == $gender['id'] ? 'selected' : '' }}>{{ $gender['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="gender_id ">Jenis Kelamin</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}"  placeholder=" " required>
                                <label for="date_of_birth ">Tanggal Lahir</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <select class="form-select" id="religion" name="religion" required>
                                    <option value="" disabled selected hidden>-Pilih Agama-</option>
                                    @foreach ($religions as $religion )
                                    <option value="{{ $religion['id'] }}" {{ old('religion') ==  $religion['id'] ? 'selected' : '' }}>{{ $religion['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="religion">Agama</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <input type="text" id="place_of_birth" class="form-control" value="{{ old('place_of_birth') }}" name="place_of_birth" placeholder=" " required>
                                <label for="place_of_birth ">Tempat Lahir</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <select class="form-select" id="marital_status" name="marital_status" required>
                                    <option value="" disabled selected hidden>-Pilih Status-</option>
                                    @foreach ($statuses as $status )
                                    <option value="{{ $status['id'] }}" {{ old('marital_status') == $status['id'] ? 'selected' : '' }}>{{ $status['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="marital_status">Status</label>
                            </div>
                        
                            <div class="form-floating mb-3" id="marriagePhotoGroup" style="display: none;">
                                <input type="file" class="form-control @error('marriagePhoto') is-invalid @enderror" id="marriagePhoto" name="marriagePhoto" accept="image/jpeg,image/jpg">
                                <label for="marriagePhoto">Upload Foto Buku Nikah</label>
                                @error('marriagePhoto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="form-floating mb-3">
                                <select class="form-select" id="occupation" name="occupation" required>
                                    <option value="" disabled selected hidden>-Pilih Pekerjaan-</option>
                                    @foreach ($jobs as $job)
                                    <option value="{{ $job['id'] }}" {{ old('occupation') == $job['id'] ? 'selected' : '' }}>{{ $job['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="occupation ">Pekerjaan</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <select class="form-select" id="education" name="education" required>
                                    <option value="" disabled selected hidden>-Pilih Pendidikan-</option>
                                    @foreach ($educations as $education)
                                    <option value="{{ $education['id'] }}" {{ old('education') == $education['id'] ? 'selected' : '' }}>{{ $education['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="education">Pendidikan</label>
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
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" id="profile_photo" name="profile_photo" accept="image/jpeg,image/jpg">
                                <label for="profile_photo">Upload Foto Profil</label>
                                @error('profile_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
  <!-- JS Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
   
        $('#registrasi').on('submit', function(e) {
            Swal.fire({
                title: 'Memproses Data',
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
        $( document ).ready(function() {
         
            const statusSelect = document.getElementById('marital_status');
            const marriagePhotoGroup = document.getElementById('marriagePhotoGroup');
            const marriagePhotoInput = document.getElementById('marriagePhoto');

            if (statusSelect) {
                function toggleMarriagePhotoInput() {
                    const selectedStatus = statusSelect.value;
                    if (selectedStatus === '1') {
                        marriagePhotoGroup.style.display = 'block';
                        marriagePhotoInput.setAttribute('required', 'required');
                    } else {
                        marriagePhotoGroup.style.display = 'none';
                        marriagePhotoInput.removeAttribute('required');
                    }
                }

                statusSelect.addEventListener('change', toggleMarriagePhotoInput);
                toggleMarriagePhotoInput();
            } else {
                console.error("Element with ID 'marital_status' not found.");
            }
        });
    </script>
</body>
</html>

