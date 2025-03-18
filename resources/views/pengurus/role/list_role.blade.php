@extends('layouts.residence.basetemplate')
@section('content')
@php
    session(['origin_page' => url()->current()]);
@endphp
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('pengurus') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;Peran
            </h1>
            <br>
            @include('layouts.elements.flash')
        </div>
        <br>
        <div class="col-md-12 col-sm-12" style="padding-left:10px;padding-right:10px;">

            <form action="{{ route('pengurus.role') }}" method="POST" class="flex items-center border border-gray-300 rounded-lg overflow-hidden w-full max-w-6xl">
                @csrf
                <input type="text" name="filter" placeholder=" Search..." class="py-2 pl-3 w-full focus:outline-none">
                <button type="submit" class="bg-green-500 text-white px-3 py-3 flex items-center justify-center">
                    <i class="fas fa-search"></i>
                </button>
            </form><br>

            @foreach($pengurus as $key => $warga)
            <div class="flex justify-left items-left">
                <img 
                    alt="User profile picture" 
                    class="w-16 h-16 rounded-full border-2 border-gray-300" 
                    src="{{ $warga['warga']['profile_photo'] }}" 
                />
                <div class="ml-4">
                    <p class="font-semibold text-lg text-gray-800">
                        {{ $warga['warga']['full_name']}}
                    </p>
                    <p class="text-gray-500">
                       {{ $warga['warga']['user']['email'] }}
                    </p>
                
                </div>
            </div>
            <div class="flex justify-between items-center mt-2">
                <div class="flex items-center">
                    <p class="text-success d-flex align-items-center">
                        
                    </p>
                </div>
                
                <div class="flex items-center">
                    <a href="" class="btn btn-sm btn-success w-20" style="color: white;border-radius:8px;">Hapus</a>
                </div>
            </div><hr class="mt-2">
            <br>
            @endforeach

            <div class="flex justify-between items-center @if($previous_page == null || $next_page == null) justify-end @else justify-between @endif">
                @if($previous_page)
                <div class="flex items-center">
                    <form action="{{ route('pengurus.role') }}" method="POST">
                        @csrf
                        <input type="hidden" name="page" value="{{ $prev }}">
                        <button type="submit" class="btn btn-sm btn-info text-white">
                            < Previous
                        </button>
                    </form>
                </div>
                @endif

                <div class="flex-grow text-center">
                    Page {{ $current }} of {{ $total_pages }}
                </div>
            
                @if($next_page)
                <div class="flex items-center ml-auto">
                    <form action="{{ route('pengurus.role') }}" method="POST">
                        @csrf
                        <input type="hidden" name="page" value="{{ $next }}">
                        <button type="submit" class="btn btn-sm btn-info text-white">
                            Next Page >
                        </button>
                    </form>
                </div>
                @endif
            </div>
            <br>
            <div class="mt-2">
                <a href="{{ route('addPengurus') }}" 
                    class="btn btn-success w-full bg-green-600 text-white py-2 px-4 rounded-lg">
                    ADD
                </a>
            </div>
        </div>
    </div>
</div>

</script>

@endsection