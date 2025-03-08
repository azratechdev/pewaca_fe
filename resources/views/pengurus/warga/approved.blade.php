@foreach($people_true as $warga)
<div class="flex justify-left items-left">
    <img 
        alt="User profile picture" 
        class="w-16 h-16 rounded-full border-2 border-gray-300" 
        src="https://storage.googleapis.com/a1aa/image/ZoAiGzvASA4pG9oiGwu50UAjrOG21IrMhFOGfFnKGy1xU85JA.jpg" 
    />
    <div class="ml-4">
        <p class="font-semibold text-lg text-gray-800">
            {{ $warga['full_name']}}
        </p>
        <p class="text-gray-500">
            {{ $warga['user']['email']}}
        </p>
      
    </div>
</div>
<div class="flex justify-between items-center mt-2">
    <div class="flex items-center">
        <p class="text-success d-flex align-items-center">
            <i class="fa fa-check"></i>&nbsp; Approved
        </p>
    </div>
    
    <div class="flex items-center">
        <a href="{{ route('detail_warga', ['id' => $warga['id']]) }}" class="btn btn-sm btn-success w-20" style="color: white;border-radius:8px;">Detail</a>
    </div>
</div><hr class="mt-2">
<br>
@endforeach

<div class="flex justify-between items-center">
    <div class="flex items-center">
        <button class="btn btn-sm btn-info" style="color: white;">< Previous</button>
    </div>
    
    <div class="flex items-center">
        <button class="btn btn-sm btn-info" style="color: white;">Next Page ></button>
    </div>
</div><br>

