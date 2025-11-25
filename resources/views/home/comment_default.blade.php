@php
    $storyId = !empty($data['results']) ? $data['results'][0]['story'] : 0;
@endphp

@foreach($data['results'] as $comment)
<div id="all-comment{{ $comment['story'] }}" class="flex items-left max-w-full mb-2 comment-all">
    <img 
        alt="Foto profil {{ $comment['warga']['full_name'] }}" 
        class="profile-picture rounded-full" 
        style="width: 36px; height: 36px;"
        src="{{ $comment['warga']['profile_photo'] ?? asset('assets/plugins/images/default.jpg')}}" 
        onerror="this.src='{{ asset('assets/plugins/images/default-avatar.png') }}'; this.onerror=null;"
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

<div class="comment-more{{ $storyId }}"></div>

@if($data['next'] != null)
<div id="load-more{{ $storyId }}" class="flex items-left max-w-full mb-2">
    <div class="text-green-500 load-more" data-id="{{ $storyId }}" 
    data-next="{{ $data['next'] }}" style="font-size: 12px;">Load More</div>
</div>
@else
<div class="flex items-left max-w-full mb-2">
    <div class="text-white" style="font-size: 12px;">&nbsp;</div>
</div>
@endif