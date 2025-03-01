@foreach($data_approved['data'] as $key => $tagihan)
@if($tagihan['warga'] == $warga_id)
<div class="flex justify-center items-center" style="height: 100%;">
    <div class="bg-white w-full max-w-6xl">
        <div class="flex items-left max-w-full mb-2">
            <div class="ml-0">
                <div class="text-gray-900 font-bold" style="font-size: 14px;">
                    <strong>{{ $tagihan['warga'] }}</strong>
                </div>
            </div>
        </div>
        <div class="flex justify-between items-center mt-1">
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                    <strong>{{ $tagihan['tagihan']['residence'] }}</strong>
                </p>
            </div>
            
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                    <strong>{{ $tagihan['unit_id']}} - A78FG</strong>
                </p>
            </div>
        </div> 
        <div class="flex justify-between items-center mt-1">
            <div class="flex items-center">
                <p class="d-flex align-items-center" style="font-size:10px;color:lightgrey">
                    <strong>Type: {{ $tagihan['tagihan']['name'] }}</strong>
                </p>
            </div>
        </div> 
        <div class="flex justify-between items-center mt-2">
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                    <strong>Rp {{ $tagihan['tagihan']['amount'] }}</strong>
                </p>
            </div>
            
            <div class="flex items-center">
                @if($tagihan['status'] == "paid")
                    <p class="td-flex align-items-center" style="color:lightgreen;">
                        <strong>Lunas</strong>
                    </p>
                @else
                    <p class="td-flex align-items-center" style="color:orange;"
                        <strong>{{ $tagihan['status'] }}</strong>
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
@if($tagihan['status'] == 'paid')
<div class="flex justify-between items-center mt-2">
    @include('layouts.elements.approved')
</div>
@endif

<div class="flex justify-between items-center mt-2">
    <div class="flex items-center">
        <p class="text-warning d-flex align-items-center"></p>
    </div>
    <div class="flex items-right">
        <a href="{{ route('pengurus.approval.detail', ['id' => $tagihan['id']]) }}" class="btn btn-sm btn-success w-20 btn-detail" style="color: white;border-radius:8px;">Detail</a>
    </div>
</div>
<hr class="mt-3 mb-2">
@endif
@endforeach


