@extends('layouts.basetemplate')
@section('content')
 

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="white-box stat-widget">
                Welcome {{ Auth::user()->name }} to member page list
            </div>
        </div>
    </div>
</div>
@endsection