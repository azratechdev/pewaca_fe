@foreach($data_tagihan['results'] as $tagihan)
<div class="flex justify-center items-center" style="height: 100%;">
    <div class="bg-white w-full max-w-6xl">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                  <strong>{{ $tagihan['name'] }}</strong>
                </p>
            </div>
        </div>  
       
        <div class="flex justify-between items-center mt-2">
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                    {{ $tagihan['description'] }}
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
                    Rp {{ $tagihan['amount'] }}
                </p>
            </div>
        </div> 
        <div class="flex justify-between items-center mt-2">
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                Type Iuran
                </p>
            </div>
            
            <div class="flex items-center">
                <p class="d-flex align-items-center" style="color: red;">
                    {{ $tagihan['tipe'] }}
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
                   {{ \Carbon\Carbon::parse($tagihan['date_due'])->translatedFormat('d F Y') }}
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
        <a href="{{ route('pengurus.tagihan.edit', ['id' => $tagihan['id']]) }}" class="btn btn-sm btn-light w-20" style="border-radius:8px;">Edit</a>
        &nbsp;&nbsp;
        <a href="" data-id="{{ $tagihan['id'] }}"class="btn btn-sm btn-success w-20 btn-publish" style="color: white;border-radius:8px;">Publish</a>
    </div>
</div>
<hr class="mt-3 mb-2">
@endforeach
<div class="p-0 mt-2">
    <a href="{{ route('tagihan.add') }}" 
        class="btn btn-success w-full bg-green-600 text-white py-2 px-4 rounded-lg">
        ADD
    </a>
</div>
