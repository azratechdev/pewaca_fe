@extends('layouts.residence.basetemplate')

@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <!-- Header -->
        <form id="reject_warga" method="POST" action="{{ route('post_reject') }}">
            @csrf
            <div class="p-6">
                <h1 class="text-xl font-semibold text-gray-800">
                    <a href="{{ route('detail_warga', ['id' => $warga_id]) }}" class="text-dark">
                        <i class="fas fa-arrow-left"></i>
                    </a>&nbsp;&nbsp;&nbsp;&nbsp;Alasan Registrasi Ditolak
                </h1>
                
            </div>
            <div class="flex justify-content-between" style="padding:10px;">
                <input type="hidden" name="warga_id" value="{{ $warga_id }}" />
                <textarea placeholder="Tulis Alasan Reject" id="alasan" name="alasan" class="w-full p-3 border border-gray-300 rounded-lg" rows="5" required></textarea>
            </div>
            <div class="flex justify-content-between" style="padding:10px;">
                <button type="submit" class="btn btn-success w-100">Continue</button>
            </div>
        </form>
    </div>
</div>
    
@endsection
