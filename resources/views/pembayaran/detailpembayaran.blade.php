@extends('layouts.residence.basetemplate')
@section('content')

<div class="container">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center" style="padding-top: 10px;">
        <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-800">
            <a href="{{ route('pembayaran') }}" class="text-dark">
                <i class="fas fa-arrow-left"></i>
            </a>&nbsp;&nbsp;Detail Bukti Pembayaran
        </h1>
        </div>
        </div>
        <br>
        <div class="mb-3">
            @include('layouts.elements.flash')
        </div>
   
        <div class="p-0 mt-2">
            <a href="{{ route('tagihan.add') }}" 
                class="btn btn-success w-full bg-green-600 text-white py-2 px-4 rounded-lg">
                ADD
            </a>
        </div>
    </div>
</div>

@endsection 