@extends('layouts.residence.basetemplate')
@section('content')

<div class="container">
    <div class="container mx-auto px-3">
        <div class="flex justify-between items-center" style="padding-top: 20px;">
            <div class="flex items-center">
                <h1 class="text-xl font-semibold text-gray-800">
                    <a href="{{ session('origin_page', route('pembayaran.list')) }}" class="text-dark">
                        <i class="fas fa-arrow-left"></i>
                    </a>&nbsp;&nbsp;Detail Bukti Pembayaran
                </h1>
            </div>
        </div>
        <br>
        <div class="mb-3">
            @include('layouts.elements.flash')
        </div>
        @foreach ($list as $note)
        
        <div class="w-full max-w-full bg-white overflow-hidden">
            <div class="card border rounded-lg p-2 {{ $note['is_pengurus'] ? '!border-red-500' : 'border-gray-900' }}">
                <div class="flex items-start justify-between">
                    <div class="pt-2 flex flex-col justify-start flex-grow">
                        <div class="text-gray-900 font-bold">
                            @if($note['is_pengurus'] == true)
                                Pengurus
                            @else
                                Warga
                            @endif
                        </div>
                        <br>
                        <div class="text-sm">
                            <p class="text-gray-400">Note:</p>
                            {{ $note['note'] }}
                        </div>
                    </div>

                    <div class="ml-4">
                        @if (!empty($note['images']))
                            <img 
                                alt="" 
                                class="rounded w-32 h-32" 
                                src="{{ $note['images'][0]['image'] }}" 
                            />
                        @endif
                    </div>    
                </div>
            </div>
        </div>
        @endforeach
        <br>
        @if($status != "paid")
        <div class="p-0 mt-2">
            <a href="{{ route('pembayaran.upload_bukti', ['id' => $id]) }}" 
                class="btn btn-success w-full bg-green-600 text-white py-2 px-4 rounded-lg">
                ADD
            </a>
        </div>
        @endif
    </div>
</div>

@endsection