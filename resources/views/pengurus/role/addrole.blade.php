@extends('layouts.residence.basetemplate')
@section('content')
<style>

    /* Atur tampilan Select2 agar sesuai dengan form-floating */
.select2-container .select2-selection--single {
    height: calc(3.5rem + 2px); /* Sesuaikan dengan tinggi form-floating */
    padding: 1rem 0.75rem;
    border-radius: 0.25rem;
    border: 1px solid #ced4da;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 100%;
    top: 0;
    right: 0.75rem;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 2.5;
    padding-left: 0;
    padding-right: 0;
}

</style>

<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <div class="p-6 border-b">
            <h1 class="text-xl font-semibold text-gray-800">
                <a href="{{ route('pengurus.role') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;Add Pengurus
            </h1>
            <br>
            @include('layouts.elements.flash')
        </div>
        <br>
        <div class="col-md-12 col-sm-12" style="padding-left:10px;padding-right:10px;">
            <form id="pengurus_role_add" method="post" action="{{ route('pengurus.postrole') }}" enctype="multipart/form-data">
                @csrf
                <div>
                    <div class="form-floating mt-2">
                    <select class="form-control form-select select2" id="nama_pengurus" name="warga_id" required>
                        <option>-Pilih Warga-</option>
                        @foreach ($wargas as $key => $warga)
                            <option value="{{ $warga['id'] }}">{{ $warga['full_name'] }}</option>
                        @endforeach
                    </select>
                    <label for="nama_bank">Nama Pengurus</label>
                    </div>
        
                    <div class="form-floating mt-4">
                        <select class="form-control" id="role" name="role_id" required>
                            <option value="" disabled selected hidden>- Pilih Role -</option>
                            @foreach($roles as $key => $role)
                            <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="role">Role</label>
                    </div>
                </div>
                <br>
                <button type="submit" id="submitBtn" class="btn btn-success form-control" disabled>Submit</button>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    setTimeout(function() {
        $('#nama_pengurus, #role').select2({
            placeholder: "Pilih salah satu",
            allowClear: true
        }).on('change', function() {
            checkFormValidity();
        });
    }, 500);
});

const form = document.getElementById('pengurus_role_add');
const submitBtn = document.getElementById('submitBtn');

function checkFormValidity() {
    const namaPengurus = $('#nama_pengurus').val();
    const role = $('#role').val();
    
    // Enable submit button only if both select fields have values
    submitBtn.disabled = !namaPengurus || !role || namaPengurus === '-Pilih Warga-';
}

// Initial check
setTimeout(checkFormValidity, 600);
</script>

@endsection