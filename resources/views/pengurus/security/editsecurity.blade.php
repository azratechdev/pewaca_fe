@extends('layouts.residence.basetemplate')
@section('content')
<style>
    
    /* Styling untuk container input */
    .form-group {
        position: relative;
        margin: 20px 0;
        width: 100%;
    }

    /* Styling untuk .input-group */
    .input-group {
        display: flex;
        align-items: center;
        width: 100%;
       
    }

    /* Styling untuk prefix */
    .input-group-text {
        padding: 10px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-right: none;
        font-size: 1em;
        color: #333;
        border-radius: 4px 0 0 4px;
        display: flex;
        align-items: center;
    }

    /* Styling untuk input */
    .form-control {
        width: 100%;
        padding: 10px;
        font-size: 1em;
        border: 1px solid #ccc;
        border-radius: 4px 4px 4px 4px;
        outline: none;
    }

    /* Styling untuk label */
    .form-label {
        position: absolute;
        left: 12px;
        top: 10px;
        font-size: 1em;
        color: #999;
        background-color: white;
        padding: 0 5px;
        transition: 0.2s ease;
        pointer-events: none;
    }

    /* Styling ketika input diisi atau di-fokus */
    .form-control:focus + .form-label,
    .form-control:not(:placeholder-shown) + .form-label{
        top: -10px; /* Pindahkan label ke luar input */
        left: 8px;
        font-size: 0.85em;
        color: #333;
    }

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
                <a href="{{ route('security.listsec') }}" class="text-dark">
                    <i class="fas fa-arrow-left"></i>
                </a>&nbsp;Edit Security
            </h1>
            <br>
            @include('layouts.elements.flash')
        </div>
        <br>
        <div class="col-md-12 col-sm-12" style="padding-left:10px;padding-right:10px;">
            <form id="pengurus_sec_edit" method="post" action="{{ route('security.updatesec') }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div>
                    <input type="hidden" class="form-control" id="id" name="id" value="{{ $data['id'] }}" required>
                    <div class="form-floating mt-2">
                        <input type="text" pattern="[A-Za-z\s]+" class="form-control" id="full_name" name="full_name" placeholder=" " value="{{ $data['fullname'] }}" required>
                        <label for="full_name ">Nama Lengkap</label>
                        
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mt-4">
                        <input type="text"  class="form-control" id="address" name="address" placeholder=" " value="{{ $data['address'] }}" required>
                        <label for="address">Alamat</label>
                        
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="form-floating mt-4">
                        <input type="text" pattern="\d{8,13}" minlength="8" maxlength="13" inputmode="numeric" class="form-control @error('phone_no') is-invalid @enderror"  value="{{ $data['phone_no'] }}" id="phone_no" name="phone_no" placeholder=" " required>
                        <label for="phone_no">Nomor Telepon</label>
                        <small class="text-danger d-none" id="phone_no-error">Nomor Telepon minimal 8 digit dan maksimal 13 digit</small>
                    </div>

                </div>
                <br>
                <button type="submit" id="submitBtn" class="btn btn-success form-control" disabled>Submit</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
     
        const form = document.getElementById('pengurus_sec_edit');
        const submitBtn = document.getElementById('submitBtn');
        
      
        function checkFormValidity() {
           
            const isValid = [...form.querySelectorAll('input[required], select[required]')].every(input => {
            
                if (input.type === 'file') {
                    return input.files.length > 0 || input.optional; // Periksa jika input file kosong
                }
                return input.value.trim() !== '';
            });
         
            submitBtn.disabled = !isValid;
        }

        form.addEventListener('input', checkFormValidity);

        checkFormValidity();
    </script>
<script>
    document.getElementById('phone_no').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, ''); // Hanya angka

    if (value.length > 13) {
        value = value.substring(0, 13); // Batasi 16 digit
    }

    e.target.value = value;

    const errorEl = document.getElementById('phone_no-error');
    const counterEl = document.getElementById('phone_no-counter');

    // Tampilkan error jika tidak kosong dan < 8
    if ((value.length > 0 && value.length < 8) || value.length > 13) {
        errorEl.classList.remove('d-none');
        e.target.classList.add('is-invalid');
    } else {
        errorEl.classList.add('d-none');
        e.target.classList.remove('is-invalid');
    }

    // Update counter jika ada
    if (counterEl) {
        counterEl.textContent = `${value.length}/8`;
    }
});
</script>

@endsection