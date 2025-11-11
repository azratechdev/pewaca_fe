@extends('layouts.residence.basetemplate')
@section('content')
<style>
    /* Contoh CSS kustom untuk Select2 */
/* .select2-container .select2-selection--single {
    height: 60px;
    border-radius: 8px;
    border: 1px solid #ced4da;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
} */

 /* Pastikan label tetap di atas saat input memiliki nilai */
.form-floating > .form-control:not(:placeholder-shown) ~ label,
.form-floating > .form-select ~ label {
    opacity: 1;
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
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
            <div class="flex justify-between items-center" style="padding-top: 10px;">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-800">
                    <a href="{{ route('inforekening') }}" class="text-dark">
                        <i class="fas fa-arrow-left"></i>
                    </a>&nbsp;&nbsp;&nbsp;&nbsp;Add Rekening
                </h1>
                </div>
            </div>
            <br>
            <div class="mb-3">
                @include('layouts.elements.flash')
            </div>
            <form id="form_add_bank" method="post" action="{{ route('postRekening') }}" enctype="multipart/form-data">
            @csrf
                <div>
                    <div class="form-floating mt-2">
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" id="nama_lengkap" name="nama_lengkap" placeholder=" " required>
                        <label for="nama_lengkap">Add Bank Account</label>
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mt-2">
                        <input type="number" class="form-control @error('nomor_rekening') is-invalid @enderror" value="{{ old('nomor_rekening') }}" id="nomor_rekening" name="nomor_rekening" placeholder=" " required>
                        <label for="nomor_rekening">No Rekening</label>
                        @error('nomor_rekening')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mt-2">
                        <select class="form-control form-select" id="bankSelect" name="nama_bank" required>
                            <option>-Pilih Bank-</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank['bank_id'] }}" {{ old('nama_bank') }} == "{{ $bank['bank_name'] }}" ? 'selected' : '' }}>{{ $bank['bank_name'] }}</option>
                            @endforeach
                        </select>
                        <label for="nama_bank">Nama Bank</label>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" id="submitBtn" class="btn btn-success form-control" disabled>Submit</button>
                    </div>
                </div>
            </form>
        </div>    
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#bankSelect').select2({
            placeholder: " ",
            allowClear: true
        });
    });
</script>   
<script>
     
     const form = document.getElementById('form_add_bank');
     const submitBtn = document.getElementById('submitBtn');
     
   
     function checkFormValidity() {
        
         const isValid = [...form.querySelectorAll('input[required], select[required]')].every(input => {
             return input.value.trim() !== '';
         });
      
         submitBtn.disabled = !isValid;
     }

     form.addEventListener('input', checkFormValidity);

     checkFormValidity();
 
</script>

</div>

@endsection 