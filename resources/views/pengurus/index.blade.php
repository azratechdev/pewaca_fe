@extends('layouts.residence.basetemplate')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="row" style="padding-top:40px;">
            <div class="col-md-12">
                <div class="login-alert">
                    @include('layouts.elements.flash')
                </div>
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
                <div class="tab-content border border-top-0 p-3" style="border-color: #00ffc3;">
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
        </div>
    </div>
  </div>
  
@endsection 