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
                    <input type="text" placeholder="Search Unit" class="w-full border rounded pl-10 pr-3 py-2" />
                </div>
            </div>

            <div class="flex justify-center mb-4">
                <div class="text-center mb-2">
                    <div class="text-gray-500">Total Uang Masuk</div>
                    <div id="total_by_type" class="text-2xl font-bold">Rp20.000.000</div>
                </div>
            </div>

            <div class="flex justify-center mb-4">
                <div class="w-full md:w-1/2 flex flex-col items-center">
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
                
            </div>
            {{-- Tabs for Wajib and Sukarela --}}
            <div class="bg-white rounded-xl shadow mb-4">
                <div class="flex border-b">
                    <button id="tab-wajib" type="button" class="w-1/2 py-2 text-center font-semibold text-green-600 border-b-2 border-green-500 focus:outline-none">Wajib</button>
                    <button id="tab-sukarela" type="button" class="w-1/2 py-2 text-center font-semibold text-gray-400 border-b-2 border-transparent focus:outline-none">Sukarela</button>
                </div>
                <div id="tab-content-wajib" class="p-4">
                    <div class="rounded-xl bg-gray-100 p-3 mb-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-semibold">Total</span>
                            <span class="font-semibold">Rp 12.000.000</span>
                        </div>
                    </div>
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
                <div id="tab-content-sukarela" class="p-4 hidden">
                    <div class="rounded-xl bg-gray-100 p-3 mb-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-semibold">Total</span>
                            <span class="font-semibold">Rp 8.000.000</span>
                        </div>
                    </div>
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
    const unitInput = document.querySelector('input[placeholder="Search Unit"]');
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
    // Fetch and render data
    let cachedData = { wajib: [], sukarela: [] };
    let shown = { wajib: 10, sukarela: 10 };
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
    }
    function fetchAndRender() {
        const periodeVal = periodeInput.value;
        const unitVal = unitInput.value.trim();
        let apiUrl = `https://api.pewaca.id/api/report/bytype/?periode=${periodeVal}`;
        if (unitVal) apiUrl += `&unit_no=${encodeURIComponent(unitVal)}`;
        fetch(apiUrl)
            .then(res => res.json())
            .then(data => {
                document.getElementById('total_by_type').textContent = 'Rp' + data.total_uang_masuk.toLocaleString('id-ID');
                // Chart
                Highcharts.chart('bytype', {
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
                                    var total = data.total_uang_masuk;
                                    var nominalJuta = Math.round(this.y / 1000000);
                                    return 'Rp' + nominalJuta + 'Jt<br>(' + Math.round(this.percentage) + '%)';
                                },
                                style: {
                                    color: 'white', textOutline: 'none', fontWeight: 'bold', fontSize: '13px'
                                }
                            }
                        }
                    },
                    series: [{
                        name: 'Jenis Pembayaran',
                        colorByPoint: true,
                        data: data.bytype_chart.map((item, idx) => ({
                            name: item.name,
                            y: item.nominal,
                            color: idx === 0 ? '#128C7E' : '#F58220'
                        }))
                    }]
                });
                // Tab data
                cachedData.wajib = data.wajib.data || [];
                cachedData.sukarela = data.sukarela.data || [];
                shown.wajib = 10;
                shown.sukarela = 10;
                // Total box
                document.querySelector('#tab-content-wajib .font-semibold:last-child').textContent = 'Rp ' + (data.wajib.total || 0).toLocaleString('id-ID');
                document.querySelector('#tab-content-sukarela .font-semibold:last-child').textContent = 'Rp ' + (data.sukarela.total || 0).toLocaleString('id-ID');
                renderTabContent('tab-content-wajib', cachedData.wajib, 'wajib');
                renderTabContent('tab-content-sukarela', cachedData.sukarela, 'sukarela');
            });
    }
    // Initial fetch
    fetchAndRender();
    // On change
    periodeInput.addEventListener('change', fetchAndRender);
    unitInput.addEventListener('input', fetchAndRender);
    // More button logic
    document.querySelectorAll('#tab-content-wajib .btn-more, #tab-content-sukarela .btn-more').forEach(btn => {
        btn.addEventListener('click', function() {
            const type = btn.closest('.p-4').id.replace('tab-content-', '');
            shown[type] += 10;
            renderTabContent(`tab-content-${type}`, cachedData[type], type);
        });
    });
    // Tabs logic (unchanged)
    const tabWajib = document.getElementById('tab-wajib');
    const tabSukarela = document.getElementById('tab-sukarela');
    const contentWajib = document.getElementById('tab-content-wajib');
    const contentSukarela = document.getElementById('tab-content-sukarela');
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
