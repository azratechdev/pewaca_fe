@foreach($data['results'] as $comment)
<div id="comment-more{{ $comment['story'] }}" class="flex items-left max-w-full mb-2" style="padding-left: 20px; padding-right:10px;">
    <img 
        alt="Profile picture" 
        class="profile-picture rounded-full" 
        style="width: 36px; height: 36px;"
        src="{{ $comment['warga']['profile_photo'] }}" 
    />
    <div class="ml-4">
        <div class="text-gray-900 font-bold" style="font-size: 14px;">
            {{ $comment['warga']['full_name'] }}
        </div>
        <div style="font-size: 12px;">
            <p>{{ $comment['replay'] }}</p>
        </div>
    </div>
</div>
@endforeach
