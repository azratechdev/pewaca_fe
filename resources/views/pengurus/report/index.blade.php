@extends('layouts.residence.basetemplate')
@section('content')

<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('pengurus') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Report
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

            {{-- first chart begin --}}
            <div class="flex flex-col md:flex-row md:items-center gap-8 mb-6">
                <div class="w-full md:w-1/2 flex flex-col items-center">
                    <strong>Pembayaran</strong>
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
                <div class="w-full md:w-1/2 flex flex-col items-center justify-center">
                    <div class="text-center mb-2">
                        <div class="text-gray-500">Total Uang Masuk</div>
                        <div id="total_by_pembayaran" class="text-2xl font-bold">Rp20.000.000</div>
                    </div>
                    <div class="text-center">
                        <div class="text-gray-500">Jumlah Warga</div>
                        <div class="text-2xl font-bold">100</div>
                    </div>
                    <a href="{{ route('pengurus.detail.report') }}" class="mt-4 w-full md:w-3/4 text-center border-2 border-green-600 text-green-600 px-6 py-2 rounded-lg font-semibold">Detail</a>
                </div>
            </div>
            {{-- first chart end --}}

            {{-- second chart begin --}}
            <div class="flex flex-col md:flex-row md:items-center gap-8 mb-6">
                <div class="w-full md:w-1/2 flex flex-col items-center">
                    <strong>Type</strong>
                    <div id="bytype" style="width:280px;height:280px;"></div>
                    <div class="flex justify-center gap-4">
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-3 h-3 rounded-full" style="background:#128C7E;"></span>
                            <span>Wajib</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-3 h-3 rounded-full" style="background:#F58220;"></span>
                            <span>Sukarela</span>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2 flex flex-col items-center justify-center">
                    <div class="text-center mb-2">
                        <div class="text-gray-500">Total Uang Masuk</div>
                        <div id="total_by_type" class="text-2xl font-bold">Rp20.000.000</div>
                    </div>
                    <div class="text-center">
                        <div class="text-gray-500">Jumlah Warga</div>
                        <div class="text-2xl font-bold">100</div>
                    </div>
                    <a href="{{ route('pengurus.detail.bytype') }}" class="mt-4 w-full md:w-3/4 text-center border-2 border-green-600 text-green-600 px-6 py-2 rounded-lg font-semibold">Detail</a>
                </div>
            </div>
            {{-- second chart end --}}

            <div class="flex flex-col md:flex-row md:items-center gap-8 mt-12">
                <div class="w-full md:w-1/2 flex flex-col items-center justify-center">
                    <p class="font-bold mb-3">Tunggakan</p>
                    <div class="text-center mb-2">
                        <div class="text-black-700">Total Unit Menunggak</div>
                        <div class="text-2xl font-bold text-red-500">10</div>
                    </div>
                    <a href="{{ route('pengurus.detail.tunggakan') }}" class="mt-4 w-full md:w-3/4 text-center border-2 border-green-600 text-green-600 px-6 py-2 rounded-lg font-semibold">Detail</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Highcharts JS -->
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


        Highcharts.chart('bytype', {
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
                        distance: -60, // nilai negatif agar label masuk ke dalam irisan
                        formatter: function () {
                            var total = 20000000; // total uang masuk
                            var nominal = (this.percentage / 100) * total;
                            var nominalJuta = nominal / 1000000;
                            return 'Rp' + Highcharts.numberFormat(nominalJuta, 2, ',', '.') + 'Jt<br>(' + Highcharts.numberFormat(this.percentage, 1) + '%)';
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
                name: 'Jenis Pembayaran',
                colorByPoint: true,
                data: [{
                    name: 'Wajib',
                    y: 60,
                    color: '#128C7E' // green-500
                }, {
                    name: 'Sukarela',
                    y: 40,
                    color: '#F58220' // red-500
                }]
            }]
        });


    });
</script>

@endsection
