@extends('layouts.residence.basetemplate')
@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl shadow-lg">
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('pengurus') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;Warga
            </h1>
        </div>

        <div class="flex items-left w-full max-w-full">
            <div class="pb-2">
                <div class="flex items-lefts"  style="padding-bottom: 10px;">
                    <div class="flex items-left">
                        <a href="javascript:void(0)" class="btn btn-default toggle-waiting" data-id="">Waiting Approval</a> 
                        <a href="javascript:void(0)" class="btn btn-default toggle-approved" data-id="">Approved</a>
                    </div>
                </div>
            </div>   
        </div>  

        <div class="col-md-12 col-sm-12 waiting-full" style="display:block;padding-left:10px;padding-right:10px;">
            @include('pengurus.warga.waiting')
        </div>
        <div  class="col-md-12 col-sm-12 approved-full" style="display:none;padding-left:10px;padding-right:10px;">
            @include('pengurus.warga.approved')
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $(document).on("click", ".toggle-approved", function() {
              
        const targetDiv = $('.approved-full');
        const targetOther = $('.waiting-full');
       
        if (targetDiv.css("display") === "none") {
            targetDiv.css("display", "block");
            targetOther.css("display", "none"); // Sembunyikan like
        } 
        else {
            targetDiv.css("display", "block");
        }

    });

    $(document).on("click", ".toggle-waiting", function() {
        const targetDiv = $('.waiting-full');
        const targetOther = $('.approved-full');
       
        if (targetDiv.css("display") === "none") {
            targetDiv.css("display", "block");
            targetOther.css("display", "none"); // Sembunyikan comment
        } else {
            targetDiv.css("display", "block");
        }

    });

});
</script>

@endsection