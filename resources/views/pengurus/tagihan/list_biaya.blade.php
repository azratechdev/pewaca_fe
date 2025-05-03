@extends('layouts.residence.basetemplate')
@section('content')
@php
    session(['origin_page' => url()->current()]);
@endphp
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('pengurus') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Biaya
            </h1>
        </div>

        @include('pengurus.tagihan.menutagihan')

        <div class="col-md-12 col-sm-12" style="padding-left:10px;padding-right:10px;">

            <form action="{{ route('pengurus.biaya.list') }}" method="POST" class="flex items-center border border-gray-300 rounded-lg overflow-hidden w-full max-w-6xl">
                @csrf
                <input type="text" name="filter" placeholder=" Search..." class="py-2 pl-3 w-full focus:outline-none">
                <button type="submit" class="bg-green-500 text-white px-3 py-3 flex items-center justify-center">
                    <i class="fas fa-search"></i>
                </button>
            </form><br>

            @foreach($biaya as $tagihan)
            <div class="flex justify-center items-center" style="height: 100%;">
                <div class="bg-white w-full max-w-6xl">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <p class="d-flex align-items-center">
                            <strong>{{ $tagihan['name'] }}</strong>
                            </p>
                        </div>
                    </div>  
                
                    <div class="flex justify-between items-center mt-2">
                        <div class="flex items-center">
                            <p class="d-flex align-items-center">
                                {{ $tagihan['description'] }}
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
                                Rp {{ $tagihan['amount'] }}
                            </p>
                        </div>
                    </div> 
                    <div class="flex justify-between items-center mt-2">
                        <div class="flex items-center">
                            <p class="d-flex align-items-center">
                            Type Iuran
                            </p>
                        </div>
                        
                        <div class="flex items-center">
                            <p class="d-flex align-items-center" style="color: red;">
                                {{ $tagihan['tipe'] }}
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
                            {{ \Carbon\Carbon::parse($tagihan['date_due'])->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-between items-center mt-2">
                <div class="flex items-center">
                    <p class="text-warning d-flex align-items-center">
                        
                    </p>
                </div>
                @if($tagihan['is_publish'] == false)
                <div class="flex items-right">
                    <a href="{{ route('pengurus.tagihan.edit', ['id' => $tagihan['id']]) }}" class="btn btn-sm btn-light w-20" style="border-radius:8px;">Edit</a>
                    &nbsp;&nbsp;
                    <a data-id="{{ $tagihan['id'] }}" class="btn btn-sm btn-success w-20 btn-publish" style="color: white;border-radius:8px;">Publish</a>
                </div>
                @else
                <div class="flex items-right">
                    <a class="btn btn-sm btn-primary w-20" style="color: white;border-radius:8px;">Published</a>
                </div>
                @endif
            </div>
            <hr class="mt-3 mb-2">
            @endforeach

            <div class="flex justify-between items-center @if($previous_page == null || $next_page == null) justify-end @else justify-between @endif">
                @if($previous_page)
                <div class="flex items-center">
                    <form action="{{ route('pengurus.biaya.list') }}" method="POST">
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
                    <form action="{{ route('pengurus.biaya.list') }}" method="POST">
                        @csrf
                        <input type="hidden" name="page" value="{{ $next }}">
                        <button type="submit" class="btn btn-sm btn-info text-white">
                            Next Page >
                        </button>
                    </form>
                </div>
                @endif
            </div>
            <br>
            <div class="p-0 mt-2">
                <a href="{{ route('tagihan.add') }}" 
                    class="btn btn-success w-full bg-green-600 text-white py-2 px-4 rounded-lg">
                    ADD
                </a>
            </div>

        </div>
    </div>
</div>
@endsection