@extends('layouts.residence.basetemplate')
@section('content')

<style>
:root {
    --primary-color: #2ca25f;
    --primary-light: #99d8c9;
    --primary-lighter: #e5f5f9;
}

.monitor-container {
    background: #0f172a;
    min-height: 100vh;
    padding: 1rem;
}

/* Header */
.monitor-header {
    max-width: 1920px;
    margin: 0 auto 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-info h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: white;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.header-subtitle {
    color: #94a3b8;
    font-size: 0.95rem;
    margin: 0.25rem 0 0 0;
}

.header-controls {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.back-link {
    padding: 0.75rem 1.25rem;
    background: #1e293b;
    border: 2px solid #334155;
    border-radius: 12px;
    color: #94a3b8;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.back-link:hover {
    background: #334155;
    color: white;
    border-color: #475569;
}

/* Grid Size Selector */
.grid-selector {
    display: flex;
    gap: 0.5rem;
    background: #1e293b;
    padding: 0.5rem;
    border-radius: 12px;
    border: 2px solid #334155;
}

.grid-btn {
    padding: 0.5rem 1rem;
    background: transparent;
    border: none;
    border-radius: 8px;
    color: #94a3b8;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.grid-btn.active {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
}

.grid-btn:hover:not(.active) {
    background: #334155;
    color: white;
}

/* Camera Grid */
.camera-grid-container {
    max-width: 1920px;
    margin: 0 auto;
}

.camera-grid {
    display: grid;
    gap: 1rem;
    grid-template-columns: repeat(1, 1fr);
}

.camera-grid.grid-1 {
    grid-template-columns: repeat(1, 1fr);
}

.camera-grid.grid-2 {
    grid-template-columns: repeat(2, 1fr);
}

.camera-grid.grid-3 {
    grid-template-columns: repeat(3, 1fr);
}

.camera-grid.grid-4 {
    grid-template-columns: repeat(4, 1fr);
}

/* Camera Tile */
.camera-tile {
    background: #1e293b;
    border-radius: 16px;
    overflow: hidden;
    position: relative;
    aspect-ratio: 16 / 9;
    border: 2px solid #334155;
    transition: all 0.3s ease;
}

.camera-tile:hover {
    border-color: var(--primary-color);
    transform: scale(1.02);
    z-index: 10;
}

.video-wrapper {
    width: 100%;
    height: 100%;
    background: #000;
    position: relative;
}

.video-player {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

/* No Signal State */
.no-signal {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #0f172a;
    color: #475569;
}

.no-signal-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.no-signal-text {
    font-weight: 600;
    font-size: 1.125rem;
    margin: 0;
}

.no-signal-url {
    font-size: 0.75rem;
    margin: 0.5rem 0 0 0;
    opacity: 0.7;
    font-family: 'Courier New', monospace;
}

/* Camera Overlay */
.camera-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.8) 0%, transparent 30%, transparent 70%, rgba(0,0,0,0.8) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 1rem;
}

.camera-tile:hover .camera-overlay {
    opacity: 1;
}

.overlay-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
}

.camera-label {
    background: rgba(0, 0, 0, 0.8);
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
}

