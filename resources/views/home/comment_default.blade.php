@foreach($data['results'] as $comment)
<div id="all-comment{{ $comment['story'] }}" class="flex items-left max-w-full mb-2 comment-all" style="padding-left: 20px; padding-right:10px;">
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

<div class="comment-more{{ $comment['story'] }}"></div>

@if($data['next'] != null)
<div id="load-more{{ $comment['story'] }}" class="flex items-left max-w-full mb-2" style="padding-left: 20px;">
    <div class="text-green-500 load-more" data-id="{{ $comment['story'] }}" 
    data-next="{{ $data['next'] }}" style="font-size: 12px;">Load More</div>
</div>
@else
<div class="flex items-left max-w-full mb-2" style="padding-left: 20px;">
    <div class="text-white" style="font-size: 12px;">&nbsp;</div>
</div>
@endif