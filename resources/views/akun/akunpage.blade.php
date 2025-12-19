@extends('layouts.residence.basetemplate')
@section('content')

<style>
/* Modern Account Page Styles */
:root {
    --primary-color: #2ca25f;
    --primary-light: #99d8c9;
    --primary-lighter: #e5f5f9;
    --gradient-start: #2ca25f;
    --gradient-end: #99d8c9;
}

.account-container {
    background: linear-gradient(135deg, var(--primary-lighter) 0%, #ffffff 100%);
    min-height: 100vh;
    padding: 0;
}

/* Header Section */
.account-header {
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    padding: 2.5rem 1.5rem 3rem;
    position: relative;
    border-radius: 0 0 24px 24px;
    box-shadow: 0 4px 20px rgba(44, 162, 95, 0.15);
}

.account-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.header-title {
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 1.5rem 0;
    position: relative;
    z-index: 1;
    text-align: center;
}

/* Profile Card */
.profile-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    margin: -2rem 1rem 1.5rem;
    box-shadow: 0 8px 24px rgba(44, 162, 95, 0.1);
    display: flex;
    align-items: center;
    gap: 1.25rem;
    position: relative;
    z-index: 2;
}

.profile-avatar {
    position: relative;
}

.profile-photo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--primary-lighter);
}

.profile-info {
    flex: 1;
}

.profile-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 0.25rem 0;
}

.profile-email {
    color: #666;
    font-size: 0.9rem;
    margin: 0;
}

/* Menu Section */
.menu-container {
    padding: 0 1rem 2rem;
}

.menu-section {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    margin-bottom: 1.5rem;
}

.section-header {
    padding: 1rem 1.25rem;
    background: linear-gradient(135deg, var(--primary-lighter) 0%, #f8fdff 100%);
    border-bottom: 2px solid var(--primary-lighter);
}

.section-title {
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--primary-color);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
}

.menu-item {
    display: flex;
    align-items: center;
    padding: 1.25rem 1.5rem;
    text-decoration: none;
    color: #1a1a1a;
    transition: all 0.3s ease;
    border-bottom: 1px solid #f0f0f0;
    position: relative;
}

.menu-item:last-child {
    border-bottom: none;
}

.menu-item:hover {
    background: linear-gradient(90deg, var(--primary-lighter) 0%, transparent 100%);
    transform: translateX(4px);
}

.menu-item.disabled {
    opacity: 0.5;
    pointer-events: none;
    cursor: not-allowed;
}

.menu-item.logout-item {
    color: #dc3545;
}

