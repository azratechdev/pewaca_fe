<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registration Testing Tool - Pewaca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .test-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .response-box {
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 1rem;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            max-height: 400px;
            overflow-y: auto;
            margin-top: 1rem;
        }
        .success-badge {
            background: #10b981;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
        }
        .error-badge {
            background: #ef4444;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
        }
        .nav-pills .nav-link {
            color: #667eea;
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
        }
        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .btn-test {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            transition: all 0.3s;
        }
        .btn-test:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 0.5rem;
        }
        .status-success { background: #10b981; }
        .status-error { background: #ef4444; }
        .status-pending { background: #f59e0b; }
        pre {
            margin: 0;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .master-data-table {
            max-height: 400px;
            overflow-y: auto;
        }
        .copy-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
        }
        .response-container {
            position: relative;
        }
    </style>
</head>
<body>
    <div class="header-section">
        <div class="container">
            <h1><i class="fas fa-flask"></i> Registration Testing Tool</h1>
            <p class="mb-0">Test API endpoints untuk skenario registrasi warga Pewaca</p>
        </div>
    </div>

    <div class="container">
        <ul class="nav nav-pills mb-4" id="testTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="master-data-tab" data-bs-toggle="pill" data-bs-target="#master-data" type="button">
                    <i class="fas fa-database"></i> Master Data
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="residence-tab" data-bs-toggle="pill" data-bs-target="#residence" type="button">
                    <i class="fas fa-building"></i> Residence & Units
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="registration-tab" data-bs-toggle="pill" data-bs-target="#registration" type="button">
                    <i class="fas fa-user-plus"></i> Registration
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="verification-tab" data-bs-toggle="pill" data-bs-target="#verification" type="button">
                    <i class="fas fa-check-circle"></i> Verification
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="login-tab" data-bs-toggle="pill" data-bs-target="#login" type="button">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </li>
        </ul>

        <div class="tab-content" id="testTabsContent">
            <!-- Master Data Tab -->
            <div class="tab-pane fade show active" id="master-data" role="tabpanel">
                <div class="test-card">
                    <h4><i class="fas fa-database"></i> Load All Master Data</h4>
                    <p class="text-muted">Test loading semua master data untuk dropdown registration form</p>
                    <button class="btn btn-test" onclick="loadAllMasterData()">
                        <i class="fas fa-download"></i> Load All Master Data
                    </button>
                    <div id="masterDataResults" class="mt-4"></div>
                </div>
            </div>

            <!-- Residence & Units Tab -->
            <div class="tab-pane fade" id="residence" role="tabpanel">
                <div class="test-card">
                    <h4><i class="fas fa-building"></i> Get Residence by Code</h4>
                    <p class="text-muted">Test endpoint GET /api/residence-by-code/{code}/</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Registration UUID Code</label>
                        <input type="text" class="form-control" id="residenceCode" value="350c228d-2121-47fd-a808-456a7523e527" placeholder="UUID residence code">
                        <small class="text-danger">⚠️ Harus UUID (bukan ID numerik seperti 1, 2, 3)</small>
                    </div>
                    <button class="btn btn-test" onclick="getResidenceByCode()">
                        <i class="fas fa-search"></i> Get Residence
                    </button>
                    <div class="response-container">
                        <div id="residenceResponse"></div>
                    </div>
                </div>

                <div class="test-card mt-4">
                    <h4><i class="fas fa-home"></i> Get Units by Code</h4>
                    <p class="text-muted">Test endpoint GET /api/units/code/{code}/</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Registration UUID Code</label>
                        <input type="text" class="form-control" id="unitsCode" value="350c228d-2121-47fd-a808-456a7523e527" placeholder="UUID residence code">
                    </div>
                    <button class="btn btn-test" onclick="getUnitsByCode()">
                        <i class="fas fa-search"></i> Get Units
                    </button>
                    <div class="response-container">
                        <div id="unitsResponse"></div>
                    </div>
                </div>
            </div>

            <!-- Registration Tab -->
            <div class="tab-pane fade" id="registration" role="tabpanel">
                <div class="test-card">
                    <h4><i class="fas fa-user-plus"></i> Test Registration</h4>
                    <p class="text-muted">Test endpoint POST /api/auth/sign-up/{code}/</p>
                    
                    <form id="registrationForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">UUID Code *</label>
                                <input type="text" class="form-control" name="code" value="350c228d-2121-47fd-a808-456a7523e527" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" value="test.warga.{{ time() }}@example.com" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password *</label>
                                <input type="password" class="form-control" name="password" value="TestPassword123" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIK (16 digit) *</label>
                                <input type="text" class="form-control" name="nik" value="3174010112900{{ substr(time(), -3) }}" pattern="\d{16}" maxlength="16" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name *</label>
                                <input type="text" class="form-control" name="full_name" value="Test Warga Auto" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number *</label>
                                <input type="text" class="form-control" name="phone_no" value="08123456{{ substr(time(), -4) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Gender ID *</label>
                                <input type="number" class="form-control" name="gender_id" value="1" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date of Birth *</label>
                                <input type="date" class="form-control" name="date_of_birth" value="1990-01-15" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Place of Birth *</label>
                                <input type="text" class="form-control" name="place_of_birth" value="Jakarta" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Religion ID *</label>
                                <input type="number" class="form-control" name="religion" value="1" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Unit ID *</label>
                                <input type="number" class="form-control" name="unit_id" value="1" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Marital Status *</label>
                                <input type="number" class="form-control" name="marital_status" value="1" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Occupation ID *</label>
                                <input type="number" class="form-control" name="occupation" value="1" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Education ID *</label>
                                <input type="number" class="form-control" name="education" value="1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Family Role ID *</label>
                                <input type="number" class="form-control" name="family_as" value="1" required>
                            </div>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> <strong>Note:</strong> File upload dinonaktifkan untuk testing. Ukuran foto max 2MB untuk avoid error 413.
                        </div>

                        <button type="submit" class="btn btn-test">
                            <i class="fas fa-paper-plane"></i> Submit Registration
                        </button>
                    </form>
                    <div class="response-container">
                        <div id="registrationResponse"></div>
                    </div>
                </div>
            </div>

            <!-- Verification Tab -->
            <div class="tab-pane fade" id="verification" role="tabpanel">
                <div class="test-card">
                    <h4><i class="fas fa-envelope"></i> Resend Verification Email</h4>
                    <p class="text-muted">Test endpoint POST /api/auth/verify/resend/</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="resendEmail" placeholder="test.warga@example.com">
                    </div>
                    <button class="btn btn-test" onclick="resendVerification()">
                        <i class="fas fa-paper-plane"></i> Resend Verification
                    </button>
                    <div class="response-container">
                        <div id="resendResponse"></div>
                    </div>
                </div>

                <div class="test-card mt-4">
                    <h4><i class="fas fa-check-circle"></i> Verify Email</h4>
                    <p class="text-muted">Test endpoint GET /api/auth/verify/{uidb64}/{token}/</p>
                    
                    <div class="mb-3">
                        <label class="form-label">UID Base64</label>
                        <input type="text" class="form-control" id="uidb64" placeholder="MQ">
                        <small class="text-muted">Dari email verification link</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Token</label>
                        <input type="text" class="form-control" id="verifyToken" placeholder="abc123-def456">
                        <small class="text-muted">Dari email verification link</small>
                    </div>
                    <button class="btn btn-test" onclick="verifyEmail()">
                        <i class="fas fa-check"></i> Verify Email
                    </button>
                    <div class="response-container">
                        <div id="verifyResponse"></div>
                    </div>
                </div>
            </div>

            <!-- Login Tab -->
            <div class="tab-pane fade" id="login" role="tabpanel">
                <div class="test-card">
                    <h4><i class="fas fa-sign-in-alt"></i> Test Login</h4>
                    <p class="text-muted">Test endpoint POST /api/auth/login/</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="loginEmail" value="pengurus1@gmail.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="loginPassword" placeholder="Your password">
                    </div>
                    <button class="btn btn-test" onclick="testLogin()">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                    <div class="response-container">
                        <div id="loginResponse"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const API_BASE = '/test/registration/api';

        function showResponse(elementId, data, success = true) {
            const element = document.getElementById(elementId);
            const badge = success ? 
                '<span class="success-badge"><i class="fas fa-check"></i> Success</span>' : 
                '<span class="error-badge"><i class="fas fa-times"></i> Error</span>';
            
            const jsonStr = JSON.stringify(data, null, 2);
            element.innerHTML = `
                <div class="mt-3">
                    ${badge}
                    <div class="response-box">
                        <button class="btn btn-sm btn-outline-light copy-btn" onclick="copyToClipboard('${elementId}')">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                        <pre>${jsonStr}</pre>
                    </div>
                </div>
            `;
        }

        function copyToClipboard(elementId) {
            const element = document.getElementById(elementId);
            const pre = element.querySelector('pre');
            navigator.clipboard.writeText(pre.textContent);
            alert('Copied to clipboard!');
        }

        async function loadAllMasterData() {
            const btn = event.target;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';

            try {
                const response = await fetch(`${API_BASE}/master-data/all`);
                const data = await response.json();
                
                let html = '<div class="row">';
                const masterTypes = ['gender', 'religions', 'family_as', 'education', 'occupation', 'marital_statuses'];
                
                for (const type of masterTypes) {
                    const items = data.data[type] || [];
                    html += `
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <strong>${type.toUpperCase()}</strong>
                                    <span class="badge bg-light text-dark float-end">${items.length} items</span>
                                </div>
                                <div class="card-body master-data-table">
                                    <table class="table table-sm">
                                        <tbody>
                                            ${items.map(item => {
                                                const id = item.id || item.gender_id || item.unit_id || 'N/A';
                                                const name = item.religion_name || item.gender_name || item.family_as_name || 
                                                           item.education_name || item.occupation_name || item.marital_status_name || 'Unknown';
                                                return `<tr><td><strong>${id}</strong></td><td>${name}</td></tr>`;
                                            }).join('')}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    `;
                }
                html += '</div>';
                document.getElementById('masterDataResults').innerHTML = html;
                
            } catch (error) {
                document.getElementById('masterDataResults').innerHTML = 
                    `<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Error: ${error.message}</div>`;
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-download"></i> Load All Master Data';
            }
        }

        async function getResidenceByCode() {
            const code = document.getElementById('residenceCode').value;
            if (!code) {
                alert('Please enter residence code');
                return;
            }

            try {
                const response = await fetch(`${API_BASE}/residence?code=${code}`);
                const data = await response.json();
                showResponse('residenceResponse', data, data.success);
            } catch (error) {
                showResponse('residenceResponse', { error: error.message }, false);
            }
        }

        async function getUnitsByCode() {
            const code = document.getElementById('unitsCode').value;
            if (!code) {
                alert('Please enter residence code');
                return;
            }

            try {
                const response = await fetch(`${API_BASE}/units?code=${code}`);
                const data = await response.json();
                showResponse('unitsResponse', data, data.success);
            } catch (error) {
                showResponse('unitsResponse', { error: error.message }, false);
            }
        }

        document.getElementById('registrationForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);

            try {
                const response = await fetch(`${API_BASE}/registration`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const data = await response.json();
                showResponse('registrationResponse', data, data.success);
            } catch (error) {
                showResponse('registrationResponse', { error: error.message }, false);
            }
        });

        async function resendVerification() {
            const email = document.getElementById('resendEmail').value;
            if (!email) {
                alert('Please enter email');
                return;
            }

            try {
                const response = await fetch(`${API_BASE}/resend-verification`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email })
                });
                const data = await response.json();
                showResponse('resendResponse', data, data.success);
            } catch (error) {
                showResponse('resendResponse', { error: error.message }, false);
            }
        }

        async function verifyEmail() {
            const uidb64 = document.getElementById('uidb64').value;
            const token = document.getElementById('verifyToken').value;
            
            if (!uidb64 || !token) {
                alert('Please enter uidb64 and token');
                return;
            }

            try {
                const response = await fetch(`${API_BASE}/verify`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ uidb64, token })
                });
                const data = await response.json();
                showResponse('verifyResponse', data, data.success);
            } catch (error) {
                showResponse('verifyResponse', { error: error.message }, false);
            }
        }

        async function testLogin() {
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            
            if (!email || !password) {
                alert('Please enter email and password');
                return;
            }

            try {
                const response = await fetch(`${API_BASE}/login`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email, password })
                });
                const data = await response.json();
                showResponse('loginResponse', data, data.success);
            } catch (error) {
                showResponse('loginResponse', { error: error.message }, false);
            }
        }
    </script>
</body>
</html>
