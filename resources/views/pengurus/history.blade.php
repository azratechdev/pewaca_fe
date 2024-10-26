@extends('layouts.residence.basetemplate')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="row" style="padding-top:20px;">
            <div class="col-md-12 col-sm-12">
                <div class="pull-left"><b>Riwayat Pembayaran Warga</b></div>
                <div class="pull-right">
                    {{-- <a class="btn btn-default btn-sm" href="{{ route('addpost') }}">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Post
                    </a> --}}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 col-sm-12">
                        <div class="pull-left"><b>Nama warga 1 - Nama Pembayaran</b></div>
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
                        <div class="pull-left"><b>Nama warga 2 - Nama Pembayaran</b></div>
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
                        <div class="pull-left"><b>Nama warga 3 - Nama Pembayaran</b></div>
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
  </div>
  
@endsection  