@extends('layouts.residence.basetemplate')

@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('pengurus') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Detail Approval
            </h1>
        </div>
        <div class="p-6 mt-2 space-y-2">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       Nama Warga
                    </p>
                </div>
                
                <div class="flex items-center">
                    <p class="td-flex align-items-center">
                        <strong>jhondoe</strong>
                    </p>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       Nama Unit
                    </p>
                </div>
                
                <div class="flex items-center">
                    <p class="td-flex align-items-center">
                        <strong>Residence Tiga</strong>
                    </p>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       Kode Unit
                    </p>
                </div>
                
                <div class="flex items-center">
                    <p class="td-flex align-items-center">
                        <strong>A78FG</strong>
                    </p>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       Kategori Iuran
                    </p>
                </div>
                
                <div class="flex items-center">
                    <p class="td-flex align-items-center">
                        <strong>Pembangunan</strong>
                    </p>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       Nominal
                    </p>
                </div>
                
                <div class="flex items-center">
                    <p class="td-flex align-items-center">
                        <strong>Rp150.000</strong>
                    </p>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       Status Pembayaran
                    </p>
                </div>
                
                <div class="flex items-center">
                    <p class="td-flex align-items-center" style="color:lightgreen;">
                        <strong>Lunas</strong>
                    </p>
                </div>
            </div>
           
            <div class="flex items-center">
                <span class="text-gray-600">Photo Bukti Pembayaran<br>
                    <img 
                    alt="Belum ada" 
                    class="profile-picture rounded w-32 h-24" 
                    src="https://storage.googleapis.com/a1aa/image/ZoAiGzvASA4pG9oiGwu50UAjrOG21IrMhFOGfFnKGy1xU85JA.jpg"
                /></span>
            </div>
        </div>

        <div class="p-6 mt-2">
            <div class="col-md-12">
                <a href="" class="btn btn-success form-control d-flex align-items-center justify-content-between">
                    <span>
                        <i class="fa fa-file-invoice me-2"></i> Detail Bukti Pembayaran
                    </span>
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="p-6 mt-2">
            <a href="" 
                class="btn btn-success w-full bg-green-600 text-white py-2 px-4 rounded-lg">
                Approve
            </a>
        </div>
      
       
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
        $(document).on("click", ".approved-warga", function() {
       
            const token = "{{ Session::get('token') }}";
            const wargaId = $(this).data('id');
        
            //alert(token + ' ' + wargaId);return;
        
            // Tampilkan SweetAlert konfirmasi
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to approve this warga?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, approve it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'https://api.pewaca.id/api/warga/verify/',
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
                            Swal.fire('Success!', 'Warga successfully verified.', 'success');
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
