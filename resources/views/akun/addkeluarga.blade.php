@extends('layouts.residence.basetemplate')
@section('content')
<div class="flex justify-center items-center">
    <div class="bg-white w-full max-w-6xl">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center" style="padding-top: 10px;">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-800">
                    <a href="{{ route('infokeluarga') }}" class="text-dark">
                        <i class="fas fa-arrow-left"></i>
                    </a>&nbsp;&nbsp;&nbsp;&nbsp;Add Keluarga
                </h1>
                </div>
            </div>
            <br>
            <div class="mb-3">
                @include('layouts.elements.flash')
            </div>
            <form id="form_add_keluarga" method="post" action="{{ route('postRekening') }}" enctype="multipart/form-data">
            @csrf
                <div>
                    <div class="form-floating mt-2">
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" id="nama_lengkap" name="nama_lengkap" placeholder=" " required>
                        <label for="nama_lengkap">Nama Lengkap</label>
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mt-2">
                        <select class="form-control" id="sebagai" name="sebagai" required>
                            <option>Pilih Sebagai</option>
                            @foreach ($families as $family)
                                <option value="{{ $family['id'] }}">{{ $family['name'] }}</option>
                            @endforeach
                        </select>
                        <label for="nama_bank">Sebagai</label>
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
     
     const form = document.getElementById('form_add_keluarga');
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