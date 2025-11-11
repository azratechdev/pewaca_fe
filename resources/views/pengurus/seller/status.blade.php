@extends('layouts.residence.basetemplate')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow-sm">
                <div class="card-header text-white text-center" style="background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);">
                    <h4 class="mb-0">
                        <i class="fas fa-store"></i> Status Pendaftaran Seller
                    </h4>
                </div>
                <div class="card-body p-4">
                    
                    @if($sellerRequest->status == 'pending')
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="far fa-clock fa-5x" style="color: #ffc107;"></i>
                            </div>
                            <h5 class="mb-3">Pendaftaran Sedang Diproses</h5>
                            <p class="text-muted">
                                Pendaftaran Anda untuk toko "<strong>{{ $sellerRequest->store_name }}</strong>" sedang menunggu persetujuan dari pengurus.
                            </p>
                            <div class="alert alert-info mt-4">
                                <i class="fas fa-info-circle"></i> 
                                Anda akan menerima pemberitahuan setelah pendaftaran Anda diproses.
                            </div>
                            <div class="mt-4">
                                <p class="small text-muted">Tanggal pendaftaran: {{ $sellerRequest->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                    @elseif($sellerRequest->status == 'approved')
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-check-circle fa-5x text-success"></i>
                            </div>
                            <h5 class="mb-3 text-success">Pendaftaran Disetujui!</h5>
                            <p class="text-muted">
                                Selamat! Pendaftaran Anda untuk toko "<strong>{{ $sellerRequest->store_name }}</strong>" telah disetujui.
                            </p>
                            <div class="alert alert-success mt-4">
                                <i class="fas fa-party-horn"></i> 
                                Anda sekarang dapat mulai berjualan di Warungku!
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('pengurus.seller.dashboard') }}" class="btn btn-lg text-white" style="background-color: #3d7357;">
                                    <i class="fas fa-arrow-right"></i> Kelola Toko Saya
                                </a>
                            </div>
                            <div class="mt-3">
                                <p class="small text-muted">
                                    Disetujui oleh {{ $sellerRequest->approver->name ?? 'Admin' }} 
                                    pada {{ $sellerRequest->approved_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>

                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-times-circle fa-5x text-danger"></i>
                            </div>
                            <h5 class="mb-3 text-danger">Pendaftaran Ditolak</h5>
                            <p class="text-muted">
                                Maaf, pendaftaran Anda untuk toko "<strong>{{ $sellerRequest->store_name }}</strong>" tidak dapat disetujui.
                            </p>
                            
                            @if($sellerRequest->rejection_reason)
                                <div class="alert alert-danger mt-4 text-start">
                                    <h6 class="fw-bold mb-2">
                                        <i class="fas fa-info-circle"></i> Alasan Penolakan:
                                    </h6>
                                    <p class="mb-0">{{ $sellerRequest->rejection_reason }}</p>
                                </div>
                            @endif

                            <div class="mt-4">
                                <p class="text-muted">
                                    Anda dapat mendaftar kembali dengan memperbaiki kekurangan yang disebutkan di atas.
                                </p>
                                <a href="{{ route('pengurus.seller.register') }}" class="btn btn-lg text-white" style="background-color: #3d7357;">
                                    <i class="fas fa-redo"></i> Daftar Lagi
                                </a>
                            </div>
                            <div class="mt-3">
                                <p class="small text-muted">
                                    Ditolak oleh {{ $sellerRequest->approver->name ?? 'Admin' }} 
                                    pada {{ $sellerRequest->approved_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="card-footer text-center bg-light">
                    <a href="{{ route('warungku.index') }}" class="text-decoration-none" style="color: #3d7357;">
                        <i class="fas fa-arrow-left"></i> Kembali ke Warungku
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
