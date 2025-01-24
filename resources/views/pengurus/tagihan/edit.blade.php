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
          </a>&nbsp;Edit Tagihan
      </h1>
      </div>
    </div>
    <br>
    <div class="mb-3">
        @include('layouts.elements.flash')
    </div>
    <form id="pengurus_tagihan_edit" method="post" action="{{ route('pengurus.tagihan.postEdit') }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
        <div>
            <div class="form-floating mt-2">
                <input type="hidden" name="tagihan_id" value="{{ $tagihan['id'] }}">
                <input type="text" class="form-control @error('nama_tagihan') is-invalid @enderror" value="{{ $tagihan['name'] }}" id="nama_tagihan" name="nama_tagihan" placeholder=" " required>
                <label for="nama_tagihan">Nama Tagihan</label>
                @error('nama_tagihan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mt-4">
                <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" value="{{ $tagihan['description'] }}" id="deskripsi" name="deskripsi" placeholder=" " required>
                <label for="deskripsi">Deskripsi</label>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mt-4">
                <select class="form-control" id="type_iuran" name="type_iuran" required>
                    <option value="" disabled selected hidden>- Pilih Type Iuran -</option>
                    <option value="wajib" @if ($tagihan['tipe'] == "wajib") selected @endif>Wajib</option>
                    <option value="tidak wajib" @if ($tagihan['tipe'] == "tidak wajib") selected @endif>Tidak Wajib</option>
                </select>
                <label for="type_iuran">Type Iuran</label>
            </div>

            <div class="form-floating mt-4">
                <input type="date" class="form-control" id="from_date" name="from_date" value=""  placeholder=" " required>
                <label for="from_date">From Date</label>
            </div>

            <div class="form-floating mt-4">
                <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $tagihan['date_due'] }}"  placeholder=" " required>
                <label for="due_date">Tanggal Terakhir Bayar</label>
            </div>
          
            <div class="form-floating mt-4">
                <input type="text" class="form-control rupiah-input @error('nominal') is-invalid @enderror" value="{{ $tagihan['amount'] }}" id="nominal" name="nominal"
                placeholder="Rp. 0" pattern="^Rp\.\s?(\d{1,3}(\.\d{3})*|\d+)$" required>
                <label for="nominal">Nominal</label>
                @error('nominal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-4">
                <div class="flex items-center">
                    <p class="d-flex align-items-center">
                       <strong>Repeat</strong>
                    </p>
                </div>
                
                <div class="flex items-center">
                    <div class="flex items-center">
                        <div class="form-check form-switch custom-switch">
                            <input 
                              class="form-check-input" 
                              type="checkbox" 
                              role="switch" 
                              id="repeat_button"/>
                        </div>
                    </div>
                </div>
            </div>

            <div id="repeat-container" class="form-floating mt-4">
                <select class="form-control" id="repeat" name="repeat">
                    <option value="one_time" @if ($tagihan['jenis_tagihan'] == "one_time") selected @endif>Select</option>
                    <option value="weekly" @if ($tagihan['jenis_tagihan'] == "weekly") selected @endif>Weekly</option>
                    <option value="monthly" @if ($tagihan['jenis_tagihan'] == "monthly") selected @endif>Monthly</option>
                    <option value="yearly" @if ($tagihan['jenis_tagihan'] == "yearly") selected @endif>Yearly</option>
                </select>
                <label for="repeat">Type Iuran</label>
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
     
     const form = document.getElementById('pengurus_tagihan_edit');
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

<script>
    // Get the checkbox and the select container
    const repeatButton = document.getElementById('repeat_button');
    const repeatContainer = document.getElementById('repeat-container');

    // Add event listener to toggle visibility
    repeatButton.addEventListener('change', function () {
      if (this.checked) {
        repeatContainer.style.display = 'block'; // Show the select dropdown
        repeatContainer.setAttribute('required', 'required');
      } else {
        repeatContainer.style.display = 'none'; // Hide the select dropdown
        repeatContainer.removeAttribute('required');
      }
    });
  </script>

<script>
    // Script to format input dynamically
    const paymentInput = document.getElementById('nominal');

    paymentInput.addEventListener('input', function (e) {
      let value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
      if (value) {
        value = parseInt(value, 10).toLocaleString('id-ID'); // Format to Rupiah locale
        this.value = `Rp. ${value}`;
      } else {
        this.value = '';
      }
    });

    paymentInput.addEventListener('blur', function () {
      if (!this.value.startsWith('Rp.')) {
        this.value = `Rp. 0`; // Default value if input is cleared
      }
    });
  </script>
</div>

@endsection 