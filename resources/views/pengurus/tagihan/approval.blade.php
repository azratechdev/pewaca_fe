@for($i=0;$i<2;$i++)
<div class="flex justify-center items-center" style="height: 100%;">
    <div class="bg-white w-full max-w-6xl">
        <div class="flex items-left max-w-full mb-2">
            <img 
                alt="Profile picture" 
                class="profile-picture rounded-full" 
                style="width: 24px; height: 24px;"
                src="" 
            />
            <div class="ml-4">
                <div class="text-gray-900 font-bold" style="font-size: 14px;">
                    <strong>Jhondoe</strong>
                </div>
            </div>
        </div>
        <div class="flex justify-between items-center mt-1">
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                    <strong>Residence Tiga</strong>
                </p>
            </div>
            
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                    <strong>A78FG</strong>
                </p>
            </div>
        </div> 
        <div class="flex justify-between items-center mt-1">
            <div class="flex items-center">
                <p class="d-flex align-items-center" style="font-size:10px;color:lightgrey">
                    <strong>Type: Pembangunan</strong>
                </p>
            </div>
            
        </div> 
        <div class="flex justify-between items-center mt-2">
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                    <strong>RP. 150.000</strong>
                </p>
            </div>
            
            <div class="flex items-center">
                <p class="d-flex align-items-center" style="color: lightgreen">
                    <strong>Lunas</strong>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="flex justify-between items-center mt-2">
    <div class="flex items-center">
        <p class="text-warning d-flex align-items-center"></p>
    </div>
    <div class="flex items-right">
        <a href="{{ route('pengurus.approval.detail', ['id' => '1']) }}" class="btn btn-sm btn-success w-20 btn-detail" style="color: white;border-radius:8px;">Detail</a>
    </div>
</div>
<hr class="mt-3 mb-2">
@endfor


