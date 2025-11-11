@extends('layouts.residence.basetemplate')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12" style="padding-left:10px;padding-right:10px;">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="font-semibold text-2xl" style="color: #2d3748;">
                    <i class="fas fa-store" style="color: #3d7357;"></i> Kelola Pendaftaran Seller
                </h3>
                @if($pendingCount > 0)
                <span class="badge bg-warning text-dark">{{ $pendingCount }} Menunggu</span>
                @endif
            </div>

            <form action="{{ route('pengurus.seller-requests.index') }}" method="GET" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-6">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama toko atau user..." class="form-control">
                    </div>
                    <div class="col-md-4">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn w-100" style="background-color: #3d7357; color: white;">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>

            @if($sellerRequests->count() > 0)
                @foreach($sellerRequests as $request)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="mb-1">
                                    <i class="fas fa-store-alt" style="color: #3d7357;"></i> 
                                    {{ $request->store_name }}
                                </h5>
                                <p class="mb-1 text-muted">
                                    <i class="fas fa-user"></i> {{ $request->user->name ?? 'User' }}
                                </p>
                                <p class="mb-1 text-muted small">
                                    <i class="fas fa-envelope"></i> {{ $request->user->email ?? '-' }}
                                </p>
                                <p class="mb-0">
                                    <span class="badge" style="background-color: #dcfce7; color: #3d7357;">
                                        <i class="fas fa-tag"></i> {{ $request->product_type }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-3 text-center">
                                @if($request->status == 'pending')
                                    <span class="badge bg-warning text-dark">
                                        <i class="far fa-clock"></i> Menunggu
                                    </span>
                                @elseif($request->status == 'approved')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Disetujui
                                    </span>
                                    <p class="small text-muted mb-0 mt-1">
                                        oleh {{ $request->approver->name ?? 'Admin' }}
                                    </p>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times"></i> Ditolak
                                    </span>
                                    <p class="small text-muted mb-0 mt-1">
                                        oleh {{ $request->approver->name ?? 'Admin' }}
                                    </p>
                                @endif
                                <p class="small text-muted mt-1">{{ $request->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="col-md-3 text-end">
                                <a href="{{ route('pengurus.seller-requests.show', $request->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color: #3d7357; color: white; border-radius: 8px;">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="d-flex justify-content-center mt-4">
                    {{ $sellerRequests->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada pendaftaran seller.</p>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
