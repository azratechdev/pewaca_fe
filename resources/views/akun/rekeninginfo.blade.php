@extends('layouts.residence.basetemplate')

@section('content')

<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('akun') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;Info Rekening
            </h1>
            <br>
            <div class="flex justify-between items-center mt-2">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       Logo & Bank name
                    </p>
                </div>
                
                <div class="flex items-center">
                    <a class="text-grey-500 d-flex align-items-center" style="color:grey;font-size: 16px;font-family:Arial;">
                        Hapus
                    </a>
                </div>
            </div> 
            <div class="flex justify-between items-center mt-2">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       Nama
                    </p>
                </div>
                
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                        Jhondoe
                    </p>
                </div>
            </div> 
            <div class="flex justify-between items-center mt-2">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       No. Rekening
                    </p>
                </div>
                
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                        123456789
                    </p>
                </div>
            </div> 
            <div class="flex justify-between items-center mt-2">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       Nama Bank
                    </p>
                </div>
                
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                        BCA (bank name)
                    </p>
                </div>
            </div>
            <div class="alert alert-dismissible alert-success fade show mt-2 rounded" role="alert" style="padding-right: 16px;">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <p Style="color:green;"><b>Utama</b><br> Sebagai Rekening Bank Utama</p>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                            <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

@endsection
