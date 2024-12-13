<div class="col-md-12 col-sm-12">
    <div>
        <ul class="nav nav-tabs" role="tablist" style="border:none;">
            <li class="nav-item">
                <a class="nav-link custom-nav-button active" data-bs-toggle="tab" href="#warga-waiting" role="tab">
                    <span class="d-block mt-2">Waiting Approval</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link custom-nav-button" data-bs-toggle="tab" href="#warga-approved" role="tab">
                    <span class="d-block mt-2">Approved</span>
                </a>
            </li>
           
          </ul>            
    
        <!-- Tab panes -->
        <div class="tab-content border-top-0 p-3">
            <div class="tab-pane fade show active" id="warga-waiting" role="tabpanel">
                @foreach($people_false as $warga)
                <div class="flex justify-left items-left">
                    <div class="w-full">
                        <div class="flex items-left">
                            <img 
                                alt="User profile picture" 
                                class="w-16 h-16 rounded-full border-2 border-gray-300" 
                                src="https://storage.googleapis.com/a1aa/image/ZoAiGzvASA4pG9oiGwu50UAjrOG21IrMhFOGfFnKGy1xU85JA.jpg" 
                            />
                            <div class="ml-4">
                                <p class="font-semibold text-lg text-gray-800">
                                    {{ $warga['user']['username']}}
                                </p>
                                <p class="text-gray-500">
                                    {{ $warga['user']['email']}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                       <button class="btn btn-sm btn-success" id="approved-warga" data-id="{{ $warga['user']['user_id'] }}">Approve</button>
                    </div>
                   
                    <div class="flex items-center">
                        <button class="btn btn-sm btn-warning" style="color: white;"
                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $warga['user']['user_id'] }}">Reject</button>
                    </div>
                </div><br>
                <div class="modal fade" id="rejectModal{{ $warga['user']['user_id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Reject Reason</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="reject-warga">
                            <div class="modal-body">
                                <input type="hidden" id="warga_id" value="{{ $warga['user']['user_id'] }}"/>
                                <textarea class="form-control" name="reject-reason" id="reject-reason" cols="4"></textarea>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </form>
                      </div>
                    </div>
                </div><hr><br>
                @endforeach
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                       <button class="btn btn-sm btn-info" style="color: white;">< Previous</button>
                    </div>
                   
                    <div class="flex items-center">
                        <button class="btn btn-sm btn-info" style="color: white;">Next Page ></button>
                    </div>
                </div><br>
            </div>
            <div class="tab-pane fade" id="warga-approved" role="tabpanel">
                @foreach($people_true as $warga)
                <div class="flex justify-left items-left">
                    <div class="w-full">
                        <div class="flex items-left">
                            <img 
                                alt="User profile picture" 
                                class="w-16 h-16 rounded-full border-2 border-gray-300" 
                                src="https://storage.googleapis.com/a1aa/image/ZoAiGzvASA4pG9oiGwu50UAjrOG21IrMhFOGfFnKGy1xU85JA.jpg" 
                            />
                            <div class="ml-4">
                                <p class="font-semibold text-lg text-gray-800">
                                    {{ $warga['user']['username']}}
                                </p>
                                <p class="text-gray-500">
                                    {{ $warga['user']['email']}}
                                </p>
                                @if($warga['isreject'] == true)
                                    <button class="btn rounded-pill btn-sm btn-warning" style="color: white;">Rejected</button>
                                @else
                                   
                                    <button class="btn btn-sm btn-info" style="color: white;">Approved</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div><br><hr><br>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Sertakan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('approved-warga').addEventListener('click', function() {
    const token = "{{ Session::get('token') }}";
    const wargaId = this.getAttribute('data-id');

    alert(token +' '+wargaId);

    // Tampilkan SweetAlert konfirmasi
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to approve this warga?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, approve it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('https://api.pewaca.id/api/warga/verify/', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Token ${token}`,
                    'Content-Type': 'application/json',
                   
                },
                body: JSON.stringify({
                    "warga_id": wargaId
                })
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire('Success!', 'Warga successfully verified.', 'success');
            })
            .catch(error => {
                Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
            });
        }
    });
});
</script>
