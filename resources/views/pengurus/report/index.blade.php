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
                
        <div class="flex justify-center mb-6">
            <form method="GET" action="" class="w-full md:w-1/3 flex flex-col items-center">
                <label for="periode" class="block text-sm font-medium text-gray-700 mb-1">Periode</label>
                <select name="periode" id="periode" class="form-select border rounded px-3 py-2 w-full">
                    <option value="mei-2025">Mei 2025</option>
                    <option value="april-2025">April 2025</option>
                    <option value="maret-2025">Maret 2025</option>
                </select>
            </form>
        </div>
       
        <div class="flex flex-col md:flex-row md:items-center gap-8">
            <div class="w-full md:w-1/2 flex flex-col items-center">
                <div id="piechart-container" style="min-width:350px; height:350px;"></div>
                <div class="flex justify-center gap-4 mt-4">
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-3 h-3 rounded-full bg-green-500"></span>
                        <span>Sudah Bayar</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-3 h-3 rounded-full bg-red-500"></span>
                        <span>Belum Bayar</span>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 flex flex-col items-center justify-center">
                <div class="text-center mb-2">
                    <div class="text-gray-500">Total Uang Masuk</div>
                    <div class="text-2xl font-bold">Rp20.000.000</div>
                </div>
                <div class="text-center">
                    <div class="text-gray-500">Jumlah Warga</div>
                    <div class="text-2xl font-bold">100</div>
                </div>
                <a href="#" class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600">Detail</a>
            </div>
        </div>
    </div>
</div>
<!-- Highcharts JS -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('piechart-container', {
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
                        format: '<b>{point.name}</b>: {point.y}'
                    }
                }
            },
            series: [{
                name: 'Warga',
                colorByPoint: true,
                data: [{
                    name: 'Sudah Bayar',
                    y: 80,
                    color: '#22c55e' // green-500
                }, {
                    name: 'Belum Bayar',
                    y: 20,
                    color: '#ef4444' // red-500
                }]
            }]
        });
    });
</script>
@endsection
