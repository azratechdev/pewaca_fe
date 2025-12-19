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

.manage-container {
    background: linear-gradient(135deg, var(--primary-lighter) 0%, #ffffff 100%);
    min-height: 100vh;
    padding: 1.5rem 1rem;
}

/* Header */
.page-header {
    max-width: 1280px;
    margin: 0 auto 2rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

@media (min-width: 768px) {
    .page-header {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
}

.header-info h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.header-info p {
    color: #64748b;
    margin: 0.25rem 0 0 0;
    font-size: 0.95rem;
}

.btn-add-camera {
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    color: white;
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    border: none;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(44, 162, 95, 0.25);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-add-camera:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(44, 162, 95, 0.35);
}

/* Toolbar */
.toolbar {
    max-width: 1280px;
    margin: 0 auto 1.5rem;
    background: white;
    padding: 1rem;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid #e2e8f0;
}

.search-box {
    position: relative;
    flex: 1;
}

.search-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 1.25rem;
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    background: #f8fafc;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    background: white;
    box-shadow: 0 0 0 4px rgba(44, 162, 95, 0.1);
}

/* Camera Grid */
.camera-grid {
    max-width: 1280px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
}

.camera-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

.camera-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(44, 162, 95, 0.15);
    border-color: rgba(44, 162, 95, 0.2);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 1rem;
}

.camera-icon-box {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.icon-wrapper {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--primary-lighter) 0%, var(--primary-light) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    font-size: 1.5rem;
}

.camera-name-box h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.location-badge {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    color: #64748b;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.status-badge {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
}

.status-online {
    background: #22c55e;
    box-shadow: 0 0 8px rgba(34, 197, 94, 0.6);
}

.status-offline {
    background: #cbd5e1;
}

.card-details {
    margin-bottom: 1.5rem;
    padding-top: 1rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px dashed #e2e8f0;
    font-size: 0.875rem;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    color: #64748b;
}

.detail-value {
    font-weight: 600;
    color: #334155;
}

.detail-value.protocol {
    font-family: 'Courier New', monospace;
    background: #f1f5f9;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
}

.status-value.online {
    color: #16a34a;
}

.status-value.offline {
    color: #94a3b8;
}

.card-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-configure {
    flex: 1;
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    background: white;
    color: #64748b;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.btn-configure:hover {
    background: #f8fafc;
    color: var(--primary-color);
    border-color: rgba(44, 162, 95, 0.3);
}

.btn-delete {
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 12px;
    background: transparent;
    color: #94a3b8;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-delete:hover {
    color: #ef4444;
    background: rgba(239, 68, 68, 0.1);
}

/* Add New Card */
.add-card {
    border: 2px dashed #cbd5e1;
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 280px;
    color: #94a3b8;
    cursor: pointer;
    transition: all 0.3s ease;
    background: transparent;
}

.add-card:hover {
    border-color: rgba(44, 162, 95, 0.5);
    color: var(--primary-color);
    background: rgba(44, 162, 95, 0.05);
}

.add-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 2rem;
    transition: all 0.3s ease;
}

.add-card:hover .add-icon {
    background: white;
    box-shadow: 0 4px 16px rgba(44, 162, 95, 0.15);
}

.add-text {
    font-weight: 600;
    font-size: 1.125rem;
}

/* Modal */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.modal-overlay.active {
    display: flex;
}

