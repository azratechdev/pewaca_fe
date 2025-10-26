@extends('layouts.residence.basetemplate')
@section('content')
@php
    session(['origin_page' => url()->current()]);
@endphp
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('pengurus') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Biaya
            </h1>
        </div>

        @include('pengurus.tagihan.menutagihan')

        <div class="col-md-12 col-sm-12" style="padding-left:10px;padding-right:10px;">

            <form action="{{ route('pengurus.biaya.list') }}" method="POST" class="flex items-center border border-gray-300 rounded-lg overflow-hidden w-full max-w-6xl">
                @csrf
                <input type="text" name="filter" placeholder=" Search..." class="py-2 pl-3 w-full focus:outline-none">
                <button type="submit" class="bg-green-500 text-white px-3 py-3 flex items-center justify-center">
                    <i class="fas fa-search"></i>
                </button>
            </form><br>

            <div class="mb-3">
                @include('layouts.elements.flash')
            </div>

            @if(isset($biaya) && is_array($biaya) && count($biaya) > 0)
                @foreach($biaya as $tagihan)
                    @if(is_array($tagihan))
                    <div class="flex justify-center items-center" style="height: 100%;">
                        <div class="bg-white w-full max-w-6xl">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                <strong>{{ isset($tagihan['name']) ? $tagihan['name'] : '-' }}</strong>
                                </p>
                            </div>
                        </div>  
                    
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                    {{ isset($tagihan['description']) ? $tagihan['description'] : '-' }}
                                </p>
                            </div>
                        </div> 
                        <div class="flex justify-between items-center mt-1">
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                Nominal
                                </p>
                            </div>
                            
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                    @if(isset($tagihan['amount']) && is_numeric($tagihan['amount']))
                                        Rp {{ number_format($tagihan['amount'], 0, ',', '.') }}
                                    @else
                                        Rp -
                                    @endif
                                </p>
                            </div>
                        </div> 
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                Type Iuran
                                </p>
                            </div>
                            
                            <div class="flex items-center">
                                <p class="d-flex align-items-center" style="color: red;">
                                    {{ isset($tagihan['tipe']) ? $tagihan['tipe'] : '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                Terakhir Pembayaran
                                </p>
                            </div>
                            
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                {{ isset($tagihan['date_due']) && $tagihan['date_due'] ? \Carbon\Carbon::parse($tagihan['date_due'])->translatedFormat('d F Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="flex justify-between items-center mt-2">
                    <div class="flex items-center">
                        <p class="text-warning d-flex align-items-center">
                            
                        </p>
                    </div>
                    @if($tagihan['is_publish'] == false)
                    <div class="flex items-right">
                        <a href="{{ route('pengurus.tagihan.edit', ['id' => $tagihan['id']]) }}" class="btn btn-sm btn-default w-20" style="border-radius:8px;">Edit</a>
                        &nbsp;&nbsp;
                        <a data-id="{{ $tagihan['id'] }}" class="btn btn-sm btn-success w-20 btn-publish" style="color: white;border-radius:8px;">Publish</a>
                    </div>
                    @else
                    <div class="flex items-right">
                        <a class="btn btn-sm btn-primary w-20" style="color: white;border-radius:8px;">Published</a>
                    </div>
                    @endif
                </div> --}}
                <div class="flex justify-between items-center mt-2">
                    @if($tagihan['is_publish'] == true)
                    <p class="text-success d-flex align-items-center">
                        <i class="fa fa-check"></i>&nbsp; Published
                    </p>
                    {{-- <div class="flex items-left">
                        <div class="btn btn-sm btn-success" style="color: white;border-radius:8px;"> 
                            <i class="fas fa-check-circle text-white mr-2"></i> Published
                        </div>
                    </div> --}}
                    @else
                    <div class="flex items-left">
                        {{-- <div class="btn btn-sm btn-danger" style="color: white;border-radius:8px;"> 
                            <i class="fas fa-times-circle text-white mr-2"></i> Unpublished</div>
                        </div> --}}
                    </div>
                    @endif
                    @if(!isset($tagihan['is_publish']) || $tagihan['is_publish'] == false)
                    <div class="flex items-right">
                        <a href="{{ route('pengurus.tagihan.edit', ['id' => isset($tagihan['id']) ? $tagihan['id'] : '']) }}" class="btn btn-sm btn-light w-20" style="border-radius:8px;">Edit</a>
                        &nbsp;&nbsp;
                        <a href="#" data-id="{{ isset($tagihan['id']) ? $tagihan['id'] : '' }}" class="btn btn-sm btn-success w-20 btn-publish" style="color: white;border-radius:8px;">Publish</a>
                    </div>
                    @else
                    <div class="flex items-right">
                        <a href="#" data-id="{{ isset($tagihan['id']) ? $tagihan['id'] : '' }}" class="btn btn-sm btn-warning w-20 btn-unpublish" style="color: white;border-radius:8px;">Unpublish</a>
                    </div>
                    @endif
                </div>
                <hr class="mt-3 mb-2">
                    @endif
                @endforeach

                <div class="flex items-center justify-between">
                    @if(isset($previous_page) && $previous_page)
                    <div class="flex items-center">
                        <form action="{{ route('pengurus.biaya.list') }}" method="POST">
                            @csrf
                            <input type="hidden" name="page" value="{{ isset($prev) ? $prev : 1 }}">
                            <button type="submit" class="btn btn-sm btn-info text-white">
                                < Previous
                            </button>
                        </form>
                    </div>
                    @endif

                    <div class="flex-grow text-center">
                        Page {{ isset($current) ? $current : 1 }} of {{ isset($total_pages) ? $total_pages : 1 }}
                    </div>
                
                    @if(isset($next_page) && $next_page)
                    <div class="flex items-center ml-auto">
                        <form action="{{ route('pengurus.biaya.list') }}" method="POST">
                            @csrf
                            <input type="hidden" name="page" value="{{ isset($next) ? $next : 1 }}">
                            <button type="submit" class="btn btn-sm btn-info text-white">
                                Next Page >
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            @else
         
                <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: auto; text-align: center;">
                    <div>
                        <img src="{{ asset('assets/plugins/images/biaya-empty.png') }}" alt="Biaya kosong" style="max-width: 200px; height: auto;" />
                    </div>
                    <div style="font-size: 14px; margin-top: 10px;">
                        <h2 style="font-size: 16px; font-weight: bold;">
                            Belum ada daftar biaya
                        </h2>
                        <p>Klik tombol dibawah untuk <br>menambahkan daftar biaya</p>
                    </div>
                </div><br>
            @endif

            <br>
            <div class="p-0 mt-2">
                <a href="{{ route('tagihan.add') }}" 
                    class="btn btn-success w-full bg-green-600 text-white py-2 px-4 rounded-lg btn-add">
                    ADD
                </a>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).on('click', '.btn-publish', function (e) {
    e.preventDefault();
    let tagihan_id = $(this).data('id');
    const publishUrl = @json(route('tagihan.publish'));

    Swal.fire({
        title: 'Yakin ingin mempublish tagihan ini?' ,
        text: "Harap periksa data tagihan terlebih dahulu!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Publish!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`https://admin.pewaca.id/api/tagihan/publish-tagihan/${tagihan_id}/`, {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "Authorization": "Token {{ Session::get('token') }}",
                    "Content-Type": "application/json",
                    "X-CSRFToken": "2EsSjVgOlsklgxbXyjSOfitDc5NQkoiBnejF5k63EViTw1LQP2p52nhkVCoTLqmu"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data) {
                    Swal.fire({
                        title: "Sukses!",
                        text: "Tagihan Berhasil dipublish.",
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

$(document).on('click', '.btn-unpublish', function (e) {
    e.preventDefault();
    let tagihan_id = $(this).data('id');
   
    Swal.fire({
        title: 'Yakin ingin unpublish tagihan ini?',
        html: `
            <p class="mb-3">Tindakan ini akan menghapus data tagihan dari daftar!</p>
            <div class="form-group">
                <textarea id="unpublish-note" class="form-control" 
                    placeholder="Masukkan catatan unpublish..." 
                    style="width: 100%; margin-top: 10px; border: 1px solid #ddd; border-radius: 4px; padding: 8px;"
                    rows="3"
                ></textarea>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Unpublish!',
        didOpen: () => {
            const confirmButton = Swal.getConfirmButton();
            confirmButton.disabled = true;
            
            document.getElementById('unpublish-note').addEventListener('input', function(e) {
                confirmButton.disabled = !e.target.value.trim();
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const note = document.getElementById('unpublish-note').value.trim();
            
            fetch(`https://admin.pewaca.id/api/tagihan/unpublish-tagihan/${tagihan_id}/`, {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "Authorization": "Token {{ Session::get('token') }}",
                    "Content-Type": "application/json",
                    "X-CSRFToken": "2EsSjVgOlsklgxbXyjSOfitDc5NQkoiBnejF5k63EViTw1LQP2p52nhkVCoTLqmu"
                },
                body: JSON.stringify({
                    note: note
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data) {
                    Swal.fire({
                        title: "Sukses!",
                        text: "Tagihan Berhasil diunpublish.",
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

$(document).on('click', '.btn-add', function(e) {
    e.preventDefault();
    const residence_id = {{ Session::get('warga')['residence'] }};

    fetch(`https://admin.pewaca.id/api/residence-banks/list_banks/?residence_id=${residence_id}`, {
        method: "GET",
        headers: {
            "Accept": "application/json",
            "Authorization": "Token {{ Session::get('token') }}",
            "Content-Type": "application/json"
        }
    })
    .then(response => response.json())
    .then(response => {
        const banks = response.data || [];

        if (banks.length === 0) {
            // ⛔ Data kosong
            Swal.fire({
                title: "Peringatan!",
                text: "Harap isikan data bank terlebih dahulu",
                icon: "warning",
                confirmButtonText: "OK",
                confirmButtonColor: "#3085d6"
            }).then(() => {
                window.location.href = "{{ route('inforekening') }}";
            });

        } else {
            // ✅ Data ada, cek apakah ada yang isactive === true
            const hasActiveBank = banks.some(bank => bank.isactive === true);

            if (!hasActiveBank) {
                // ⛔ Tidak ada rekening aktif
                Swal.fire({
                    title: "Peringatan!",
                    text: "Belum ada rekening utama yang dipilih, harap pilih rekening utama",
                    icon: "warning",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#3085d6"
                }).then(() => {
                    window.location.href = "{{ route('inforekening') }}";
                });
            } else {
                // ✅ Semua OK, lanjut
                window.location.href = "{{ route('tagihan.add') }}";
            }
        }
    })
    .catch(error => {
        console.error("Error:", error);
        Swal.fire("Error", "Gagal menghubungi server.", "error");
    });
});


</script>
@endsection