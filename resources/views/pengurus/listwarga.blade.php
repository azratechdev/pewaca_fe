<div class="col-md-12 col-sm-12">
    <div class="pull-left"><b>Daftar Warga</b></div></br>

    @foreach($peoples as $warga)
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
    </div><br>
    @endforeach
</div>
