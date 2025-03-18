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
            @if($note['is_pengurus'] == true)
            <div class="card border !border-red-500 rounded-lg">
                <div class="flex items-start">
                    <img 
                        alt="" 
                        class="rounded w-32 h-32" 
                        src="https://admin.pewaca.id/media/tagihan_images/envelope.jpg" 
                    />
                    
                    <div class="ml-2 pt-2 flex flex-col justify-start">
                        <div class="text-gray-900 font-bold">
                            Pengurus
                        </div>
                        <br>
                        <div class="text-sm">
                            <p class="text-gray-400">Note:</p>
                            {{ $note['note'] }}
                        </div>
                    </div>
                </div>
            </div>
            @else

            <div class="card border !border-grey-500 rounded-lg">
                <div class="flex items-start">
                    <img 
                        alt="" 
                        class="rounded w-32 h-32" 
                        src="https://admin.pewaca.id/media/tagihan_images/envelope.jpg" 
                    />
                    
                    <div class="ml-2 pt-2 flex flex-col justify-start">
                        <div class="text-gray-900 font-bold">
                            Warga
                        </div>
                        <br>
                        <div class="text-sm">
                            <p class="text-gray-400">Note:</p>
                            {{ $note['note'] }}
                        </div>
                        
                        {{-- <div class="text-sm">
                            <p class="text-gray-400">Nominal: <span class="text-black">Rp250.000</span></p>
                        </div> --}}
                    </div>
                </div>
            </div>
            @endif
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