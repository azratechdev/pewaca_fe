@extends('layouts.residence.basetemplate')
@section('content')

<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('pengurus.report') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Detail Report
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

            <div class="flex justify-center mb-4">
                <div class="text-center mb-2">
                    <div class="text-gray-500">Jumlah Warga</div>
                    <div id="total_by_type" class="text-2xl font-bold">100</div>
                </div>
            </div>

            <div class="flex justify-center mb-4">
                <div class="w-full md:w-1/2 flex flex-col items-center">
                    <div id="bypembayaran" style="width:280px;height:280px;"></div>
                    <div class="flex justify-center gap-4">
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-3 h-3 rounded-full" style="background:#128C7E;"></span>
                            <span>Sudah Bayar</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-3 h-3 rounded-full" style="background:#F58220;"></span>
                            <span>Belum Bayar</span>
                        </div>
                    </div>
                </div>
                
            </div>
            {{-- Tabs for Wajib and Sukarela --}}
            <div class="bg-white rounded-xl shadow mb-4">
                <div class="flex border-b">
                    <button id="tab-sudahbayar" type="button" class="w-1/2 py-2 text-center font-semibold text-green-600 border-b-2 border-green-500 focus:outline-none">Sudah Bayar</button>
                    <button id="tab-belumbayar" type="button" class="w-1/2 py-2 text-center font-semibold text-gray-400 border-b-2 border-transparent focus:outline-none">Belum Bayar</button>
                </div>
                <div id="tab-content-sudahbayar" class="p-4">
                    {{-- <div class="rounded-xl bg-gray-100 p-3 mb-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-semibold">Total</span>
                            <span class="font-semibold">Rp 12.000.000</span>
                        </div>
                    </div> --}}
                    <div class="divide-y divide-gray-200">
                        @for($i=0; $i<5; $i++)
                        <div class="py-4">
                            <div class="flex justify-between">
                                <div>
                                    <div class="text-gray-500">Nama Unit</div>
                                    <div class="text-gray-500">Tanggal</div>
                                    <div class="text-gray-500">Nominal</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-semibold">C44</div>
                                    <div class="font-semibold">12 April 2025</div>
                                    <div class="font-semibold">IDR 150.000</div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                    <div class="flex justify-center mt-4"><button class="w-full md:w-3/4 border-2 border-green-600 text-green-600 px-6 py-2 rounded-lg font-semibold">More</button>
                        
                    </div>
                </div>
                <div id="tab-content-belumbayar" class="p-4 hidden">
                    {{-- <div class="rounded-xl bg-gray-100 p-3 mb-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-semibold">Total</span>
                            <span class="font-semibold">Rp 8.000.000</span>
                        </div>
                    </div> --}}
                    <div class="divide-y divide-gray-200">
                        @for($i=0; $i<3; $i++)
                        <div class="py-4">
                            <div class="flex justify-between">
                                <div>
                                    <div class="text-gray-500">Nama Unit</div>
                                    <div class="text-gray-500">Tanggal</div>
                                    <div class="text-gray-500">Nominal</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-semibold">C12</div>
                                    <div class="font-semibold">12 April 2025</div>
                                    <div class="font-semibold">IDR 200.000</div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                    <div class="flex justify-center mt-4">
                        <button class="w-full md:w-3/4 border-2 border-green-600 text-green-600 px-6 py-2 rounded-lg font-semibold">More</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    Highcharts.chart('bypembayaran', {
        chart: {
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    distance: -60, // Menempatkan label di dalam irisan
                    formatter: function () {
                        return '<b>' + this.point.name + '</b><br>' +
                            this.y + ' Warga<br>';
                    },
                    style: {
                        color: 'white',
                        textOutline: 'none',
                        fontWeight: 'bold',
                        fontSize: '13px'
                    }
                }
            }
        },
        series: [{
            name: 'Warga',
            colorByPoint: true,
            data: [{
                name: '',
                y: 80,
                color: '#128C7E' // green-500
            }, {
                name: '',
                y: 20,
                color: '#F58220' // red-500
            }]
        }]
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const tabWajib = document.getElementById('tab-sudahbayar');
    const tabSukarela = document.getElementById('tab-belumbayar');
    const contentWajib = document.getElementById('tab-content-sudahbayar');
    const contentSukarela = document.getElementById('tab-content-belumbayar');
    tabWajib.addEventListener('click', function() {
        tabWajib.classList.add('text-green-600', 'border-green-500');
        tabWajib.classList.remove('text-gray-400', 'border-transparent');
        tabSukarela.classList.remove('text-green-600', 'border-green-500');
        tabSukarela.classList.add('text-gray-400', 'border-transparent');
        contentWajib.classList.remove('hidden');
        contentSukarela.classList.add('hidden');
    });
    tabSukarela.addEventListener('click', function() {
        tabSukarela.classList.add('text-green-600', 'border-green-500');
        tabSukarela.classList.remove('text-gray-400', 'border-transparent');
        tabWajib.classList.remove('text-green-600', 'border-green-500');
        tabWajib.classList.add('text-gray-400', 'border-transparent');
        contentSukarela.classList.remove('hidden');
        contentWajib.classList.add('hidden');
    });
});
</script>
@endsection
