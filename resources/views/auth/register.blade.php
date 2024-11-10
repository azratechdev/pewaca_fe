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

 
    /* Remove border radius for left-aligned select2 */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px;
    }

    .select2-container .select2-selection--single {
        height: calc(2em + 0.75rem + 2px) !important; /* Sesuaikan ukuran tinggi */
        padding: 0.375rem 0.75rem !important;
        border: 1px solid #ccc !important;
        border-radius: 4px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: calc(2em + 0.75rem) !important;
        color: #333;
    }

    /* Hapus border tambahan */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
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
                            <p>Teras Country Residence</p>
                            <p style="font-size:1vw;">Mohon lengkapi data untuk persyaratan menjadi warga<p>
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
                                <select class="form-select" id="unit_id" name="unit_id" required>
                                    <option value="" disabled selected hidden>-Pilih Unit-</option>
                                    @foreach ($units as $unit )
                                    <option value="{{ $unit['unit_id'] }}">{{ $unit['unit_name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="noUnit">No Unit</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nik" name="nik" placeholder=" " required>
                                <label for="nik">NIK</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="full_name" name="full_name" placeholder=" " required>
                                <label for="full_name ">Nama Lengkap</label>
                            </div>
                                                
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="phone_no" name="phone_no" min="8" max="13" placeholder=" " required>
                                {{-- <input type="text" class="form-control" id="phone" name="phone" pattern="^\+62[0-9]{8,13}$" placeholder=" " required> --}}
                                <label for="phone_no ">Nomor Telepon</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <select class="form-select" id="gender_id" name="gender_id" required>
                                    <option value="" disabled selected hidden>-Pilih Jenis Kelamin-</option>
                                    @foreach ($genders as $gender)
                                    <option value="{{ $gender['id'] }}">{{ $gender['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="gender_id ">Jenis Kelamin</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" placeholder=" " required>
                                <label for="date_of_birth ">Tanggal Lahir</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <select class="form-select" id="religion" name="religion" required>
                                    <option value="" disabled selected hidden>-Pilih Agama-</option>
                                    @foreach ($religions as $religion )
                                    <option value="{{ $religion['id'] }}">{{ $religion['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="religion">Agama</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <select class="form-select" id="place_of_birth" name="place_of_birth" required>
                                    <option value="" disabled selected hidden>-Pilih Tempat Lahir-</option>
                                    @foreach ($cities as $city )
                                    <option value="{{ $city['id'] }}">{{ $city['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="place_of_birth ">Tempat Lahir</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <select class="form-select" id="marital_status" name="marital_status" required>
                                    <option value="" disabled selected hidden>-Pilih Status-</option>
                                    @foreach ($statuses as $status )
                                    <option value="{{ $status['id'] }}">{{ $status['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="marital_status">Status</label>
                            </div>
                        
                            <div class="form-floating mb-3" id="marriagePhotoGroup" style="display: none;">
                                <input type="file" class="form-control" id="marriagePhoto" name="marriagePhoto">
                                <label for="marriagePhoto">Upload Foto Buku Nikah</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <select class="form-select" id="occupation" name="occupation" required>
                                    <option value="" disabled selected hidden>-Pilih Pekerjaan-</option>
                                    @foreach ($jobs as $job)
                                    <option value="{{ $job['id'] }}">{{ $job['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="occupation ">Pekerjaan</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <select class="form-select" id="education" name="education" required>
                                    <option value="" disabled selected hidden>-Pilih Pendidikan-</option>
                                    @foreach ($educations as $education)
                                    <option value="{{ $education['id'] }}">{{ $education['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="education">Pendidikan</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder=" " required>
                                <label for="email">Alamat Email</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder=" " required>
                                <label for="password">Buat Kata Sandi</label>
                            </div>

                            <div class="form-floating mb-3">
                                <select class="form-select" id="family_as" name="family_as" required>
                                    <option value="" disabled selected hidden>-Pilih Sebagai-</option>
                                    @foreach ($families as $family)
                                    <option value="{{ $family['id'] }}">{{ $family['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="family_as">Family As</label>
                            </div>
                        
                            <div class="form-floating mb-3">
                                <input type="file" class="form-control" id="profile_photo" name="profile_photo">
                                <label for="profile_photo">Upload Foto Profil</label>
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

    @if(session('status') == 'success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session("message") }}'
            });
        </script>
     @elseif(session('status') == 'error')
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session("message") }}'
            });
        </script>
    @endif

  <!-- Tambahkan jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
  <!-- JS Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS Select2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  
    <script>
        // Ambil elemen form dan tombol submit
        const form = document.getElementById('registrasi');
        const submitBtn = document.getElementById('submitBtn');
        
        // Fungsi untuk memeriksa apakah semua field required terisi
        function checkFormValidity() {
            // Memeriksa apakah semua input dengan atribut required terisi
            const isValid = [...form.querySelectorAll('input[required], select[required]')].every(input => {
                // Pastikan field tidak kosong
                if (input.type === 'file') {
                    return input.files.length > 0 || input.optional; // Periksa jika input file kosong
                }
                return input.value.trim() !== '';
            });
            
            // Aktifkan atau nonaktifkan tombol submit berdasarkan hasil validasi
            submitBtn.disabled = !isValid;
        }

        // Pasang event listener pada form untuk memantau perubahan pada input
        form.addEventListener('input', checkFormValidity);

        // Inisialisasi status tombol submit saat pertama kali dimuat
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

        // Contoh penggunaan ketika form di-post
        document.getElementById("registrasi").addEventListener("submit", function(event) {
            const id = document.getElementById("code").value;
            if (!validateUUID(id)) {
                event.preventDefault();
                alert("Invalid ID format!");
            }
        });
   
    </script>

    <script>
        $( document ).ready(function() {
            // Mendapatkan elemen yang dibutuhkan
            const statusSelect = document.getElementById('marital_status');
            console.log(statusSelect);
            const marriagePhotoGroup = document.getElementById('marriagePhotoGroup');
            const marriagePhotoInput = document.getElementById('marriagePhoto');

             // Cek apakah statusSelect ditemukan
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

