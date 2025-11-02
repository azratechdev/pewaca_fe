@extends('layouts.residence.basetemplate')

@section('content')
<style>
    .form-check-input:checked {
        background-color: green;
        border-color: green;
    }
</style>
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('akun') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Info Rekening
            </h1>
            <br>
            <div class="mb-3">
                @include('layouts.elements.flash')
            </div>
            @foreach($bank_list as $key => $bank)
            <div class="flex justify-between items-center mt-2">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       Logo Bank here
                    </p>
                </div>
                <div class="flex items-center">
                    <button class="text-grey-500 d-flex align-items-center hapus-bank" data-id="{{ $bank['id'] }}" style="color:grey;font-size: 16px;font-family:Arial;">
                        Hapus
                    </button>
                </div>
            </div> 
            <div class="flex justify-between items-center mt-2">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       Nama
                    </p>
                </div>
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                        {{ $bank['account_holder_name'] }}
                    </p>
                </div>
            </div> 
            <div class="flex justify-between items-center mt-2">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       No. Rekening
                    </p>
                </div>
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                        {{ $bank['account_number'] }}
                    </p>
                </div>
            </div> 
            <div class="flex justify-between items-center mt-2">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       Nama Bank
                    </p>
                </div>
                
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                        {{ $bank['bank']['bank_name'] }}
                    </p>
                </div>
            </div>
           
            @php
                if ($bank['isactive'] == true) {
                    $alert_class = "alert-success";
                    $message = '<p style="color: green; margin: 0; font-weight: bold;">Utama<br>
                        <small>Rekening Bank Utama</small></p>';
                  
                    
                } else {
                    $alert_class = "alert-secondary";
                    $message = '<p style="color: rgb(97, 101, 97); margin: 0; font-weight: bold;">
                        Jadikan sebagai rekening bank utama
                    </p>';
                   
                }
            @endphp

            <div class="alert alert-dismissible {{ $alert_class }} fade show mt-2 rounded" role="alert" style="padding-right: 16px; font-size: 12px; line-height: 1.2;">
                <div class="flex justify-between items-center" style="padding: 8px 0;">
                    <div class="flex items-center">
                        {!! $message !!}
                    </div>
                    <div class="flex items-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input bank-switch" type="checkbox" role="switch" id="successSwitch" style="width: 40px; height: 20px;" 
                            id="switch_{{ $bank['id'] }}" data-id="{{ $bank['id'] }}"
                            @if($bank['isactive']) checked @endif 
                            @if($bank['isactive']) disabled @endif>
                            <label class="form-check-label" for="switch_{{ $bank['id'] }}"></label>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="mt-3 mb-2">
            @endforeach
            <div class="p-0 mt-2">
                <a href="{{ route('addRekening') }}" 
                    class="btn btn-success w-full bg-green-600 text-white py-2 px-4 rounded-lg">
                    ADD
                </a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).on('click', '.hapus-bank', function (e) {
    e.preventDefault();
    let bank_id = $(this).data('id');
    const publishUrl = @json(route('tagihan.publish'));

    Swal.fire({
        title: 'Yakin ingin menghapus rekening ini?' ,
        text: "Tindakan ini tidak dapat diubah!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`https://admin.pewaca.id/api/residence-banks/${bank_id}/`, {
                method: "DELETE",
                headers: {
                    "Accept": "application/json",
                    "Authorization": "Token {{ Session::get('token') }}",
                    "Content-Type": "application/json",
                    "X-CSRFToken": "ehbPFxLcdp440i5BmhZAq8c1wRQZuJVIzR2CrWBrwS2CgMFuD0wRdd0Ifor2VLZB"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data) {
                    Swal.fire({
                        title: "Sukses!",
                        text: "Rekening berhasil dihapus.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload(); // Refresh halaman setelah sukses
                    });
                } else {
                    Swal.fire("Error", "Terjadi kesalahan, coba lagi.", "error");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire("Error", "Gagal menghubungi server.", "error");
            });
        }
    });
});

</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let checkbox = document.getElementById("successSwitch");

        if (checkbox.checked) {
            checkbox.setAttribute("disabled", "disabled");
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.bank-switch').forEach(function(switchElement) {
            switchElement.addEventListener('change', function() {
                let bankId = this.getAttribute('data-id');
    
                if (this.checked) {
                    Swal.fire({
                        title: "Konfirmasi",
                        text: "Aktifkan rekening bank ini sebagai rekening utama?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Aktifkan!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch("https://admin.pewaca.id/api/residence-banks/activate/", {
                                method: "POST",
                                headers: {
                                    "Accept": "application/json",
                                    "Authorization": "Token {{ Session::get('token') }}",
                                    "Content-Type": "application/json",
                                    "X-CSRFToken": "ehbPFxLcdp440i5BmhZAq8c1wRQZuJVIzR2CrWBrwS2CgMFuD0wRdd0Ifor2VLZB"
                                },
                                body: JSON.stringify({ id: bankId })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.id == bankId && data.isactive === true) {
                                    Swal.fire({
                                        title: "Sukses!",
                                        text: "Rekening berhasil diaktifkan sebagai rekening utama.",
                                        icon: "success",
                                        confirmButtonText: "OK"
                                    }).then(() => {
                                        location.reload(); // Refresh halaman setelah sukses
                                    });
                                } else {
                                    Swal.fire("Error", "Terjadi kesalahan, coba lagi.", "error");
                                }
                            })
                            .catch(error => {
                                console.error("Error:", error);
                                Swal.fire("Error", "Gagal menghubungi server.", "error");
                            });
                        } else {
                            this.checked = false; // Kembalikan ke unchecked jika dibatalkan
                        }
                    });
                }
            });
        });
    });
    </script>
@endsection
