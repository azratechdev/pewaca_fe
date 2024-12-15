
<div class="comment-before{{ $story['id'] }}"></div>
<div id="all-comment{{ $story['id'] }}" class="flex items-left max-w-full mb-2 comment-all" style="padding-left: 20px; padding-right:10px;">
    <div class="comment-show{{ $story['id'] }}"></div>
</div>

@for ($i = 0; $i < 5; $i++)
<div id="all-comment{{ $story['id'] }}" class="flex items-left max-w-full mb-2" style="padding-left: 20px; padding-right:10px;">
    <img 
        alt="Profile picture" 
        class="profile-picture rounded-full" 
        style="width: 36px; height: 36px;"
        src="{{ $warga['profile_photo'] }}" 
    />
    <div class="ml-4">
        <div class="text-gray-900 font-bold" style="font-size: 14px;">
            {{ $warga['full_name'] }}
        </div>
        <div style="font-size: 12px;">
            <p>ini contoh comment dari pengurus coba untuk memasukan text yang cukup panjang</p>
        </div>
    </div>
</div>
@endfor

<div class="comment-load{{ $story['id'] }}"></div>
{{-- <div class="flex items-left max-w-full mb-2" style="padding-left: 20px;">
    <div class="text-green-500 load-more" data-page="2" data-id="{{ $story['id'] }}" style="font-size: 12px;">Load More</div>
</div> --}}

