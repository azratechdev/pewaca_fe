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

<div class="col-md-12 col-sm-12 waiting-full" style="display:block;padding-left:10px;padding-right:10px;">
    @include('pengurus.tagihan.list')
</div>