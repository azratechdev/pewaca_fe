
@foreach($people_false as $warga)
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
<br>
<div class="flex justify-between items-center">
    <div class="flex items-center">
        <button class="btn btn-sm btn-success approved-warga" data-id="{{ $warga['id'] }}">Approve</button>
    </div>
    
    <div class="flex items-center">
        <button class="btn btn-sm btn-warning" style="color: white;"
        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $warga['id'] }}">Reject</button>
    </div>
</div><br>
<div class="modal fade" id="rejectModal{{ $warga['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Reject Reason</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="form-reject{{ $warga['id'] }}">
            <div class="modal-body">
                <input type="hidden" id="warga_id{{ $warga['id'] }}" value="{{ $warga['id'] }}"/>
                <textarea class="form-control" name="reject-reason" id="reject-reason{{ $warga['id'] }}" cols="4" required></textarea>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Cancel</button>
            <button data-id="{{ $warga['id'] }}"type="submit" class="btn btn-sm btn-primary send-reject">Save</button>
            </div>
        </form>
        </div>
    </div>
</div><hr><br>
@endforeach
<div class="flex justify-between items-center">
    <div class="flex items-center">
        <button class="btn btn-sm btn-info wait-prev" style="color: white;">< Previous</button>
    </div>
    <div class="flex items-center">
        <button class="btn btn-sm btn-info wait-next" style="color: white;">Next Page ></button>
    </div>
</div><br>

