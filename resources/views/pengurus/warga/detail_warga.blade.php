@extends('layouts.residence.basetemplate')

@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ session('origin_page', route('pengurus')) }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Info Warga
                @include('layouts.elements.flash')
            </h1>
            <br>
            <div class="flex justify-between items-center mt-2">
                <div class="flex items-center">
                    @if($warga['is_checker'] == false && $warga['isreject'] == false)
                        <p class="text-warning d-flex align-items-center">
                            <i class="far fa-clock"></i>&nbsp; Waiting Approval
                        </p>
                    @else
                        <p class="text-success d-flex align-items-center">
                            <i class="fa fa-check"></i>&nbsp; Approved
                        </p>
                    @endif
                </div>
                
                <div class="flex items-center">
                    <p class="text-dark d-flex align-items-center">
                        <i class="far fa-calendar"></i>&nbsp; 
                        @if($warga['is_checker'] == false && $warga['isreject'] == false)
                        {{ \Carbon\Carbon::parse($warga['created_on'])->locale('id')->format('d F Y') }}
                        @else
                        {{ \Carbon\Carbon::parse($warga['checked_on'])->locale('id')->format('d F Y') }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
        <div class="card card-body p-6">
            <div class="space-y-4">
                <div class="flex items-center">
                    <span class="text-gray-600">Photo Profile <br>
                        <img 
                        alt="Belum ada" 
                        class="profile-picture rounded w-32 h-24" 
                        src="{{ $warga['profile_photo'] }}"
                    /></span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Nama<br>
                       {{ $warga['full_name'] }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">No Unit <br>
                       {{ $warga['unit_id']['unit_name'] }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">NIK <br>
                        {{ $warga['nik'] }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Jenis Kelamin <br>
                        {{ $warga['gender'] }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Tanggal Lahir <br>
                        {{ \Carbon\Carbon::parse($warga['date_of_birth'])->locale('id')->translatedFormat('d F Y') }}
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Agama <br>
                        {{ $warga['religion']['name'] }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Tempat Lahir <br>
                       {{ $warga['place_of_birth'] }}</span>
                </div>
                <hr>
                <div class="flex items-center">
                    <span class="text-gray-600">Status <br>
                        {{ $warga['marital_status']['name'] }}</span>
                </div>
                @if($warga['marital_status']['name'] == "Kawin")
                <div class="flex items-center">
                    <span class="text-gray-600">Buku Nikah <br>
                        <img 
                        alt="Belum ada" 
                        class="profile-picture rounded w-32 h-24" 
                        src="{{ $warga['marriagePhoto'] }}"
                    /></span>
                </div>
                @endif
                <hr>
                <div class="flex items-center">
                    <span class="text-gray-600">Pekerjaan <br>
                        {{ $warga['occupation']['name'] }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-600">Pendidikan <br>
                        {{ $warga['education']['name'] }}</span>
                </div>
            </div>
        </div>
        <!-- Footer -->
        @if($warga['is_checker'] == false && $warga['isreject'] == false)
        <div class="flex justify-content-between" style="padding:10px;">
            <a href="{{ route('reject_warga', ['id' => $warga['id']]) }}" class="btn btn-danger w-40 me-2">Reject</a>
            <button class="btn btn-success w-60 approved-warga" data-id="{{ $warga['id'] }}">Approve</button>
        </div>
        @endif
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
                        url: 'http://43.156.75.206/api/warga/verify/',
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
                            Swal.fire('Success!', 'Warga successfully verified.', 'success')
                                .then(() => {
                                    window.location.href = '/pengurus/warga/approved';
                                });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
                            // Swal.fire('Error!', 'Something went wrong, please try again.', 'error')
                            //     .then(() => {
                            //         window.location.href = '/pengurus/warga/waitingapproval';
                            //     });
                        }
                       
                    });
                }
            });
        });
    });    
</script>
    
@endsection
