@extends('layouts.residence.basetemplate')
@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <div class="p-6">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('pengurus') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;Role
            </h1>
            <br>
            @include('layouts.elements.flash')
        </div>
      
        <div class="col-md-12 col-sm-12" style="padding-left:10px;padding-right:10px;">
            <div class="flex justify-center items-center">
                <div class="bg-white w-full max-w-6xl">
                    @foreach($data_pengurus['results'] as $key => $val)
                    <div class="flex items-center border-t mt-2"><br>
                        <img 
                            alt="User profile picture" 
                            class="w-16 h-16 rounded-full border-2 border-gray-300" 
                            src="{{ $val['warga']['profile_photo'] }}" 
                            onerror="this.onerror=null; this.src='/placeholder_avatars/avatar-{{ ($loop->index % 5) + 1 }}.png';"
                        />
                        <div class="ml-4">
                            <p class="font-semibold text-lg text-gray-800">
                                {{ $val['warga']['full_name'] }}
                            </p>
                            <p class="text-gray-500">
                            @if (!empty($result['role_name']))
                                {{ $val['role_name'] }}
                            @else
                                {{ $val['role'] }}
                            @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <p class="text-warning d-flex align-items-center"></p>
                        </div>
                        <div class="flex items-right">
                            <a href="" class="btn btn-sm btn-success w-20" style="border-radius:8px;">Hapus</a>
                        </div>
                    </div>
                   
                    @endforeach
                   
                    <div class="mt-2">
                        <a href="{{ route('addPengurus') }}" 
                            class="btn btn-success w-full bg-green-600 text-white py-2 px-4 rounded-lg">
                            ADD
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection