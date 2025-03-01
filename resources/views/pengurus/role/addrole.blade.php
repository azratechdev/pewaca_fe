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
              <select class="form-control form-select" id="nama_pengurus" name="nama_pengurus" required>
                <option>-Pilih Warga-</option>
                @foreach ($wargas as $key => $warga)
                    <option value="{{ $warga['id'] }}">{{ $warga['full_name'] }}</option>
                @endforeach
              </select>
              <label for="nama_bank">Nama Pengurus</label>
            </div>

            <div class="form-floating mt-4">
                <select class="form-control" id="role" name="role" required>
                    <option value="" disabled selected hidden>- Pilih Role -</option>
                    @foreach($roles as $key => $role)
                    <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                    @endforeach
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
  $(document).ready(function() {
      $('#nama_pengurus').select2({
          placeholder: " ",
          allowClear: true
      });
  });
</script>    
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