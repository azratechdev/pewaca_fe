@extends('layouts.residence.basetemplate')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="row" style="padding-top:20px;">
            <div class="col-md-12 col-sm-12">
                @include('layouts.elements.flash')
                <div class="pull-left"><h4><b>List Postingan</b></hf></div>
                <div class="pull-right">
                    <a class="btn btn-default btn-sm" href="{{ route('addpost') }}">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i> <b>Add Post</b>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
            <!-- Card 1 -->
            <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="flex items-center p-4">
                    <img alt="Profile picture" class="w-12 h-12 rounded-full" height="161" src="https://storage.googleapis.com/a1aa/image/ZoAiGzvASA4pG9oiGwu50UAjrOG21IrMhFOGfFnKGy1xU85JA.jpg" width="161"/>
                    <div class="ml-4">
                        <div class="text-gray-900 font-bold">
                            Jhondoe
                        </div>
                        <div class="text-gray-600 text-sm">
                            12 Sep 2024 18:00
                        </div>
                    </div>
                    <div class="ml-auto text-green-500">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                </div>
                <div class="px-4 pb-4">
                    <h5 class="text-gray-900 font-bold">
                        Judul Postingan 1
                    </h5>
                    <br/>
                    <img alt="Deskripsi gambar di sini" class="w-full" height="300" src="https://storage.googleapis.com/a1aa/image/H57fey20D7hosUpCSOhc7cF23nePfIDDnB1EfPEiU8YiMFf8E.jpg" width="500"/>
                    <br/>
                    <br/>
                    <p class="text-gray-900">
                        Deskripsi postingan di sini
                    </p>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="flex items-center p-4">
                    <img alt="Profile picture" class="w-12 h-12 rounded-full" height="161" src="https://storage.googleapis.com/a1aa/image/ZoAiGzvASA4pG9oiGwu50UAjrOG21IrMhFOGfFnKGy1xU85JA.jpg" width="161"/>
                    <div class="ml-4">
                        <div class="text-gray-900 font-bold">
                            Jhondoe
                        </div>
                        <div class="text-gray-600 text-sm">
                            12 Sep 2024 18:00
                        </div>
                    </div>
                    <div class="ml-auto text-green-500">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                </div>
                <div class="px-4 pb-4">
                    <h5 class="text-gray-900 font-bold">
                        Judul Postingan 2
                    </h5>
                    <br/>
                    <img alt="Deskripsi gambar di sini" class="w-full" height="300" src="https://storage.googleapis.com/a1aa/image/H57fey20D7hosUpCSOhc7cF23nePfIDDnB1EfPEiU8YiMFf8E.jpg" width="500"/>
                    <br/>
                    <br/>
                    <p class="text-gray-900">
                        Deskripsi postingan di sini
                    </p>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="flex items-center p-4">
                    <img alt="Profile picture" class="w-12 h-12 rounded-full" height="161" src="https://storage.googleapis.com/a1aa/image/ZoAiGzvASA4pG9oiGwu50UAjrOG21IrMhFOGfFnKGy1xU85JA.jpg" width="161"/>
                    <div class="ml-4">
                        <div class="text-gray-900 font-bold">
                            Jhondoe
                        </div>
                        <div class="text-gray-600 text-sm">
                            12 Sep 2024 18:00
                        </div>
                    </div>
                    <div class="ml-auto text-green-500">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                </div>
                <div class="px-4 pb-4">
                    <h5 class="text-gray-900 font-bold">
                        Judul Postingan 3
                    </h5>
                    <br/>
                    <img alt="Deskripsi gambar di sini" class="w-full" height="300" src="https://storage.googleapis.com/a1aa/image/H57fey20D7hosUpCSOhc7cF23nePfIDDnB1EfPEiU8YiMFf8E.jpg" width="500"/>
                    <br/>
                    <br/>
                    <p class="text-gray-900">
                        Deskripsi postingan di sini
                    </p>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="flex items-center p-4">
                    <img alt="Profile picture" class="w-12 h-12 rounded-full" height="161" src="https://storage.googleapis.com/a1aa/image/ZoAiGzvASA4pG9oiGwu50UAjrOG21IrMhFOGfFnKGy1xU85JA.jpg" width="161"/>
                    <div class="ml-4">
                        <div class="text-gray-900 font-bold">
                            Jhondoe
                        </div>
                        <div class="text-gray-600 text-sm">
                            12 Sep 2024 18:00
                        </div>
                    </div>
                    <div class="ml-auto text-green-500">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                </div>
                <div class="px-4 pb-4">
                    <h5 class="text-gray-900 font-bold">
                        Judul Postingan 4
                    </h5>
                    <br/>
                    <img alt="Deskripsi gambar di sini" class="w-full" height="300" src="https://storage.googleapis.com/a1aa/image/H57fey20D7hosUpCSOhc7cF23nePfIDDnB1EfPEiU8YiMFf8E.jpg" width="500"/>
                    <br/>
                    <br/>
                    <p class="text-gray-900">
                        Deskripsi postingan di sini
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
  
@endsection 