.camera-name {
    color: white;
    font-weight: 700;
    font-size: 0.95rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.camera-location {
    color: #94a3b8;
    font-size: 0.75rem;
    margin: 0.25rem 0 0 0;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.status-badge {
    background: rgba(0, 0, 0, 0.8);
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-badge.online {
    color: #22c55e;
}

.status-badge.offline {
    color: #94a3b8;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #22c55e;
    box-shadow: 0 0 8px rgba(34, 197, 94, 0.8);
    animation: pulse 2s infinite;
}

.status-badge.offline .status-dot {
    background: #64748b;
    box-shadow: none;
    animation: none;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

/* PTZ Controls Overlay */
.ptz-overlay {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.25rem;
    width: 120px;
}

.ptz-mini-btn {
    width: 36px;
    height: 36px;
    background: rgba(0, 0, 0, 0.8);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 6px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.875rem;
}

.ptz-mini-btn:hover {
    background: var(--primary-color);
    border-color: var(--primary-light);
}

.ptz-mini-btn.center {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
}

/* Empty Slot */
.empty-slot {
    background: #1e293b;
    border: 2px dashed #334155;
    border-radius: 16px;
    aspect-ratio: 16 / 9;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #475569;
}

.empty-icon {
    font-size: 2rem;
    opacity: 0.3;
}

/* Responsive */
@media (max-width: 1024px) {
    .camera-grid.grid-4 {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .camera-grid.grid-3,
    .camera-grid.grid-4 {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .monitor-header {
        flex-direction: column;
        align-items: stretch;
    }
    
    .header-info h1 {
        font-size: 1.25rem;
    }
}

@media (max-width: 480px) {
    .camera-grid.grid-2,
    .camera-grid.grid-3,
    .camera-grid.grid-4 {
        grid-template-columns: repeat(1, 1fr);
    }
}
</style>

<div class="monitor-container">
    <!-- Header -->
    <div class="monitor-header">
        <div class="header-info">
            <h1>
                <i class="fas fa-desktop"></i>
                Live Monitor
            </h1>
            <p class="header-subtitle">Real-time surveillance dashboard</p>
        </div>
        
        <div class="header-controls">
            <a href="{{ route('cctv.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Back to List
            </a>
            
            <div class="grid-selector">
                <button class="grid-btn" onclick="setGridSize(1)">1×1</button>
                <button class="grid-btn active" onclick="setGridSize(2)">2×2</button>
                <button class="grid-btn" onclick="setGridSize(3)">3×3</button>
                <button class="grid-btn" onclick="setGridSize(4)">4×4</button>
            </div>
        </div>
    </div>

    <!-- Camera Grid -->
    <div class="camera-grid-container">
        <div class="camera-grid grid-2" id="cameraGrid">
            @if($cameras->count() > 0)
                @foreach($cameras as $camera)
                <div class="camera-tile">
                    <div class="video-wrapper">
                        @if(Str::startsWith($camera->stream_url, 'rtsp://'))
                            <!-- RTSP Stream - Show no signal -->
                            <div class="no-signal">
                                <i class="fas fa-video-slash no-signal-icon"></i>
                                <p class="no-signal-text">NO SIGNAL</p>
                                <p class="no-signal-url">HLS URL Not Configured</p>
                            </div>
                        @elseif(Str::endsWith($camera->stream_url, '.m3u8'))
                            <!-- HLS Stream -->
                            <video 
                                class="video-player" 
                                autoplay 
                                muted 
                                loop
                                data-camera-id="{{ $camera->id }}"
                            >
                                <source src="{{ $camera->stream_url }}" type="application/x-mpegURL">
                            </video>
                        @else
                            <!-- Direct Video or Image -->
                            <video 
                                class="video-player" 
                                autoplay 
                                muted 
                                loop
                                data-camera-id="{{ $camera->id }}"
                            >
                                <source src="{{ $camera->stream_url }}">
                            </video>
                        @endif
                        
                        <div class="camera-overlay">
                            <div class="overlay-header">
                                <div class="camera-label">
                                    <p class="camera-name">
                                        <i class="fas fa-video"></i>
                                        {{ $camera->camera_name }}
                                    </p>
                                    <p class="camera-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $camera->location_name }}
                                    </p>
                                </div>
                                
                                <div class="status-badge online">
                                    <span class="status-dot"></span>
                                    ONLINE
                                </div>
                            </div>
                            
                            <!-- PTZ Controls (mini) -->
                            <div class="ptz-overlay">
                                <button class="ptz-mini-btn" onclick="ptzControl({{ $camera->id }}, 'up-left')">
                                    <i class="fas fa-arrow-up" style="transform: rotate(-45deg); font-size: 0.75rem;"></i>
                                </button>
                                <button class="ptz-mini-btn" onclick="ptzControl({{ $camera->id }}, 'up')">
                                    <i class="fas fa-arrow-up"></i>
                                </button>
                                <button class="ptz-mini-btn" onclick="ptzControl({{ $camera->id }}, 'up-right')">
                                    <i class="fas fa-arrow-up" style="transform: rotate(45deg); font-size: 0.75rem;"></i>
                                </button>
                                
                                <button class="ptz-mini-btn" onclick="ptzControl({{ $camera->id }}, 'left')">
                                    <i class="fas fa-arrow-left"></i>
                                </button>
                                <button class="ptz-mini-btn center" onclick="ptzControl({{ $camera->id }}, 'home')">
                                    <i class="fas fa-home"></i>
                                </button>
                                <button class="ptz-mini-btn" onclick="ptzControl({{ $camera->id }}, 'right')">
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                                
                                <button class="ptz-mini-btn" onclick="ptzControl({{ $camera->id }}, 'zoom-out')">
                                    <i class="fas fa-search-minus"></i>
                                </button>
                                <button class="ptz-mini-btn" onclick="ptzControl({{ $camera->id }}, 'down')">
                                    <i class="fas fa-arrow-down"></i>
                                </button>
                                <button class="ptz-mini-btn" onclick="ptzControl({{ $camera->id }}, 'zoom-in')">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <!-- Fill empty slots based on grid size -->
                <div class="empty-slot" style="display: none;" data-empty-slot>
                    <i class="fas fa-video-slash empty-icon"></i>
                </div>
            @else
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; color: #64748b;">
                    <i class="fas fa-video-slash" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p style="font-size: 1.25rem; font-weight: 600;">No Active Cameras</p>
                    <p style="opacity: 0.7;">Add cameras from the management page to start monitoring</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
let currentGridSize = 2;

function setGridSize(size) {
    currentGridSize = size;
    const grid = document.getElementById('cameraGrid');
    
    // Remove all grid classes
    grid.classList.remove('grid-1', 'grid-2', 'grid-3', 'grid-4');
    
    // Add new grid class
    grid.classList.add('grid-' + size);
    
    // Update active button
    document.querySelectorAll('.grid-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Calculate total slots needed
    const totalSlots = size * size;
    const cameraTiles = document.querySelectorAll('.camera-tile').length;
    const emptySlots = document.querySelectorAll('[data-empty-slot]');
    
    // Hide all empty slots first
    emptySlots.forEach(slot => {
        slot.style.display = 'none';
    });
    
    // Show empty slots if needed
    const slotsToShow = totalSlots - cameraTiles;
    if (slotsToShow > 0) {
        for (let i = 0; i < Math.min(slotsToShow, emptySlots.length); i++) {
            emptySlots[i].style.display = 'flex';
        }
        
        // Create additional empty slots if needed
        for (let i = emptySlots.length; i < slotsToShow; i++) {
            const slot = document.createElement('div');
            slot.className = 'empty-slot';
            slot.setAttribute('data-empty-slot', '');
            slot.innerHTML = '<i class="fas fa-video-slash empty-icon"></i>';
            grid.appendChild(slot);
        }
    }
}

function ptzControl(cameraId, action) {
    console.log('PTZ Control - Camera:', cameraId, 'Action:', action);
    // TODO: Implement PTZ API call
}

// HLS.js support
document.addEventListener('DOMContentLoaded', function() {
    const videos = document.querySelectorAll('.video-player');
    
    videos.forEach(video => {
        const source = video.querySelector('source');
        if (source && source.type === 'application/x-mpegURL') {
            if (video.canPlayType('application/vnd.apple.mpegurl')) {
                // Native HLS support (Safari)
                console.log('Native HLS support for camera', video.dataset.cameraId);
            } else {
                // Load HLS.js
                if (typeof Hls === 'undefined') {
                    const script = document.createElement('script');
                    script.src = 'https://cdn.jsdelivr.net/npm/hls.js@latest';
                    script.onload = function() {
                        initHls(video, source.src);
                    };
                    document.head.appendChild(script);
                } else {
                    initHls(video, source.src);
                }
            }
        }
    });
});

function initHls(video, url) {
    if (Hls.isSupported()) {
        const hls = new Hls({
            enableWorker: true,
            lowLatencyMode: true
        });
        hls.loadSource(url);
        hls.attachMedia(video);
        console.log('HLS.js initialized for', url);
    }
}

// Initialize grid size on load
setTimeout(() => {
    const activeBtn = document.querySelector('.grid-btn.active');
    if (activeBtn) {
        activeBtn.click();
    }
}, 100);
</script>

@endsection
