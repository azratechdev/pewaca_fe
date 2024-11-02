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
                        <div class="col-md-12 col-sm-12">
                            <div class="pull-left"><b>Approval Pembayaran</b></div>
                        </div><br>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 col-sm-12">
                                        <p><b>Warga 1 - Pembayaran Abc</b></p>
                                        <br>
                                        <a class="btn btn-success btn-sm" href="#">
                                            <i class="fa fa-check" aria-hidden="true"></i> Approve
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#">
                                            <i class="fa fa-cros" aria-hidden="true"></i> Reject
                                        </a>
                                    </div>
                                </div>
                            </div>
                
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 col-sm-12">
                                        <p><b>Warga 2 - Pembayaran Abc</b></p>
                                        <br>
                                        <a class="btn btn-success btn-sm" href="#">
                                            <i class="fa fa-check" aria-hidden="true"></i> Approve
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#">
                                            <i class="fa fa-cros" aria-hidden="true"></i> Reject
                                        </a>
                                    </div>
                                </div>
                            </div>
                
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 col-sm-12">
                                        <p><b>Warga 3 - Pembayaran Abc</b></p>
                                        <br>
                                        <a class="btn btn-success btn-sm" href="#">
                                            <i class="fa fa-check" aria-hidden="true"></i> Approve
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#">
                                            <i class="fa fa-cros" aria-hidden="true"></i> Reject
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="riwayat" role="tabpanel">
                        <div class="col-md-12 col-sm-12">
                            <div class="pull-left"><b>Riwayat Pembayaran Warga</b></div>
                        </div><br>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="pull-left"><b>Warga 1 - Pembayaran abc</b></div>
                                        <div class="pull-right">
                                            <button class="btn btn-success btn-sm">
                                                <i class="fa fa-check" aria-hidden="true"></i> Success
                                            </botton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="pull-left"><b>Warga 2 - Pembayaran abc</b></div>
                                        <div class="pull-right">
                                            <button class="btn btn-success btn-sm">
                                                <i class="fa fa-check" aria-hidden="true"></i> Success
                                            </botton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="pull-left"><b>Warga 3 - Pembayaran abc</b></div>
                                        <div class="pull-right">
                                            <button class="btn btn-success btn-sm">
                                                <i class="fa fa-check" aria-hidden="true"></i> Success
                                            </botton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="warga" role="tabpanel">
                        <div class="col-md-12 col-sm-12">
                            <div class="pull-left"><b>Daftar Warga</b></div>
                        </div><br><br>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>NIK</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($data_warga['data']))
                                            @if(!empty($data_warga['data']))
                                                
                                                @foreach ($data_warga['data'] as $key => $v )
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $v['nik'] }}</td>
                                                    <td>{{ $v['full_name'] }}</td>
                                                    <td>{{ $v['phone_no'] }}</td>
                                                    <td>
                                                        <button style="color: white;" class="btn btn-sm btn-info" id="detail" data-id="{{ $v['id'] }}" title="Detail Warga">
                                                            <i class="fa fa-list" aria-hidden="true"> Detail</i>
                                                        </button> 
                                                        <button style="color: white;" class="btn btn-sm btn-warning" id="detail" data-id="{{ $v['id'] }}" title="Edit Warga">
                                                            <i class="fa fa-pencil" aria-hidden="true"> Edit</i>
                                                        </button> 
                                                        {{-- <button class="btn btn-xs btn-danger" id="delete_user" data-id="{{ $v['id'] }}" title="Delete User">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                        </button> --}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5">
                                                        <strong>{{ $data_warga['messageS'] }}</strong>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  
@endsection 