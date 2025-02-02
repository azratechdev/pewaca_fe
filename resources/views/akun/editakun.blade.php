@extends('layouts.residence.basetemplate')
@section('content')
<style>
.no-spinner::-webkit-outer-spin-button,
.no-spinner::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.no-spinner {
    -moz-appearance: textfield;
}

/* CSS untuk ikon mata */
#togglePassword {
    background-color: transparent;
    border: none;
}

#togglePassword:hover {
    color: #0e0e0e; /* Warna saat hover */
}

/* CSS untuk input group */
.input-group {
    position: relative;
    display: flex;
    align-items: stretch;
    width: 100%;
}


</style>
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center mt-2">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-800">
                        <a href="{{ route('infoakun') }}" class="text-dark">
                            <i class="fas fa-arrow-left"></i>
                        </a>&nbsp;&nbsp;&nbsp;&nbsp;Update Akun
                    </h1>
                </div>
                
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-800">
                        <a href="{{ route('infoakun') }}" class="text-dark" title="Edit Akun">
                            Batal
                        </a>
                    </h1>
                </div>
            </div>
        </div>
        <br>
        <div class="pl-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold">
                        <span class="text-dark">
                            <i class="fas fa-home" style="color:lightgreen;"></i>
                        </span>&nbsp;&nbsp;&nbsp;&nbsp;{{ $data['residence']['name'] }}
                    </h1>
                </div>
            </div>
        </div>
        <br>
        <div class="p-6 pt-0">
            @include('layouts.elements.flash')
            <form id="update_akun" method="post" action="{{ route('akunUpdate') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-floating mb-3">
                   
                        <img 
                        alt="Belum ada" 
                        class="profile-picture rounded w-32 h-32" 
                        src="{{ $data['warga']['profile_photo'] }}"
                    />
                   
                    <a id="change_photo" href="#" class="btn btn-sm btn-success">Ganti Photo</a>
                </div>
                
                <div class="form-floating mb-3" style="display:none;">
                    <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" id="profile_photo" name="profile_photo" accept="image/jpeg,image/jpg">
                    <label for="profile_photo">Upload Foto Profil</label>
                    @error('profile_photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select  @error('unit_id') is-invalid @enderror" id="unit_id" name="unit_id" required>
                        <option value="" disabled selected hidden>-Pilih Unit-</option>
                        @foreach ($units as $unit )
                        <option value="{{ $unit['unit_id'] }}" {{ $data['warga']['unit_id']['unit_id'] == $unit['unit_id'] ? 'selected' : '' }}>{{ $unit['unit_name'] }}</option>
                        @endforeach
                    </select>
                    <label for="noUnit">No Unit</label>
                    @error('unit_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="form-floating mb-3">
                    <input type="number" pattern="[0-9]*" class="form-control @error('nik') is-invalid @enderror no-spinner" value="{{ str_replace(' ', '', $data['warga']['nik']) }}" id="nik" name="nik" placeholder=" " required>
                    <label for="nik">NIK</label>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder=" " value="{{ $data['warga']['full_name'] }}" required>
                    <label for="full_name ">Nama Lengkap</label>
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                                    
                <div class="form-floating mb-3">
                    <input type="number" class="form-control @error('phone_no') is-invalid @enderror no-spinner" pattern="[0-9]{8,13}" value="{{ $data['warga']['phone_no']}}" id="phone_no" name="phone_no" placeholder=" " required>
                    <label for="phone_no ">Nomor Telepon</label>
                    @error('phone_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="form-floating mb-3">
                    <select class="form-select" id="gender_id" name="gender_id" required>
                        <option value="" disabled selected hidden>-Pilih Jenis Kelamin-</option>
                        @foreach ($genders as $gender)
                        <option value="{{ $gender['id'] }}" {{ $data['warga']['gender_id'] == $gender['id'] ? 'selected' : '' }}>{{ $gender['name'] }}</option>
                        @endforeach
                    </select>
                    <label for="gender_id ">Jenis Kelamin</label>
                </div>
            
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $data['warga']['date_of_birth'] }}"  placeholder=" " required>
                    <label for="date_of_birth ">Tanggal Lahir</label>
                </div>
            
                <div class="form-floating mb-3">
                    <select class="form-select" id="religion" name="religion" required>
                        <option value="" disabled selected hidden>-Pilih Agama-</option>
                        @foreach ($religions as $religion )
                        <option value="{{ $religion['id'] }}" {{ $data['warga']['religion']['id'] ==  $religion['id'] ? 'selected' : '' }}>{{ $religion['name'] }}</option>
                        @endforeach
                    </select>
                    <label for="religion">Agama</label>
                </div>
            
                <div class="form-floating mb-3">
                    <input type="text" id="place_of_birth" class="form-control" value="{{ $data['warga']['place_of_birth'] }}" name="place_of_birth" placeholder=" " required>
                    <label for="place_of_birth ">Tempat Lahir</label>
                </div>
            
                <div class="form-floating mb-3">
                    <select class="form-select" id="marital_status" name="marital_status" required>
                        <option value="" disabled selected hidden>-Pilih Status-</option>
                        @foreach ($statuses as $status )
                        <option value="{{ $status['id'] }}" {{ $data['warga']['marital_status']['id'] == $status['id'] ? 'selected' : '' }}>{{ $status['name'] }}</option>
                        @endforeach
                    </select>
                    <label for="marital_status">Status</label>
                </div>
            
                {{-- <div class="form-floating mb-3" id="marriagePhotoGroup" style="display: none;">
                    <input type="file" class="form-control @error('marriagePhoto') is-invalid @enderror" id="marriagePhoto" name="marriagePhoto" accept="image/jpeg,image/jpg">
                    <label for="marriagePhoto">Upload Foto Buku Nikah</label>
                    @error('marriagePhoto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}

                <div class="form-floating mb-3">
                    <select class="form-select" id="family_as" name="family_as" required>
                        <option value="" disabled selected hidden>-Pilih Sebagai-</option>
                        @foreach ($families as $family)
                        <option value="{{ $family['id'] }}" {{ $data['warga']['family_as']['id'] == $family['id'] ? 'selected' : '' }}>{{ $family['name'] }}</option>
                        @endforeach
                    </select>
                    <label for="family_as">Family As</label>
                </div>
            
                <div class="form-floating mb-3">
                    <select class="form-select" id="occupation" name="occupation" required>
                        <option value="" disabled selected hidden>-Pilih Pekerjaan-</option>
                        @foreach ($jobs as $job)
                        <option value="{{ $job['id'] }}" {{ $data['warga']['occupation']['id'] == $job['id'] ? 'selected' : '' }}>{{ $job['name'] }}</option>
                        @endforeach
                    </select>
                    <label for="occupation ">Pekerjaan</label>
                </div>
            
                <div class="form-floating mb-3">
                    <select class="form-select" id="education" name="education" required>
                        <option value="" disabled selected hidden>-Pilih Pendidikan-</option>
                        @foreach ($educations as $education)
                        <option value="{{ $education['id'] }}" {{ $data['warga']['education']['id'] == $education['id'] ? 'selected' : '' }}>{{ $education['name'] }}</option>
                        @endforeach
                    </select>
                    <label for="education">Pendidikan</label>
                </div>
            
                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $data['user']['email'] }}" id="email" name="email" placeholder=" " required>
                    <label for="email">Alamat Email</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" value="" id="password" name="password" placeholder="">
                    <label for="password">Buat Kata Sandi</label>
                
                    @error('password')
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
                {{-- <div class="input-group">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" value="" id="password" name="password" placeholder="">
                        <label for="password">Buat Kata Sandi</label>
                        
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group-text" id="togglePassword" style="cursor: pointer;">
                        <i class="fas fa-eye"></i>
                    </div>
                </div> --}}
                

                {{-- <div class="form-floating mb-3">
                    <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" id="profile_photo" name="profile_photo" accept="image/jpeg,image/jpg">
                    <label for="profile_photo">Upload Foto Profil</label>
                    @error('profile_photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}

                <br>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" id="submitBtn" class="btn btn-success form-control">Update</button>
                    </div>
                </div>
            </form>
        </div>    
    </div>    
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('#update_akun').on('submit', function(e) {
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

<script>
     
    const form = document.getElementById('update_akun');
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
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const showPasswordCheckbox = document.getElementById('showPasswordCheckbox');

        
        if (showPasswordCheckbox.checked) {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
  </script>
{{-- <script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        const val = document.getElementById('password').value;

        if (passwordInput.type === 'password' && val !== "") {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash'); 
        }
        else if (passwordInput.type === 'text' && val !== ""){
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye'); 
        }
        else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    });
</script> --}}
  
@endsection 