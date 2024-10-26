@extends('layouts.residence.basetemplate')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
           
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-center text-white">Registrasi Warga</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="name" placeholder="Nama" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="address" placeholder="Alamat" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="email" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="password" placeholder="Password" required>
                        </div>
                        <div class="mb-3">
                            <input type="file" class="form-control" id="photo" accept="image/*" title="Upload" required>
                        </div>
                        <button type="submit" class="btn btn-success">Daftar Sebagai Warga</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection 