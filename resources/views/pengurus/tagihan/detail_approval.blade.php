@extends('layouts.residence.basetemplate')

@section('content')
<style>
    /* Custom styling for vertical buttons */
    .swal2-actions {
        flex-direction: column !important; /* Set buttons vertically */
        border-radius: 12px;
    }
    .swal2-confirm {
        width: 350px;
        border-radius: 12px;
        border: 1px solid #128C7E;
        background: #128c7e !important;
        color: #fff !important;
    }
    .swal2-cancel {
        width: 350px;
        border-radius: 12px;
        border: 1px solid #128C7E;
        background: #fff !important;
        color: #128c7e !important;

    }
</style>
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ session('origin_page', route('pengurus')) }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Detail Pembayaran Tagihan
            </h1>
        </div>

        <div class="p-6 mt-2 space-y-2">
            @if($data['status'] == 'process')
            <div class="flex justify-between items-center">
                @include('layouts.elements.pengurus_confirm')
            </div>
            @endif

            @if($data['status'] == 'unpaid' && date('Y-m-d') > $data['date_due'])
            <div class="flex justify-between items-center">
                @include('layouts.elements.pengurus_tempo')
            </div>
            @endif

            @if($data['status'] == 'paid')
                <div class="flex justify-between items-center">
                    @include('layouts.elements.approved')
                </div>
            @endif
           
            @if(empty($data['paydate']))
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="text-black-900" style="font-size: 16px;">
                        <p>Tanggal Pembayaran</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <div class="text-black-900" style="font-size: 16px;">
                        <strong>{{ \Carbon\Carbon::parse($data['update_date'])->addHours(12)->locale('id')->translatedFormat('d F Y (H:i)') }}</strong>
                    </div>
                </div>
            </div>
            @endif
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="text-black-900" style="font-size: 16px;">
                        <p>Nama Warga</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <div class="text-black-900" style="font-size: 16px;">
                        <strong>{{ $data['warga']['full_name'] ?? 'Anonim' }}</strong>
                    </div>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="text-black-900" style="font-size: 16px;">
                        <p>Nama Unit</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                   <div class="text-black-900" style="font-size: 16px;">
                        <strong>{{ $data['unit_id']['unit_name']}}</strong>
                   </div>
                </div>
            </div>
            
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="text-black-900" style="font-size: 16px;">
                        <p>Nama Tagihan</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <div class="text-black-900" style="font-size: 16px;">
                        <strong>{{ $data['tagihan']['name'] }}</strong>
                    </div>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                     <div class="text-black-900" style="font-size: 16px;">
                        <p>Nominal</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <div class="text-black-900" style="font-size: 16px;">
                        <strong>Rp {{ number_format($data['tagihan']['amount'], 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       Status Pembayaran
                    </p>
                </div>
                
                <div class="flex items-center">
                    @if($data['status'] == "paid")
                        <div class="td-flex align-items-center font-semibold" style="font-size:16px;color:lightgreen;">
                            <p>Lunas</p>
                        </div>
                    @else
                        <div class="td-flex align-items-center font-semibold" style="font-size:16px;color:orange;"
                            <p>{{ $data['status'] }}</p>
                        </div>
                    @endif
                </div>
            </div>
            @if(!empty($data['paydate']))
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="text-black-900" style="font-size: 16px;">
                            <p>Tanggal Disetujui</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="text-black-900" style="font-size: 16px;">
                            <strong>{{ \Carbon\Carbon::parse($data['paydate'])->addHours(12)->locale('id')->translatedFormat('d F Y (H:i)') }}</strong>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="p-6 mt-2">
            <div class="col-md-12">
                <a href="{{ route('pembayaran.detail_bukti', ['id' => $data['id']]) }}" class="btn btn-success form-control d-flex align-items-center justify-content-between">
                    <span>
                        <i class="fa fa-file-invoice me-2"></i> Detail Bukti Pembayaran
                    </span>
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>

        @if ($data['status'] == 'process')
            <div class="p-6 mt-2">
                <a class="btn btn-success approved-tagihan-warga w-full bg-green-600 text-white py-2 px-4 rounded-lg"
                data-id="{{ $data['id'] }}" data-warga_id="{{ $data['warga']['id'] }}">
                    Approve
                </a>
            </div>
        @endif
       
        <!-- Footer -->
        {{-- <div class="flex justify-content-between p-6"> --}}
            {{-- <a href="{{ route('reject_warga', ['id' => '1']) }}" class="btn btn-danger w-40 me-2">Reject</a> --}}
            {{-- <button class="btn btn-success w-60 approved-warga" data-id="1">Approve</button> --}}
        {{-- </div> --}}
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $(document).on("click", "a.approved-tagihan-warga", function() {
       
            const token = "{{ Session::get('token') }}";
            const tagihanId = $(this).data('id');
            const wargaId = $(this).data('warga_id');
        
            // alert(tagihanId + ' ' + wargaId);
            // return;
        
            // Tampilkan SweetAlert konfirmasi
            Swal.fire({
                title: 'Approve Tagihan',
                text: 'Apakah anda yakin ingin menyetujui tagihan ini?',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: env('API_URL') . '/api/tagihan-warga/'+tagihanId+'/approve/',
                        type: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Token ${token}`,
                            'Content-Type': 'application/json'
                        },
                        data: JSON.stringify({
                            "warga_id": wargaId
                        }),
                        success: function(data) {
                            Swal.fire('Success!', 'Tagihan berhasil disetujui.', 'success').then((result) => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
                        }
                    });
                }
            });
        });
    });    
</script>
    
@endsection
