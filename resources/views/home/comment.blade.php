
@for ($i = 0; $i < 5; $i++)
<div id="all-comment{{ $story['id'] }}" class="flex items-left max-w-full mb-2" style="padding-left: 20px; padding-right:10px;">
    <img 
        alt="Profile picture" 
        class="profile-picture rounded-full" 
        style="width: 36px; height: 36px;"
        src="{{ $story['warga']['profile_photo'] }}" 
    />
    <div class="ml-4">
        <div class="text-gray-900 font-bold" style="font-size: 14px;">
            {{ $story['warga']['full_name'] }}
        </div>
        <div style="font-size: 12px;">
            <p>ini contoh comment dari pengurus coba untuk memasukan text yang cukup panjang</p>
        </div>
    </div>
</div>
@endfor
<div class="flex items-left max-w-full mb-2" style="padding-left: 20px;">
    <div class="text-green-500 load-more" style="font-size: 12px;">Load More</div>
</div>

