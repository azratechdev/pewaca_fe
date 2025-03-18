<div class="flex items-left w-full max-w-full">
    <div class="pb-2">
        <div class="flex items-lefts" style="padding-bottom: 10px;">
            <div class="flex items-left">
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
                <a href="{{ route('postingan') }}" 
                    class="btn btn-default {{ request()->routeIs('postingan') ? 'text-green-500 font-bold' : '' }}" 
                    data-id="">
                    Postingan
                </a>
            </div>
        </div>
    </div>   
</div>
  