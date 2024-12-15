<div class="flex items-left w-full max-w-full">
    <div class="pb-2">
        <div class="flex items-lefts"  style="padding-bottom: 10px;">
            <div class="flex items-left">
                <a href="javascript:void(0)" class="btn btn-default toggle-waiting" data-id="">Waiting Approval</a> 
                <a href="javascript:void(0)" class="btn btn-default toggle-approved" data-id="">Approved</a>
            </div>
        </div>
    </div>   
</div>  

<div id="waiting-full" class="col-md-12 col-sm-12 waiting-full" style="display:block;padding-left:10px;padding-right:10px;">
    @include('pengurus.waiting')
</div>
<div id="approved-full" class="col-md-12 col-sm-12 approved-full" style="display:none;padding-left:10px;padding-right:10px;">
    @include('pengurus.approved')
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    $(document).on("click", ".toggle-approved", function() {
              
        const targetDiv = $('.approved-full');
        const targetOther = $('.waiting-full');
       
        if (targetDiv.css("display") === "none") {
            targetDiv.css("display", "block");
            targetOther.css("display", "none"); // Sembunyikan like
        } 
        else {
            targetDiv.css("display", "block");
        }

    });

    $(document).on("click", ".toggle-waiting", function() {
        const targetDiv = $('.waiting-full');
        const targetOther = $('.approved-full');
       
        if (targetDiv.css("display") === "none") {
            targetDiv.css("display", "block");
            targetOther.css("display", "none"); // Sembunyikan comment
        } else {
            targetDiv.css("display", "block");
        }

    });

});
</script>
<script>
$('.approved-warga').on('click', function() {
    const token = "{{ Session::get('token') }}";
    const wargaId = $(this).data('id');

    // alert(token + ' ' + wargaId);return;

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
            $.ajax({
                url: 'https://api.pewaca.id/api/warga/verify/',
                type: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Token ${token}`,
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({
                    "warga_id": wargaId
                }),
                success: function(data) {
                    Swal.fire('Success!', 'Warga successfully verified.', 'success');
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
                }
            });
        }
    });
});

$(document).ready(function () {
    $(document).on("click", ".send-reject", function() {
        const formid = $(this).attr('data-id');
        //alert(formid);return;
        $('#form-reject'+formid).submit(function (e) {
   
            e.preventDefault(); // Prevent default form submission
            
            const form = $(this);
            const wargaId = formid
            const reason = form.find('#reject-reason'+formid).val();
            const token = "{{ Session::get('token') }}"; // Replace with your actual token

            //alert(wargaId +' '+ reason + ' ' + token);return;
            
            if (!reason.trim()) {
                Swal.fire('Error!', 'Rejection reason is required.', 'error');
                return;
            }
        
            // Show confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to reject this warga?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, reject it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request
                    $.ajax({
                        url: 'https://api.pewaca.id/api/warga/reject/',
                        type: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Token ${token}`,
                            'Content-Type': 'application/json'
                        },
                        data: JSON.stringify({
                            warga_id: wargaId,
                            reason: reason
                        }),
                        success: function (response) {
                            Swal.fire('Success!', 'Warga successfully rejected.', 'success');
                            form.closest('.modal').modal('hide'); // Close modal (if using Bootstrap modal)
                        },
                        error: function (xhr, status, error) {
                            Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
                        }
                    });
                }
            });
        });
    });
});


</script>
