<div class="mb-3">
    @include('layouts.elements.flash')
</div>
@foreach($data_tagihan['data'] as $tagihan)
<div class="flex justify-center items-center" style="height: 100%;">
    <div class="bg-white w-full max-w-6xl">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                  <strong>{{ $tagihan['tagihan']['name'] }}</strong>
                </p>
            </div>

            <div class="flex items-center">
                <?php if ($tagihan['tagihan']['tipe'] == "wajib"){
                        $col = 'red';
                    }else{
                        $col = 'lightgreen';
                    }
                ?>
                <p class="d-flex align-items-center" style="color:<?php echo $col;?>">
                  <strong>{{ $tagihan['tagihan']['tipe'] }}</strong>
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
    @if($tagihan['status'] == 'rejected')
    <div class="flex items-center justify-left bg-red-50 p-2 rounded-lg shadow-md w-full max-w-full mt-3">
        <div class="flex items-left">
            <i class="fas fa-wallet-x text-red-500 text-2xl mr-3"></i>
            <div>
                <p class="text-red-500 font-semibold">Pembayaran Tidak Disetujui</p>
                <p class="text-red-500">Note: Photo bukti pembayaran tidak jelas mohon uplaod ulang bukti pembayaran</p>
            </div>
        </div>
    </div>
    @endif

    @if(date('Y-m-d') > $tagihan['tagihan']['date_due'] && $tagihan['status'] == 'unpaid') 
        @include('layouts.elements.tempo')
    @endif

    @if($tagihan['status'] == 'process')
        @include('layouts.elements.confirm')
    @endif
</div>

<div class="flex justify-between items-center mt-2">
    <div class="flex items-center">
        <p class="text-warning d-flex align-items-center">
            
        </p>
    </div>
    @if($tagihan['status'] == 'unpaid')
        <div class="flex items-right">
            @if($tagihan['tagihan']['tipe'] != 'wajib')
            <a href="#" class="btn btn-sm btn-light w-20" style="border-radius:8px;">Tidak</a>
            @endif
            &nbsp;&nbsp;
            <a href="{{ route('pembayaran.qris', ['id' => $tagihan['id']]) }}" class="btn btn-sm btn-primary w-20" style="color: white;border-radius:8px;">
                <i class="fas fa-qrcode"></i> QRIS
            </a>
            &nbsp;&nbsp;
            <a href="{{ route('pembayaran.add', ['id' => $tagihan['id']]) }}" class="btn btn-sm btn-success w-20 btn-publish" style="color: white;border-radius:8px;">Bayar</a>
        </div>
    @else
        <div class="flex items-right">
            &nbsp;&nbsp;
            <a href="{{ route('pembayaran.add', ['id' => $tagihan['id']]) }}" class="btn btn-sm btn-success w-20 btn-publish" style="color: white;border-radius:8px;">Detail</a>
        </div>
    @endif
</div>
<hr class="mt-3 mb-2">
@endforeach

