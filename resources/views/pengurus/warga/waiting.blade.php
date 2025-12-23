
@foreach($people_false as $warga)
<div class="flex justify-left items-left">
    <img 
        alt="{{  }}" 
        class="w-16 h-16 rounded-full border-2 border-gray-300" 
        src="{{ $warga['profile_photo'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($warga['full_name']) }}" 
        
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
        <p class="text-warning d-flex align-items-center">
            <i class="far fa-clock"></i>&nbsp; Waiting Approval
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
        <button class="btn btn-sm btn-info wait-prev" style="color: white;">< Previous</button>
    </div>
    <div class="flex items-center">
        <button class="btn btn-sm btn-info wait-next" style="color: white;">Next Page ></button>
    </div>
</div><br>

