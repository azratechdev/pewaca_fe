@extends('layouts.residence.basetemplate')

@section('content')
<!-- Ensure OneSignal SDK is loaded -->
<script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>

<div class="onesignal-test-container">
    <div class="test-header">
        <a href="{{ route('home') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>🔔 OneSignal Test Center</h1>
    </div>

    <div class="test-content">
        @include('layouts.elements.flash')

        <!-- User Info Card -->
        <div class="info-card">
            <h3><i class="fas fa-user"></i> Informasi User</h3>
            <div class="info-item">
                <span class="label">Warga ID:</span>
                <span class="value">{{ $wargaId ?? 'Tidak ada' }}</span>
            </div>
            <div class="info-item">
                <span class="label">OneSignal App ID:</span>
                <span class="value">f3929e4b-b78b-40ce-8376-e1f30b883b46</span>
            </div>
        </div>

        <!-- Subscription Status -->
        <div class="status-card">
            <h3><i class="fas fa-satellite-dish"></i> Status Subscription</h3>
            <div id="subscription-status" class="status-box">
                <div class="spinner"></div>
                <span>Checking subscription...</span>
            </div>
            <div id="subscription-details" class="details-box" style="display: none;">
                <div class="detail-item">
                    <span class="label">Player ID:</span>
                    <span id="player-id" class="value">-</span>
                </div>
                <div class="detail-item">
                    <span class="label">External User ID:</span>
                    <span id="external-id" class="value">-</span>
                </div>
                <div class="detail-item">
                    <span class="label">Permission:</span>
                    <span id="permission" class="value">-</span>
                </div>
            </div>
        </div>

        <!-- Test Actions -->
        <div class="actions-card">
            <h3><i class="fas fa-vial"></i> Test Actions</h3>
            
            <!-- Test Notification Button -->
            <form action="{{ route('test.onesignal.send') }}" method="POST">
                @csrf
                <button type="submit" class="btn-test" id="btn-send-test">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Test Notification
                </button>
            </form>

            <!-- Request Permission Button -->
            <button class="btn-permission" id="btn-request-permission">
                <i class="fas fa-bell"></i>
                Request Notification Permission
            </button>

            <!-- Reload Subscription -->
            <button class="btn-reload" id="btn-reload">
                <i class="fas fa-sync-alt"></i>
                Reload Subscription Status
            </button>
        </div>

        <!-- Instructions -->
        <div class="instructions-card">
            <h3><i class="fas fa-book"></i> Cara Testing</h3>
            <ol>
                <li>
                    <strong>Allow Permission:</strong>
                    <p>Klik tombol "Request Notification Permission" dan izinkan browser untuk mengirim notifikasi.</p>
                </li>
                <li>
                    <strong>Check Status:</strong>
                    <p>Pastikan status subscription menampilkan "Subscribed" dan External User ID sesuai dengan Warga ID Anda.</p>
                </li>
                <li>
                    <strong>Send Test:</strong>
                    <p>Klik "Kirim Test Notification" untuk mengirim test notifikasi ke browser Anda.</p>
                </li>
                <li>
                    <strong>Verify:</strong>
                    <p>Notifikasi akan muncul di browser Anda dalam beberapa detik. Klik notifikasi untuk membuka aplikasi.</p>
                </li>
                <li>
                    <strong>Check Dashboard:</strong>
                    <p>Buka <a href="https://onesignal.com" target="_blank">OneSignal Dashboard</a> → Audience untuk melihat subscriber Anda.</p>
                </li>
            </ol>
        </div>

        <!-- Troubleshooting -->
        <div class="troubleshooting-card">
            <h3><i class="fas fa-tools"></i> Troubleshooting</h3>
            <div class="trouble-item">
                <strong>❌ Permission Denied:</strong>
                <p>Buka browser settings → Site settings → Notifications → Izinkan untuk 127.0.0.1:9000</p>
            </div>
            <div class="trouble-item">
                <strong>❌ Not Subscribed:</strong>
                <p>Pastikan Local Testing Mode sudah enabled di OneSignal dashboard (Configuration → Platforms → Web).</p>
            </div>
            <div class="trouble-item">
                <strong>❌ No Notification:</strong>
                <p>Cek console browser (F12) untuk error. Pastikan App ID sudah benar di .env file.</p>
            </div>
        </div>
    </div>
