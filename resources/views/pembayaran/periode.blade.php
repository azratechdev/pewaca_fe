@extends('layouts.residence.basetemplate')
@section('content')
<style>
    .container {
        padding: 20px;
        background: #fff;
    }
    
    .year-header {
        padding: 10px 20px;
        background: #f8f9fa;
        font-weight: 500;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }
    .month-item {
        padding: 12px 20px;
        border-bottom: 1px solid #eee;
    }
    .month-item .month-name {
        font-weight: 500;
        margin-bottom: 4px;
    }
    .month-item .due-date {
        font-size: 12px;
        color: #666;
    }
    .month-checkbox {
        width: 20px;
        height: 20px;
        border: 2px solid #00A884;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .month-checkbox.checked {
        background: #00A884;
    }
    .month-checkbox.checked::after {
        content: "✓";
        color: white;
        font-size: 12px;
    }
    .month-checkbox.disabled {
        border-color: #ccc;
        background: #00A884;
    }
    .btn-pilih {
        background: #00A884;
        color: white;
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        text-align: center;
        font-weight: 500;
    }
    .year-toggle {
        transition: transform 0.3s;
    }
    .year-toggle.expanded {
        transform: rotate(180deg);
    }
</style>

<div class="container">
    <div class="container mx-auto px-4">
        <div class="flex items-center mb-6">
            <a href="{{ route('pembayaran.pembayaran_periode') }}" class="text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-xl font-semibold ml-4">Periode</h1>
        </div>
   
        <div class="year-section mb-4">
            <div class="year-header" onclick="toggleYear('2025')">
                <span>2025</span>
                <i class="fas fa-chevron-down year-toggle" id="toggle-2025"></i>
            </div>
            <div id="months-2025">
                <div class="month-item flex justify-between items-center">
                    <div class="flex-1">
                        <div class="month-name">Agustus</div>
                        <div class="due-date">Terakhir pembayaran : 30 Agustus 2025</div>
                    </div>
                    <div class="month-checkbox checked"></div>
                </div>
                <div class="month-item flex justify-between items-center">
                    <div class="flex-1">
                        <div class="month-name">September</div>
                        <div class="due-date">Terakhir pembayaran : 30 September 2025</div>
                    </div>
                    <div class="month-checkbox"></div>
                </div>
                <div class="month-item flex justify-between items-center">
                    <div class="flex-1">
                        <div class="month-name">November</div>
                        <div class="due-date">Terakhir pembayaran : 30 November 2025</div>
                    </div>
                    <div class="month-checkbox"></div>
                </div>
                <div class="month-item flex justify-between items-center">
                    <div class="flex-1">
                        <div class="month-name">Desember</div>
                        <div class="due-date">Terakhir pembayaran : 30 Desember 2025</div>
                    </div>
                    <div class="month-checkbox"></div>
                </div>
            </div>
        </div>

    
        <div class="year-section">
            <div class="year-header" onclick="toggleYear('2026')">
                <span>2026</span>
                <i class="fas fa-chevron-down year-toggle" id="toggle-2026"></i>
            </div>
            <div id="months-2026">
                <div class="month-item flex justify-between items-center">
                    <div class="flex-1">
                        <div class="month-name">Januari</div>
                        <div class="due-date">Terakhir pembayaran : 30 Januari 2026</div>
                    </div>
                    <div class="month-checkbox"></div>
                </div>
                <div class="month-item flex justify-between items-center">
                    <div class="flex-1">
                        <div class="month-name">Februari</div>
                        <div class="due-date">Terakhir pembayaran : 30 Februari 2026</div>
                    </div>
                    <div class="month-checkbox"></div>
                </div>
                <div class="month-item flex justify-between items-center">
                    <div class="flex-1">
                        <div class="month-name">Maret</div>
                        <div class="due-date">Terakhir pembayaran : 30 Maret 2026</div>
                    </div>
                    <div class="month-checkbox"></div>
                </div>
                <div class="month-item flex justify-between items-center">
                    <div class="flex-1">
                        <div class="month-name">April</div>
                        <div class="due-date">Terakhir pembayaran : 30 April 2026</div>
                    </div>
                    <div class="month-checkbox"></div>
                </div>
            </div>
        </div>

        <button class="mt-4 btn-pilih" onclick="submitSelectedPeriods()">Pilih</button>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set current month checked by default and disabled
    const currentDate = new Date();
    const currentMonth = currentDate.toLocaleString('id-ID', { month: 'long' });
    const checkboxes = document.querySelectorAll('.month-checkbox');
    
    checkboxes.forEach(checkbox => {
        const monthName = checkbox.parentElement.querySelector('.month-name').textContent;
        if (monthName === currentMonth) {
            checkbox.classList.add('checked');
            checkbox.classList.add('disabled');
        } else {
            checkbox.addEventListener('click', function() {
                this.classList.toggle('checked');
            });
        }
    });
});

function toggleYear(year) {
    const monthsDiv = document.getElementById(`months-${year}`);
    const toggle = document.getElementById(`toggle-${year}`);
    const isExpanded = monthsDiv.style.display === 'none';
    
    monthsDiv.style.display = isExpanded ? 'block' : 'none';
    toggle.classList.toggle('expanded', isExpanded);
}

function submitSelectedPeriods() {
    const selectedMonths = [];
    document.querySelectorAll('.month-checkbox.checked').forEach(checkbox => {
        const monthName = checkbox.parentElement.previousElementSibling.querySelector('.month-name').textContent;
        selectedMonths.push(monthName);
    });
    
    // Store selected months in localStorage
    localStorage.setItem('selectedPeriods', JSON.stringify(selectedMonths));
    
    // Redirect back to pembayaran periode page
    window.location.href = "{{ route('pembayaran.pembayaran_periode') }}";
}
</script>
@endsection
