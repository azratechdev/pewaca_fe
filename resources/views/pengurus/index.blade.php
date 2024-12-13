@extends('layouts.residence.basetemplate')
@section('content')

<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl shadow-lg">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                Pengurus (Admin Operasional)
            </h1>
        </div>

        <div class="p-2">
            <ul class="nav nav-tabs" role="tablist" style="border:none;">
                <li class="nav-item">
                    <a class="nav-link custom-nav-button" data-bs-toggle="tab" href="#approval" role="tab">
                        <i class="fa fa-check-circle fa-2x"></i> <!-- Ikon Approval -->
                        <span class="d-block mt-2">Approval</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link custom-nav-button" data-bs-toggle="tab" href="#riwayat" role="tab">
                        <i class="fa fa-history fa-2x"></i> <!-- Ikon History -->
                        <span class="d-block mt-2">History</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active custom-nav-button" data-bs-toggle="tab" href="#warga" role="tab">
                        <i class="fa fa-users fa-2x"></i> <!-- Ikon Warga -->
                        <span class="d-block mt-2">Warga</span>
                    </a>
                </li>
              </ul>            
        
            <!-- Tab panes -->
            <div class="tab-content border-top-0">
                <div class="tab-pane fade" id="approval" role="tabpanel">
                   @include('pengurus.approval')
                </div>
                <div class="tab-pane fade" id="riwayat" role="tabpanel">
                    @include('pengurus.history')
                </div>
                <div class="tab-pane fade show active" id="warga" role="tabpanel">
                    @include('pengurus.listwarga')
                </div>
            </div>
        </div>
       
    </div>
</div>

@endsection 