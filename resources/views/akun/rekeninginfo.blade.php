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
                        BCA
                    </p>
                </div>
            </div>
           
            {{-- <div class="alert alert-dismissible alert-success fade show mt-2 rounded" role="alert" style="padding-right: 16px; font-size: 12px; line-height: 1.2;">
                <div class="flex justify-between items-center" style="padding: 8px 0;">
                    <div class="flex items-center">
                        <p style="color: green; margin: 0; font-weight: bold;">Utama<br>
                        <small>Sebagai Rekening Bank Utama</small></p>
                    </div>
                    <div class="flex items-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="successSwitch" style="width: 40px; height: 20px;" checked>
                            <label class="form-check-label" for="successSwitch"></label>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="alert alert-dismissible alert-secondary fade show mt-2 rounded" role="alert" style="padding-right: 16px; font-size: 12px; line-height: 1.2;">
                <div class="flex justify-between items-center" style="padding: 8px 0;">
                    <div class="flex items-center">
                        <p style="color: rgb(97, 101, 97); margin: 0; font-weight: bold;">
                            Tambahkan sebagai Rekening Bank Utama
                        </p>
                    </div>
                    <div class="flex items-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="successSwitch" style="width: 40px; height: 20px;">
                            <label class="form-check-label" for="successSwitch"></label>
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
    let tagihanId = $(this).data('id');
    const publishUrl = @json(route('tagihan.publish'));

    Swal.fire({
        title: 'Yakin ingin menghapus rekening ini?',
        text: "Tindakan ini tidak dapat diubah!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: publishUrl, // Laravel route URL
                method: 'POST',
                data: {
                    tagihan_id: tagihanId,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire(
                            'Berhasil!',
                            response.message,
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Gagal!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function (xhr) {
                    let message = xhr.responseJSON?.message || 'Terjadi kesalahan. Coba lagi nanti.';
                    Swal.fire(
                        'Error!',
                        message,
                        'error'
                    );
                    console.error(xhr.responseJSON);
                }
            });
        }
    });
});

</script>
@endsection
