@extends('layouts.residence.basetemplate')
@section('content')
@php
    session(['origin_page' => url()->current()]);
    $cred = session('cred');
    $backRoute = isset($cred['is_pengurus']) && $cred['is_pengurus'] ? route('pengurus') : route('home');
@endphp
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ $backRoute }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Cashout
            </h1>
        </div>

        @include('pembayaran.menupembayaran')

        <div class="col-md-12 col-sm-12" style="padding-left:10px;padding-right:10px;">
            @if(empty($data_tagihan))
                <h2 align="center">Belum ada Riwayat</h2>
            @else
                <form action="{{ route('pembayaran.list') }}" method="POST" class="flex items-center border border-gray-300 rounded-lg overflow-hidden w-full max-w-6xl">
                    @csrf
                    <input type="text" name="filter" placeholder=" Search..." class="py-2 pl-3 w-full focus:outline-none">
                    <button type="submit" class="bg-green-500 text-white px-3 py-3 flex items-center justify-center">
                        <i class="fas fa-search"></i>
                    </button>
                </form><br>

                <div class="mb-3">
                    @include('layouts.elements.flash')
                </div>
           
                @foreach($data_tagihan as $key => $tagihan)
                
                <div class="flex justify-center items-center" style="height: 100%;">
                    <div class="bg-white w-full max-w-6xl">
                        <div class="flex items-left max-w-full mb-2">
                            <div class="ml-0">
                                <div class="text-gray-900 font-bold" style="font-size: 17px;">
                                    <strong>{{ $tagihan['tagihan']['name'] }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <div class="text-black-900 font-semibold" style="font-size: 15px;color:lightgrey;">
                                    <p>Deskripsi</p>
                                </div>
                            </div>
                        </div> 
                                           
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <div class="text-black-900 font-semibold" style="font-size: 16px;">
                                    <p>Nominal</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="text-black-900 font-semibold" style="font-size: 16px;">
                                    @php
                                        $formattedAmount = number_format((int) $tagihan['tagihan']['amount'], 0, ',', '.');
                                    @endphp
                                    <p>Rp {{ $formattedAmount }}</p>
                                 </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <div class="text-black-900 font-semibold" style="font-size: 16px;">
                                    <p>Terakhir Pembayaran</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="text-black-900 font-semibold" style="font-size: 16px;">
                                    {{ \Carbon\Carbon::parse($tagihan['tagihan']['date_due'])->addHours(12)->locale('id')->translatedFormat('d F Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <div class="text-black-900 font-semibold" style="font-size: 16px;">
                                    <p>Disetujui</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="text-black-900 font-semibold" style="font-size: 16px;">
                                    {{ \Carbon\Carbon::parse($tagihan['paydate'])->addHours(12)->locale('id')->translatedFormat('d F Y (H:i)') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                    @if($tagihan['status'] == 'paid')
                    <div class="flex justify-between items-center mt-2">
                        @include('layouts.elements.approved')
                    </div>
                    @endif

                <div class="flex justify-between items-center mt-2">
                    <div class="flex items-center">
                        <p class="text-warning d-flex align-items-center"></p>
                    </div>
                    <div class="flex items-right">
                        <a href="{{ route('pembayaran.detail_bukti', ['id' => $tagihan['id']]) }}" class="btn btn-sm btn-success w-20 btn-detail" style="color: white;border-radius:8px;">Detail</a>
                    </div>
                </div>
                <hr class="mt-3 mb-2">
               
                @endforeach

                <div class="flex justify-between items-center @if($previous_page == null || $next_page == null) justify-end @else justify-between @endif">
                    @if($previous_page)
                    <div class="flex items-center">
                        <form action="{{ route('pembayaran.list') }}" method="POST">
                            @csrf
                            <input type="hidden" name="page" value="{{ $prev }}">
                            <button type="submit" class="btn btn-sm btn-info text-white">
                                < Previous
                            </button>
                        </form>
                    </div>
                    @endif

                    <div class="flex-grow text-center">
                        Page {{ $current }} of {{ $total_pages }}
                    </div>
                
                    @if($next_page)
                    <div class="flex items-center ml-auto">
                        <form action="{{ route('pembayaran.list') }}" method="POST">
                            @csrf
                            <input type="hidden" name="page" value="{{ $next }}">
                            <button type="submit" class="btn btn-sm btn-info text-white">
                                Next Page >
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection