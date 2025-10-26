@foreach($data_tagihan['results'] as $tagihan)
<div class="flex justify-center items-center" style="height: 100%;">
    <div class="bg-white w-full max-w-6xl">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                  <strong>{{ $tagihan['name'] }}</strong>
                </p>
            </div>
        </div>  
       
        <div class="flex justify-between items-center mt-2">
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                    {{ $tagihan['description'] }}
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
                    Rp {{ $tagihan['amount'] }}
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
                    {{ $tagihan['tipe'] }}
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
                   {{ \Carbon\Carbon::parse($tagihan['date_due'])->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>
    </div>
</div>
<div class="flex justify-between items-center mt-2">
    <div class="flex items-center">
        <p class="text-warning d-flex align-items-center">
            
        </p>
    </div>
    @if($tagihan['is_publish'] == false)
    <div class="flex items-right">
        <a href="{{ route('pengurus.tagihan.edit', ['id' => $tagihan['id']]) }}" class="btn btn-sm btn-light w-20" style="border-radius:8px;">Edit</a>
        &nbsp;&nbsp;
        <a data-id="{{ $tagihan['id'] }}" class="btn btn-sm btn-success w-20 btn-publish" style="color: white;border-radius:8px;">Publish</a>
    </div>
    @else
    <div class="flex items-right">
       <a class="btn btn-sm btn-primary w-20" style="color: white;border-radius:8px;">Published</a>
    </div>
    @endif
</div>
<hr class="mt-3 mb-2">
@endforeach

<div class="p-0 mt-2">
    <a href="{{ route('tagihan.add') }}" 
        class="btn btn-success w-full bg-green-600 text-white py-2 px-4 rounded-lg">
        ADD
    </a>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

$(document).on('click', '.btn-publish', function (e) {
    e.preventDefault();
    let tagihanId = $(this).data('id');
    const publishUrl = @json(route('tagihan.publish'));
    
    console.log('=== PUBLISH DEBUG ===');
    console.log('Tagihan ID:', tagihanId);
    console.log('Publish URL:', publishUrl);
    console.log('CSRF Token:', $('meta[name="csrf-token"]').attr('content'));

    Swal.fire({
        title: 'Yakin ingin publish tagihan ini?',
        text: "Tindakan ini tidak dapat diubah!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Publish!'
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