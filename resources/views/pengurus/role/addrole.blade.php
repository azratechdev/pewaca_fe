@extends('layouts.residence.basetemplate')
@section('content')
<style>
   <style>
    /* Custom Switch Styles */
    .custom-switch .form-check-input {
      width: 4rem;
      height: 2rem;
      border-radius: 2rem;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }
    .custom-switch .form-check-input:not(:checked) {
      background-color: #ccc;
      border-color: #ccc;
    }
    .custom-switch .form-check-input:checked {
      background-color: #198754;
      border-color: #198754;
      box-shadow: 0 0 10px rgba(25, 135, 84, 0.5); */
    }

    #repeat-container {
      display: none;
    }
    
  </style>
</style>
<div class="container">
  <div class="container mx-auto px-4">
    <div class="flex justify-between items-center" style="padding-top: 10px;">
      <div class="flex items-center">
        <h1 class="text-xl font-semibold text-gray-800">
          <a href="{{ route('pengurus') }}" class="text-dark">
              <i class="fas fa-arrow-left"></i>
          </a>&nbsp;Add Pengurus
      </h1>
      </div>
    </div>
    <br>
    <div class="mb-3">
        @include('layouts.elements.flash')
    </div>
    <form id="pengurus_role_add" method="post" action="" enctype="multipart/form-data">
      @csrf
        <div>
            <div class="form-floating mt-2">
                <input type="text" class="form-control @error('nama_pengurus') is-invalid @enderror" value="{{ old('nama_pengurus') }}" id="nama_pengurus" name="nama_pengurus" placeholder=" " required>
                <label for="nama_pengurus">Nama Pengurus</label>
                @error('nama_pengurus')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mt-4">
                <select class="form-control" id="role" name="role" required>
                    <option value="" disabled selected hidden>- Pilih Role -</option>
                    <option value="bendahara">Bendahara</option>
                    <option value="sekretaris">Sekretaris</option>
                    <option value="humas">Humas</option>
                </select>
                <label for="role">Role</label>
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
    
<script>
     
     const form = document.getElementById('pengurus_role_add');
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

@endsection 