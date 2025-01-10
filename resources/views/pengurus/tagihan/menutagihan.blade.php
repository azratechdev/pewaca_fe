<div class="flex items-left w-full max-w-full">
    <div class="pb-2">
        <div class="flex items-lefts" style="padding-bottom: 10px;">
            <div class="flex items-left">
                <a href="javascript:void(0)" class="btn btn-default toggle-tagihan">Tagihan</a> 
                <a href="javascript:void(0)" class="btn btn-default toggle-approval">Approval</a>
                <a href="javascript:void(0)" class="btn btn-default toggle-approved">Approved</a>
                <a href="javascript:void(0)" class="btn btn-default toggle-tunggakan">Tunggakan</a>
            </div>
        </div>
    </div>   
</div>  

<div class="col-md-12 col-sm-12 tagihan-list" style="display:block;padding-left:10px;padding-right:10px;">
    @include('pengurus.tagihan.list')
</div>
<div class="col-md-12 col-sm-12 tagihan-approval" style="display:none;padding-left:10px;padding-right:10px;">
    approval
</div>
<div class="col-md-12 col-sm-12 tagihan-approved" style="display:none;padding-left:10px;padding-right:10px;">
    approved
</div>
<div class="col-md-12 col-sm-12 tagihan-tunggakan" style="display:none;padding-left:10px;padding-right:10px;">
    tunggakan
</div>

<script>
    $(document).ready(function () {
        // Fungsi umum untuk mengatur display menu
        function toggleDisplay(targetClass) {
            // Sembunyikan semua menu
            $('.tagihan-list, .tagihan-approval, .tagihan-approved, .tagihan-tunggakan').css("display", "none");
            // Tampilkan menu yang sesuai
            $(targetClass).css("display", "block");
        }
    
        // Event listener untuk tombol "Tagihan"
        $(document).on("click", ".toggle-tagihan", function () {
            console.log("Tagihan button clicked");
            toggleDisplay('.tagihan-list');
        });
    
        // Event listener untuk tombol "Approval"
        $(document).on("click", ".toggle-approval", function () {
            toggleDisplay('.tagihan-approval');
        });
    
        // Event listener untuk tombol "Approved"
        $(document).on("click", ".toggle-approved", function () {
            toggleDisplay('.tagihan-approved');
        });
    
        // Event listener untuk tombol "Tunggakan"
        $(document).on("click", ".toggle-tunggakan", function () {
            toggleDisplay('.tagihan-tunggakan');
        });
    });
</script>
    