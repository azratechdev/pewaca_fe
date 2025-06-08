@extends('layouts.residence.basetemplate')
@section('content')

<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('pengurus.report') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Detail Tunggakan Unit
            </h1>
        </div>
        
        <div class="col-md-12 col-sm-12" style="padding-left:20px;padding-right:20px;">
            <div class="flex justify-center mb-6 mt-4">
                <div class="relative w-full">
                    <form method="GET" action="" class="flex items-center space-x-3">
                        <label for="periode" class="text-sm font-medium text-gray-700">Periode</label>
                        <input type="month" name="periode" id="periode" class="w-full border rounded px-6 py-2" value="{{ request('periode', date('Y-m')) }}" />
                        {{-- <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                            <span class="fas fa-search"></span>
                        </button> --}}
                    </form>
                </div>
            </div>
        
            <!-- Search Unit -->
            <div class="flex justify-center mb-4">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-search text-gray-400"></i>
                    </span>
                    <input type="text" placeholder="Search Unit" class="w-full border rounded pl-10 pr-3 py-2" />
                </div>
            </div>
            <!-- Summary Box -->
            <div class="rounded-xl bg-gray-100 p-2 mb-4">
                <div class="flex justify-between items-center text-sm mb-1">
                    <span class="font-semibold">Total unit</span>
                    <span class="font-semibold">10</span>
                </div>
                <hr class="my-1 border-black-200">
                <div class="flex justify-between items-center text-sm">
                    <span class="font-semibold">Total nominal</span>
                    <span class="font-semibold">Rp 15.000.000</span>
                </div>
            </div>
            <!-- List Tunggakan -->
            <div class="divide-y divide-gray-200">
                @for($i=0; $i<5; $i++)
                <div class="py-4">
                    <div class="flex justify-between">
                        <div>
                            <div class="text-gray-500">Nama Unit</div>
                            <div class="text-gray-500">Periode</div>
                            <div class="text-gray-500">Tahun</div>
                        </div>
                        <div class="text-right">
                            
                            <div class="font-semibold">C44</div>
                            <div class="font-semibold">April,Mei</div>
                            <div class="font-semibold">2025</div>
                        </div>
                    </div>
                    <div class="flex justify-between mt-2">
                        <div class="text-gray-500">Total Nominal</div>
                        <div class="font-semibold">IDR {{ $i % 2 == 0 ? '300.000' : '150.000' }}</div>
                    </div>
                </div>
                @endfor
                
            </div>
        </div>
    </div>
</div>

@endsection
