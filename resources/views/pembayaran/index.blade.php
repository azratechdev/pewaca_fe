@extends('layouts.residence.basetemplate')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="row" style="padding-top:40px;">
            <div class="col-md-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#pembayaran" role="tab">Pembayaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#riwayat" role="tab">Riwayat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#postingan" role="tab">Postingan</a>
                    </li>
                </ul>
            
                <!-- Tab panes -->
                <div class="tab-content border border-top-0 p-3" style="border-color: #00ffc3;">
                    <div class="tab-pane fade show active" id="pembayaran" role="tabpanel">
                        <div class="col-md-12 col-sm-12">
                            <div class="pull-left"><b>Daftar Pembayaran Aktif</b></div>
                        </div><br>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="pull-left"><b>judul Pembayaran 1</b></div>
                                        <div class="pull-right">
                                            <a class="btn btn-primary btn-sm" href="{{ route('addpembayaran') }}">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i> Bayar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="pull-left"><b>judul Pembayaran 2</b></div>
                                        <div class="pull-right">
                                            <a class="btn btn-primary btn-sm" href="{{ route('addpembayaran') }}">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i> Bayar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="pull-left"><b>judul Pembayaran 3</b></div>
                                        <div class="pull-right">
                                            <a class="btn btn-primary btn-sm" href="{{ route('addpembayaran') }}">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i> Bayar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="riwayat" role="tabpanel">
                        <div class="col-md-12 col-sm-12">
                            <div class="pull-left"><b>Riwayat Pembayaran</b></div>
                        </div><br>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="pull-left"><b>Nama Pembayaran 1</b></div>
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
                                        <div class="pull-left"><b>Nama Pembayaran 2</b></div>
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
                                        <div class="pull-left"><b>Nama Pembayaran 3</b></div>
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
                    <div class="tab-pane fade" id="postingan" role="tabpanel">
                        <div class="col-md-12 col-sm-12">
                            <div class="pull-left"><b>Riwayat Postingan</b></div>
                        </div><br>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                     <h5>Judul Postingan 1</h5><br>
                                     <img>image here<img><br><br>
                                     <p>deskripsi postigan disini <p>
                                </div>
                            </div>
                
                            <div class="card">
                                <div class="card-body">
                                    <h5>Judul Postingan 2</h5><br>
                                    <img>image here<img><br><br>
                                    <p>deskripsi postigan disini <p>
                               </div>
                            </div>
                
                            <div class="card">
                                <div class="card-body">
                                    <h5>Judul Postingan 2</h5><br>
                                    <img>image here<img><br><br>
                                    <p>deskripsi postigan disini <p>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  
@endsection 