.modal-content {
    background: white;
    border-radius: 24px;
    max-width: 600px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e2e8f0;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.modal-body {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(44, 162, 95, 0.1);
}

.form-check {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.modal-footer {
    padding: 1.5rem 2rem;
    border-top: 1px solid #e2e8f0;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.btn-cancel {
    padding: 0.75rem 1.5rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    background: white;
    color: #64748b;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #f8fafc;
}

.btn-submit {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    color: white;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(44, 162, 95, 0.25);
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(44, 162, 95, 0.35);
}

/* Empty State */
.empty-state {
    max-width: 500px;
    margin: 4rem auto;
    text-align: center;
    padding: 2rem;
}

.empty-icon {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #64748b;
    margin: 0 0 0.5rem 0;
}

.empty-text {
    color: #94a3b8;
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .camera-grid {
        grid-template-columns: 1fr;
    }
    
    .page-header h1 {
        font-size: 1.5rem;
    }
}
</style>

<div class="manage-container">
    <!-- Header -->
    <div class="page-header">
        <div class="header-info">
            <h1><i class="fas fa-video"></i> Camera Management</h1>
            <p>{{ DB::table('m_residence')->where('id', Session::get('warga.residence'))->value('name') ?? 'Residence' }}</p>
        </div>
        <button class="btn-add-camera" onclick="openModal()">
            <i class="fas fa-plus"></i>
            Add Camera
        </button>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="search-box">
            <i class="fas fa-search search-icon"></i>
            <input 
                type="text" 
                class="search-input" 
                placeholder="Search cameras by name or location..."
                id="searchInput"
                onkeyup="filterCameras()"
            />
        </div>
    </div>

    <!-- Camera Grid -->
    @if($cameras->count() > 0)
    <div class="camera-grid" id="cameraGrid">
        @foreach($cameras as $camera)
        <div class="camera-card" data-name="{{ strtolower($camera->camera_name) }}" data-location="{{ strtolower($camera->location_name ?? '') }}">
            <div class="card-header">
                <div class="camera-icon-box">
                    <div class="icon-wrapper">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="camera-name-box">
                        <h3>{{ $camera->camera_name }}</h3>
                        <div class="location-badge">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $camera->location_name ?? 'Unknown' }}
                        </div>
                    </div>
                </div>
                <span class="status-badge {{ $camera->is_active ? 'status-online' : 'status-offline' }}"></span>
            </div>

            <div class="card-details">
                <div class="detail-row">
                    <span class="detail-label">Group</span>
                    <span class="detail-value">{{ $camera->location_group ?? 'Default' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Protocol</span>
                    <span class="detail-value protocol">RTSP / HLS</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status</span>
                    <span class="detail-value {{ $camera->is_active ? 'status-value online' : 'status-value offline' }}">
                        {{ $camera->is_active ? 'Online' : 'Offline' }}
                    </span>
                </div>
            </div>

            <div class="card-actions">
                <button class="btn-configure" onclick="editCamera({{ $camera->id }}, '{{ addslashes($camera->camera_name) }}', '{{ addslashes($camera->location_name) }}', '{{ addslashes($camera->location_group) }}', '{{ addslashes($camera->stream_url) }}', '{{ addslashes($camera->description ?? '') }}', {{ $camera->is_active ? 'true' : 'false' }})">
                    <i class="fas fa-cog"></i>
                    Configure
                </button>
                <button class="btn-delete" onclick="deleteCamera({{ $camera->id }}, '{{ addslashes($camera->camera_name) }}')">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
        @endforeach

        <!-- Add New Card -->
        <button class="add-card" onclick="openModal()">
            <div class="add-icon">
                <i class="fas fa-plus"></i>
            </div>
            <span class="add-text">Add New Camera</span>
        </button>
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-video-slash empty-icon"></i>
        <h3 class="empty-title">No Cameras Yet</h3>
        <p class="empty-text">Click "Add Camera" button to configure your first surveillance device</p>
    </div>
    @endif
</div>

<!-- Modal Form -->
<div class="modal-overlay" id="cameraModal" onclick="if(event.target === this) closeModal()">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Add New Camera</h2>
        </div>
        <form id="cameraForm" method="POST" action="{{ route('cctv.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="camera_id" id="cameraId">
            
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="camera_name">
                        <i class="fas fa-video"></i> Camera Name
                    </label>
                    <input type="text" class="form-control" id="camera_name" name="camera_name" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="location_name">
                        <i class="fas fa-map-marker-alt"></i> Location Name
                    </label>
                    <input type="text" class="form-control" id="location_name" name="location_name" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="location_group">
                        <i class="fas fa-layer-group"></i> Location Group
                    </label>
                    <input type="text" class="form-control" id="location_group" name="location_group" required placeholder="e.g., Main Gate, Parking, Lobby">
                </div>

                <div class="form-group">
                    <label class="form-label" for="stream_url">
                        <i class="fas fa-link"></i> Stream URL (RTSP/HLS)
                    </label>
                    <input type="url" class="form-control" id="stream_url" name="stream_url" required placeholder="rtsp://... or https://...">
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">
                        <i class="fas fa-align-left"></i> Description (Optional)
                    </label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" checked>
                        <span>Camera is active</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-save"></i> Save Camera
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('cameraModal').classList.add('active');
    document.getElementById('cameraForm').reset();
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('cameraForm').action = '{{ route('cctv.store') }}';
    document.getElementById('modalTitle').textContent = 'Add New Camera';
    document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save"></i> Save Camera';
}

function closeModal() {
    document.getElementById('cameraModal').classList.remove('active');
}

function editCamera(id, name, location, group, url, description, isActive) {
    document.getElementById('cameraModal').classList.add('active');
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('cameraId').value = id;
    document.getElementById('cameraForm').action = `/pengurus/cctv/${id}`;
    document.getElementById('modalTitle').textContent = 'Edit Camera';
    document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save"></i> Update Camera';
    
    document.getElementById('camera_name').value = name;
    document.getElementById('location_name').value = location;
    document.getElementById('location_group').value = group;
    document.getElementById('stream_url').value = url;
    document.getElementById('description').value = description;
    document.getElementById('is_active').checked = isActive;
}

function deleteCamera(id, name) {
    if (confirm(`Are you sure you want to delete "${name}"?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/pengurus/cctv/${id}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

function filterCameras() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.camera-card');
    
    cards.forEach(card => {
        const name = card.getAttribute('data-name');
        const location = card.getAttribute('data-location');
        
        if (name.includes(search) || location.includes(search)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Flash messages
@if(session('success'))
    setTimeout(() => {
        alert('{{ session('success') }}');
    }, 100);
@endif

@if($errors->any())
    setTimeout(() => {
        alert('{{ $errors->first() }}');
    }, 100);
@endif
</script>

@endsection
