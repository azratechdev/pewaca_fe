@extends('layouts.residence.basetemplate')
@section('content')

<style>
:root {
    --primary-color: #2ca25f;
    --primary-light: #99d8c9;
    --primary-lighter: #e5f5f9;
}

.show-container {
    background: linear-gradient(135deg, var(--primary-lighter) 0%, #ffffff 100%);
    min-height: 100vh;
    padding: 1rem;
}

.camera-viewer {
    max-width: 1280px;
    margin: 0 auto;
}

/* Header */
.viewer-header {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid #e2e8f0;
}

.header-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.back-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    color: #64748b;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.back-button:hover {
    background: #f8fafc;
    color: var(--primary-color);
    border-color: rgba(44, 162, 95, 0.3);
}

.status-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: #f0fdf4;
    border-radius: 12px;
    font-weight: 600;
    color: #16a34a;
}

.status-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #22c55e;
    box-shadow: 0 0 8px rgba(34, 197, 94, 0.6);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.camera-info h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 0.5rem 0;
}

.camera-meta {
    display: flex;
    gap: 1.5rem;
    color: #64748b;
    font-size: 0.95rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.meta-item i {
    color: var(--primary-color);
}

/* Video Player */
.video-container {
    background: #000;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    margin-bottom: 1.5rem;
    position: relative;
    aspect-ratio: 16 / 9;
}

.video-player {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.5) 0%, transparent 20%, transparent 80%, rgba(0,0,0,0.5) 100%);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 1.5rem;
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.video-container:hover .video-overlay {
    opacity: 1;
    pointer-events: all;
}

.overlay-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
}

.camera-label {
    background: rgba(0, 0, 0, 0.7);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    color: white;
    font-weight: 600;
}

.fullscreen-btn {
    background: rgba(0, 0, 0, 0.7);
    color: white;
    border: none;
    padding: 0.75rem;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.25rem;
    transition: all 0.3s ease;
}

.fullscreen-btn:hover {
    background: rgba(44, 162, 95, 0.9);
}

/* PTZ Controls */
.ptz-controls {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid #e2e8f0;
    margin-bottom: 1.5rem;
}

.controls-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 1rem 0;
}

.ptz-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.5rem;
    max-width: 300px;
    margin: 0 auto;
}

.ptz-btn {
    padding: 1rem;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    color: #64748b;
    font-size: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.ptz-btn:hover {
    background: var(--primary-lighter);
    color: var(--primary-color);
    border-color: rgba(44, 162, 95, 0.3);
}

.ptz-btn:active {
    transform: scale(0.95);
}

.ptz-btn.disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.ptz-btn.center {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
    border-color: transparent;
}

.zoom-controls {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    margin-top: 1rem;
}

.zoom-btn {
    padding: 0.75rem 1.5rem;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    color: #64748b;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.zoom-btn:hover {
    background: var(--primary-lighter);
    color: var(--primary-color);
    border-color: rgba(44, 162, 95, 0.3);
}

/* Camera Details */
.camera-details {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid #e2e8f0;
}

.details-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 1rem 0;
}

.detail-grid {
    display: grid;
    gap: 1rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px dashed #e2e8f0;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-label {
    color: #64748b;
    font-weight: 600;
}

.detail-value {
    color: #334155;
    font-weight: 600;
}

.detail-value.url {
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
    color: var(--primary-color);
    word-break: break-all;
}