</div>

<script>
// Wait for OneSignal to be ready
function waitForOneSignal() {
    return new Promise((resolve) => {
        let attempts = 0;
        const maxAttempts = 100; // 10 seconds max
        
        const checkInterval = setInterval(() => {
            attempts++;
            
            if (typeof OneSignal !== 'undefined' && typeof OneSignal.User !== 'undefined') {
                clearInterval(checkInterval);
                console.log('✅ OneSignal SDK ready');
                resolve(true);
            } else if (attempts >= maxAttempts) {
                clearInterval(checkInterval);
                console.error('❌ OneSignal SDK failed to load after 10 seconds');
                resolve(false);
            }
        }, 100);
    });
}

document.addEventListener('DOMContentLoaded', async function() {
    const statusBox = document.getElementById('subscription-status');
    statusBox.innerHTML = '<div class="spinner"></div><span>Loading OneSignal SDK...</span>';
    
    // Wait for OneSignal SDK to load
    const sdkLoaded = await waitForOneSignal();
    
    if (!sdkLoaded) {
        statusBox.innerHTML = '<i class="fas fa-times-circle text-danger"></i> OneSignal SDK gagal dimuat. Silakan refresh halaman.';
        statusBox.className = 'status-box error';
        return;
    }
    
    // Wait for initialization
    await new Promise(resolve => setTimeout(resolve, 1000));
    
    checkSubscriptionStatus();

    // Request Permission Button
    document.getElementById('btn-request-permission').addEventListener('click', async function() {
        try {
            if (typeof OneSignal === 'undefined') {
                alert('OneSignal SDK belum ter-load. Silakan refresh halaman.');
                return;
            }
            
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Requesting...';
            
            await OneSignal.Slidedown.promptPush();
            
            setTimeout(() => {
                checkSubscriptionStatus();
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-bell"></i> Request Notification Permission';
            }, 1500);
        } catch (error) {
            console.error('Error requesting permission:', error);
            alert('Error: ' + error.message);
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-bell"></i> Request Notification Permission';
        }
    });

    // Reload Button
    document.getElementById('btn-reload').addEventListener('click', function() {
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Reloading...';
        
        checkSubscriptionStatus();
        
        setTimeout(() => {
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-sync-alt"></i> Reload Subscription Status';
        }, 1000);
    });
});

async function checkSubscriptionStatus() {
    const statusBox = document.getElementById('subscription-status');
    const detailsBox = document.getElementById('subscription-details');
    
    try {
        // Check if OneSignal is initialized
        if (typeof OneSignal === 'undefined') {
            statusBox.innerHTML = '<i class="fas fa-times-circle text-danger"></i> <strong>OneSignal SDK tidak terdeteksi</strong>';
            statusBox.className = 'status-box error';
            return;
        }

        statusBox.innerHTML = '<div class="spinner"></div><span>Checking subscription...</span>';
        statusBox.className = 'status-box';

        // Get subscription status - wait for initialization
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        const isSubscribed = await OneSignal.User.PushSubscription.optedIn;
        const permission = await OneSignal.Notifications.permission;
        
        // Get Player ID (subscription ID)
        let playerId = 'Not available';
        try {
            const subscriptionId = OneSignal.User.PushSubscription.id;
            const token = OneSignal.User.PushSubscription.token;
            playerId = subscriptionId || token || 'Not available';
        } catch (e) {
            console.warn('Could not get player ID:', e);
        }
        
        // Safe way to get external ID
        let externalId = 'Not set';
        try {
            const userId = OneSignal.User.externalId;
            if (userId) {
                externalId = userId;
            } else {
                // Try to get from onesignalId as fallback
                const onesignalId = OneSignal.User.onesignalId;
                if (onesignalId) {
                    playerId = onesignalId;
                }
            }
        } catch (e) {
            console.warn('Could not get external ID:', e);
        }

        console.log('Subscription check:', { isSubscribed, playerId, externalId, permission });

        if (isSubscribed) {
            statusBox.innerHTML = '<i class="fas fa-check-circle text-success"></i> <strong>Subscribed</strong>';
            statusBox.className = 'status-box success';
            
            document.getElementById('player-id').textContent = playerId;
            document.getElementById('external-id').textContent = externalId;
            document.getElementById('permission').textContent = permission ? 'Granted' : 'Denied';
            
            detailsBox.style.display = 'block';
            
            // Show console info for debugging
            console.log('OneSignal Debug Info:', {
                'Player/OneSignal ID': playerId,
                'External User ID': externalId,
                'Permission': permission,
                'Full User Object': OneSignal.User
            });
        } else {
            statusBox.innerHTML = '<i class="fas fa-exclamation-circle text-warning"></i> <strong>Not Subscribed</strong><br><small>Click "Request Notification Permission" to subscribe</small>';
            statusBox.className = 'status-box warning';
            detailsBox.style.display = 'none';
        }
    } catch (error) {
        console.error('Error checking subscription:', error);
        statusBox.innerHTML = '<i class="fas fa-times-circle text-danger"></i> <strong>Error:</strong> ' + error.message;
        statusBox.className = 'status-box error';
    }
}
</script>

