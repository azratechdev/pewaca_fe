@extends('layouts.residence.basetemplate')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="row" style="padding-top:20px;">
            <div class="col-md-12 col-sm-12">
                <div class="pull-left"><a href="{{ route('home') }}" class="text-dark"><i class="fa fa-arrow-left"></i></a></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-center">Input Data Warga</h5>
                </div>
                <div class="card-body">
                    <form id="loginform" method="post" >
                        <div class="mb-3">
                            <label for="title" class="form-label">Nama :</label>
                            <input type="text" class="form-control" id="judul" value="Nama Warga">
                        </div>
                        <div class="mb-3">
                            <label for="deskirpsi" class="form-label">Alamat :</label>
                            <textarea type="deskripsi" col="5" class="form-control" id="deskripsi">Pendaftaran Warga Baru</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Foto :</label>
                            <input type="file" class="form-control" id="gambar">
                        </div>
                        <a class="btn btn-success" href="{{ route('home') }}" role="button"><i class="fa fa-save"></i> Submit</a>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
  
@endsection 