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
                        <input type="month" name="periode" id="periode" class="w-full border rounded px-6 py-2" max="{{ date('Y-m') }}" onkeydown="return false;" />
                    </form>
                </div>
            </div>

            {{-- first chart begin --}}
           
            <div class="flex flex-col md:flex-row md:items-center bg-white rounded-xl shadow gap-8 mb-6">
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
                <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-4">
                    <div class="text-center mb-2">
                        <div class="text-gray-500">Total Uang Masuk</div>
                        <div id="total_by_pembayaran" class="text-2xl font-bold">Rp20.000.000</div>
                    </div>
                    <div class="text-center">
                        <div class="text-gray-500">Jumlah Warga</div>
                        <div class="text-2xl font-bold">100</div>
                    </div>
                   
                   
                     <a id="detailPembayaranLink" href="#" class="mt-4 mb-3 w-full md:w-3/4 text-center border-2 border-green-600 text-green-600 py-2 rounded-lg font-semibold">Detail</a>
                </div>
               
            </div>
            {{-- first chart end --}}

            {{-- second chart begin --}}
            <div class="flex flex-col md:flex-row md:items-center bg-white rounded-xl shadow gap-8 mb-6">
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
                <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-4">
                    <div class="text-center mb-2">
                        <div class="text-gray-500">Total Uang Masuk</div>
                        <div id="total_by_type" class="text-2xl font-bold">Rp20.000.000</div>
                    </div>
                    <div class="text-center">
                        <div class="text-gray-500">Jumlah Warga</div>
                        <div class="text-2xl font-bold">100</div>
                    </div>
                    <a id="detailByTypeLink" href="#" class="mt-4 mb-3 md:w-3/4 w-full text-center border-2 border-green-600 text-green-600 px-6 py-2 rounded-lg font-semibold">Detail</a>
                </div>
            </div>
            {{-- second chart end --}}
            <div class="bg-white rounded-xl shadow">
                <div class="flex flex-col md:flex-row md:items-center gap-8 mt-12 p-4">
                    <div class="w-full md:w-1/2 flex flex-col items-center justify-center">
                        <p class="font-bold mb-3">Tunggakan</p>
                        <div class="text-center mb-2">
                            <div class="text-black-700">Total Unit Menunggak</div>
                            <div class="text-2xl font-bold text-red-500">10</div>
                        </div>
                        <a id="detailTunggakanLink" href="#" class="mt-4 mb-3 w-full md:w-3/4 text-center border-2 border-green-600 text-green-600 px-6 py-2 rounded-lg font-semibold">Detail</a>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
</div>
<!-- Highcharts JS -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
function formatRupiah(angka) {
    return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function getDefaultPeriode() {
    const now = new Date();
    now.setMonth(now.getMonth() - 1); // mundur 1 bulan
    const year = now.getFullYear();
    const month = (now.getMonth() + 1).toString().padStart(2, '0');
    return `${year}-${month}`;
}

document.addEventListener('DOMContentLoaded', function () {
    const periodeInput = document.getElementById('periode');
    const detailLink = document.getElementById('detailPembayaranLink');
    const detailByTypeLink = document.getElementById('detailByTypeLink');
    const detailTunggakanLink = document.getElementById('detailTunggakanLink');
    // Set default value periode
    periodeInput.value = getDefaultPeriode();
    periodeInput.max = getDefaultPeriode();
    function updateDetailLinks() {
        const periode = periodeInput.value;
        detailLink.href = `{{ route('pengurus.detail.report', [':periode']) }}`.replace(':periode', periode).replace(':unit', '');
        detailByTypeLink.href = `{{ route('pengurus.detail.bytype', [':periode']) }}`.replace(':periode', periode);
        detailTunggakanLink.href = `{{ route('pengurus.detail.tunggakan', [':periode']) }}`.replace(':periode', periode);
    }
    periodeInput.addEventListener('change', updateDetailLinks);
    updateDetailLinks(); // set awal
    periodeInput.value = getDefaultPeriode();
    periodeInput.max = getDefaultPeriode(); // batasi max ke bulan default (tidak bisa pilih bulan depan)
    const urlBase = '{{ env('API_URL') }}/api/report/index/?periode=';
    fetchAndRender(periodeInput.value);

    periodeInput.addEventListener('change', function() {
        fetchAndRender(this.value);
    });

    function fetchAndRender(periode) {
        fetch(urlBase + periode)
            .then(res => res.json())
            .then(data => {
                // Update summary
                document.getElementById('total_by_pembayaran').innerText = formatRupiah(data.total_uang_masuk);
                document.getElementById('total_by_type').innerText = formatRupiah(data.total_uang_masuk);
                // Update jumlah warga
                document.querySelectorAll('.text-2xl.font-bold').forEach(el => {
                    if (el.innerText.match(/^\d+$/)) el.innerText = data.jumlah_warga;
                });
                // Update tunggakan
                document.querySelectorAll('.text-2xl.font-bold.text-red-500').forEach(el => {
                    el.innerText = data.tunggakan.total_unit;
                });
                // Chart bypembayaran
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
                                    color: 'white', textOutline: 'none', fontWeight: 'bold', fontSize: '13px'
                                }
                            }
                        }
                    },
                    series: [{
                        name: 'Warga',
                        colorByPoint: true,
                        data: data.bypembayaran.map((item, idx) => ({
                            name: item.name,
                            y: item.jumlah,
                            color: idx === 0 ? '#128C7E' : '#F58220'
                        }))
                    }]
                });
                // Chart bytype
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
                                    var nominal = (this.percentage / 100) * total;
                                    var nominalJuta = Math.round(nominal / 1000000); // bulatkan ke juta tanpa desimal
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
                        data: data.bytype.map((item, idx) => ({
                            name: item.name,
                            y: item.nominal,
                            color: idx === 0 ? '#128C7E' : '#F58220'
                        }))
                    }]
                });
            });
    }
});
</script>

@endsection
