<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline - Pewaca</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .offline-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        
        .offline-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: #f3f4f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .offline-icon svg {
            width: 60px;
            height: 60px;
            fill: #9ca3af;
        }
        
        h1 {
            color: #1f2937;
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        p {
            color: #6b7280;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .retry-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px 32px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .retry-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }
        
        .retry-btn:active {
            transform: translateY(0);
        }
        
        .offline-info {
            margin-top: 30px;
            padding: 20px;
            background: #f9fafb;
            border-radius: 10px;
            font-size: 14px;
            color: #6b7280;
        }
        
        @media (max-width: 480px) {
            .offline-container {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            .offline-icon {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="offline-container">
        <div class="offline-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z"/>
            </svg>
        </div>
        
        <h1>Tidak Ada Koneksi</h1>
        
        <p>
            Maaf, sepertinya Anda sedang offline. Aplikasi Pewaca memerlukan koneksi internet untuk berfungsi dengan baik.
        </p>
        
        <button class="retry-btn" onclick="location.reload()">
            Coba Lagi
        </button>
        
        <div class="offline-info">
            <strong>💡 Tips:</strong><br>
            Pastikan WiFi atau data seluler Anda aktif, lalu coba lagi.
        </div>
    </div>
    
    <script>
        // Auto-reload saat online kembali
        window.addEventListener('online', function() {
            location.reload();
        });
        
        // Cek koneksi setiap 5 detik
        setInterval(function() {
            if (navigator.onLine) {
                location.reload();
            }
        }, 5000);
    </script>
</body>
</html>
