@extends('layouts.app_pengurus')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="mb-3">
                <a href="{{ route('pengurus.seller-requests.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-header" style="background-color: #3d7357; color: white;">
                    <h5 class="mb-0">
                        <i class="fas fa-store"></i> Detail Pendaftaran Seller
                    </h5>
                </div>
                <div class="card-body">
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status</div>
                        <div class="col-md-8">
                            @if($sellerRequest->status == 'pending')
                                <span class="badge bg-warning text-dark">
                                    <i class="far fa-clock"></i> Menunggu Persetujuan
                                </span>
                            @elseif($sellerRequest->status == 'approved')
                                <span class="badge bg-success">
                                    <i class="fas fa-check"></i> Disetujui
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-times"></i> Ditolak
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <h6 class="text-muted mb-3">Informasi Toko</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nama Toko</div>
                        <div class="col-md-8">{{ $sellerRequest->store_name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Alamat Toko</div>
                        <div class="col-md-8">{{ $sellerRequest->store_address }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Jenis Produk</div>
                        <div class="col-md-8">
                            <span class="badge" style="background-color: #dcfce7; color: #3d7357;">
                                {{ $sellerRequest->product_type }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    <h6 class="text-muted mb-3">Informasi Pemohon</h6>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nama</div>
                        <div class="col-md-8">{{ $sellerRequest->user->name ?? '-' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Email</div>
                        <div class="col-md-8">{{ $sellerRequest->user->email ?? '-' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tanggal Daftar</div>
                        <div class="col-md-8">{{ $sellerRequest->created_at->format('d M Y H:i') }}</div>
                    </div>

                    @if($sellerRequest->status != 'pending')
                        <hr>
                        <h6 class="text-muted mb-3">Informasi Persetujuan</h6>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Diproses Oleh</div>
                            <div class="col-md-8">{{ $sellerRequest->approver->name ?? '-' }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Tanggal Diproses</div>
                            <div class="col-md-8">{{ $sellerRequest->approved_at ? $sellerRequest->approved_at->format('d M Y H:i') : '-' }}</div>
                        </div>

                        @if($sellerRequest->status == 'rejected' && $sellerRequest->rejection_reason)
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Alasan Penolakan</div>
                                <div class="col-md-8">
                                    <div class="alert alert-danger mb-0">
                                        {{ $sellerRequest->rejection_reason }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                </div>
                
                @if($sellerRequest->status == 'pending')
                <div class="card-footer bg-light">
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="fas fa-times"></i> Tolak
                        </button>
                        <form action="{{ route('pengurus.seller-requests.approve', $sellerRequest->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui pendaftaran seller ini?')">
                                <i class="fas fa-check"></i> Setujui
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pengurus.seller-requests.reject', $sellerRequest->id) }}" method="POST">
                @csrf
                <div class="modal-header" style="background-color: #dc3545; color: white;">
                    <h5 class="modal-title" id="rejectModalLabel">
                        <i class="fas fa-times-circle"></i> Tolak Pendaftaran Seller
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label fw-bold">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="4" required minlength="10" maxlength="500" placeholder="Jelaskan alasan penolakan pendaftaran seller ini (minimal 10 karakter)"></textarea>
                        <div class="form-text">Minimal 10 karakter, maksimal 500 karakter</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Tolak Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