.menu-item.logout-item:hover {
    background: linear-gradient(90deg, #ffe5e5 0%, transparent 100%);
}

.menu-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.menu-item:hover .menu-icon {
    transform: scale(1.1);
}

.menu-icon.icon-primary {
    background: linear-gradient(135deg, var(--primary-lighter) 0%, var(--primary-light) 100%);
    color: var(--primary-color);
}

.menu-icon.icon-info {
    background: linear-gradient(135deg, #e3f2fd 0%, #90caf9 100%);
    color: #1976d2;
}

.menu-icon.icon-faq {
    background: linear-gradient(135deg, #fff3e0 0%, #ffb74d 100%);
    color: #f57c00;
}

.menu-icon.icon-policy {
    background: linear-gradient(135deg, #f3e5f5 0%, #ce93d8 100%);
    color: #7b1fa2;
}

.menu-icon.icon-contact {
    background: linear-gradient(135deg, #e8f5e9 0%, #81c784 100%);
    color: #388e3c;
}

.menu-icon.icon-logout {
    background: linear-gradient(135deg, #ffebee 0%, #ef9a9a 100%);
    color: #c62828;
}

.menu-content {
    flex: 1;
    margin-left: 1rem;
}

.menu-label {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
    color: #1a1a1a;
}

.menu-description {
    font-size: 0.8rem;
    color: #666;
    margin: 0;
}

.menu-arrow {
    color: #ccc;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.menu-item:hover .menu-arrow {
    color: var(--primary-color);
    transform: translateX(4px);
}

/* Responsive */
@media (max-width: 768px) {
    .account-header {
        padding: 2rem 1rem 2.5rem;
        border-radius: 0 0 20px 20px;
    }
    
    .header-title {
        font-size: 1.25rem;
    }
    
    .profile-card {
        margin: -1.5rem 1rem 1.25rem;
        padding: 1.25rem;
    }
    
    .profile-photo {
        width: 70px;
        height: 70px;
    }
    
    .profile-name {
        font-size: 1.1rem;
    }
    
    .menu-icon {
        width: 44px;
        height: 44px;
        font-size: 1.1rem;
    }
    
    .menu-item {
        padding: 1rem 1.25rem;
    }
}

@media (max-width: 480px) {
    .profile-card {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-info {
        width: 100%;
    }
}
</style>

<div class="account-container">
    <!-- Header -->
    <div class="account-header">
        <h1 class="header-title">
            <i class="fas fa-user-circle"></i> Pengaturan Akun
        </h1>
    </div>

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-avatar">
            <img 
                class="profile-photo" 
                src="{{ $warga['profile_photo'] ?? asset('assets/plugins/images/default.jpg')}}" 
                alt="{{ $warga['full_name'] }}"
            />
        </div>
        <div class="profile-info">
            <h2 class="profile-name">{{ $warga['full_name'] }}</h2>
            <p class="profile-email">{{ $user['email'] ?? 'Email tidak tersedia' }}</p>
        </div>
    </div>

    <!-- Menu Container -->
    <div class="menu-container">
        @php
            $isPengurus = Session::get('cred.is_pengurus') ?? false;
            $isChecker = Session::get('warga.is_checker') ?? false;
        @endphp

        <!-- Account Section -->
        <div class="menu-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-user-cog"></i> Akun & Profil
                </h3>
            </div>
            
            @if($isPengurus)
            <a class="menu-item" href="{{ route('inforekening') }}">
                <div class="menu-icon icon-primary">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="menu-content">
                    <p class="menu-label">Info Rekening</p>
                    <p class="menu-description">Kelola rekening perumahan</p>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
            @endif

            <a class="menu-item {{ (!$isPengurus && !$isChecker) ? 'disabled' : '' }}" 
                href="{{ (!$isPengurus && !$isChecker) ? '#' : '/infoakun' }}">
                <div class="menu-icon icon-info">
                    <i class="fas fa-user"></i>
                </div>
                <div class="menu-content">
                    <p class="menu-label">Info Akun</p>
                    <p class="menu-description">Lihat dan edit profil Anda</p>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
        </div>

        <!-- Support Section -->
        <div class="menu-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-life-ring"></i> Bantuan & Dukungan
                </h3>
            </div>
            
            <a class="menu-item {{ (!$isPengurus && !$isChecker) ? 'disabled' : '' }}" 
                href="{{ (!$isPengurus && !$isChecker) ? '#' : '/faq' }}">
                <div class="menu-icon icon-faq">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="menu-content">
                    <p class="menu-label">FAQ</p>
                    <p class="menu-description">Pertanyaan yang sering diajukan</p>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>

            <a class="menu-item {{ (!$isPengurus && !$isChecker) ? 'disabled' : '' }}" 
                href="{{ (!$isPengurus && !$isChecker) ? '#' : '/policy' }}">
                <div class="menu-icon icon-policy">
                    <i class="fas fa-gavel"></i>
                </div>
                <div class="menu-content">
                    <p class="menu-label">Kebijakan Privasi</p>
                    <p class="menu-description">Baca kebijakan privasi kami</p>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>

            <a class="menu-item {{ (!$isPengurus && !$isChecker) ? 'disabled' : '' }}" 
                href="{{ (!$isPengurus && !$isChecker) ? '#' : '/kontak' }}">
                <div class="menu-icon icon-contact">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="menu-content">
                    <p class="menu-label">Hubungi Kami</p>
                    <p class="menu-description">Dapatkan bantuan dari tim kami</p>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
        </div>

        <!-- Logout Section -->
        <div class="menu-section">
            <a class="menu-item logout-item" href="{{ route('log_out') }}">
                <div class="menu-icon icon-logout">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <div class="menu-content">
                    <p class="menu-label">Logout</p>
                    <p class="menu-description">Keluar dari akun Anda</p>
                </div>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </a>
        </div>
    </div>
</div>

  
  
@endsection 