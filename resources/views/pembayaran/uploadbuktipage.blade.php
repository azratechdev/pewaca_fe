@extends('layouts.residence.basetemplate')
@section('content')

@if ($tagihan['data']['status'] == 'unpaid')
    @include('pembayaran.pembayaranwarga')
@endif
@if($tagihan['data']['status'] == 'process')
    @include('pembayaran.notepage')
@endif

@endsection 