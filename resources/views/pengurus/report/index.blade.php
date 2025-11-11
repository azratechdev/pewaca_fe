@extends('layouts.residence.basetemplate')
@section('content')

<style>
body {
    background: linear-gradient(135deg, #f5f7fa 0%, #e8f0f3 100%);
}

.report-container {
    background: white;
    border-radius: 24px;
    box-shadow: 0 4px 20px rgba(95, 167, 130, 0.1);
    overflow: hidden;
}

.report-header {
    background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
    color: white;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(61, 115, 87, 0.2);
}

.btn-download {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    color: #2d5642;
    border: none;
    padding: 10px 20px;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(255, 255, 255, 0.2);
}

.btn-download:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
    color: #1e3f2f;
}

.chart-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 2px 12px rgba(95, 167, 130, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    border: 1px solid rgba(95, 167, 130, 0.1);
}

.chart-card:hover {
    box-shadow: 0 8px 24px rgba(95, 167, 130, 0.15);
    transform: translateY(-4px);
}

.stat-value {
    background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 2rem;
    font-weight: 800;
}

.btn-detail {
    background: transparent;
    border: 2px solid #3d7357;
    color: #2d5642;
    padding: 10px 24px;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-detail:hover {
    background: linear-gradient(135deg, #3d7357 0%, #2d5642 100%);
    color: white;
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(61, 115, 87, 0.3);
}

.legend-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px;
    background: rgba(95, 167, 130, 0.05);
    border-radius: 20px;
    font-size: 0.9rem;
}

.tunggakan-card {
    background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
    border-radius: 20px;
    box-shadow: 0 2px 12px rgba(220, 53, 69, 0.08);
    padding: 2rem;
    border: 1px solid rgba(220, 53, 69, 0.1);
}

.tunggakan-value {
    background: linear-gradient(135deg, #991b1b 0%, #7f1d1d 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 2.5rem;
    font-weight: 800;
}

.periode-input {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 10px 16px;
    transition: all 0.3s ease;
}

.periode-input:focus {
    outline: none;
    border-color: #3d7357;
    box-shadow: 0 0 0 3px rgba(61, 115, 87, 0.15);
}
</style>

<div class="flex justify-center items-center" style="padding: 20px;">
    <div class="report-container w-full max-w-6xl">
        <div class="report-header flex justify-between items-center">
            <h1 class="text-2xl font-bold">
                <a href="{{ route('pengurus') }}" class="text-white hover:opacity-80 transition-opacity">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;<i class="fas fa-chart-line"></i> Report Keuangan
            </h1>
            <button id="download-comprehensive" class="btn-download flex items-center gap-2">
                <i class="fas fa-download"></i> Download Excel
            </button>
        </div>
        
        <div class="col-md-12 col-sm-12" style="padding: 2rem;">
            
            <div class="flex justify-center mb-8">
                <div class="relative w-full max-w-md">
                    <form method="GET" action="" class="flex items-center space-x-3">
                        <label for="periode" class="text-sm font-semibold" style="color: #2d3748;">
                            <i class="fas fa-calendar-alt" style="color: #3d7357;"></i> Periode
                        </label>
                        <input type="month" name="periode" id="periode" class="periode-input flex-1" max="{{ date('Y-m') }}" onkeydown="return false;" />
                    </form>
                </div>
            </div>

            {{-- first chart begin --}}
           
            <div class="chart-card flex flex-col md:flex-row md:items-center gap-8 mb-8 p-6">
                <div class="w-full md:w-1/2 flex flex-col items-center">
                    <h3 class="font-bold text-lg mb-4" style="color: #2d3748;">
                        <i class="fas fa-money-bill-wave" style="color: #3d7357;"></i> Status Pembayaran
                    </h3>
                    <div id="bypembayaran" style="width:280px;height:280px;"></div>
                    <div class="flex justify-center gap-4 mt-4">
                        <span class="legend-badge">
                            <span class="inline-block w-3 h-3 rounded-full" style="background:#128C7E;"></span>
                            <span>Sudah Bayar</span>
                        </span>
                        <span class="legend-badge">
                            <span class="inline-block w-3 h-3 rounded-full" style="background:#F58220;"></span>
                            <span>Belum Bayar</span>
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-4 gap-4">
                    <div class="text-center">
                        <div class="text-sm font-medium mb-2" style="color: #718096;">Total Uang Masuk</div>
                        <div id="total_by_pembayaran" class="stat-value">-</div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm font-medium mb-2" style="color: #718096;">Jumlah Warga</div>
                        <div id="jumlah_warga_pembayaran" class="stat-value">-</div>
                    </div>
                     <a id="detailPembayaranLink" href="#" class="btn-detail w-full md:w-3/4 text-center mt-2">
                         <i class="fas fa-eye"></i> Lihat Detail
                     </a>
                </div>
               
            </div>
            {{-- first chart end --}}

            {{-- second chart begin --}}
            <div class="chart-card flex flex-col md:flex-row md:items-center gap-8 mb-8 p-6">
                <div class="w-full md:w-1/2 flex flex-col items-center">
                    <h3 class="font-bold text-lg mb-4" style="color: #2d3748;">
                        <i class="fas fa-tags" style="color: #3d7357;"></i> Tipe Iuran
                    </h3>
                    <div id="bytype" style="width:280px;height:280px;"></div>
                    <div class="flex justify-center gap-4 mt-4">
                        <span class="legend-badge">
                            <span class="inline-block w-3 h-3 rounded-full" style="background:#128C7E;"></span>
                            <span>Wajib</span>
                        </span>
                        <span class="legend-badge">
                            <span class="inline-block w-3 h-3 rounded-full" style="background:#F58220;"></span>
                            <span>Sukarela</span>
                        </span>
                    </div>
                </div>
                <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-4 gap-4">
                    <div class="text-center">
                        <div class="text-sm font-medium mb-2" style="color: #718096;">Total Uang Masuk</div>
                        <div id="total_by_type" class="stat-value">-</div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm font-medium mb-2" style="color: #718096;">Jumlah Warga</div>
                        <div id="jumlah_warga_type" class="stat-value">-</div>
                    </div>
                    <a id="detailByTypeLink" href="#" class="btn-detail w-full md:w-3/4 text-center mt-2">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
            {{-- second chart end --}}
            
            {{-- tunggakan card --}}
            <div class="tunggakan-card text-center">
                <h3 class="font-bold text-lg mb-4" style="color: #2d3748;">
                    <i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i> Data Tunggakan
                </h3>
                <div class="mb-2">
                    <div class="text-sm font-medium mb-2" style="color: #718096;">Total Unit Menunggak</div>
                    <div id="total_unit_tunggakan" class="tunggakan-value">-</div>
                </div>
                <a id="detailTunggakanLink" href="#" class="btn-detail mt-4 inline-block px-8">
                    <i class="fas fa-eye"></i> Lihat Detail
                </a>
            </div>
            
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
    
    // Get residence_id from residence_commites for filtering by residence
    const residenceCommites = @json(Session::get('cred.residence_commites', []));
    
    // DEBUG: Check what data we have
    console.log('=== DEBUG RESIDENCE DATA ===');
    console.log('Raw residenceCommites:', residenceCommites);
    console.log('Is Array?', Array.isArray(residenceCommites));
    console.log('Length:', residenceCommites ? residenceCommites.length : 'null/undefined');
    
    // Extract all residence_ids that this pengurus manages
    const residenceIds = [];
    residenceCommites.forEach((commite, index) => {
        console.log(`Commite [${index}]:`, commite);
        console.log(`  - residence:`, commite.residence);
        console.log(`  - type of residence:`, typeof commite.residence);
        
        if (commite.residence && typeof commite.residence === 'number') {
            residenceIds.push(commite.residence);
        }
    });
    
    // Remove duplicates (though usually pengurus only has 1 residence)
    const uniqueResidenceIds = [...new Set(residenceIds)];
    console.log('Extracted residenceIds:', residenceIds);
    console.log('Unique residence IDs:', uniqueResidenceIds);
    console.log('Report filtering by residence count:', uniqueResidenceIds.length);
    console.log('=== END DEBUG ===');
    
    const urlBase = '{{ env('API_URL') }}/api/report/index/?periode=';
    
    fetchAndRender(periodeInput.value);

    periodeInput.addEventListener('change', function() {
        fetchAndRender(this.value);
    });

    function fetchAndRender(periode) {
        // Security: Only fetch if pengurus has valid residence assigned
        if (uniqueResidenceIds.length === 0) {
            console.error('No residence assigned to this pengurus');
            alert('Anda tidak memiliki akses ke residence manapun. Silakan hubungi administrator.');
            return;
        }
        
        // Add residence_id parameter to filter data by pengurus's residence
        let url = urlBase + periode + '&residence_id=' + encodeURIComponent(uniqueResidenceIds[0]);
        
        fetch(url, {
            headers: {
                'Authorization': 'Token {{ Session::get("token") }}',
                'Content-Type': 'application/json'
            }
        })
            .then(res => res.json())
            .then(data => {
                // Update summary
                document.getElementById('total_by_pembayaran').innerText = formatRupiah(data.total_uang_masuk);
                document.getElementById('total_by_type').innerText = formatRupiah(data.total_uang_masuk);
                // Update jumlah warga
                document.getElementById('jumlah_warga_pembayaran').innerText = data.jumlah_warga;
                document.getElementById('jumlah_warga_type').innerText = data.jumlah_warga;
                // Update tunggakan
                document.getElementById('total_unit_tunggakan').innerText = data.tunggakan.total_unit;
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
    
    // Download comprehensive report button
    document.getElementById('download-comprehensive').addEventListener('click', function() {
        const periodeVal = periodeInput.value;
        if (!periodeVal) {
            alert('Silakan pilih periode terlebih dahulu');
            return;
        }
        const url = `{{ route('pengurus.report.download.comprehensive') }}?periode=${periodeVal}`;
        window.location.href = url;
    });
});
</script>

@endsection
