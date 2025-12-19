@extends('layouts.residence.basetemplate')

@section('content')
@php
    $imageUrl = $data['residence']['image'] ?? '';
    if (!str_starts_with($imageUrl, 'http://') && !str_starts_with($imageUrl, 'https://')) {
        $imageUrl = env('API_URL') . $imageUrl;
    }
@endphp

<div class="modern-profile-container">
    <!-- Header with Background Image -->
    <div class="profile-header">
        <div class="header-overlay"></div>
        <img src="{{ $imageUrl }}" class="header-bg-img" alt="{{ $data['residence']['name'] }}">
        
        <!-- Navigation Bar -->
        <div class="nav-bar">
            <a href="{{ route('akun') }}" class="nav-back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="nav-title">Informasi Akun</h1>
            <a href="{{ route('akunEdit') }}" class="nav-edit-btn">
                <i class="fas fa-user-edit"></i>
            </a>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="profile-content">
        @include('layouts.elements.flash')
        
        <!-- Profile Photo & Main Info Card -->
        <div class="profile-main-card">
            <div class="profile-photo-wrapper">
                <img 
                    alt="{{ $data['warga']['full_name'] }}" 
                    class="profile-photo" 
                    src="{{ $data['warga']['profile_photo'] ?? asset('assets/plugins/images/default.jpg') }}"
                />
                <div class="profile-photo-ring"></div>
            </div>
            
            <div class="profile-main-info">
                <h2 class="profile-name">{{ $data['warga']['full_name'] }}</h2>
                <p class="profile-unit">
                    <i class="fas fa-home"></i> 
                    {{ $data['warga']['unit_id']['unit_name'] ?? 'Nomor Unit' }}
                </p>
                <p class="profile-residence">{{ $data['residence']['name'] }}</p>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="info-grid">
            <!-- Contact Information -->
            <div class="info-section">
                <h3 class="section-title">
                    <i class="fas fa-address-card"></i>
                    Informasi Kontak
                </h3>
                <div class="info-items">
                    <div class="info-item">
                        <div class="item-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <p class="item-label">Email</p>
                            <p class="item-value">{{ $data['user']['email'] }}</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="item-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <p class="item-label">No. Ponsel</p>
                            <p class="item-value">{{ $data['warga']['phone_no'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="info-section">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    Informasi Pribadi
                </h3>
                <div class="info-items">
                    <div class="info-item">
                        <div class="item-icon">
                            <i class="fas fa-venus-mars"></i>
                        </div>
                        <div>
                            <p class="item-label">Jenis Kelamin</p>
                            <p class="item-value">
                                @if($data['warga']['gender_id'] == 1)
                                    Laki-laki
                                @else
                                    Perempuan
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="item-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div>
                            <p class="item-label">Tanggal Lahir</p>
                            <p class="item-value">{{ $data['warga']['date_of_birth'] ?? '00-00-0000'}}</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="item-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <p class="item-label">Tempat Lahir</p>
                            <p class="item-value">{{ $data['warga']['place_of_birth'] ?? 'Anonim'}}</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="item-icon">
                            <i class="fas fa-praying-hands"></i>
                        </div>
                        <div>
                            <p class="item-label">Agama</p>
                            <p class="item-value">{{ $data['warga']['religion']['name']}}</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="item-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div>
                            <p class="item-label">Status Pernikahan</p>
                            <p class="item-value">{{ $data['warga']['marital_status']['name']}}</p>
                        </div>
                    </div>

                    @if($data['warga']['marital_status']['id'] == '1' && $data['warga']['marriagePhoto'] != null)
                        <div class="info-item marriage-cert">
                            <div class="item-icon">
                                <i class="fas fa-file-certificate"></i>
                            </div>
                            <div>
                                <p class="item-label">Buku Nikah</p>
                                <img 
                                    alt="Buku Nikah" 
                                    class="marriage-photo" 
                                    src="{{ $data['warga']['marriagePhoto'] }}"
                                />
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Professional Information -->
            <div class="info-section">
                <h3 class="section-title">
                    <i class="fas fa-briefcase"></i>
                    Informasi Profesional
                </h3>
                <div class="info-items">
                    <div class="info-item">
                        <div class="item-icon">
                            <i class="fas fa-business-time"></i>
                        </div>
                        <div>
                            <p class="item-label">Pekerjaan</p>
                            <p class="item-value">{{ $data['warga']['occupation']['name'] }}</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="item-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <p class="item-label">Pendidikan</p>
                            <p class="item-value">{{ $data['warga']['education']['name'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $cred = Session::get('cred');
                $roleMode = Session::get('role_mode', 'warga');
                $isPengurus = isset($cred['is_pengurus']);
            @endphp

            @if($isPengurus)
            <!-- Role Switcher Section (Only for dual-role users) -->
            <div class="info-section role-switcher-section">
                <h3 class="section-title">
                    <i class="fas fa-user-shield"></i>
                    Switch Akun
                </h3>
                <div class="role-switcher-container">
                    <div class="role-info">
                        <p class="role-description">
                            Anda memiliki akses sebagai <strong>Warga</strong> dan <strong>Pengurus</strong>.
                            Gunakan tombol di bawah untuk beralih antara kedua role.
                        </p>
                        <div class="current-role-badge">
                            @if($roleMode === 'pengurus')
                                <i class="fas fa-user-shield"></i>
                                Mode saat ini: <span class="role-name pengurus">Pengurus</span>
                            @else
                                <i class="fas fa-user"></i>
                                Mode saat ini: <span class="role-name warga">Warga</span>
                            @endif
                        </div>
                    </div>
                    
                    <form action="{{ route('akunSwitchRole') }}" method="POST" class="switch-form">
                        @csrf
                        <button type="submit" class="btn-switch-role">
                            @if($roleMode === 'pengurus')
                                <i class="fas fa-exchange-alt"></i>
                                Switch ke Mode Warga
                            @else
                                <i class="fas fa-exchange-alt"></i>
                                Switch ke Mode Pengurus
                            @endif
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

<style>
/* Modern Profile Styles */
.modern-profile-container {
    background: linear-gradient(135deg, #e5f5f9 0%, #ffffff 100%);
    min-height: 100vh;
    padding-bottom: 2rem;
}

/* Header Section */
.profile-header {
    position: relative;
    height: 280px;
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
    background: linear-gradient(to bottom, rgba(44, 162, 95, 0.3), rgba(44, 162, 95, 0.6));
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

.nav-back-btn,
.nav-edit-btn {
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

.nav-back-btn:hover,
.nav-edit-btn:hover {
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

/* Profile Content */
.profile-content {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 1rem;
    margin-top: -80px;
    position: relative;
    z-index: 3;
}

/* Main Card */
.profile-main-card {
    background: white;
    border-radius: 20px;
    padding: 2rem 1.5rem 1.5rem;
    box-shadow: 0 8px 24px rgba(44, 162, 95, 0.12);
    text-align: center;
    margin-bottom: 1.5rem;
    border-top: 4px solid #2ca25f;
}

.profile-photo-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
}

.profile-photo {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid white;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    position: relative;
    z-index: 2;
}

.profile-photo-ring {
    position: absolute;
    top: -8px;
    left: -8px;
    right: -8px;
    bottom: -8px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2ca25f, #99d8c9);
    z-index: 1;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 0.6;
        transform: scale(1);
    }
    50% {
        opacity: 0.8;
        transform: scale(1.05);
    }
}

.profile-main-info {
    padding-top: 0.5rem;
}

.profile-name {
    font-size: 1.75rem;
    font-weight: 700;
    color: #2ca25f;
    margin: 0 0 0.5rem 0;
}

.profile-unit {
    font-size: 1rem;
    color: #666;
    margin: 0.25rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.profile-unit i {
    color: #99d8c9;
}

.profile-residence {
    font-size: 0.95rem;
    color: #888;
    margin: 0.25rem 0 0 0;
}

/* Info Sections */
.info-grid {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.info-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(44, 162, 95, 0.08);
    border-left: 4px solid #99d8c9;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.info-section:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(44, 162, 95, 0.15);
}

.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2ca25f;
    margin: 0 0 1.25rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #e5f5f9;
}

.section-title i {
    font-size: 1.25rem;
}

.info-items {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem;
    border-radius: 10px;
    background: linear-gradient(135deg, #e5f5f9 0%, #f8fdff 100%);
    transition: background 0.3s ease;
}

.info-item:hover {
    background: linear-gradient(135deg, #99d8c9 0%, #e5f5f9 100%);
}

.item-icon {
    width: 40px;
    height: 40px;
    min-width: 40px;
    flex-shrink: 0;
    border-radius: 10px;
    background: linear-gradient(135deg, #2ca25f, #99d8c9);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    box-shadow: 0 4px 8px rgba(44, 162, 95, 0.2);
}

.item-icon i {
    line-height: 1;
    display: block;
}

.item-label {
    font-size: 0.85rem;
    color: #666;
    margin: 0 0 0.25rem 0;
    font-weight: 500;
}

.item-value {
    font-size: 1rem;
    color: #2ca25f;
    margin: 0;
    font-weight: 600;
}

.marriage-photo {
    margin-top: 0.5rem;
    border-radius: 8px;
    max-width: 200px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .edit-header {
        height: 220px;
    }
    
    .nav-title {
        font-size: 1rem;
    }
    
    .nav-back-btn,
    .nav-edit-btn {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .profile-content {
        padding: 0 0.75rem;
        margin-top: -60px;
    }
    
    .profile-main-card {
        padding: 1.5rem 1rem;
        border-radius: 16px;
    }
    
    .profile-photo {
        width: 100px;
        height: 100px;
    }
    
    .profile-name {
        font-size: 1.4rem;
    }
    
    .profile-unit {
        font-size: 0.9rem;
    }
    
    .profile-residence {
        font-size: 0.85rem;
    }
    
    .info-section {
        padding: 1.25rem;
        border-radius: 12px;
    }
    
    .section-title {
        font-size: 1rem;
    }
    
    .item-icon {
        width: 36px;
        height: 36px;
        min-width: 36px;
        font-size: 0.9rem;
    }
    
    .item-label {
        font-size: 0.8rem;
    }
    
    .item-value {
        font-size: 0.95rem;
    }
    
    .marriage-photo {
        max-width: 150px;
    }
}

@media (max-width: 480px) {
    .profile-header {
        height: 200px;
    }
    
    .nav-bar {
        padding: 1rem;
    }
    
    .nav-title {
        font-size: 0.95rem;
    }
    
    .profile-content {
        margin-top: -50px;
    }
    
    .profile-main-card {
        padding: 1.25rem 0.875rem;
    }
    
    .profile-photo {
        width: 90px;
        height: 90px;
    }
    
    .profile-name {
        font-size: 1.25rem;
    }
    
    .info-section {
        padding: 1rem;
    }
    
    .section-title {
        font-size: 0.95rem;
    }

    .btn-switch-role {
        padding: 0.875rem 1.5rem;
        font-size: 0.95rem;
    }
}

/* Role Switcher Styles */
.role-switcher-section {
    background: linear-gradient(135deg, #fff3e0 0%, #ffffff 100%) !important;
    border-left: 4px solid #ff9800 !important;
}

.role-switcher-container {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.role-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.role-description {
    font-size: 0.95rem;
    color: #555;
    line-height: 1.6;
    margin: 0;
}

.role-description strong {
    color: #ff9800;
    font-weight: 600;
}

.current-role-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.25rem;
    background: linear-gradient(135deg, #ff9800, #ffb74d);
    color: white;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
    width: fit-content;
}

.current-role-badge i {
    font-size: 1.25rem;
}

.role-name {
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    background: rgba(255, 255, 255, 0.25);
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
}

.switch-form {
    margin: 0;
}

.btn-switch-role {
    width: 100%;
    padding: 1rem 1.75rem;
    background: linear-gradient(135deg, #2ca25f, #66bb6a);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(44, 162, 95, 0.3);
}

.btn-switch-role:hover {
    background: linear-gradient(135deg, #238b50, #4caf50);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(44, 162, 95, 0.4);
}

.btn-switch-role:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(44, 162, 95, 0.3);
}

.btn-switch-role i {
    font-size: 1.1rem;
    animation: switchIcon 2s infinite;
}

@keyframes switchIcon {
    0%, 100% {
        transform: rotate(0deg);
    }
    50% {
        transform: rotate(180deg);
    }
}
</style>