@extends('layouts.residence.basetemplate')
@section('content')

<style>
:root {
    --primary-color: #2ca25f;
    --primary-light: #99d8c9;
    --primary-lighter: #e5f5f9;
    --gradient-start: #2ca25f;
    --gradient-end: #99d8c9;
}

.cctv-container {
    background: linear-gradient(135deg, var(--primary-lighter) 0%, #ffffff 100%);
    min-height: 100vh;
    padding: 0;
}

/* Header */
.cctv-header {
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    padding: 2rem 1.5rem;
    border-radius: 0 0 24px 24px;
    box-shadow: 0 4px 20px rgba(44, 162, 95, 0.15);
    position: relative;
}

.cctv-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.nav-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    z-index: 1;
}

.nav-back-btn {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.nav-back-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateX(-4px);
}

.header-title {
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    flex: 1;
    text-align: center;
}

.manage-btn {
    padding: 0.625rem 1.25rem;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    color: white;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.manage-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

.monitor-btn {
    padding: 0.625rem 1.25rem;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.95);
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-right: 0.5rem;
}

.monitor-btn:hover {
    background: white;
    transform: scale(1.05);
}

/* Filter Section */
.filter-section {
    padding: 1.5rem 1rem 1rem;
}

.filter-group {
    background: white;
    border-radius: 16px;
    padding: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

.filter-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
    display: block;
}

.filter-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--primary-lighter);
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.filter-select:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 4px rgba(44, 162, 95, 0.1);
}

/* Camera Grid */
.camera-grid {
    padding: 0 1rem 2rem;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.25rem;
}

.camera-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    cursor: pointer;
}

.camera-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(44, 162, 95, 0.15);
}

.camera-preview {
    width: 100%;
    height: 200px;
    background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.camera-icon {
    font-size: 3rem;
    color: rgba(255, 255, 255, 0.3);
}

.live-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: #dc3545;
    color: white;
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.live-dot {
    width: 8px;
    height: 8px;
    background: white;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

.camera-info {
    padding: 1.25rem;
}

.camera-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 0.5rem 0;
}

.camera-location {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #666;
    font-size: 0.9rem;
    margin: 0 0 0.75rem 0;
}

.camera-location i {
    color: var(--primary-color);
}

.camera-description {
    color: #888;
    font-size: 0.85rem;
    margin: 0;
    line-height: 1.5;
}

/* Empty State */
.empty-state {
    padding: 4rem 2rem;
    text-align: center;
}

.empty-icon {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 1rem;
}

.empty-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #666;
    margin: 0 0 0.5rem 0;
}

.empty-text {
    color: #888;
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .camera-grid {
        grid-template-columns: 1fr;
    }
    
    .header-title {
        font-size: 1.25rem;
    }
    
    .manage-btn {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }
}
</style>

<div class="cctv-container">
    <!-- Header -->
    <div class="cctv-header">
        <div class="nav-bar">
            <a href="{{ route('home') }}" class="nav-back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="header-title">
                <i class="fas fa-video"></i> CCTV Surveillance
            </h1>
            <div>
                <a href="{{ route('cctv.monitor') }}" class="monitor-btn">
                    <i class="fas fa-desktop"></i>
                    Monitor
                </a>
                @if($isPengurus)
                <a href="{{ route('cctv.manage') }}" class="manage-btn">
                    <i class="fas fa-cog"></i>
                    Kelola
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    @if($groups->count() > 0)
    <div class="filter-section">
        <div class="filter-group">
            <label class="filter-label">
                <i class="fas fa-filter"></i> Filter Lokasi
            </label>
            <select class="filter-select" id="locationFilter">
                <option value="">Semua Lokasi</option>
                @foreach($groups as $group)
                    <option value="{{ $group }}">{{ $group }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif

    <!-- Camera Grid -->
    @if($cameras->count() > 0)
    <div class="camera-grid" id="cameraGrid">
        @foreach($cameras as $camera)
        <div class="camera-card" data-location="{{ $camera->location_group }}" onclick="window.location.href='{{ route('cctv.show', $camera->id) }}'">
            <div class="camera-preview">
                <i class="fas fa-video camera-icon"></i>
                <span class="live-badge">
                    <span class="live-dot"></span>
                    LIVE
                </span>
            </div>
            <div class="camera-info">
                <h3 class="camera-name">{{ $camera->camera_name }}</h3>
                <p class="camera-location">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ $camera->location_name }}
                </p>
                @if($camera->description)
                <p class="camera-description">{{ $camera->description }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-video-slash empty-icon"></i>
        <h3 class="empty-title">Belum Ada Kamera</h3>
        <p class="empty-text">
            @if($isPengurus)
                Klik tombol "Kelola" untuk menambahkan kamera CCTV
            @else
                Belum ada kamera CCTV yang tersedia saat ini
            @endif
        </p>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filter = document.getElementById('locationFilter');
    const grid = document.getElementById('cameraGrid');
    
    if (filter && grid) {
        filter.addEventListener('change', function() {
            const selectedLocation = this.value;
            const cards = grid.querySelectorAll('.camera-card');
            
            cards.forEach(card => {
                const cardLocation = card.getAttribute('data-location');
                
                if (selectedLocation === '' || cardLocation === selectedLocation) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});
</script>

@endsection