/* Responsive */
@media (max-width: 768px) {
    .camera-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .header-top {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .camera-info h1 {
        font-size: 1.25rem;
    }
}
</style>

<div class="show-container">
    <div class="camera-viewer">
        <!-- Header -->
        <div class="viewer-header">
            <div class="header-top">
                <a href="{{ route('cctv.index') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                    Back to All Cameras
                </a>
                <div class="status-indicator">
                    <span class="status-dot"></span>
                    Live
                </div>
            </div>
            
            <div class="camera-info">
                <h1><i class="fas fa-video"></i> {{ $camera->camera_name }}</h1>
                <div class="camera-meta">
                    <div class="meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $camera->location_name }}
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-layer-group"></i>
                        {{ $camera->location_group }}
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-clock"></i>
                        {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Video Player -->
        <div class="video-container" id="videoContainer">
            @if(Str::startsWith($camera->stream_url, 'rtsp://'))
                <!-- RTSP Stream - Need to convert to HLS -->
                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: white; text-align: center;">
                    <div>
                        <i class="fas fa-video-slash" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p>RTSP stream requires conversion to HLS</p>
                        <small style="opacity: 0.7;">{{ $camera->stream_url }}</small>
                    </div>
                </div>
            @elseif(Str::endsWith($camera->stream_url, '.m3u8'))
                <!-- HLS Stream -->
                <video 
                    class="video-player" 
                    id="videoPlayer" 
                    controls 
                    autoplay 
                    muted
                >
                    <source src="{{ $camera->stream_url }}" type="application/x-mpegURL">
                    Your browser does not support HLS video playback.
                </video>
            @else
                <!-- Direct Video URL -->
                <video 
                    class="video-player" 
                    id="videoPlayer" 
                    controls 
                    autoplay 
                    muted
                >
                    <source src="{{ $camera->stream_url }}">
                    Your browser does not support video playback.
                </video>
            @endif
            
            <div class="video-overlay">
                <div class="overlay-header">
                    <div class="camera-label">
                        {{ $camera->camera_name }}
                    </div>
                    <button class="fullscreen-btn" onclick="toggleFullscreen()">
                        <i class="fas fa-expand"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- PTZ Controls -->
        <div class="ptz-controls">
            <h3 class="controls-title"><i class="fas fa-gamepad"></i> PTZ Controls</h3>
            
            <div class="ptz-grid">
                <button class="ptz-btn disabled" onclick="ptzControl('up-left')">
                    <i class="fas fa-arrow-up" style="transform: rotate(-45deg);"></i>
                </button>
                <button class="ptz-btn" onclick="ptzControl('up')">
                    <i class="fas fa-arrow-up"></i>
                </button>
                <button class="ptz-btn disabled" onclick="ptzControl('up-right')">
                    <i class="fas fa-arrow-up" style="transform: rotate(45deg);"></i>
                </button>
                
                <button class="ptz-btn" onclick="ptzControl('left')">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <button class="ptz-btn center" onclick="ptzControl('home')">
                    <i class="fas fa-home"></i>
                </button>
                <button class="ptz-btn" onclick="ptzControl('right')">
                    <i class="fas fa-arrow-right"></i>
                </button>
                
                <button class="ptz-btn disabled" onclick="ptzControl('down-left')">
                    <i class="fas fa-arrow-down" style="transform: rotate(45deg);"></i>
                </button>
                <button class="ptz-btn" onclick="ptzControl('down')">
                    <i class="fas fa-arrow-down"></i>
                </button>
                <button class="ptz-btn disabled" onclick="ptzControl('down-right')">
                    <i class="fas fa-arrow-down" style="transform: rotate(-45deg);"></i>
                </button>
            </div>
            
            <div class="zoom-controls">
                <button class="zoom-btn" onclick="ptzControl('zoom-in')">
                    <i class="fas fa-search-plus"></i>
                    Zoom In
                </button>
                <button class="zoom-btn" onclick="ptzControl('zoom-out')">
                    <i class="fas fa-search-minus"></i>
                    Zoom Out
                </button>
            </div>
        </div>

        <!-- Camera Details -->
        <div class="camera-details">
            <h3 class="details-title"><i class="fas fa-info-circle"></i> Camera Details</h3>
            
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Camera Name</span>
                    <span class="detail-value">{{ $camera->camera_name }}</span>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Location</span>
                    <span class="detail-value">{{ $camera->location_name }}</span>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Location Group</span>
                    <span class="detail-value">{{ $camera->location_group }}</span>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Stream URL</span>
                    <span class="detail-value url">{{ $camera->stream_url }}</span>
                </div>
                
                @if($camera->description)
                <div class="detail-item">
                    <span class="detail-label">Description</span>
                    <span class="detail-value">{{ $camera->description }}</span>
                </div>
                @endif
                
                <div class="detail-item">
                    <span class="detail-label">Status</span>
                    <span class="detail-value" style="color: #16a34a;">
                        <i class="fas fa-circle" style="font-size: 0.5rem;"></i> Active
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFullscreen() {
    const container = document.getElementById('videoContainer');
    
    if (!document.fullscreenElement) {
        container.requestFullscreen().catch(err => {
            console.error('Error attempting to enable fullscreen:', err);
        });
    } else {
        document.exitFullscreen();
    }
}

function ptzControl(action) {
    console.log('PTZ Control:', action);
    // TODO: Implement PTZ control via API
    // This would typically send commands to the camera's API endpoint
    
    // Show feedback
    const btn = event.target.closest('.ptz-btn');
    if (btn && !btn.classList.contains('disabled')) {
        btn.style.transform = 'scale(0.95)';
        setTimeout(() => {
            btn.style.transform = '';
        }, 100);
    }
}

// HLS.js support for browsers that don't natively support HLS
const video = document.getElementById('videoPlayer');
if (video && video.canPlayType('application/vnd.apple.mpegurl')) {
    // Native HLS support (Safari)
    console.log('Native HLS support detected');
} else if (video) {
    // Try to load HLS.js for other browsers
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/hls.js@latest';
    script.onload = function() {
        if (Hls.isSupported()) {
            const hls = new Hls();
            hls.loadSource(video.querySelector('source').src);
            hls.attachMedia(video);
            console.log('HLS.js initialized');
        }
    };
    document.head.appendChild(script);
}
</script>

@endsection
