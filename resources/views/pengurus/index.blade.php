@extends('layouts.residence.basetemplate')
@section('content')

<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                Pengurus (Admin Operasional)
            </h1>
        </div>

        <div class="p-2">
            <ul class="nav nav-tabs" role="tablist" style="border:none;">
                <li class="nav-item">
                    <a href="{{ route('pengurus.tagihan') }}" class="nav-link custom-nav-button active">
                        <i class="fa fa-check-circle fa-2x"></i> <!-- Ikon Approval -->
                        <span class="d-block">Biaya</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengurus.role') }}" class="nav-link custom-nav-button active">
                        <i class="fa fa-id-card fa-2x"></i> <!-- Ikon History -->
                        <span class="d-block">Peran</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengurus.warga.waiting') }}" class="nav-link custom-nav-button active">
                        <i class="fa fa-users fa-2x"></i> <!-- Ikon Warga -->
                        <span class="d-block">Warga</span>
                    </a>
                </li>
              </ul>            
        
            <!-- Tab panes -->
            {{-- <div class="tab-content border-top-0">
                <div class="tab-pane fade show active" id="tagihan" role="tabpanel">
                   @include('pengurus.tagihan.menutagihan')
                </div>
                <div class="tab-pane fade" id="role" role="tabpanel">
                    @include('pengurus.listrole')
                </div>
                <div class="tab-pane fade" id="warga" role="tabpanel">
                    @include('pengurus.listwarga')
                </div>
            </div> --}}
        </div>
       
    </div>
</div>
@endsection 
