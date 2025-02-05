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
          </a>&nbsp;Add Tagihan
      </h1>
      </div>
    </div>
    <br>
    <div class="mb-3">
        @include('layouts.elements.flash')
    </div>
    <form id="pengurus_tagihan_add" method="post" action="{{ route('tagihan.post') }}" enctype="multipart/form-data">
      @csrf
        <div>
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
                    <option value="one_time" selected hidden>Select</option>
                    <option value="weekly" {{ old('repeat') == "weekly" ? 'selected' : '' }}>Weekly</option>
                    <option value="monthly" {{ old('repeat') == "monthly"? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ old('repeat') == "yearly"? 'selected' : '' }}>Yearly</option>
                </select>
                <label for="repeat">Type Iuran</label>
            </div>
            <hr class="mt-2 mb-2">

            <div class="form-floating mt-2">
                <input type="text" class="form-control @error('nama_tagihan') is-invalid @enderror" value="{{ old('nama_tagihan') }}" id="nama_tagihan" name="nama_tagihan" placeholder=" " required>
                <label for="nama_tagihan">Nama Tagihan</label>
                @error('nama_tagihan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mt-4">
                <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" value="{{ old('deskripsi') }}" id="deskripsi" name="deskripsi" placeholder=" " required>
                <label for="deskripsi">Deskripsi</label>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mt-4">
                <select class="form-control" id="type_iuran" name="type_iuran" required>
                    <option value="" disabled selected hidden>- Pilih Type Iuran -</option>
                    <option value="wajib" {{ old('type_iuran') == "wajib" ? 'selected' : '' }}>Wajib</option>
                    <option value="tidak wajib" {{ old('type_iuran') == "tidak wajib"? 'selected' : '' }}>Tidak Wajib</option>
                </select>
                <label for="type_iuran">Type Iuran</label>
            </div>

            <div id="tempo" class="form-floating mt-4">
                <input type="date" class="form-control" id="jatuh_tempo" name="jatuh_tempo" value="{{ old('from_date') }}"  placeholder=" " required>
                <label for="jatuh_tempo">Jatuh Tempo</label>
            </div>

            <div id="periode" class="form-floating mt-4" style="display:none;">
              <input type="date" class="form-control" id="periode" name="periode" value="{{ old('from_date') }}"  placeholder=" ">
              <label for="periode">Periode</label>
            </div>

            {{-- <div class="form-floating mt-4">
                <input type="date" class="form-control" id="from_date" name="from_date" value="{{ old('from_date') }}"  placeholder=" " required>
                <label for="from_date">From Date</label>
            </div>

            <div class="form-floating mt-4">
                <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}"  placeholder=" " required>
                <label for="due_date">Tanggal Terakhir Bayar</label>
            </div> --}}
          
            <div class="form-floating mt-4">
                <input type="text" class="form-control rupiah-input @error('nominal') is-invalid @enderror" value="{{ old('nominal') }}" id="nominal" name="nominal"
                placeholder="Rp. 0" pattern="^Rp\.\s?(\d{1,3}(\.\d{3})*|\d+)$" required>
                <label for="nominal">Nominal</label>
                @error('nominal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
function getDefaultDates() {
  const now = new Date(); // Tanggal sekarang
  const tomorrow = new Date(now); // Salin tanggal sekarang
  tomorrow.setDate(now.getDate() + 1); // Tambahkan 1 hari

  // Format tanggal ke dalam bentuk "d-M-Y" (contoh: 12-Feb-2025)
  const formatDate = (date) => {
    const day = date.getDate();
    const month = date.toLocaleString('default', { month: 'short' });
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
  };

  return [formatDate(now), formatDate(tomorrow)];
}
</script>
<script>
  flatpickr("#periode", {
    mode: "range",
    dateFormat: "d-M-Y",
    //defaultDate: getDefaultDates(),
    locale: "id", // Bahasa Indonesia
    onReady: function(selectedDates, dateStr, instance) {
      if (!selectedDates.length) {
        instance.input.placeholder = "Pilih Periode";
      }
    }
  });
</script>
    
<script>
     
     const form = document.getElementById('pengurus_tagihan_add');
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
    const tempo = document.getElementById('tempo');
    const jatuhTempo = document.getElementById('jatuh_tempo'); // Input dalam tempo
    const periode = document.getElementById('periode');
    const periodeInput = document.querySelector('#periode input'); // Input dalam periode

    // Add event listener to toggle visibility
    repeatButton.addEventListener('change', function () {
      if (this.checked) {
            // Hide 'tempo' and disable its required attribute
            tempo.style.display = 'none';
            jatuhTempo.removeAttribute('required');
            jatuhTempo.setAttribute('disabled', 'true');

            // Show 'repeatContainer' and set required attribute
            repeatContainer.style.display = 'block';
            repeatContainer.querySelector('select').setAttribute('required', 'required');

            // Show 'periode' and set required attribute
            periode.style.display = 'block';
            periodeInput.setAttribute('required', 'required');
            periodeInput.removeAttribute('disabled');

        } else {
            // Show 'tempo' and set required attribute
            tempo.style.display = 'block';
            jatuhTempo.setAttribute('required', 'required');
            jatuhTempo.removeAttribute('disabled');

            // Hide 'repeatContainer' and remove required attribute
            repeatContainer.style.display = 'none';
            repeatContainer.querySelector('select').removeAttribute('required');

            // Hide 'periode' and remove required attribute
            periode.style.display = 'none';
            periodeInput.removeAttribute('required');
            periodeInput.setAttribute('disabled', 'true');
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