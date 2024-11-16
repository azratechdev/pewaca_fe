<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/favicon.png') }}">
  <title>Residence</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
      // Tampilkan loading Swal saat halaman dimuat
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
                      title: '<strong style="font-size: 20px; font-weight: bold;">'+data.data.message+'</strong>',
                      text: 'Selamat data anda telah terferifikasi, silahkan login.',
                      confirmButtonText: 'Mengerti',
                      customClass: {
                          confirmButton: 'btn btn-sm col-md-12 btn-success'
                      },
                      imageUrl: "{{ asset('assets/plugins/images/verified.jpg') }}",
                      imageWidth: 180,
                      imageHeight: 175
                  }).then(() => {
                      window.location.href = '{{ route('showLoginForm') }}';
                  });
              } else {
                  Swal.fire({
                    title: '<strong style="font-size: 20px; font-weight: bold;">'+data.message+'</strong>',
                    text: 'Pastikan email anda memiliki pesan verifikasi yang benar',
                      icon: 'warning',
                      confirmButtonText: 'Mengerti',
                      customClass: {
                          confirmButton: 'btn btn-sm col-md-12 btn-success'
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
                  title: 'Kesalahan',
                  text: 'Gagal Verifikasi, Pastikan anda memiliki akses internet.',
                  icon: 'error',
                  confirmButtonText: 'Verifikasi Ulang',
                  customClass: {
                      confirmButton: 'btn btn-sm col-md-12 btn-success'
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
                         title: '<strong style="font-size: 20px; font-weight: bold;">'+data.data.message+'</strong>',
                         text: 'Selamat data anda telah terferifikasi, silahkan login.',
                          icon: 'success',
                          confirmButtonText: 'Mengerti',
                          customClass: {
                              confirmButton: 'btn btn-sm col-md-12 btn-success'
                          },
                          imageUrl: "{{ asset('assets/plugins/images/verified.jpg') }}",
                          imageWidth: 180,
                          imageHeight: 175
                      }).then(() => {
                          window.location.href = '{{ route('showLoginForm') }}';
                      });
                  } else {
                      Swal.fire({
                          title: '<strong style="font-size: 20px; font-weight: bold;">'+data.message+'</strong>',
                          text: 'Pastikan email anda memiliki pesan verifikasi yang benar', 
                          icon: 'warning',
                          confirmButtonText: 'Mengerti',
                          customClass: {
                              confirmButton: 'btn btn-sm col-md-12 btn-success'
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
                      title: 'Kesalahan',
                      text: 'Gagal Verifikasi, Pastikan anda memiliki akses internet.',
                      icon: 'error',
                      confirmButtonText: 'Verifikasi Ulang',
                      customClass: {
                          confirmButton: 'btn btn-sm col-md-12 btn-success'
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

