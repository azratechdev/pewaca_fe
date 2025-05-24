<div class="container">
    <div class="container mx-auto px-4">
      <div class="flex justify-between items-center" style="padding-top: 10px;">
        <div class="flex items-center">
          <h1 class="text-xl font-semibold text-gray-800">
            <a href="{{ route('pembayaran.add', ['id' => $tagihan['data']['id']]) }}" class="text-dark">
                <i class="fas fa-arrow-left"></i>
            </a>&nbsp;&nbsp;Catatan Bukti Pembayaran
        </h1>
        </div>
      </div>
      <br>
      <div class="mb-3">
          @include('layouts.elements.flash')
      </div>
     
      <form id="upload_note_tagihan" method="post" action="{{ route('postNote') }}" enctype="multipart/form-data">
          @csrf
          <div class="flex justify-between items-center mt-3">
              <div class="flex items-center">
                  <p class="d-flex align-items-center">
                      Upload Image
              </div>
          </div> 
          <div class="flex justify-between items-center">
              <div class="flex items-center">
                  <div class="relative mb-2 mt-4">
                     
                      <input 
                        accept="image/*" 
                        class="hidden" 
                        id="imageUpload" 
                        type="file" 
                        name="image"
                        {{-- @if(!$ceknote) required @endif --}}
                      />
                      
                      <label class="cursor-pointer relative" for="imageUpload">
                          <div class="img-upload h-48 object-cover rounded-lg bg-gray-200 flex items-center justify-center relative">
                              <img 
                                  alt="Preview of uploaded image" 
                                  class="absolute inset-0 h-full w-full object-cover rounded-lg hidden" 
                                  id="imagePreview"
                                  src=""
                              />
                              <div class="text-center">
                                  <i class="fas fa-plus text-white text-4xl mb-2"></i><br>
                                  <span class="text-white text-lg">Upload Foto</span>
                                  {{-- @if(!$ceknote)
                                  <span class="text-red-500 block mt-1">*Wajib</span>
                                  @endif --}}
                              </div>
                              <button 
                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hidden" 
                                id="removeImageButton">
                                <i class="fas fa-times"></i>
                              </button>
                          </div>
                      </label>
                      <div class="alert-upload"></div>
                  </div>
              </div>
          </div> 
         
            <div>
                <div class="form-floating mt-4">
                    <input type="hidden" name="warga_id" value="{{ $warga_id }}" required/>
                    <input type="hidden" name="tagihan_warga_id" value="{{ $tagihan['data']['id'] }}" required/>
                </div>
  
                <div class="form-floating mt-4">
                    <textarea name="note" class="form-control" id="note" style="height: 120px" required></textarea>
                    <label for="note">Note</label>
                </div>
            </div>
          
          <br>
          <div class="row">
              <div class="col-md-12">
                  <button type="submit" id="submitBtn" class="btn btn-success form-control" disabled>Lanjutkan</button>
              </div>
          </div>
      </form>
    </div>
  </div>
  <script>
    const form = document.getElementById('upload_note_tagihan');
    const submitBtn = document.getElementById('submitBtn');
    //const imageUpload = document.getElementById('imageUpload');
    const noteInput = document.getElementById('note');
 
  
    function checkFormValidity() {
        const noteValid = noteInput.value.trim() !== '';
             
        submitBtn.disabled = !(noteValid);
    }
  
    form.addEventListener('input', checkFormValidity);
    imageUpload.addEventListener('change', checkFormValidity);
  
    checkFormValidity();
  </script>
  
  
  <script>
   const imageUpload = document.getElementById('imageUpload');
   const imagePreview = document.getElementById('imagePreview');
   const removeImageButton = document.getElementById('removeImageButton');
  
   imageUpload.addEventListener('change', function() {
     const file = this.files[0];
     if (file) {
       const reader = new FileReader();
       reader.onload = function(e) {
         imagePreview.src = e.target.result;
         removeImageButton.classList.remove('hidden');
         imagePreview.classList.remove('hidden'); // Tampilkan gambar
         imagePreview.classList.remove('bg-gray-200'); // Hapus latar abu-abu
       }
       reader.readAsDataURL(file);
     }
   });
  
   removeImageButton.addEventListener('click', function() {
     imagePreview.src = 'x';
     imageUpload.value = '';
     removeImageButton.classList.add('hidden');
     imagePreview.classList.add('hidden');
   });
  </script> 
  
  
  </script>