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
        </div>

        <div class="flex justify-center items-center">
            <div class="bg-white w-full max-w-6xl">
                <div class="p-6 flex items-center border-t mt-2">
                    <img 
                        alt="User profile picture" 
                        class="w-16 h-16 rounded-full border-2 border-gray-300" 
                        src="https://via.placeholder.com/150" 
                    />
                    <div class="ml-4">
                        <p class="font-semibold text-lg text-gray-800">
                            Jhondoe
                        </p>
                        <p class="text-gray-500">
                            Admin Operasional
                        </p>
                    </div>
                </div>
                <hr class="mt-2">

                <div class="p-6 flex items-center">
                    <img 
                        alt="User profile picture" 
                        class="w-16 h-16 rounded-full border-2 border-gray-300" 
                        src="https://via.placeholder.com/150" 
                    />
                    <div class="ml-4">
                        <p class="font-semibold text-lg text-gray-800">
                            Boni
                        </p>
                        <p class="text-gray-500">
                            Bendahara
                        </p>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <p class="text-warning d-flex align-items-center"></p>
                    </div>
                    <div class="flex items-right">
                        <a href="" class="btn btn-sm btn-light w-20" style="border-radius:8px;">Hapus</a>
                    </div>
                </div>
                <hr class="mt-2">

                <div class="p-6 flex items-center">
                    <img 
                        alt="User profile picture" 
                        class="w-16 h-16 rounded-full border-2 border-gray-300" 
                        src="https://via.placeholder.com/150" 
                    />
                    <div class="ml-4">
                        <p class="font-semibold text-lg text-gray-800">
                            Kahfian
                        </p>
                        <p class="text-gray-500">
                            Sekretaris
                        </p>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <p class="text-warning d-flex align-items-center"></p>
                    </div>
                    <div class="flex items-right">
                        <a href="" class="btn btn-sm btn-light w-20" style="border-radius:8px;">Hapus</a>
                    </div>
                </div>
                <hr class="mt-2">

                <div class="p-3 mt-2">
                    <a href="{{ route('addPengurus') }}" 
                        class="btn btn-success w-full bg-green-600 text-white py-2 px-4 rounded-lg">
                        ADD
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection