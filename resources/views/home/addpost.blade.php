@extends('layouts.residence.basetemplate')
@section('content')
<div class="container">
  <div class="container mx-auto px-4">
    <div class="flex justify-between items-center" style="padding-top: 10px;">
      <div class="flex items-center">
        <h1 class="text-xl font-semibold text-gray-800">
          <a href="{{ route('home') }}" class="text-dark">
              <i class="fas fa-arrow-left"></i>
          </a>&nbsp;Add Post
        </h1>
      </div>
    </div>

    <form id="postingan" method="post" action="{{ route('addPost') }}" enctype="multipart/form-data">
      @csrf
      <div>
        <div class="relative mb-4 mt-4">
          <input 
              accept="image/*" 
              class="hidden" 
              id="imageUpload" 
              type="file" 
              name="post_picture" 
          />
          <label class="cursor-pointer relative" for="imageUpload">
              <!-- Bingkai gambar -->
              <div 
                  class="img-upload h-48 object-cover rounded-lg bg-gray-200 flex items-center justify-center relative" 
                  
              >
                  <img 
                      alt="Preview of uploaded image" 
                      class="absolute inset-0 h-full w-full object-cover rounded-lg hidden" 
                      id="imagePreview"
                      src=""
                  />
                  <div class="text-center">
                      <i class="fas fa-plus text-white text-4xl mb-2"></i><br>
                      <span class="text-white text-lg">Upload Foto</span>
                      <span class="text-white text-sm block">(Opsional)</span>
                  </div>

                  <button 
                      class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hidden" 
                      id="removeImageButton"
                  >
                      <i class="fas fa-times"></i>
                  </button>
              </div>
          </label>
        </div>
      </div>
      <div class="col-md-12">
          <textarea placeholder="Tulis Sesuatu..." id="description" name="description" class="w-full p-3 border border-gray-300 rounded-lg" rows="5" required></textarea>
      </div>
      <br>
      
      <div class="row">
        <div class="col-md-12">
            <button type="submit" id="submitBtn" class="btn btn-success form-control" disabled>Posting</button>
        </div>
      </div>
    </form>
  </div>
</div>

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

<script>
  
  const description = document.getElementById('description');
  const submitBtn = document.getElementById('submitBtn');

  function toggleSubmitButton() {
      // Aktifkan tombol jika kedua input terisi, jika tidak nonaktifkan
      if (description.value.trim()) {
          submitBtn.disabled = false;
      } else {
          submitBtn.disabled = true;
      }
  }
   
  description.addEventListener('input', toggleSubmitButton);
</script>
</div>

@endsection 