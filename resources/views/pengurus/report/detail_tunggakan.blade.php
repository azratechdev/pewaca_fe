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
            <!-- Summary Box -->
            <div class="rounded-xl bg-gray-100 p-2 mb-4">
                <div class="flex justify-between items-center text-sm mb-1">
                    <span class="font-semibold">Total unit</span>
                    <span class="font-semibold" id="total_unit">-</span>
                </div>
                <hr class="my-1 border-black-200">
                <div class="flex justify-between items-center text-sm">
                    <span class="font-semibold">Total nominal</span>
                    <span class="font-semibold" id="total_nominal">-</span>
                </div>
            </div>
            <!-- List Tunggakan -->
            <div id="list-tunggakan" class="divide-y divide-gray-200 overflow-y-auto" style="max-height:500px;-ms-overflow-style: none;scrollbar-width: none;"></div>
        </div>
    </div>
</div>

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
    let periode = periodeInput.value;
    let cachedUnits = [];
    let shown = 10;
    const listDiv = document.getElementById('list-tunggakan');
    function renderList() {
        let html = '';
        let filtered = cachedUnits;
        const search = unitInput.value.trim().toLowerCase();
        if (search) {
            filtered = cachedUnits.filter(u => u.nama_unit.toLowerCase().includes(search));
        }
        if (filtered.length === 0) {
            html = '<div class="text-center text-gray-400 py-8">Tidak ada data</div>';
        } else {
            html = filtered.slice(0, shown).map(item => `
                <div class=\"py-4\">
                    <div class=\"flex justify-between\">
                        <div>
                            <div class=\"text-gray-500\">Nama Unit</div>
                            <div class=\"text-gray-500\">Periode</div>
                            <div class=\"text-gray-500\">Tahun</div>
                        </div>
                        <div class=\"text-right\">
                            <div class=\"font-semibold\">${item.nama_unit}</div>
                            <div class=\"font-semibold\">${item.periode.join(',')}</div>
                            <div class=\"font-semibold\">${item.tahun}</div>
                        </div>
                    </div>
                    <div class=\"flex justify-between mt-2\">
                        <div class=\"text-gray-500\">Total Nominal</div>
                        <div class=\"font-semibold\">IDR ${item.total_nominal.toLocaleString('id-ID')}</div>
                    </div>
                </div>
            `).join('');
        }
        listDiv.innerHTML = html;
    }
    // Get residence_id from residence_commites for filtering by residence
    const residenceCommites = @json(Session::get('cred.residence_commites', []));
    const residenceIds = [];
    residenceCommites.forEach(commite => {
        if (commite.residence && typeof commite.residence === 'number') {
            residenceIds.push(commite.residence);
        }
    });
    const uniqueResidenceIds = [...new Set(residenceIds)];
    console.log('Tunggakan filtering by residence count:', uniqueResidenceIds.length);
    
    function fetchAndRender() {
        if (uniqueResidenceIds.length === 0) {
            console.error('No residence assigned');
            alert('Anda tidak memiliki akses ke residence manapun.');
            return;
        }
        
        const periodeVal = periodeInput.value;
        const unitVal = unitInput.value.trim();
        let apiUrl = `https://admin.pewaca.id/api/report/tunggakan/?periode=${periodeVal}&residence_id=${encodeURIComponent(uniqueResidenceIds[0])}`;
        if (unitVal) apiUrl += `&unit_no=${encodeURIComponent(unitVal)}`;
        
        fetch(apiUrl)
            .then(res => res.json())
            .then(data => {
                document.getElementById('total_unit').textContent = data.total_unit;
                document.getElementById('total_nominal').textContent = 'Rp ' + data.total_nominal.toLocaleString('id-ID');
                cachedUnits = data.units || [];
                shown = 10;
                renderList();
            });
    }
    // Initial fetch
    fetchAndRender();
    // On change
    periodeInput.addEventListener('change', fetchAndRender);
    unitInput.addEventListener('input', function() {
        shown = 10;
        renderList();
    });
    // Infinite scroll
    listDiv.addEventListener('scroll', function() {
        if (listDiv.scrollTop + listDiv.clientHeight >= listDiv.scrollHeight - 10) {
            if (shown < cachedUnits.length) {
                shown += 10;
                renderList();
            }
        }
    });
});
</script>
@endsection
