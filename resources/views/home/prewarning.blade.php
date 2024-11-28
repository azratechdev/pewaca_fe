@extends('layouts.residence.basetemplate')
@section('content')

<div class="flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-sm w-full text-center">
     <img alt="Pewaca logo" class="mx-auto mb-4" height="120" src="{{ asset('assets/plugins/images/wacalogo.jpg') }}" width="170"/>
     <div class="mb-6">
      <img alt="Illustration of a document with a clock" class="mx-auto" height="200" src="{{ asset('assets/plugins/images/verified-wait.jpeg') }}" width="200"/>
     </div>
     <h1 class="text-xl font-semibold mb-2">
      Pendaftaran menunggu di verifikasi pengurus
     </h1>
     <p class="text-gray-600">
      Mohon menunggu untuk proses verifikasi oleh pengurus
     </p>
    </div>
</div>
@endsection