<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/pewaca.jpeg') }}">
  <title>Pewaca</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

  <style>
  
    .swal2-popup.rounded-alert {
    border-radius: 12px !important;
    padding: 20px;
    width: 400px !important;
    max-width: 90%;
}

/* Tambahan styling opsional */
.swal2-popup .swal2-title {
    font-size: 20px !important;
    font-weight: bold !important;
    margin: 10px 0 !important;
}

.swal2-popup .swal2-content {
    font-size: 14px !important;
    margin-bottom: 10px !important;
    text-align: center;
}
.swal2-actions {
    display: flex !important; /* Atur elemen pembungkus tombol agar fleksibel */
    justify-content: center !important; /* Pusatkan tombol */
    width: 100% !important; /* Pastikan pembungkus tombol lebar penuh */
    margin: 0 !important;
}

.swal-confirm-btn{
    display: block !important; /* Ubah tombol menjadi elemen blok */
    width: 100% !important; /* Pastikan tombol melebar penuh */
    font-size: 16px !important; /* Ukuran teks */
    background-color: #198754 !important; /* Warna hijau success */
    color: white !important; /* Teks putih */
    border: none !important; /* Hapus border */
    border-radius: 8px !important; /* Sudut melengkung */
    text-align: center !important; /* Teks di tengah */
}
    
  </style>
</head>
<body>

  <!-- Bootstrap JS -->
 
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
  <!-- JS Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('status') == 'warning')
      <script>
        Swal.fire({
            html: `
                
                <div class="alert alert-warning d-flex align-items-left justify-content-left mx-auto" role="alert"
                style="text-align: left; border-radius: 8px;">
                    <i class="fa fa-exclamation-triangle fa-2x text-warning"></i>
                    <div class="ms-3">
                        <p style="font-size:16px;" class="text-warning fw-bold mb-1">Warning!</p>
                        <p style="font-size:14px;" class="text-dark mb-0">Anda belum verifikasi email.</p>
                    </div>
                </div>

                <div style="text-align: center; font-size: 14px;">
                    <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0">
                        Verifikasi Akun Anda
                    </h2>
                    <p>Silahkan cek email untuk melanjutkan proses <i>onboarding platform</i> Pewaca.</p>
                    <img
                        src="{{ asset('assets/plugins/images/verified-send.jpeg') }}"
                        alt="Verified" style="width: 180px; height: 175px; margin: 10px 0" />
                </div>
            `,
            
            showConfirmButton: true,
            confirmButtonText: 'Mengerti',
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                popup: 'rounded-alert', // Class untuk border-radius
                confirmButton: 'swal-confirm-btn'
            }
        }).then(() => {
            window.location.href = '{{ route('showLoginForm') }}';
        });
      </script>
    @endif
  </body>
</html>
