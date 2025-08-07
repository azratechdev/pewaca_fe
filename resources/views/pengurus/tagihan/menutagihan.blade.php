<div class="flex items-left w-full max-w-full">
    <div class="pb-2">
        <div class="flex items-lefts" style="padding-bottom: 10px;">
            <div class="flex items-left">
                <a href="{{ route('pengurus.biaya.konfirmasi') }}" 
                   class="btn btn-default {{ request()->routeIs('pengurus.biaya.konfirmasi') ? 'text-green-500 font-bold' : '' }}" 
                   data-id="">
                    Menunggu Konfirmasi
                </a>
                <a href="{{ route('pengurus.biaya.list') }}" 
                   class="btn btn-default {{ request()->routeIs('pengurus.biaya.list') ? 'text-green-500 font-bold' : '' }}" 
                   data-id="">
                    Daftar Biaya
                </a> 
                <a href="{{ route('pengurus.biaya.disetujui') }}" 
                    class="btn btn-default {{ request()->routeIs('pengurus.biaya.disetujui') ? 'text-green-500 font-bold' : '' }}" 
                    data-id="">
                    Disetujui
                </a>
                <a href="{{ route('pengurus.biaya.tunggakan') }}" 
                    class="btn btn-default {{ request()->routeIs('pengurus.biaya.tunggakan') ? 'text-green-500 font-bold' : '' }}" 
                    data-id="">
                    Tunggakan
                </a>
            </div>
        </div>
    </div>   
</div>
 