<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/pewaca.jpeg') }}">
  <title>Pewaca</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
<style>
        /* Styling untuk SweetAlert */
.swal2-popup.rounded-alert {
    border-radius: 12px !important;
    padding: 20px;
    width: 400px !important;
    max-width: 75%;
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

.swal-confirm-btn {
    display: block !important; /* Ubah tombol menjadi elemen blok */
    width: 100% !important; /* Pastikan tombol melebar penuh */
    padding: 10px !important; /* Tinggi tombol */
    font-size: 16px !important; /* Ukuran teks */
    background-color: #198754 !important; /* Warna hijau success */
    color: white !important; /* Teks putih */
    border: none !important; /* Hapus border */
    border-radius: 4px !important; /* Sudut melengkung */
    text-align: center !important; /* Teks di tengah */
}
</style> 
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
      
        Swal.fire({
            title: 'Memverifikasi Data',
            text: 'Harap tunggu sebentar...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Dapatkan UUID dan Token dari URL
        let url = window.location.href;
        let urlParts = url.split('/');
        let uuid = urlParts[4];
        let token = urlParts[5];

        if (!uuid || !token) {
            Swal.fire({
                title: 'Error',
                text: 'UUID atau Token tidak valid di URL.',
                icon: 'error',
                confirmButtonText: 'Mengerti'
            });
            return;
        }

      // Fungsi untuk memverifikasi API
        const verifyApi = () => {
            return fetch(`https://api.pewaca.id/api/auth/verify/${uuid}/${token}/`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                }
            });
        };

      // Jalankan API pertama kali
        verifyApi()
            .then(response => response.json())
            .then(data => { console.log(data)
                if (data.success === true) {
                   
                    Swal.fire({
                        html: `
                            <div style="text-align: center; font-size: 14px;">
                                <img
                                 src="{{ asset('assets/plugins/images/verified-success.jpeg') }}"
                                  alt="Verified"
                                 style="width: 180px; height: 175px; margin: 10px 0" />
                                <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0">
                                    Verifikasi Berhasil!
                                </h2>
                                <p>Silahkan lakukan login.</p>
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

                } else {
                    Swal.fire({
                        html: `
                            <div style="text-align: center; font-size: 14px;">
                                <i class="swal2-icon swal2-warning" style="font-size: 50px; margin-bottom: 10px;"></i>
                                <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0;">
                                    ${data.message}
                                </h2>
                                <p>Pastikan email anda memiliki pesan verifikasi yang benar</p>
                            </div>
                        `,
                        showConfirmButton: true,
                        icon: 'warning',
                        confirmButtonText: 'Mengerti',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        customClass: {
                            popup: 'rounded-alert',
                            confirmButton: 'swal-confirm-btn'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route('showLoginForm') }}';
                        }
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    html: `
                        <div style="text-align: center; font-size: 14px;">
                            <i class="swal2-icon swal2-error" style="font-size: 50px; margin-bottom: 10px;"></i>
                            <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0;">
                                Kesalahan
                            </h2>
                            <p>Gagal Verifikasi, Pastikan anda memiliki akses internet.</p>
                        </div>
                    `,
                    showConfirmButton: true,
                    icon: 'error',
                    confirmButtonText: 'Verifikasi Ulang',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        popup: 'rounded-alert',
                        confirmButton: 'swal-confirm-btn'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        retryApi();
                    }
                });

        });

      // Fungsi untuk menjalankan ulang API (jika tombol "Coba Lagi" diklik)
        const retryApi = () => {
          Swal.fire({
              title: 'Memverifikasi Data',
              text: 'Harap tunggu sebentar...',
              allowOutsideClick: false,
              allowEscapeKey: false,
              didOpen: () => {
                  Swal.showLoading();
              }
          });

          verifyApi()
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                    Swal.fire({
                        html: `
                            <div style="text-align: center; font-size: 14px;">
                                <img
                                 src="{{ asset('assets/plugins/images/verified-success.jpeg') }}"
                                  alt="Verified"
                                 style="width: 180px; height: 175px; margin: 10px 0" />
                                <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0">
                                    Verifikasi Berhasil!
                                </h2>
                                <p>Silahkan lakukan login.</p>
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
                  } else {
                    Swal.fire({
                        html: `
                            <div style="text-align: center; font-size: 14px;">
                                <i class="swal2-icon swal2-warning" style="font-size: 50px; margin-bottom: 10px;"></i>
                                <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0;">
                                    ${data.message}
                                </h2>
                                <p>Pastikan email anda memiliki pesan verifikasi yang benar</p>
                            </div>
                        `,
                        showConfirmButton: true,
                        icon: 'warning',
                        confirmButtonText: 'Mengerti',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        customClass: {
                            popup: 'rounded-alert',
                            confirmButton: 'swal-confirm-btn'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route('showLoginForm') }}';
                        }
                    });
                  }
              })
              .catch(() => {
                Swal.fire({
                    html: `
                        <div style="text-align: center; font-size: 14px;">
                            <i class="swal2-icon swal2-error" style="font-size: 50px; margin-bottom: 10px;"></i>
                            <h2 style="font-size: 20px; font-weight: bold; margin: 10px 0;">
                                Kesalahan
                            </h2>
                            <p>Gagal Verifikasi, Pastikan anda memiliki akses internet.</p>
                        </div>
                    `,
                    showConfirmButton: true,
                    icon: 'error',
                    confirmButtonText: 'Verifikasi Ulang',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        popup: 'rounded-alert',
                        confirmButton: 'swal-confirm-btn'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        retryApi();
                    }
                });
            });
        };
    });
</script>

</body>
</html>

