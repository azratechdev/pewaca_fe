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

            @if(!empty($data_tagihan) && count($data_tagihan) > 0)
               
                @foreach($data_tagihan as $tagihan)
                <div class="flex justify-center items-center" style="height: 100%;">
                    <div class="bg-white w-full max-w-6xl">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                <strong>{{ $tagihan['tagihan']['name'] }}</strong>
                                </p>
                            </div>
                
                            <div class="flex items-center">
                                <?php if ($tagihan['tagihan']['tipe'] == "wajib"){
                                        $col = 'red';
                                    }else{
                                        $col = 'lightgreen';
                                    }
                                ?>
                                <p class="d-flex align-items-center" style="color:<?php echo $col;?>">
                                <strong>{{ $tagihan['tagihan']['tipe'] }}</strong>
                                </p>
                            </div>
                        </div>  
                    
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                    {{ $tagihan['tagihan']['description'] }}
                                </p>
                            </div>
                        </div> 
                        <div class="flex justify-between items-center mt-1">
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                Nominal
                                </p>
                            </div>
                            
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                    @php
                                        $formattedAmount = 'Rp ' . number_format($tagihan['tagihan']['amount'], 0, ',', '.');
                                    @endphp
                                    {{ $formattedAmount }}
                                </p>
                            </div>
                        </div> 
                    
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                Terakhir Pembayaran
                                </p>
                            </div>
                            
                            <div class="flex items-center">
                                <p class="d-flex align-items-center">
                                {{ \Carbon\Carbon::parse($tagihan['tagihan']['date_due'])->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-2">
                    @if($tagihan['status'] == 'rejected')
                    <div class="flex items-center justify-left bg-red-50 p-2 rounded-lg shadow-md w-full max-w-full mt-3">
                        <div class="flex items-left">
                            <i class="fas fa-wallet-x text-red-500 text-2xl mr-3"></i>
                            <div>
                                <p class="text-red-500 font-semibold">Pembayaran Tidak Disetujui</p>
                                <p class="text-red-500">Note: Photo bukti pembayaran tidak jelas mohon uplaod ulang bukti pembayaran</p>
                            </div>
                        </div>
                    </div>
                    @endif
                
                    @if(date('Y-m-d') > $tagihan['tagihan']['date_due']  && $tagihan['status'] == 'unpaid') 
                        @include('layouts.elements.tempo')
                    @endif
                
                    @if($tagihan['status'] == 'process')
                        @include('layouts.elements.confirm')
                    @endif
                </div>
                
                <div class="flex justify-between items-center mt-2">
                    <div class="flex items-center">
                        <p class="text-warning d-flex align-items-center">
                            
                        </p>
                    </div>
                    @if($tagihan['status'] == 'unpaid')
                        <div class="flex items-right">
                            @if($tagihan['tagihan']['tipe'] != 'wajib')
                            <a href="#" class="btn btn-sm btn-light w-20" style="border-radius:8px;">Tidak</a>
                            @endif
                            &nbsp;&nbsp;
                            <a href="{{ route('pembayaran.add', ['id' => $tagihan['id']]) }}" class="btn btn-sm btn-success w-20 btn-publish" style="color: white;border-radius:8px;">Bayar</a>
                        </div>
                    @else
                        <div class="flex items-right">
                            &nbsp;&nbsp;
                            <a href="{{ route('pembayaran.detail_bukti', ['id' => $tagihan['id']]) }}" class="btn btn-sm btn-success w-20 btn-publish" style="color: white;border-radius:8px;">Detail</a>
                        </div>
                    @endif
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
            @else
                {{-- @include('pembayaran.pembayaran_view') --}}

                {{-- Uncomment if you want to show a message when there are no payments --}}
               <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: auto; text-align: center;">
                    <div>
                        <img src="{{ asset('assets/plugins/images/konfirmasi-empty.png') }}" alt="Biaya kosong" style="max-width: 200px; height: auto;" />
                    </div>
                    <div style="font-size: 14px; margin-top: 10px;">
                        <h2 style="font-size: 16px; font-weight: bold;">
                            Tagihan belum tersedia
                        </h2>
                    </div>
                </div><br>


            @endif
        </div>
    </div>
</div>
@endsection