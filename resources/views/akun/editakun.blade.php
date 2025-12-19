@extends('layouts.residence.basetemplate')
@section('content')

@php
    $imageUrl = $data['residence']['image'] ?? '';
    if (!str_starts_with($imageUrl, 'http://') && !str_starts_with($imageUrl, 'https://')) {
        $imageUrl = env('API_URL') . $imageUrl;
    }
@endphp

<div class="modern-edit-container">
    <!-- Header with Background -->
    <div class="edit-header">
        <div class="header-overlay"></div>
        <img src="{{ $imageUrl }}" class="header-bg-img" alt="{{ $data['residence']['name'] }}">
        
        <!-- Navigation Bar -->
        <div class="nav-bar">
            <a href="{{ route('infoakun') }}" class="nav-back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="nav-title">Edit Profil</h1>
            <a href="{{ route('infoakun') }}" class="nav-cancel-btn">
                Batal
            </a>
        </div>
    </div>

    <!-- Form Content -->
    <div class="edit-content">
        <!-- Residence Info Card -->
        <div class="residence-card">
            <img src="{{ $imageUrl }}" alt="Icon Perumahan" class="residence-icon">
            <span class="residence-name">{{ $data['residence']['name'] }}</span>
        </div>

        @include('layouts.elements.flash')

        <!-- Edit Form -->
        <form id="update_akun" method="post" action="{{ route('akunUpdate') }}" enctype="multipart/form-data" class="edit-form">
            @csrf
            
            <!-- Profile Photo Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-camera"></i>
                    Foto Profil
                </h3>
                
                <div class="photo-edit-container">
                    <div class="current-photo-wrapper">
                        <img 
                            alt="Foto Profil" 
                            class="current-photo" 
                            src="{{ $data['warga']['profile_photo'] }}"
                        />
                        <div class="photo-overlay">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                    
                    <div class="photo-actions">
                        <button type="button" id="change_photo" class="btn-change-photo">
                            <i class="fas fa-image"></i>
                            Ganti Foto
                        </button>
                    </div>
                </div>
                
                <div id="photo_input_container" class="photo-input-wrapper" style="display:none;">
                    <div class="form-group">
                        <label for="profile_photo" class="form-label">
                            <i class="fas fa-upload"></i>
                            Pilih File Gambar
                        </label>
                        <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" id="profile_photo" name="profile_photo" accept="image/jpeg,image/jpg,image/png">
                        <small class="form-hint">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                        @error('profile_photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Personal Information Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    Informasi Pribadi
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="unit_id" class="form-label">
                            <i class="fas fa-home"></i>
                            No Unit
                        </label>
                        <select class="form-control @error('unit_id') is-invalid @enderror" id="unit_id" name="unit_id" required>
                            <option value="" disabled selected hidden>Pilih Unit</option>
                            @foreach ($units as $unit)
                            <option value="{{ $unit['unit_id'] }}" {{ $data['warga']['unit_id']['unit_id'] == $unit['unit_id'] ? 'selected' : '' }}>{{ $unit['unit_name'] }}</option>
                            @endforeach
                        </select>
                        @error('unit_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="full_name" class="form-label">
                            <i class="fas fa-id-card"></i>
                            Nama Lengkap
                        </label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ $data['warga']['full_name'] }}" required>
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone_no" class="form-label">
                            <i class="fas fa-phone"></i>
                            Nomor Telepon
                        </label>
                        <input type="text" pattern="\d{8,13}" minlength="8" maxlength="13" inputmode="numeric" class="form-control no-spinner @error('phone_no') is-invalid @enderror" value="{{ $data['warga']['phone_no']}}" id="phone_no" name="phone_no" required>
                        @error('phone_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender_id" class="form-label">
                            <i class="fas fa-venus-mars"></i>
                            Jenis Kelamin
                        </label>
                        <select class="form-control @error('gender_id') is-invalid @enderror" id="gender_id" name="gender_id" required>
                            <option value="" disabled selected hidden>Pilih Jenis Kelamin</option>
                            @foreach ($genders as $gender)
                            <option value="{{ $gender['id'] }}" {{ $data['warga']['gender_id'] == $gender['id'] ? 'selected' : '' }}>{{ $gender['name'] }}</option>
                            @endforeach
                        </select>
                        @error('gender_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth" class="form-label">
                            <i class="fas fa-calendar"></i>
                            Tanggal Lahir
                        </label>
                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ $data['warga']['date_of_birth'] }}" required>
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="place_of_birth" class="form-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Tempat Lahir
                        </label>
                        <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror" id="place_of_birth" name="place_of_birth" value="{{ $data['warga']['place_of_birth'] }}" required>
                        @error('place_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="religion" class="form-label">
                            <i class="fas fa-praying-hands"></i>
                            Agama
                        </label>
                        <select class="form-control @error('religion') is-invalid @enderror" id="religion" name="religion" required>
                            <option value="" disabled selected hidden>Pilih Agama</option>
                            @foreach ($religions as $religion)
                            <option value="{{ $religion['id'] }}" {{ $data['warga']['religion']['id'] == $religion['id'] ? 'selected' : '' }}>{{ $religion['name'] }}</option>
                            @endforeach
                        </select>
                        @error('religion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="marital_status" class="form-label">
                            <i class="fas fa-heart"></i>
                            Status Pernikahan
                        </label>
                        <select class="form-control @error('marital_status') is-invalid @enderror" id="marital_status" name="marital_status" required>
                            <option value="" disabled selected hidden>Pilih Status</option>
                            @foreach ($statuses as $status)
                            <option value="{{ $status['id'] }}" {{ $data['warga']['marital_status']['id'] == $status['id'] ? 'selected' : '' }}>{{ $status['name'] }}</option>
                            @endforeach
                        </select>
                        @error('marital_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div id="marriagePhotoGroup" class="form-group" style="margin-top: 1rem;">
                    <label for="marriagePhoto" class="form-label">
                        <i class="fas fa-file-certificate"></i>
                        Upload Foto Buku Nikah
                    </label>
                    <input type="file" class="form-control @error('marriagePhoto') is-invalid @enderror" id="marriagePhoto" name="marriagePhoto" accept="image/jpeg,image/jpg,image/png">
                    <small class="form-hint">Hanya untuk status Kawin</small>
                    @error('marriagePhoto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Family & Professional Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-briefcase"></i>
                    Informasi Keluarga & Profesional
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="family_as" class="form-label">
                            <i class="fas fa-users"></i>
                            Status Keluarga
                        </label>
                        <select class="form-control @error('family_as') is-invalid @enderror" id="family_as" name="family_as" required>
                            <option value="" disabled selected hidden>Pilih Status</option>
                            @foreach ($families as $family)
                            <option value="{{ $family['id'] }}" {{ $data['warga']['family_as']['id'] == $family['id'] ? 'selected' : '' }}>{{ $family['name'] }}</option>
                            @endforeach
                        </select>
                        @error('family_as')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="occupation" class="form-label">
                            <i class="fas fa-business-time"></i>
                            Pekerjaan
                        </label>
                        <select class="form-control @error('occupation') is-invalid @enderror" id="occupation" name="occupation" required>
                            <option value="" disabled selected hidden>Pilih Pekerjaan</option>
                            @foreach ($jobs as $job)
                            <option value="{{ $job['id'] }}" {{ $data['warga']['occupation']['id'] == $job['id'] ? 'selected' : '' }}>{{ $job['name'] }}</option>
                            @endforeach
                        </select>
                        @error('occupation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="education" class="form-label">
                            <i class="fas fa-graduation-cap"></i>
                            Pendidikan
                        </label>
                        <select class="form-control @error('education') is-invalid @enderror" id="education" name="education" required>
                            <option value="" disabled selected hidden>Pilih Pendidikan</option>
                            @foreach ($educations as $education)
                            <option value="{{ $education['id'] }}" {{ $data['warga']['education']['id'] == $education['id'] ? 'selected' : '' }}>{{ $education['name'] }}</option>
                            @endforeach
                        </select>
                        @error('education')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-actions">
                <button type="submit" id="submitBtn" class="btn-submit">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Modern Edit Profile Styles */
.modern-edit-container {
    background: linear-gradient(135deg, #e5f5f9 0%, #ffffff 100%);
    min-height: 100vh;
    padding-bottom: 2rem;
}

/* Header Section */
.edit-header {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.header-bg-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.header-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(44, 162, 95, 0.4), rgba(44, 162, 95, 0.7));
    z-index: 1;
}

.nav-bar {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 1.25rem;
    z-index: 2;
}

.nav-back-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.95);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2ca25f;
    font-size: 1.1rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    text-decoration: none;
}

.nav-back-btn:hover {
    background: #2ca25f;
    color: white;
    transform: scale(1.05);
}

.nav-title {
    color: white;
    font-size: 1.25rem;
    font-weight: 600;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    margin: 0;
}

.nav-cancel-btn {
    padding: 0.5rem 1.25rem;
    border-radius: 22px;
    background: rgba(255, 255, 255, 0.95);
    color: #2ca25f;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.nav-cancel-btn:hover {
    background: white;
    transform: scale(1.05);
}

/* Edit Content */
.edit-content {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 1rem;
    margin-top: -40px;
    position: relative;
    z-index: 3;
}

/* Residence Card */
.residence-card {
    background: white;
    border-radius: 16px;
    padding: 1rem 1.5rem;
    box-shadow: 0 4px 16px rgba(44, 162, 95, 0.12);
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    border-left: 4px solid #2ca25f;
}

.residence-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.residence-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2ca25f;
}

/* Form Sections */
.form-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 4px 12px rgba(44, 162, 95, 0.08);
    border-left: 4px solid #99d8c9;
}

.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2ca25f;
    margin: 0 0 1.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #e5f5f9;
}

