@extends('layouts.residence.basetemplate')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="row" style="padding-top:20px;">
            <div class="col-md-12 col-sm-12">
                <div class="pull-left"><h4><b>List Postingan</b></hf></div>
                <div class="pull-right">
                    <a class="btn btn-default btn-sm" href="{{ route('addpost') }}">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Post
                    </a>
                </div>
            </div>
        </div>
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
  
@endsection 