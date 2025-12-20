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
                </a>&nbsp;Keamanan
            </h1>
            <br>
            @include('layouts.elements.flash')
        </div>
        <br>
        <div class="col-md-12 col-sm-12" style="padding-left:10px;padding-right:10px;">

            <form action="{{ route('security.listsec') }}" method="POST" class="flex items-center border border-gray-300 rounded-lg overflow-hidden w-full max-w-6xl">
                @csrf
                <input type="text" name="filter" placeholder=" Search..." class="py-2 pl-3 w-full focus:outline-none">
                <button type="submit" class="bg-green-500 text-white px-3 py-3 flex items-center justify-center">
                    <i class="fas fa-search"></i>
                </button>
            </form><br>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
                @foreach($security as $key => $sec)
                    <div class="bg-white rounded-xl shadow hover:shadow-lg p-4 h-full flex flex-col">
                        <div class="flex items-start space-x-4">
                            <!-- Profile Picture -->
                            <img 
                                alt="User profile picture" 
                                class="w-16 h-16 rounded border-2 border-gray-200 shadow-sm flex-shrink-0"
                                src="{{ $sec['profile_picture'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($sec['fullname']) }}"
                            />

                            <!-- User Info -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-lg text-gray-800 truncate">{{ $sec['fullname'] }}</h3>
                                <p class="text-gray-600 text-sm mt-1 truncate">{{ $sec['address'] }}</p>
                                <p class="text-gray-600 text-sm truncate">{{ $sec['phone_no'] }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-auto flex justify-end space-x-2 pt-4">
                            <!-- Edit Button -->
                            <a href="{{ route('security.editsec', $sec['id']) }}" 
                            class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                Edit
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('security.deletesec', $sec['id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr class="mt-4 mb-2">
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
                    <form action="{{ route('pengurus.keamanan') }}" method="POST">
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
                <a href="{{ route('security.addsec') }}" 
                    class="btn btn-success w-full bg-green-600 text-white py-2 px-4 rounded-lg">
                    ADD
                </a>
            </div>
        </div>
    </div>
</div>

</script>

@endsection