<style>
.onesignal-test-container {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    padding-bottom: 100px;
}

.test-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 1.5rem;
    color: white;
    position: relative;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.back-btn {
    position: absolute;
    top: 1.5rem;
    left: 1rem;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

.test-header h1 {
    margin: 0;
    text-align: center;
    font-size: 1.5rem;
    font-weight: 700;
}

.test-content {
    max-width: 800px;
    margin: -20px auto 0;
    padding: 0 1rem;
}

.info-card, .status-card, .actions-card, .instructions-card, .troubleshooting-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.info-card h3, .status-card h3, .actions-card h3, .instructions-card h3, .troubleshooting-card h3 {
    color: #667eea;
    font-size: 1.1rem;
    font-weight: 700;
    margin: 0 0 1rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-item, .detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 0.5rem;
}

.info-item:last-child, .detail-item:last-child {
    margin-bottom: 0;
}

.label {
    font-weight: 600;
    color: #666;
}

.value {
    font-family: 'Courier New', monospace;
    color: #667eea;
    font-weight: 600;
}

.status-box {
    padding: 1.5rem;
    border-radius: 12px;
    text-align: center;
    font-size: 1.1rem;
    font-weight: 600;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.status-box.success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
}

.status-box.warning {
    background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
    color: #856404;
}

.status-box.error {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
}

.spinner {
    width: 20px;
    height: 20px;
    border: 3px solid rgba(102, 126, 234, 0.3);
    border-top-color: #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.details-box {
    margin-top: 1rem;
}

.btn-test, .btn-permission, .btn-reload {
    width: 100%;
    padding: 1rem;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.btn-test {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-test:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.btn-permission {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(240, 147, 251, 0.3);
}

.btn-permission:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(240, 147, 251, 0.4);
}

.btn-reload {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(79, 172, 254, 0.3);
}

.btn-reload:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(79, 172, 254, 0.4);
}

.instructions-card ol {
    margin: 0;
    padding-left: 1.25rem;
}

.instructions-card li {
    margin-bottom: 1rem;
}

.instructions-card li:last-child {
    margin-bottom: 0;
}

.instructions-card strong {
    color: #667eea;
}

.instructions-card p {
    margin: 0.25rem 0 0 0;
    color: #666;
}

.instructions-card a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
}

.instructions-card a:hover {
    text-decoration: underline;
}

.trouble-item {
    padding: 1rem;
    background: #fff3cd;
    border-left: 4px solid #ffc107;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.trouble-item:last-child {
    margin-bottom: 0;
}

.trouble-item strong {
    display: block;
    color: #856404;
    margin-bottom: 0.5rem;
}

.trouble-item p {
    margin: 0;
    color: #856404;
}

.text-success { color: #28a745; }
.text-warning { color: #ffc107; }
.text-danger { color: #dc3545; }

@media (max-width: 768px) {
    .test-header h1 {
        font-size: 1.25rem;
    }
    
    .info-card, .status-card, .actions-card, .instructions-card, .troubleshooting-card {
        padding: 1.25rem;
    }
}
</style>
@endsection
