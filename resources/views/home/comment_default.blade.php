@foreach($comments as $comment)
<div class="comment" id="comment-{{ $loop->index }}">
    <strong>{{ $comment['user'] }}</strong>
    <p>{{ $comment['comment'] }}</p>
</div>
@endforeach