@foreach($data_tagihan['data'] as $tagihan)
<div class="flex justify-center items-center" style="height: 100%;">
    <div class="bg-white w-full max-w-6xl">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                  <strong>{{ $tagihan['tagihan']['name'] }}</strong>
                </p>
            </div>
        </div>  
       
        <div class="flex justify-between items-center mt-2">
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                    {{ $tagihan['tagihan']['description'] }}
                </p>
            </div>
        </div> 
        <div class="flex justify-between items-center mt-1">
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                Nominal
                </p>
            </div>
            
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                    @php
                        $formattedAmount = number_format((int) $tagihan['tagihan']['amount'], 0, ',', '.');
                    @endphp
                    Rp {{ $formattedAmount }}
                </p>
            </div>
        </div> 
       
        <div class="flex justify-between items-center mt-2">
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                Terakhir Pembayaran
                </p>
            </div>
            
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                   {{ \Carbon\Carbon::parse($tagihan['tagihan']['date_due'])->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>
    </div>
</div>
<div class="flex justify-between items-center mt-2">
    <div class="flex items-center">
        <p class="text-warning d-flex align-items-center">
            
        </p>
    </div>
    <div class="flex items-right">
        <a href="#" class="btn btn-sm btn-light w-20" style="border-radius:8px;">Tidak</a>
        &nbsp;&nbsp;
        <a href="{{ route('pembayaran.add', ['id' => $tagihan['id']]) }}" class="btn btn-sm btn-success w-20 btn-publish" style="color: white;border-radius:8px;">Bayar</a>
    </div>
</div>
<hr class="mt-3 mb-2">
@endforeach

