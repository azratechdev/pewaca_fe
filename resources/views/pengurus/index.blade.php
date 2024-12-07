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

        <div class="p-6">
            {{-- <div class="login-alert">
                @include('layouts.elements.flash')
            </div> --}}
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#approval" role="tab">Approval</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#riwayat" role="tab">History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#warga" role="tab">Warga</a>
                </li>
            </ul>
        
            <!-- Tab panes -->
            <div class="tab-content border-top-0 p-3">
                <div class="tab-pane fade show active" id="approval" role="tabpanel">
                   @include('pengurus.approval')
                </div>
                <div class="tab-pane fade" id="riwayat" role="tabpanel">
                    @include('pengurus.history')
                </div>
                <div class="tab-pane fade" id="warga" role="tabpanel">
                    @include('pengurus.listwarga')
                </div>
            </div>
        </div>
       
        {{-- <div class="p-6 border-b">
            <div class="navbar menu-custom navbar-dark navbar-expand bg-white">
                <div class="container-fluid">
                    <ul class="navbar-nav nav-justified w-100">
                        <li class="navbar-item">
                            <a class="navbar-link text-center">
                                <button type="button" class="btn btn-outline-success">
                                    <i class="fa fa-file-invoice fa-2x"></i></button>
                                <span class="small d-block">Tagihan</span>
                            </a>
                        </li>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <li class="menu-item">
                            <a class="menu-link text-center">
                            <button type="button" class="btn btn-outline-success">
                                <i class="fa fa fa-id-badge fa-2x"></i></button>
                            <span class="small d-block">Role</span>
                            </a>
                        </li>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <li class="menu-item">
                            <a class="menu-link text-center">
                                <button type="button" class="btn btn-outline-success">
                                    <i class="fa fa-user fa-2x"></i></button>
                                <span class="small d-block">Warga</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @include('layouts.residence.pengurus_menu') --}}
    </div>
</div>

@endsection 