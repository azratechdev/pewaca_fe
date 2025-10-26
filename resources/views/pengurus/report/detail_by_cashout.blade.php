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
                        <input type="month" name="periode" id="periode" class="w-full border rounded px-6 py-2" value="{{ $periode }}" />
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
                    <input type="text" name="unit" placeholder="Search Unit" class="w-full border rounded pl-10 pr-3 py-2" />
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
                    <div class="divide-y divide-gray-200 overflow-y-auto" style="max-height:340px;"></div>
                    <div class="flex justify-center mt-4">
                        <button type="button" class="w-full md:w-3/4 border-2 border-green-600 text-green-600 px-6 py-2 rounded-lg font-semibold btn-more" data-type="sudah_bayar">More</button>
                    </div>
                </div>
                <div id="tab-content-belumbayar" class="p-4 hidden">
                    <div class="divide-y divide-gray-200 overflow-y-auto" style="max-height:340px;"></div>
                    <div class="flex justify-center mt-4">
                        <button type="button" class="w-full md:w-3/4 border-2 border-green-600 text-green-600 px-6 py-2 rounded-lg font-semibold btn-more" data-type="belum_bayar">More</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
function getPrevMonth() {
    const now = new Date();
    now.setMonth(now.getMonth() - 1);
    return now.toISOString().slice(0, 7);
}

function setMaxMonth(input) {
    input.max = getPrevMonth();
}

document.addEventListener('DOMContentLoaded', function () {
    const periodeInput = document.getElementById('periode');
    const unitInput = document.querySelector('input[name="unit"]');
    setMaxMonth(periodeInput);
    // Prevent clearing
    periodeInput.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' || e.key === 'Delete') {
            e.preventDefault();
        }
    });
    periodeInput.addEventListener('paste', function(e) {
        e.preventDefault();
    });
    // Ambil default value dari variabel controller
    let periode = periodeInput.value;
    // Setiap kali user mengubah periode, update localStorage agar konsisten antar halaman
    periodeInput.addEventListener('change', function() {
        localStorage.setItem('periode_report', periodeInput.value);
        fetchAndRender();
    });
    // Fetch and render data
    let cachedData = { sudah_bayar: [], belum_bayar: [] };
    let shown = { sudah_bayar: 10, belum_bayar: 10 };
    function renderTabContent(tabId, items, type) {
        const tab = document.getElementById(tabId);
        const container = tab.querySelector('.divide-y');
        let html = '';
        if (items.length === 0) {
            html = '<div class="text-center text-gray-400 py-8">Tidak ada data</div>';
        } else {
            html = items.slice(0, shown[type]).map(item => `
                <div class=\"py-4\">
                    <div class=\"flex justify-between\">
                        <div>
                            <div class=\"text-gray-500\">Nama Unit</div>
                            <div class=\"text-gray-500\">Tanggal</div>
                            <div class=\"text-gray-500\">Nominal</div>
                        </div>
                        <div class=\"text-right\">
                            <div class=\"font-semibold\">${item.unit}</div>
                            <div class=\"font-semibold\">${item.tanggal}</div>
                            <div class=\"font-semibold\">IDR ${item.nominal.toLocaleString('id-ID')}</div>
                        </div>
                    </div>
                </div>
            `).join('');
        }
        container.innerHTML = html;
        // Show/hide More button
        // const moreBtn = tab.querySelector('.btn-more');
        // if (items.length > shown[type]) {
        //     moreBtn.style.display = '';
        // } else {
        //     moreBtn.style.display = 'none';
        // }
    }
    function fetchAndRender() {
        const periodeVal = periodeInput.value;
        const unitVal = unitInput.value.trim();
        let apiUrl = `https://admin.pewaca.id/api/report/cashout/?periode=${periodeVal}`;
        if (unitVal) apiUrl += `&unit_no=${encodeURIComponent(unitVal)}`;
        fetch(apiUrl)
            .then(res => res.json())
            .then(data => {
                document.getElementById('total_by_type').textContent = data.jumlah_warga;
                Highcharts.chart('bypembayaran', {
                    chart: { type: 'pie' },
                    title: { text: '' },
                    tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>' },
                    accessibility: { point: { valueSuffix: '%' } },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                distance: -60,
                                formatter: function () {
                                    return this.y + ' Warga';
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
                        data: [
                            {
                                name: 'Sudah Bayar',
                                y: data.bypembayaran[0]?.jumlah || 0,
                                color: '#128C7E'
                            },
                            {
                                name: 'Belum Bayar',
                                y: data.bypembayaran[1]?.jumlah || 0,
                                color: '#F58220'
                            }
                        ]
                    }]
                });
                // Cache data and reset shown count
                cachedData.sudah_bayar = data.sudah_bayar.data || [];
                cachedData.belum_bayar = data.belum_bayar.data || [];
                shown.sudah_bayar = 10;
                shown.belum_bayar = 10;
                renderTabContent('tab-content-sudahbayar', cachedData.sudah_bayar, 'sudah_bayar');
                renderTabContent('tab-content-belumbayar', cachedData.belum_bayar, 'belum_bayar');
            });
    }
    // Initial fetch pakai nilai dari controller
    fetchAndRender();
    // On change
    periodeInput.addEventListener('change', function() {
        fetchAndRender();
    });
    unitInput.addEventListener('input', function() {
        fetchAndRender();
    });
    // More button logic
    document.querySelectorAll('.btn-more').forEach(btn => {
        btn.addEventListener('click', function() {
            const type = btn.dataset.type;
            shown[type] += 10;
            renderTabContent(`tab-content-${type.replace('_', '')}`, cachedData[type], type);
        });
    });
    // Tabs logic (unchanged)
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