.section-title i {
    font-size: 1.25rem;
}

/* Profile Photo Section */
.photo-edit-container {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 1rem;
}

.current-photo-wrapper {
    position: relative;
    width: 120px;
    height: 120px;
}

.current-photo {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #99d8c9;
    box-shadow: 0 4px 16px rgba(44, 162, 95, 0.2);
}

.photo-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 50%;
    background: rgba(44, 162, 95, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.current-photo-wrapper:hover .photo-overlay {
    opacity: 1;
}

.photo-overlay i {
    color: white;
    font-size: 2rem;
}

.btn-change-photo {
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    background: linear-gradient(135deg, #2ca25f, #99d8c9);
    color: white;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(44, 162, 95, 0.3);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-change-photo:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(44, 162, 95, 0.4);
}

.btn-change-photo.active {
    background: linear-gradient(135deg, #ffa500, #ff8c00);
}

.photo-input-wrapper {
    margin-top: 1rem;
    padding: 1rem;
    background: linear-gradient(135deg, #e5f5f9 0%, #f8fdff 100%);
    border-radius: 12px;
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
}

@media (min-width: 768px) {
    .form-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Form Group */
.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #2ca25f;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-label i {
    font-size: 1rem;
    color: #99d8c9;
}

.form-control {
    padding: 0.75rem 1rem;
    border: 2px solid #e5f5f9;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.form-control:focus {
    border-color: #2ca25f;
    box-shadow: 0 0 0 3px rgba(44, 162, 95, 0.1);
    outline: none;
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-hint {
    color: #666;
    font-size: 0.85rem;
    margin-top: 0.25rem;
}

/* No Spinner for Number Inputs */
.no-spinner::-webkit-outer-spin-button,
.no-spinner::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.no-spinner {
    -moz-appearance: textfield;
}

/* Submit Button */
.form-actions {
    margin-top: 2rem;
}

.btn-submit {
    width: 100%;
    padding: 1rem 2rem;
    border-radius: 12px;
    background: linear-gradient(135deg, #2ca25f, #99d8c9);
    color: white;
    border: none;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(44, 162, 95, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.btn-submit:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(44, 162, 95, 0.4);
}

.btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-submit i {
    font-size: 1.2rem;
}

/* Responsive */
@media (max-width: 768px) {
    .edit-header {
        height: 180px;
    }
    
    .nav-bar {
        padding: 1.25rem 1rem;
    }
    
    .nav-title {
        font-size: 1rem;
    }
    
    .nav-back-btn {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .nav-cancel-btn {
        padding: 0.4rem 1rem;
        font-size: 0.9rem;
    }
    
    .edit-content {
        padding: 0 0.75rem;
        margin-top: -30px;
    }
    
    .residence-card {
        padding: 0.875rem 1.25rem;
        border-radius: 12px;
    }
    
    .residence-icon {
        width: 32px;
        height: 32px;
    }
    
    .residence-name {
        font-size: 1rem;
    }
    
    .form-section {
        padding: 1.25rem;
        border-radius: 12px;
    }
    
    .section-title {
        font-size: 1rem;
    }
    
    .photo-edit-container {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .current-photo {
        width: 100px;
        height: 100px;
    }
    
    .btn-change-photo {
        width: 100%;
    }
    
    .form-label {
        font-size: 0.85rem;
    }
    
    .form-control,
    .form-select {
        padding: 0.75rem;
        font-size: 0.95rem;
    }
    
    .btn-submit {
        padding: 0.875rem 1.5rem;
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .edit-header {
        height: 160px;
    }
    
    .nav-bar {
        padding: 1rem 0.75rem;
    }
    
    .nav-title {
        font-size: 0.95rem;
    }
    
    .nav-cancel-btn {
        padding: 0.35rem 0.875rem;
        font-size: 0.85rem;
    }
    
    .edit-content {
        margin-top: -25px;
    }
    
    .residence-card {
        padding: 0.75rem 1rem;
    }
    
    .residence-name {
        font-size: 0.95rem;
    }
    
    .form-section {
        padding: 1rem;
    }
    
    .section-title {
        font-size: 0.95rem;
    }
    
    .current-photo {
        width: 90px;
        height: 90px;
    }
}
</style>

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
    document.getElementById("change_photo").addEventListener("click", function(event) {
        event.preventDefault();
        
        let inputContainer = document.getElementById("photo_input_container");
        let inputPhoto = document.getElementById("profile_photo");
        let button = document.getElementById("change_photo");

        if (inputContainer.style.display === "none") {
            inputContainer.style.display = "block";
            inputPhoto.setAttribute("required", "required");
            button.classList.add("active");
            button.innerHTML = '<i class="fas fa-times"></i> Urungkan';
        } else {
            inputContainer.style.display = "none";
            inputPhoto.removeAttribute("required");
            button.classList.remove("active");
            button.innerHTML = '<i class="fas fa-image"></i> Ganti Foto';
        }
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const nikInput = document.getElementById('nik');
    const counterEl = document.getElementById('nik-counter');
    const errorEl = document.getElementById('nik-error');
    const maxLength = 16;

    function updateNik() {
        let value = nikInput.value.replace(/\D/g, '');

        if (value.length > maxLength) {
            value = value.substring(0, maxLength);
        }

        nikInput.value = value;

        if (counterEl) {
            counterEl.textContent = `${value.length}/${maxLength}`;
        }

        if (value.length > 0 && value.length < maxLength) {
            errorEl.classList.remove('d-none');
            nikInput.classList.add('is-invalid');
        } else {
            errorEl.classList.add('d-none');
            nikInput.classList.remove('is-invalid');
        }
    }

    nikInput.addEventListener('input', updateNik);
    updateNik();
});
</script>

@endsection 