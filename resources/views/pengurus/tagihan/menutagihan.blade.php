<div class="flex items-left w-full max-w-full">
    <div class="pb-2">
        <div class="flex items-lefts" style="padding-bottom: 10px;">
            <div class="flex items-left">
                <a href="{{ route('pengurus.warga.waiting') }}" 
                   class="btn btn-default {{ request()->routeIs('pengurus.warga.waiting') ? 'text-green-500 font-bold' : '' }}" 
                   data-id="">
                    Daftar Biaya
                </a> 
                <a href="{{ route('pengurus.warga.approved') }}" 
                   class="btn btn-default {{ request()->routeIs('pengurus.warga.approved') ? 'text-green-500 font-bold' : '' }}" 
                   data-id="">
                    Menunggu Konfirmasi
                </a>
                <a href="{{ route('pengurus.warga.approved') }}" 
                    class="btn btn-default {{ request()->routeIs('pengurus.warga.approved') ? 'text-green-500 font-bold' : '' }}" 
                    data-id="">
                    Disetujui
                </a>
                <a href="{{ route('pengurus.warga.approved') }}" 
                    class="btn btn-default {{ request()->routeIs('pengurus.warga.approved') ? 'text-green-500 font-bold' : '' }}" 
                    data-id="">
                    Tunggakan
                </a>
            </div>
        </div>
    </div>   
</div>
 