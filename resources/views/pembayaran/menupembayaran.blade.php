@php
    $isPengurus = Session::get('cred.is_pengurus') ?? false;
@endphp

<div class="flex items-left w-full max-w-full">
    <div class="pb-2">
        <div class="flex items-lefts overflow-x-auto" style="padding-bottom: 10px;">
            <div class="flex items-left" style="white-space: nowrap;">
                <a href="{{ route('pembayaran.list') }}" 
                   class="btn btn-default {{ request()->routeIs('pembayaran.list') ? 'text-green-500 font-bold' : '' }}" 
                   data-id="">
                    Pembayaran
                </a> 
                <a href="{{ route('pembayaran.history') }}" 
                   class="btn btn-default {{ request()->routeIs('pembayaran.history') ? 'text-green-500 font-bold' : '' }}" 
                   data-id="">
                    Riwayat
                </a>
                
                @if($isPengurus)
                <a href="{{ route('pengurus.pengeluaran') }}" 
                   class="btn btn-default {{ request()->routeIs('pengurus.pengeluaran') ? 'text-green-500 font-bold' : '' }}" 
                   data-id="">
                    Pengeluaran
                </a>
                <a href="{{ route('pengurus.pengeluaran') }}?tab=dana" 
                   class="btn btn-default {{ request()->routeIs('pengurus.pengeluaran') && request('tab') == 'dana' ? 'text-green-500 font-bold' : '' }}" 
                   data-id="">
                    Dana Tersimpan
                </a>
                @endif
                
                {{-- <a href="{{ route('postingan') }}" 
                    class="btn btn-default {{ request()->routeIs('postingan') ? 'text-green-500 font-bold' : '' }}" 
                    data-id="">
                    Postingan
                </a> --}}
            </div>
        </div>
    </div>   
</div>
  