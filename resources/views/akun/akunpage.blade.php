@extends('layouts.residence.basetemplate')
@section('content')

<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-md rounded-lg shadow-lg">
     <div class="p-4 border-b">
      <h1 class="text-lg font-semibold">
       Akun
      </h1>
     </div>
     <div class="p-4 flex items-center border-b">
      <img alt="User profile picture" class="w-12 h-12 rounded-full" height="50" src="https://storage.googleapis.com/a1aa/image/2QGMMarsNI53Bxy48yTm22JJOwlxwcOo3GvxZ9rngfsIgl6JA.jpg" width="50"/>
      <div class="ml-4">
       <p class="font-semibold">
        Jhondoe
       </p>
       <p class="text-gray-500">
        jhondoe@gmail.com
       </p>
      </div>
     </div>
     <div>
      <a class="flex items-center p-4 border-b hover:bg-gray-100" href="#">
       <i class="fas fa-user text-gray-500">
       </i>
       <span class="ml-4">
        Info Akun
       </span>
       <i class="fas fa-chevron-right ml-auto text-gray-500">
       </i>
      </a>
      <a class="flex items-center p-4 border-b hover:bg-gray-100" href="#">
       <i class="fas fa-users text-gray-500">
       </i>
       <span class="ml-4">
        Keluarga
       </span>
       <i class="fas fa-chevron-right ml-auto text-gray-500">
       </i>
      </a>
      <a class="flex items-center p-4 hover:bg-gray-100" href="#">
       <i class="fas fa-sign-out-alt text-gray-500">
       </i>
       <span class="ml-4">
        Logout
       </span>
       <i class="fas fa-chevron-right ml-auto text-gray-500">
       </i>
      </a>
     </div>
    </div>
</div>

  
  
@endsection 